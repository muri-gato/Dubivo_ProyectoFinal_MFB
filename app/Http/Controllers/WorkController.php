<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function index(Request $request)
    {
        $query = Work::withCount('actors');

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        $works = $query->latest()->paginate(12);
        return view('works.index', compact('works'));
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
}