<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'actor_id',
        'subject',
        'message',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    // RELACIONES
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    // SCOPES
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // MÉTODOS DE ESTADO
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isAccepted()
    {
        return $this->status === 'accepted';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}