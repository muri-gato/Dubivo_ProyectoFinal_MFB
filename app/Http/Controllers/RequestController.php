<?php

namespace App\Http\Controllers;

use App\Models\Request as ContactRequest;
use App\Models\User;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RequestController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = ContactRequest::query();
        // Usar role directamente en lugar de métodos que no existen
        if ($user->role == 'actor') {
        $query->where('actor_id', $user->id)
              ->with('client');
    } else {
        $query->where('client_id', $user->id)
              ->with('actor.user');
    }

    if ($request->has('status') && $request->status != '') { //filtro por estado
        $query->where('status', $request->status);
    }
    
    $requests = $query->latest()->paginate(10);

    return view('requests.index', compact('requests'));
    
}

    public function create(Actor $actor)

    {
        // Verificar que el actor existe y está disponible
         if (!$actor->is_available) {
        return redirect()->back()->with('error', 'Este actor no está disponible.');
    }

        return view('requests.create', compact('actor'));
    }

    public function store(Request $request, Actor $actor)
    {
        // Verificar que el usuario es cliente
        if (Auth::user()->role != 'client') {
            return redirect()->back()->with('error', 'Solo los clientes pueden enviar solicitudes.');
        }

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);

        ContactRequest::create([
            'client_id' => Auth::id(),
            'actor_id' => $actor->user_id,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'pending'
        ]);

        return redirect()->route('actors.show', $actor)
                        ->with('success', 'Solicitud enviada exitosamente.');
    }

    public function updateStatus(ContactRequest $contactRequest, $status)
    {
        // Verificación manual en lugar de authorize()
        if (Auth::id() != $contactRequest->actor_id) {
            abort(403, 'No autorizado.');
        }

        if (!in_array($status, ['accepted', 'rejected'])) {
            return redirect()->back()->with('error', 'Estado inválido.');
        }

        $contactRequest->update(['status' => $status]);

        return redirect()->back()->with('success', "Solicitud {$status}.");
    }

    public function destroy(ContactRequest $contactRequest)
    {
        // Verificación manual
        if (Auth::id() != $contactRequest->client_id && Auth::id() != $contactRequest->actor_id) {
            abort(403, 'No autorizado.');
        }

        $contactRequest->delete();

        return redirect()->back()->with('success', 'Solicitud eliminada.');
    }
}