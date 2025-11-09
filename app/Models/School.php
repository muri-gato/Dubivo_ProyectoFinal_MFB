<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'description',
        'founded_year',
        'website'
    ];

    // RELACIONES
    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'actor_school')
                    ->withTimestamps();
    }
}