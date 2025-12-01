<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function index(Request $request)
    {
        $works = Work::withCount('actors')->paginate(12);
        $types = [
        'movie' => 'Película',
        'series' => 'Serie', 
        'commercial' => 'Comercial',
        'animation' => 'Animación',
        'videogame' => 'Videojuego',
        'documentary' => 'Documental',
        'other' => 'Otro'
    ];

        return view('works.index', compact('works', 'types'));
    }

    public function show(Work $work)
    {
        $work->load(['actors.user', 'actors.schools']);
        $work->loadCount('actors');

        // Obtener obras relacionadas (mismo tipo, excluyendo la actual)
        $relatedWorks = Work::where('type', $work->type)
            ->where('id', '!=', $work->id)
            ->withCount('actors')
            ->latest()
            ->take(3)
            ->get();

        return view('works.show', compact('work', 'relatedWorks'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $works = Work::where('title', 'like', '%' . $query . '%')
            ->limit(10)
            ->get(['id', 'title', 'type', 'year']);

        return response()->json($works);
    }
}
