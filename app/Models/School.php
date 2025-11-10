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
        'website',
        'logo'
    ];

    // RELACIONES
    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'actor_school')
            ->withTimestamps();
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function teacherActors()
    {
        return $this->belongsToMany(Actor::class, 'actor_school_teacher')
            ->withPivot('subject', 'teaching_bio', 'is_active_teacher')
            ->withTimestamps();
    }
}
