<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    //Mostramos todas las obras con sus estadísticas y filtros
    public function index(Request $request)
    {
        $query = Work::withCount('actors');

        // 1. Filtro por Búsqueda de Título
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 2. Filtro por Tipos (Ej: peli, serie...)
        if ($request->filled('types')) {
            $query->whereIn('type', $request->types);
        }

        // 3. Filtro por Año
        if ($request->filled('year')) {
            // Asume que el usuario busca un año específico
            $query->where('year', $request->year);
        }

        // 4. Finalizamos la consulta con paginación
        $works = $query->latest()->paginate(12)->withQueryString();

        // 5. Obtenemos las opciones de tipo para los filtros de la vista
        $types = Work::getTypeOptions();

        return view('works.index', compact('works', 'types'));
    }

    //Mostramos los detalles de una obra específica
    public function show(Work $work)
    {
        //Cargamos los actores con sus datos completos
        $work->load(['actors.user', 'actors.schools']);

        return view('works.show', compact('work'));
    }
}
