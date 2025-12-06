<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request; // Importante: Mantener esta línea

class SchoolController extends Controller
{
    //Listamos todas las escuelas con sus estadísticas y filtros
    public function index(Request $request)
    {
        // 1. Inicializamos la consulta base
        $query = School::withCount('actors');

        // 2. Filtro por Búsqueda de Nombre
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 3. Filtro por Ciudad
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // 4. Finalizamos la consulta
        $schools = $query->paginate(12)->withQueryString();

        // 5. Obtenemos las ciudades para el dropdown de filtros
        $cities = School::distinct('city')->orderBy('city')->pluck('city');

        return view('schools.index', compact('schools', 'cities'));
    }

    //Mostramos una escuela en detalle con sus actores
    public function show(School $school)
    {
        //Cargamos actores y profesores de esta escuela
        $school->load(['actors.user', 'teacherActors.user']);
        $school->loadCount('actors');

        return view('schools.show', compact('school'));
    }
}
