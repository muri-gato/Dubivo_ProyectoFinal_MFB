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

    // OPCIONES DISPONIBLES
    public static function getGenderOptions()
    {
        return ['Masculino', 'Femenino', 'Otro'];
    }

    public static function getVoiceAgeOptions()
    {
        return ['Niño', 'Adolescente', 'Adulto joven', 'Adulto', 'Anciano', 'Atipada'];
    }

    // SCOPES PARA FILTROS
    public function scopeFilterByVoiceAges($query, $voiceAges)
    {
        if ($voiceAges && count($voiceAges) > 0) {
            foreach ($voiceAges as $age) {
                $query->whereJsonContains('voice_ages', $age);
            }
        }
        return $query;
    }

    public function scopeFilterByGenders($query, $genders)
    {
        if ($genders && count($genders) > 0) {
            foreach ($genders as $gender) {
                $query->whereJsonContains('genders', $gender);
            }
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
        return $this->voice_ages ? implode(', ', $this->voice_ages) : '';
    }

    public function getGendersStringAttribute()
    {
        return $this->genders ? implode(', ', $this->genders) : '';
    }

}