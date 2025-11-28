<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\School;
use App\Models\Work;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Actores destacados para el carrusel (sin stats)
        $featuredActors = Actor::with(['user', 'works', 'schools'])
            ->where('is_available', true)
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        return view('dashboard', compact('featuredActors'));
    }
}