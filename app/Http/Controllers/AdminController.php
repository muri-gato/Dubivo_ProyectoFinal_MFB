<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Work;
use App\Models\User;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; // ¡FALTABA ESTE IMPORT!

class AdminController extends Controller
{
    public function dashboard()
    {
        // Verificar manualmente si es admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $stats = [
            'total_users' => User::count(),
            'total_actors' => User::where('role', 'actor')->count(),
            'total_clients' => User::where('role', 'client')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_schools' => School::count(),
            'total_works' => Work::count(),
            'total_teacher_actors' => Actor::has('teachingSchools')->count(),
        ];

        $recentActors = Actor::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentActors'));
    }

    public function schools(Request $request)
    {
        // Verificar manualmente si es admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $query = School::withCount(['actors', 'teachers']);

        // Filtros
        if ($request->has('city') && $request->city != '') {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'active') {
                $query->has('actors', '>', 0);
            } elseif ($request->status == 'inactive') {
                $query->doesntHave('actors');
            }
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Ordenamiento
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'name':
                    $query->orderBy('name');
                    break;
                case 'actors':
                    $query->orderBy('actors_count', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $schools = $query->paginate(10);
        $cities = School::whereNotNull('city')->distinct()->pluck('city')->sort();

        return view('admin.schools.index', compact('schools', 'cities'));
    }

    public function createSchool()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return view('admin.schools.create');
    }

    public function storeSchool(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url'
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('schools/logos', 'public');
        }

        School::create($validated);

        return redirect()->route('admin.schools')->with('success', 'Escuela creada exitosamente.');
    }

    public function editSchool(School $school)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return view('admin.schools.edit', compact('school'));
    }

    public function updateSchool(Request $request, School $school)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url'
        ]);

        if ($request->hasFile('logo')) {
            if ($school->logo) {
                Storage::disk('public')->delete($school->logo);
            }
            $validated['logo'] = $request->file('logo')->store('schools/logos', 'public');
        }

        $school->update($validated);

        return redirect()->route('admin.schools')->with('success', 'Escuela actualizada exitosamente.');
    }

    public function destroySchool(School $school)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $school->delete();
        return redirect()->route('admin.schools')->with('success', 'Escuela eliminada exitosamente.');
    }

    // Métodos para Works (similar estructura)
    public function works(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        $query = Work::withCount('actors');

        // Aplicar filtros directamente aquí (sin método auxiliar)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Ordenamiento
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title':
                $query->orderBy('title');
                break;
            case 'actors':
                $query->orderBy('actors_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $works = $query->paginate(10);
        $types = Work::getTypeOptions();
        $years = Work::whereNotNull('year')->distinct()->pluck('year')->sort();

        return view('admin.works.index', compact('works', 'types', 'years'));
    }

    public function createWork()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        $types = Work::getTypeOptions();
        return view('admin.works.create', compact('types'));
    }

    public function storeWork(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:' . implode(',', array_keys(Work::getTypeOptions())),
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'description' => 'nullable|string|max:1000',
            'poster' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,gif'
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('works/posters', 'public');
        }

        Work::create($validated);

        return redirect()->route('admin.works')->with('success', 'Obra creada exitosamente.');
    }

    public function updateWork(Request $request, Work $work)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:' . implode(',', array_keys(Work::getTypeOptions())),
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'description' => 'nullable|string|max:1000',
            'poster' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,gif'
        ]);

        if ($request->hasFile('poster')) {
            // Eliminar el póster anterior si existe
            if ($work->poster) {
                Storage::disk('public')->delete($work->poster);
            }
            $validated['poster'] = $request->file('poster')->store('works/posters', 'public');
        }

        $work->update($validated);

        return redirect()->route('admin.works')->with('success', 'Obra actualizada exitosamente.');
    }

    public function destroyWork(Work $work)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        // Eliminar el póster si existe
        if ($work->poster) {
            Storage::disk('public')->delete($work->poster);
        }
        
        $work->delete();

        return redirect()->route('admin.works')->with('success', 'Obra eliminada exitosamente.');
    }

    // Métodos para Actors
    public function actors(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        $query = Actor::with(['user', 'schools', 'works']);

        // Aplicar filtros directamente
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('gender')) {
            $gender = $request->gender;
            $query->where(function ($q) use ($gender) {
                $q->whereJsonContains('genders', $gender)
                    ->orWhere('genders', 'like', '%"' . $gender . '"%');
            });
        }

        if ($request->filled('voice_age')) {
            $voiceAge = $request->voice_age;
            $query->where(function ($q) use ($voiceAge) {
                $q->whereJsonContains('voice_ages', $voiceAge)
                    ->orWhere('voice_ages', 'like', '%"' . $voiceAge . '"%');
            });
        }

        if ($request->filled('availability')) {
            $query->where('is_available', $request->availability == 'available');
        }

        $actors = $query->paginate(10);
        $schools = School::all();
        $genders = Actor::getGenderOptions();
        $voiceAges = Actor::getVoiceAgeOptions();

        return view('admin.actors.index', compact('actors', 'schools', 'genders', 'voiceAges'));
    }

    public function editActor(Actor $actor)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        $schools = School::all();
        $works = Work::all();
        $genders = Actor::getGenderOptions();
        $voiceAges = Actor::getVoiceAgeOptions();

        $currentTeachingSchools = $actor->teachingSchools()
            ->where('is_active_teacher', true)
            ->pluck('schools.id')
            ->toArray();

        // Pasamos la bandera isAdmin para la vista unificada
        return view('actors.edit', [
            'actor' => $actor,
            'schools' => $schools,
            'works' => $works,
            'genders' => $genders,
            'voiceAges' => $voiceAges,
            'currentTeachingSchools' => $currentTeachingSchools,
            'isAdmin' => true
        ]);
    }

    public function updateActor(Request $request, Actor $actor)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        $validated = $request->validate([
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,gif',
            'audio_path' => 'nullable|file|mimes:mp3,wav,m4a|max:5120',
            'genders' => 'required|array|min:1',
            'genders.*' => 'in:' . implode(',', Actor::getGenderOptions()),
            'voice_ages' => 'required|array|min:1',
            'voice_ages.*' => 'in:' . implode(',', Actor::getVoiceAgeOptions()),
            'is_available' => 'required|boolean',
            'schools' => 'nullable|array',
            'works' => 'nullable|array',
            'teaching_schools' => 'nullable|array',
            'teaching_subjects.*' => 'nullable|string|max:255',
            'teaching_bios.*' => 'nullable|string|max:500'
        ]);

        try {
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

            // Convertir arrays a JSON
            $validated['genders'] = json_encode($validated['genders']);
            $validated['voice_ages'] = json_encode($validated['voice_ages']);

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

            // Sincronizar escuelas donde enseña
            $teachingSchoolsData = [];
            if ($request->has('teaching_schools')) {
                foreach ($request->teaching_schools as $schoolId) {
                    $teachingSchoolsData[$schoolId] = [
                        'subject' => $request->teaching_subjects[$schoolId] ?? null,
                        'teaching_bio' => $request->teaching_bios[$schoolId] ?? null,
                        'is_active_teacher' => true
                    ];
                }
            }
            $actor->teachingSchools()->sync($teachingSchoolsData);

            return redirect()->route('admin.actors')->with('success', 'Actor actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error updating actor: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al actualizar el actor: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroyActor(Actor $actor)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        // Eliminar archivos si existen
        if ($actor->photo) {
            Storage::disk('public')->delete($actor->photo);
        }
        if ($actor->audio_path) {
            Storage::disk('public')->delete($actor->audio_path);
        }

        $actor->delete();

        return redirect()->route('admin.actors')->with('success', 'Actor eliminado exitosamente.');
    }

    // Métodos para Users
    public function users(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    // Métodos auxiliares para manejo de archivos (sin verificación de admin)
    private function storeFile($file, $directory)
    {
        return $file->store($directory, 'public');
    }

    private function deleteFile($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}