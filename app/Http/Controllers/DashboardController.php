<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\School;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir a la página principal
            return redirect()->route('home');
        }

        $user = Auth::user();
        
        // Redirigir admin al panel de administración
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Para actores y clientes, mostrar dashboard con contenido
        $featuredActors = Actor::with(['user', 'works', 'schools'])
            ->where('is_available', true)
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        return view('dashboard', compact('featuredActors', 'user'));
    }
}