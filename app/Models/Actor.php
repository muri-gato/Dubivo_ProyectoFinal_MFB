<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'photo',
        'audio_path',
        'genders',
        'voice_ages',
        'is_available',
        'voice_characteristics'
    ];

    protected $casts = [
        'genders' => 'array',
        'voice_ages' => 'array',
        'is_available' => 'boolean',
        'voice_characteristics' => 'array',
    ];

    public static function getGenderOptions()
    {
        return ['Masculino', 'Femenino', 'Otro'];
    }

    public static function getVoiceAgeOptions()
    {
        return ['Niño', 'Adolescente', 'Adulto joven', 'Adulto', 'Anciano', 'Atipada'];
    }


    public function scopeFilterByVoiceAges($query, $voiceAges)
    {
        if ($voiceAges && count($voiceAges) > 0) {
            $query->where(function ($q) use ($voiceAges) {
                foreach ($voiceAges as $age) {
                    $q->orWhereJsonContains('voice_ages', $age);
                }
            });
        }
        return $query;
    }

    public function scopeFilterByGenders($query, $genders)
    {
        if ($genders && count($genders) > 0) {
            $query->where(function ($q) use ($genders) {
                foreach ($genders as $gender) {
                    $q->orWhereJsonContains('genders', $gender);
                }
            });
        }
        return $query;
    }

    public function scopeFilterByAvailability($query, $availability)
    {
        if ($availability !== null) {
            return $query->where('is_available', $availability);
        }
        return $query;
    }

    public function scopeFilterBySchools($query, $schoolIds)
    {
        if ($schoolIds && count($schoolIds) > 0) {
            return $query->whereHas('schools', function ($q) use ($schoolIds) {
                $q->whereIn('schools.id', $schoolIds);
            });
        }
        return $query;
    }

    // ACCESORS
    public function getNameAttribute()
    {
        return $this->user->name;
    }

    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    // HELPERS para mostrar como string
    public function getVoiceAgesStringAttribute()
    {
        $voiceAges = $this->voice_ages;
        if (is_string($voiceAges)) {
            $voiceAges = json_decode($voiceAges, true) ?? [];
        }
        // Asegurar que siempre sea array
        $voiceAges = is_array($voiceAges) ? $voiceAges : [];
        return $voiceAges ? implode(', ', $voiceAges) : '';
    }

    public function getGendersStringAttribute()
    {
        $genders = $this->genders;
        if (is_string($genders)) {
            $genders = json_decode($genders, true) ?? [];
        }
        // Asegurar que siempre sea array
        $genders = is_array($genders) ? $genders : [];
        return $genders ? implode(', ', $genders) : '';
    }

    // Obtener arrays seguros:
    public function getGendersArrayAttribute()
    {
        $genders = $this->genders;
        if (is_string($genders)) {
            $genders = json_decode($genders, true) ?? [];
        }
        return is_array($genders) ? $genders : [];
    }
    public function getVoiceAgesArrayAttribute()
    {
        $voiceAges = $this->voice_ages;
        if (is_string($voiceAges)) {
            $voiceAges = json_decode($voiceAges, true) ?? [];
        }
        return is_array($voiceAges) ? $voiceAges : [];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'actor_school');
    }

    public function works() // o works - revisa cómo lo llamaste en la migración
    {
        return $this->belongsToMany(Work::class, 'actor_work')
            ->withPivot('character_name')
            ->withTimestamps();
    }

    public function teachingSchools()
    {
        return $this->belongsToMany(School::class, 'actor_school_teacher')
            ->withPivot('subject', 'teaching_bio', 'is_active_teacher')
            ->withTimestamps();
    }

    public function isTeacher()
    {
        return $this->teachingSchools()->where('is_active_teacher', true)->exists();
    }

    public function getActiveTeachingSchools()
    {
        return $this->teachingSchools()->where('is_active_teacher', true)->get();
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'actor_user_favorites')
            ->withTimestamps();
    }

    public function isFavoritedBy($userId)
    {
        return $this->favoritedByUsers()->where('user_id', $userId)->exists();
    }
}
