<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Support\Facades\Auth;


class FavoriteController extends Controller
{
    public function toggleFavorite(Actor $actor)
    {
        $user = Auth::user();
        
        if ($user->favoriteActors()->where('actor_id', $actor->id)->exists()) {
            $user->favoriteActors()->detach($actor->id);
            $message = 'Actor removido de favoritos';
        } else {
            $user->favoriteActors()->attach($actor->id);
            $message = 'Actor añadido a favoritos';
        }

        return back()->with('success', $message);
    }
}