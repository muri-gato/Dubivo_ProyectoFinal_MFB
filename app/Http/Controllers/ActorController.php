<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\School;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ActorController extends Controller
{
    public function index(Request $request)
{
    $query = Actor::with(['user', 'schools', 'works']);

    // Aplicar filtros
    if ($request->has('search') && $request->search != '') {
        $query->whereHas('user', function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->has('availability') && $request->availability !== '') {
        $query->filterByAvailability($request->availability);
    }

    if ($request->has('genders')) {
        $query->filterByGenders($request->genders);
    }

    if ($request->has('voice_ages')) {
        $query->filterByVoiceAges($request->voice_ages);
    }

    if ($request->has('schools')) {
        $query->filterBySchools($request->schools);
    }

    $actors = $query->paginate(12);
    $schools = School::all();
    
    // Pasar opciones para los filtros
    $genders = Actor::getGenderOptions();
    $voiceAges = Actor::getVoiceAgeOptions();
    
    return view('actors.index', compact('actors', 'schools', 'genders', 'voiceAges'));
}

    public function create()
{
    if (Auth::user()->actorProfile) {
        return redirect()->route('actors.show', Auth::user()->actorProfile)
                        ->with('info', 'Ya tienes un perfil de actor.');
    }

    $schools = School::all();
    $works = Work::all();
    $genders = Actor::getGenderOptions();
    $voiceAges = Actor::getVoiceAgeOptions();
    // ELIMINA esta línea: $availabilities = Actor::getAvailabilityOptions();

    return view('actors.create', compact('schools', 'works', 'genders', 'voiceAges'));
}

    public function store(Request $request)
{
    if (Auth::user()->actorProfile) {
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
        'is_available' => 'sometimes|boolean', // CAMBIADO: de availabilities a is_available
        'schools' => 'nullable|array',
        'works' => 'nullable|array'
    ]);

    $actor = new Actor();
    $actor->user_id = Auth::id();
    $actor->bio = $validated['bio'];
    $actor->genders = $validated['genders'];
    $actor->voice_ages = $validated['voice_ages'];
    $actor->is_available = $request->has('is_available'); // CAMBIADO
    
    if ($request->hasFile('photo')) {
        $actor->photo = $request->file('photo')->store('actors/photos', 'public');
    }
    
    if ($request->hasFile('audio_path')) {
        $actor->audio_path = $request->file('audio_path')->store('actors/audios', 'public');
    }

    $actor->save();

    // Sincronizar relaciones
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
    if (Auth::id() != $actor->user_id && Auth::user()->role != 'admin') {
        abort(403, 'No autorizado.');
    }
    
    $schools = School::all();
    $works = Work::all();
    $genders = Actor::getGenderOptions();
    $voiceAges = Actor::getVoiceAgeOptions();
    // ELIMINA esta línea: $availabilities = Actor::getAvailabilityOptions();

    return view('actors.edit', compact('actor', 'schools', 'works', 'genders', 'voiceAges'));
}

    public function update(Request $request, Actor $actor)
{
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
        'is_available' => 'sometimes|boolean', // CAMBIADO: de availabilities a is_available
        'schools' => 'nullable|array',
        'works' => 'nullable|array'
    ]);

    // Manejar archivos
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

    // Sincronizar relaciones
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
        
        $actor->delete();
        
        return redirect()->route('home')
                        ->with('success', 'Perfil eliminado exitosamente.');
}

    public function show(Actor $actor)
{
    $actor->load(['user', 'schools', 'works', 'requests.client']);
    return view('actors.show', compact('actor'));
}

}