@extends('layouts.app')

@section('title', isset($isAdmin) ? 'Editar ' . $actor->user->name . ' - Admin' : 'Editar Perfil de Actor - Dubivo')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <!-- Header diferenciado según rol -->
    @if(isset($isAdmin) && $isAdmin)
    <!-- Header Admin -->
    <div class="bg-white shadow-md p-6 mb-6">
        <div class="border-b border-gray-200 pb-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    @if($actor->photo)
                    <img src="{{ asset('storage/' . $actor->photo) }}"
                        alt="{{ $actor->user->name }}"
                        class="w-16 h-16 object-cover mr-4 rounded">
                    @else
                    <div class="w-16 h-16 bg-gray-200 flex items-center justify-center mr-4 rounded">
                        <i class="fas fa-user text-gray-400 text-xl"></i>
                    </div>
                    @endif
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Editar Actor</h1>
                        <p class="text-gray-600 mt-1">{{ $actor->user->name }} ({{ $actor->user->email }})</p>
                    </div>
                </div>
                <div class="text-sm text-gray-500">
                    ID: {{ $actor->id }} • Creado: {{ $actor->created_at->format('d/m/Y') }}
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Header Actor -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Editar Perfil de Actor</h1>
    </div>

    {{-- Mensaje de bienvenida --}}
    @if(session('success') && str_contains(session('success'), 'Completa tu información adicional'))
    <div class="bg-azul-profundo bg-opacity-10 p-4 mb-6 border border-azul-profundo border-opacity-20">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-star text-azul-profundo text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-azul-profundo">¡Bienvenido a Dubivo!</h3>
                <div class="mt-2 text-sm text-azul-profundo">
                    <p>Completa tu perfil profesional para que los clientes puedan encontrarte.</p>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Formulario Principal -->
        <div class="{{ isset($isAdmin) && $isAdmin ? 'w-full' : 'lg:w-3/4' }}">
            <div class="bg-white shadow-md p-6 border border-gray-200">
                @if(!isset($isAdmin))
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Actualiza tu información</h2>
                    <p class="text-gray-600 mt-2">Mantén tu perfil actualizado para más oportunidades</p>
                </div>
                @endif

                <form action="{{ isset($isAdmin) && $isAdmin ? route('admin.actors.update', $actor) : route('actors.update', $actor) }}" 
                      method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @if(isset($isAdmin) && $isAdmin)
                    <input type="hidden" name="user_id" value="{{ $actor->user_id }}">
                    @endif

                    <!-- Distribución en 2 columnas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Columna Izquierda -->
                        <div class="space-y-6">
                            <!-- Géneros -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Géneros que puede{{ !isset($isAdmin) ? 's' : '' }} interpretar 
                                    <span class="text-rojo-intenso">*</span>
                                </label>
                                <div class="filter-scroll-container border border-gray-200 bg-gray-50">
                                    @php
                                        $currentGenders = is_array($actor->genders) ? $actor->genders : json_decode($actor->genders, true) ?? [];
                                        $currentGenders = old('genders', $currentGenders);
                                    @endphp
                                    @foreach($genders as $gender)
                                    <label class="flex items-center p-3 border-b border-gray-100 last:border-b-0 hover:bg-gray-100 cursor-pointer transition duration-150">
                                        <input type="checkbox" name="genders[]" value="{{ $gender }}"
                                            {{ in_array($gender, $currentGenders) ? 'checked' : '' }}
                                            class="border-gray-300 text-rosa-electrico focus:ring-rosa-electrico">
                                        <span class="ml-3 text-sm font-medium text-gray-700">{{ $gender }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                @error('genders')
                                    <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Edades Vocales -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Edades vocales que puede{{ !isset($isAdmin) ? 's' : '' }} interpretar 
                                    <span class="text-rojo-intenso">*</span>
                                </label>
                                <div class="filter-scroll-container border border-gray-200 bg-gray-50">
                                    @php
                                        $currentVoiceAges = is_array($actor->voice_ages) ? $actor->voice_ages : json_decode($actor->voice_ages, true) ?? [];
                                        $currentVoiceAges = old('voice_ages', $currentVoiceAges);
                                    @endphp
                                    @foreach($voiceAges as $age)
                                    <label class="flex items-center p-3 border-b border-gray-100 last:border-b-0 hover:bg-gray-100 cursor-pointer transition duration-150">
                                        <input type="checkbox" name="voice_ages[]" value="{{ $age }}"
                                            {{ in_array($age, $currentVoiceAges) ? 'checked' : '' }}
                                            class="border-gray-300 text-naranja-vibrante focus:ring-naranja-vibrante">
                                        <span class="ml-3 text-sm font-medium text-gray-700">{{ $age }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                @error('voice_ages')
                                    <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Columna Derecha -->
                        <div class="space-y-6">
                            <!-- Biografía -->
                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                                    Biografía
                                </label>
                                <textarea name="bio" id="bio" rows="6"
                                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-azul-profundo focus:border-azul-profundo transition duration-200"
                                    placeholder="{{ !isset($isAdmin) ? 'Cuéntanos sobre tu experiencia, formación y especialidades...' : 'Biografía profesional del actor...' }}">{{ old('bio', $actor->bio) }}</textarea>
                                @error('bio')
                                    <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Disponibilidad -->
                            <div class="p-4 border border-gray-200 bg-gray-50">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Estado de disponibilidad
                                </label>
                                <div class="flex items-center space-x-4">
                                    <button type="button" 
                                            id="availabilityToggle"
                                            class="relative inline-flex h-8 w-16 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 {{ old('is_available', $actor->is_available) ? 'bg-verde-menta focus:ring-verde-menta' : 'bg-gray-300 focus:ring-gray-400' }}">
                                        <span class="inline-block h-6 w-6 transform bg-white rounded-full shadow-lg transition-transform duration-200 {{ old('is_available', $actor->is_available) ? 'translate-x-9' : 'translate-x-1' }}"></span>
                                    </button>
                                    <input type="hidden" name="is_available" id="availabilityInput" value="{{ old('is_available', $actor->is_available) ? '1' : '0' }}">
                                    <div>
                                        <span class="text-sm font-medium text-gray-700 block" id="availabilityText">
                                            {{ old('is_available', $actor->is_available) ? 'Disponible' : 'No disponible' }}
                                        </span>
                                        <span class="text-xs text-gray-500" id="availabilitySubtext">
                                            {{ old('is_available', $actor->is_available) ? 'Los clientes pueden contactarte' : 'No aparecerás en búsquedas' }}
                                        </span>
                                    </div>
                                </div>
                                @error('is_available')
                                    <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Archivos (Foto y Audio) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <!-- Foto -->
                        <div class="p-4 border border-gray-200 bg-gray-50">
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto de perfil
                            </label>
                            @if($actor->photo)
                            <div class="flex items-center space-x-4 mb-3">
                                <img src="{{ asset('storage/' . $actor->photo) }}"
                                    alt="Foto actual"
                                    class="w-16 h-16 object-cover border-2 border-amber-500 rounded">
                                <span class="text-sm text-gray-600">Foto actual</span>
                            </div>
                            @endif
                            <input type="file" name="photo" id="photo"
                                accept="image/*"
                                class="w-full border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-rosa-electrico focus:border-rosa-electrico">
                            <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener la actual</p>
                            @error('photo')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Audio -->
                        <div class="p-4 border border-gray-200 bg-gray-50">
                            <label for="audio_path" class="block text-sm font-medium text-gray-700 mb-2">
                                Muestra de voz
                            </label>
                            @if($actor->audio_path)
                            <div class="flex items-center space-x-4 mb-3">
                                <i class="fas fa-volume-up text-azul-profundo text-xl"></i>
                                <audio controls class="h-8">
                                    <source src="{{ asset('storage/' . $actor->audio_path) }}" type="audio/mpeg">
                                </audio>
                            </div>
                            @endif
                            <input type="file" name="audio_path" id="audio_path"
                                accept="audio/*"
                                class="w-full border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-azul-profundo focus:border-azul-profundo">
                            <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener la actual</p>
                            @error('audio_path')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Escuelas y Obras -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <!-- Escuelas -->
                        <div class="p-4 border border-gray-200 bg-gray-50">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Escuelas de formación
                            </label>
                            <div class="filter-scroll-container border border-gray-200 bg-white">
                                @foreach($schools as $school)
                                <label class="flex items-center p-3 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" name="schools[]" value="{{ $school->id }}"
                                        class="border-gray-300 text-azul-profundo focus:ring-azul-profundo"
                                        {{ in_array($school->id, old('schools', $actor->schools->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <span class="ml-3 text-sm text-gray-700">{{ $school->name }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('schools')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Obras -->
                        <div class="p-4 border border-gray-200 bg-gray-50">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Obras participadas
                            </label>
                            <div class="filter-scroll-container border border-gray-200 bg-white">
                                @foreach($works as $work)
                                <div class="flex items-start p-3 border-b border-gray-100 last:border-b-0 hover:bg-gray-50">
                                    <input type="checkbox" name="works[]" value="{{ $work->id }}"
                                        class="mt-1 border-gray-300 text-azul-profundo focus:ring-azul-profundo"
                                        {{ in_array($work->id, old('works', $actor->works->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <div class="ml-3 flex-1">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <span class="text-sm font-medium text-gray-700">{{ $work->title }}</span>
                                                <div class="text-xs text-gray-500 capitalize">
                                                    {{ $work->type }} @if($work->year)• {{ $work->year }}@endif
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                        $characterName = $actor->works->find($work->id)->pivot->character_name ?? '';
                                        @endphp
                                        <input type="text" name="character_names[{{ $work->id }}]"
                                            placeholder="Nombre del personaje"
                                            class="mt-2 w-full text-sm border border-gray-300 px-3 py-1 focus:border-azul-profundo focus:ring-azul-profundo"
                                            value="{{ old('character_names.' . $work->id, $characterName) }}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Profesor (Solo para Admin) -->
                    @if(isset($isAdmin) && $isAdmin)
                    <div class="mt-6 p-4 border border-gray-200 bg-gray-50">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Información como Profesor</h2>
                        <div class="space-y-3">
                            @foreach($schools as $school)
                            <div class="flex items-center justify-between p-3 border border-gray-200 bg-white">
                                <label class="flex items-center">
                                    <input type="checkbox" name="teaching_schools[]" value="{{ $school->id }}"
                                        {{ in_array($school->id, $currentTeachingSchools ?? []) ? 'checked' : '' }}
                                        class="text-blue-600 focus:ring-blue-500 teaching-school-checkbox">
                                    <span class="ml-2 text-sm text-gray-700">{{ $school->name }}</span>
                                </label>

                                <div class="teaching-school-fields ml-4 {{ in_array($school->id, $currentTeachingSchools ?? []) ? '' : 'hidden' }}">
                                    <input type="text" name="teaching_subjects[{{ $school->id }}]"
                                        placeholder="Materia que imparte"
                                        value="{{ $actor->teachingSchools->firstWhere('id', $school->id)?->pivot?->subject }}"
                                        class="border border-gray-300 px-3 py-1 text-sm w-48">
                                    <textarea name="teaching_bios[{{ $school->id }}]"
                                        placeholder="Bio como profesor"
                                        class="border border-gray-300 px-3 py-1 text-sm w-48 ml-2">{{ $actor->teachingSchools->firstWhere('id', $school->id)?->pivot?->teaching_bio }}</textarea>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Botones -->
                    <div class="flex {{ isset($isAdmin) && $isAdmin ? 'justify-between' : 'justify-end' }} items-center pt-6 border-t border-gray-200">
                        @if(isset($isAdmin) && $isAdmin)
                        <div>
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                                Usuario: {{ $actor->user->email }}
                            </p>
                        </div>
                        @endif
                        <div class="flex space-x-4">
                            <a href="{{ isset($isAdmin) && $isAdmin ? route('admin.actors') : route('actors.show', $actor) }}"
                                class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 transition duration-200 font-medium">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="px-6 py-3 {{ isset($isAdmin) && $isAdmin ? 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500' : 'bg-verde-menta hover:bg-verde-menta hover:bg-opacity-90' }} text-white hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-200 font-medium flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                {{ isset($isAdmin) && $isAdmin ? 'Actualizar Actor' : 'Actualizar Perfil' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Columna de Información Lateral (Solo para Actor) -->
        @if(!isset($isAdmin))
        <div class="lg:w-1/4">
            <div class="bg-white p-6 shadow-md sticky top-4 border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Estado del perfil</h2>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Visibilidad:</span>
                        <span class="text-sm font-medium {{ $actor->is_available ? 'text-verde-menta' : 'text-rojo-intenso' }}">
                            {{ $actor->is_available ? 'Público' : 'No disponible' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Última actualización:</span>
                        <span class="text-sm text-gray-500">{{ $actor->updated_at->diffForHumans() }}</span>
                    </div>
                </div>

                <!-- Consejos para mejorar -->
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="font-medium text-gray-700 mb-2">Consejos para mejorar</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        @if(!$actor->photo)
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-camera text-rosa-electrico"></i>
                            <span>Añade una foto profesional</span>
                        </div>
                        @endif
                        @if(!$actor->audio_path)
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-volume-up text-azul-profundo"></i>
                            <span>Sube una muestra de voz</span>
                        </div>
                        @endif
                        @if(!$actor->bio)
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-file-alt text-ambar"></i>
                            <span>Completa tu biografía</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
.filter-scroll-container {
    max-height: 12rem;
    overflow-y: auto;
    padding: 0;
}

.filter-scroll-container::-webkit-scrollbar {
    width: 6px;
}

.filter-scroll-container::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.filter-scroll-container::-webkit-scrollbar-thumb {
    background: #c1c1c1;
}

.filter-scroll-container::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Colores personalizados */
.text-rosa-electrico { color: #ec4899; }
.text-naranja-vibrante { color: #f97316; }
.text-azul-profundo { color: #1e40af; }
.text-verde-menta { color: #10b981; }
.text-rojo-intenso { color: #ef4444; }

.bg-rosa-electrico { background-color: #ec4899; }
.bg-naranja-vibrante { background-color: #f97316; }
.bg-azul-profundo { background-color: #1e40af; }
.bg-verde-menta { background-color: #10b981; }
.bg-rojo-intenso { background-color: #ef4444; }

.border-rosa-electrico { border-color: #ec4899; }
.border-naranja-vibrante { border-color: #f97316; }
.border-azul-profundo { border-color: #1e40af; }
.border-verde-menta { border-color: #10b981; }
.border-rojo-intenso { border-color: #ef4444; }

.focus\:ring-rosa-electrico:focus { --tw-ring-color: #ec4899; }
.focus\:ring-naranja-vibrante:focus { --tw-ring-color: #f97316; }
.focus\:ring-azul-profundo:focus { --tw-ring-color: #1e40af; }
.focus\:ring-verde-menta:focus { --tw-ring-color: #10b981; }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Switch para disponibilidad
    const availabilityToggle = document.getElementById('availabilityToggle');
    const availabilityInput = document.getElementById('availabilityInput');
    
    if (availabilityToggle) {
        const availabilityText = document.getElementById('availabilityText');
        const availabilitySubtext = document.getElementById('availabilitySubtext');
        
        availabilityToggle.addEventListener('click', function() {
            const isAvailable = availabilityInput.value === '1';
            availabilityInput.value = isAvailable ? '0' : '1';
            
            if (availabilityInput.value === '1') {
                this.classList.remove('bg-gray-300', 'focus:ring-gray-400');
                this.classList.add('bg-verde-menta', 'focus:ring-verde-menta');
                this.querySelector('span').classList.remove('translate-x-1');
                this.querySelector('span').classList.add('translate-x-9');
                availabilityText.textContent = 'Disponible';
                if(availabilitySubtext) {
                    availabilitySubtext.textContent = 'Los clientes pueden contactarte';
                }
            } else {
                this.classList.remove('bg-verde-menta', 'focus:ring-verde-menta');
                this.classList.add('bg-gray-300', 'focus:ring-gray-400');
                this.querySelector('span').classList.remove('translate-x-9');
                this.querySelector('span').classList.add('translate-x-1');
                availabilityText.textContent = 'No disponible';
                if(availabilitySubtext) {
                    availabilitySubtext.textContent = 'No aparecerás en búsquedas';
                }
            }
        });
    }

    // Toggle para escuelas de profesor (solo admin)
    const teachingCheckboxes = document.querySelectorAll('.teaching-school-checkbox');
    teachingCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const fields = this.closest('.flex').querySelector('.teaching-school-fields');
            if (this.checked) {
                fields.classList.remove('hidden');
            } else {
                fields.classList.add('hidden');
            }
        });
    });
});
</script>
@endsection