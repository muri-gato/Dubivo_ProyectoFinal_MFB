<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // RELACIONES
    public function actorProfile()
    {
        return $this->hasOne(Actor::class);
    }

    public function sentRequests()
    {
        return $this->hasMany(Request::class, 'client_id');
    }

    public function receivedRequests()
    {
        return $this->hasMany(Request::class, 'actor_id');
    }

    public function schools()
{
    return $this->hasManyThrough(School::class, Actor::class);
}

    // SCOPES PARA ROLES
    public function scopeActors($query)
    {
        return $query->where('role', 'actor');
    }

    public function scopeClients($query)
    {
        return $query->where('role', 'client');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    // HELPERS
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isActor()
    {
        return $this->role === 'actor';
    }

    public function isClient()
    {
        return $this->role === 'client';
    }
}