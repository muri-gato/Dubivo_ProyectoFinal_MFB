<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\School;
use App\Models\Work;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ActorController extends Controller
{
    public function index(Request $request)
    {
        // Consulta base - TODOS los actores, disponibles y no disponibles
        $query = Actor::with(['user', 'schools', 'works']);

        // Filtro de búsqueda por nombre
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filtro de disponibilidad (opcional para todos)
        if ($request->filled('availability')) {
            $availability = $request->availability === '1' ? true : false;
            $query->filterByAvailability($availability);
        }

        // Usar los scopes que ya tienes definidos en el modelo
        if ($request->filled('genders')) {
            $genders = is_array($request->genders) ? $request->genders : [$request->genders];
            $query->filterByGenders($genders);
        }

        if ($request->filled('voice_ages')) {
            $voiceAges = is_array($request->voice_ages) ? $request->voice_ages : [$request->voice_ages];
            $query->filterByVoiceAges($voiceAges);
        }

        if ($request->filled('schools')) {
            $schoolIds = is_array($request->schools) ? $request->schools : [$request->schools];
            $query->filterBySchools($schoolIds);
        }

        $actors = $query->paginate(12);
        $schools = School::all();

        $genders = Actor::getGenderOptions();
        $voiceAges = Actor::getVoiceAgeOptions();

        return view('actors.index', compact('actors', 'schools', 'genders', 'voiceAges'));
    }

    public function create()
    {
        // Solo actores pueden crear perfil (o admin creando para otros)
        if (Auth::user()->role !== 'actor' && Auth::user()->role !== 'admin') {
            abort(403, 'Solo actores pueden crear perfiles.');
        }

        if (Auth::user()->actorProfile && Auth::user()->role !== 'admin') {
            return redirect()->route('actors.show', Auth::user()->actorProfile)
                ->with('info', 'Ya tienes un perfil de actor.');
        }

        $schools = School::all();
        $works = Work::all();
        $genders = Actor::getGenderOptions();
        $voiceAges = Actor::getVoiceAgeOptions();

        return view('actors.create', compact('schools', 'works', 'genders', 'voiceAges'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->actorProfile && Auth::user()->role !== 'admin') {
            return redirect()->route('actors.show', Auth::user()->actorProfile)
                ->with('error', 'Ya tienes un perfil de actor.');
        }

        $validated = $request->validate([
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:2048',
            'audio_path' => 'nullable|file|mimes:mp3,wav|max:5120',
            'genders' => 'required|array',
            'genders.*' => 'in:' . implode(',', Actor::getGenderOptions()),
            'voice_ages' => 'required|array',
            'voice_ages.*' => 'in:' . implode(',', Actor::getVoiceAgeOptions()),
            'is_available' => 'sometimes|boolean',
            'schools' => 'nullable|array',
            'works' => 'nullable|array'
        ]);

        $actor = new Actor();
        $actor->user_id = Auth::id();
        $actor->bio = $validated['bio'];
        $actor->genders = $validated['genders'];
        $actor->voice_ages = $validated['voice_ages'];
        $actor->is_available = $request->has('is_available');

        if ($request->hasFile('photo')) {
            $actor->photo = $request->file('photo')->store('actors/photos', 'public');
        }

        if ($request->hasFile('audio_path')) {
            $actor->audio_path = $request->file('audio_path')->store('actors/audios', 'public');
        }

        $actor->save();

        if ($request->has('schools')) {
            $actor->schools()->sync($request->schools);
        }

        if ($request->has('works')) {
            $worksData = [];
            foreach ($request->works as $workId) {
                $worksData[$workId] = [
                    'character_name' => $request->character_names[$workId] ?? null
                ];
            }
            $actor->works()->sync($worksData);
        }

        return redirect()->route('actors.show', $actor)
            ->with('success', 'Perfil creado exitosamente.');
    }

    public function edit(Actor $actor)
    {
        // Verificar permisos: dueño o admin
        if (Auth::id() != $actor->user_id && Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $schools = School::all();
        $works = Work::all();
        $genders = Actor::getGenderOptions();
        $voiceAges = Actor::getVoiceAgeOptions();

        return view('actors.edit', compact('actor', 'schools', 'works', 'genders', 'voiceAges'));
    }

    public function update(Request $request, Actor $actor)
    {
        // Verificar permisos: dueño o admin
        if (Auth::id() != $actor->user_id && Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:2048',
            'audio_path' => 'nullable|file|mimes:mp3,wav|max:5120',
            'genders' => 'required|array',
            'genders.*' => 'in:' . implode(',', Actor::getGenderOptions()),
            'voice_ages' => 'required|array',
            'voice_ages.*' => 'in:' . implode(',', Actor::getVoiceAgeOptions()),
            'is_available' => 'sometimes|boolean',
            'schools' => 'nullable|array',
            'works' => 'nullable|array'
        ]);

        if ($request->hasFile('photo')) {
            if ($actor->photo) {
                Storage::disk('public')->delete($actor->photo);
            }
            $validated['photo'] = $request->file('photo')->store('actors/photos', 'public');
        }

        if ($request->hasFile('audio_path')) {
            if ($actor->audio_path) {
                Storage::disk('public')->delete($actor->audio_path);
            }
            $validated['audio_path'] = $request->file('audio_path')->store('actors/audios', 'public');
        }

        $actor->update($validated);

        $actor->schools()->sync($request->schools ?? []);

        $worksData = [];
        if ($request->has('works')) {
            foreach ($request->works as $workId) {
                $worksData[$workId] = [
                    'character_name' => $request->character_names[$workId] ?? null
                ];
            }
        }
        $actor->works()->sync($worksData);

        return redirect()->route('actors.show', $actor)
            ->with('success', 'Perfil actualizado exitosamente.');
    }

    public function destroy(Actor $actor)
    {
        if (Auth::id() != $actor->user_id && Auth::user()->role != 'admin') {
            abort(403, 'No autorizado.');
        }

        $userId = $actor->user_id;

        $actor->delete();

        if (Auth::user()->role != 'admin') {
            $user = User::find($userId);
            if ($user) {
                $user->delete();
            }

            Auth::logout();

            return redirect('/')->with('success', 'Tu perfil y cuenta han sido eliminados exitosamente.');
        }

        return redirect()->route('admin.actors')->with('success', 'Perfil de actor eliminado exitosamente.');
    }

    public function show(Actor $actor)
    {
        $actor->load(['user', 'schools', 'works']);
        return view('actors.show', compact('actor'));
    }

    public function updateAvailability(Request $request, Actor $actor)
    {
        if (Auth::id() !== $actor->user_id && Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        $request->validate([
            'is_available' => 'required|boolean'
        ]);

        try {
            $actor->update([
                'is_available' => $request->is_available
            ]);

            return response()->json([
                'success' => true,
                'is_available' => $actor->is_available,
                'message' => 'Disponibilidad actualizada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la disponibilidad'
            ], 500);
        }
    }
}