@extends('layouts.app')

@section('title', 'Editar Perfil de Actor - Dubivo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Editar Perfil de Actor</h1>
    </div>

    {{-- Mensaje de bienvenida para nuevos actores --}}
    @if(session('success') && str_contains(session('success'), 'Completa tu información adicional'))
        <div class="bg-azul-profundo bg-opacity-10 border border-azul-profundo border-opacity-20 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-star text-azul-profundo text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-azul-profundo">¡Bienvenido a Dubivo!</h3>
                    <div class="mt-2 text-sm text-azul-profundo">
                        <p>Completa tu perfil profesional para que los clientes puedan encontrarte. Puedes añadir:</p>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>Foto profesional</li>
                            <li>Audio de demostración</li>
                            <li>Tus escuelas de formación</li>
                            <li>Tus trabajos anteriores</li>
                            <li>Características específicas de tu voz</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Formulario Principal -->
        <div class="lg:w-3/4">
            <div class="bg-white shadow-md p-6 border-l-4 border-rosa-electrico">
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Actualiza tu información</h2>
                    <p class="text-gray-600 mt-2">Mantén tu perfil actualizado para más oportunidades</p>
                </div>

                <form action="{{ route('actors.update', $actor) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Información Básica -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Géneros -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Géneros que puedes interpretar <span class="text-rojo-intenso">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                @foreach($genders as $gender)
                                @php
                                    $currentGenders = is_array(old('genders', $actor->genders ?? [])) 
                                        ? old('genders', $actor->genders ?? []) 
                                        : (is_string($actor->genders ?? '') ? explode(',', $actor->genders) : []);
                                    $isChecked = in_array($gender, $currentGenders);
                                @endphp
                                <label class="flex items-center p-3 border border-gray-300 hover:border-rosa-electrico cursor-pointer transition duration-150 group {{ $isChecked ? 'bg-rosa-electrico bg-opacity-10 border-rosa-electrico' : '' }}">
                                    <input type="checkbox" name="genders[]" value="{{ $gender }}" 
                                           {{ $isChecked ? 'checked' : '' }}
                                           class="text-rosa-electrico focus:ring-rosa-electrico">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-rosa-electrico {{ $isChecked ? 'text-rosa-electrico' : '' }}">{{ $gender }}</span>
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
                                Edades vocales que puedes interpretar <span class="text-rojo-intenso">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($voiceAges as $age)
                                @php
                                    $currentVoiceAges = is_array(old('voice_ages', $actor->voice_ages ?? [])) 
                                        ? old('voice_ages', $actor->voice_ages ?? []) 
                                        : (is_string($actor->voice_ages ?? '') ? explode(',', $actor->voice_ages) : []);
                                    $isChecked = in_array($age, $currentVoiceAges);
                                @endphp
                                <label class="flex items-center p-3 border border-gray-300 hover:border-naranja-vibrante cursor-pointer transition duration-150 group {{ $isChecked ? 'bg-naranja-vibrante bg-opacity-10 border-naranja-vibrante' : '' }}">
                                    <input type="checkbox" name="voice_ages[]" value="{{ $age }}" 
                                           {{ $isChecked ? 'checked' : '' }}
                                           class="text-naranja-vibrante focus:ring-naranja-vibrante">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-naranja-vibrante {{ $isChecked ? 'text-naranja-vibrante' : '' }}">{{ $age }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('voice_ages')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Disponibilidad con Toggle Switch -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Disponibilidad para nuevos proyectos
                        </label>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600 {{ !$actor->is_available ? 'font-semibold' : '' }}">No disponible</span>
                            
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_available" value="1" class="sr-only peer" 
                                       {{ old('is_available', $actor->is_available) ? 'checked' : '' }}>
                                <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-verde-menta peer-focus:ring-opacity-30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-verde-menta"></div>
                            </label>
                            
                            <span class="text-sm text-gray-600 {{ $actor->is_available ? 'font-semibold' : '' }}">Disponible</span>
                        </div>
                        @error('is_available')
                            <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Biografía -->
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                            Biografía
                        </label>
                        <textarea name="bio" id="bio" rows="4"
                                  class="w-full border border-gray-300 px-3 py-2 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200"
                                  placeholder="Cuéntanos sobre tu experiencia, formación y especialidades...">{{ old('bio', $actor->bio) }}</textarea>
                        @error('bio')
                            <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Archivos Actuales -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Foto Actual -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Foto de Perfil Actual
                            </label>
                            @if($actor->photo)
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('storage/' . $actor->photo) }}" 
                                         alt="Foto actual" 
                                         class="w-16 h-16 object-cover border-2 border-ambar">
                                    <span class="text-sm text-gray-600">Foto actual</span>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No hay foto de perfil</p>
                            @endif
                        </div>

                        <!-- Audio Actual -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Muestra de Voz Actual
                            </label>
                            @if($actor->audio_path)
                                <div class="flex items-center space-x-4">
                                    <i class="fas fa-volume-up text-azul-profundo text-xl"></i>
                                    <audio controls class="h-8">
                                        <source src="{{ asset('storage/' . $actor->audio_path) }}" type="audio/mpeg">
                                    </audio>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No hay muestra de voz</p>
                            @endif
                        </div>
                    </div>

                    <!-- Nuevos Archivos -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nueva Foto -->
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Cambiar Foto de Perfil
                            </label>
                            <input type="file" name="photo" id="photo" 
                                   accept="image/*"
                                   class="w-full border border-gray-300 px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico transition duration-200">
                            <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener la actual</p>
                            @error('photo')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nuevo Audio -->
                        <div>
                            <label for="audio_path" class="block text-sm font-medium text-gray-700 mb-2">
                                Cambiar Muestra de Voz
                            </label>
                            <input type="file" name="audio_path" id="audio_path" 
                                   accept="audio/*"
                                   class="w-full border border-gray-300 px-3 py-2 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200">
                            <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener la actual</p>
                            @error('audio_path')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Escuelas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Formación Académica
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-48 overflow-y-auto border border-gray-200 p-4">
                            @forelse($schools as $school)
                                @php
                                    $actorSchoolIds = $actor->schools->pluck('id')->toArray();
                                    $isChecked = in_array($school->id, old('schools', $actorSchoolIds));
                                @endphp
                                <label class="flex items-center space-x-3 cursor-pointer p-2 hover:bg-gray-50 transition duration-150 group {{ $isChecked ? 'bg-ambar bg-opacity-10' : '' }}">
                                    <input type="checkbox" name="schools[]" value="{{ $school->id }}" 
                                           class="text-ambar focus:ring-ambar"
                                           {{ $isChecked ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700 group-hover:text-ambar {{ $isChecked ? 'text-ambar font-semibold' : '' }}">
                                        {{ $school->name }} 
                                        @if($school->city)
                                            <span class="text-gray-500">({{ $school->city }})</span>
                                        @endif
                                    </span>
                                </label>
                            @empty
                                <p class="text-gray-500 text-sm col-span-2">No hay escuelas registradas</p>
                            @endforelse
                        </div>
                        @error('schools')
                            <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Obras (BÚSQUEDA CON AUTOCOMPLETADO) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Trabajos Destacados
                        </label>
                        
                        <!-- Contenedor para las obras seleccionadas -->
                        <div id="selectedWorks" class="mb-4 space-y-2">
                            <!-- Las obras seleccionadas se añadirán aquí dinámicamente -->
                        </div>

                        <!-- Input de búsqueda -->
                        <div class="relative">
                            <input type="text" 
                                   id="workSearch" 
                                   placeholder="Buscar obra por título..."
                                   class="w-full border border-gray-300 px-3 py-2 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Resultados de búsqueda -->
                        <div id="searchResults" class="hidden mt-2 border border-gray-200 max-h-48 overflow-y-auto">
                            <!-- Los resultados aparecerán aquí -->
                        </div>

                        <!-- Inputs ocultos para enviar al formulario -->
                        <div id="worksInputs">
                            <!-- Se generarán dinámicamente -->
                        </div>

                        <p class="text-xs text-gray-500 mt-1">Escribe el título de una obra y selecciónala de la lista</p>
                        @error('works')
                            <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                        @enderror
                        @error('character_names.*')
                            <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Sección para asignar como profesor --}}
                    @if(Auth::user()->role == 'admin')
                    <div class="bg-ambar bg-opacity-10 border border-ambar border-opacity-30 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-ambar mb-4 flex items-center">
                            <i class="fas fa-chalkboard-teacher mr-2"></i>
                            Asignar como Profesor
                        </h3>
                        
                        <form action="{{ route('admin.schools.teachers.store', $actor) }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Escuela</label>
                                    <select name="school_id" class="w-full border border-gray-300 px-3 py-2 focus:border-ambar focus:ring-ambar">
                                        <option value="">Seleccionar escuela...</option>
                                        @foreach($schools as $school)
                                            <option value="{{ $school->id }}" 
                                                {{ $actor->teachingSchools->contains($school->id) ? 'selected' : '' }}>
                                                {{ $school->name }} - {{ $school->city }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Materia que imparte</label>
                                    <input type="text" name="subject" 
                                           value="{{ $actor->teachingSchools->first() ? $actor->teachingSchools->first()->pivot->subject : '' }}"
                                           class="w-full border border-gray-300 px-3 py-2 focus:border-azul-profundo focus:ring-azul-profundo"
                                           placeholder="Ej: Doblaje, Interpretación...">
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bio como profesor</label>
                                <textarea name="teaching_bio" rows="3" 
                                          class="w-full border border-gray-300 px-3 py-2 focus:border-azul-profundo focus:ring-azul-profundo"
                                          placeholder="Información específica como profesor...">{{ $actor->teachingSchools->first() ? $actor->teachingSchools->first()->pivot->teaching_bio : '' }}</textarea>
                            </div>
                            
                            <div class="mt-4 flex justify-between">
                                @if($actor->teachingSchools->count() > 0)
                                    <button type="submit" name="action" value="update" 
                                            class="bg-azul-profundo hover:bg-azul-profundo hover:bg-opacity-90 text-white px-4 py-2 font-semibold transition duration-200">
                                        Actualizar información de profesor
                                    </button>
                                    <button type="submit" name="action" value="remove" 
                                            class="bg-rojo-intenso hover:bg-rojo-intenso hover:bg-opacity-90 text-white px-4 py-2 font-semibold transition duration-200"
                                            onclick="return confirm('¿Remover como profesor?')">
                                        Remover como profesor
                                    </button>
                                @else
                                    <button type="submit" name="action" value="add" 
                                            class="bg-verde-menta hover:bg-verde-menta hover:bg-opacity-90 text-white px-4 py-2 font-semibold transition duration-200">
                                        Asignar como profesor
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                    @endif

                    <!-- Botones -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('actors.show', $actor) }}" 
                           class="px-6 py-2 border border-gray-300 text-gray-700 hover:bg-gray-50 transition duration-200 font-semibold">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-verde-menta text-white hover:bg-verde-menta hover:bg-opacity-90 transition duration-200 font-semibold">
                            Actualizar Perfil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Columna de Información Lateral -->
        <div class="lg:w-1/4">
            <div class="bg-white p-6 shadow-md sticky top-4 border border-gray-200">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Estado del perfil</h2>
                
                <!-- Información de visibilidad -->
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
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const workSearch = document.getElementById('workSearch');
    const searchResults = document.getElementById('searchResults');
    const selectedWorks = document.getElementById('selectedWorks');
    const worksInputs = document.getElementById('worksInputs');
    let selectedWorksMap = new Map();

    // Búsqueda en tiempo real
    workSearch.addEventListener('input', function(e) {
        const query = e.target.value.trim();
        
        if (query.length < 2) {
            searchResults.classList.add('hidden');
            return;
        }

        fetch(`/works/search?q=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta');
                }
                return response.json();
            })
            .then(data => {
                displaySearchResults(data);
            })
            .catch(error => {
                console.error('Error:', error);
                searchResults.innerHTML = '<div class="p-3 text-gray-500 text-sm">Error en la búsqueda. Intenta de nuevo.</div>';
                searchResults.classList.remove('hidden');
            });
    });

    // Mostrar resultados de búsqueda
    function displaySearchResults(works) {
        searchResults.innerHTML = '';
        
        if (!works || works.length === 0) {
            searchResults.innerHTML = '<div class="p-3 text-gray-500 text-sm">No se encontraron obras</div>';
            searchResults.classList.remove('hidden');
            return;
        }

        works.forEach(work => {
            if (!selectedWorksMap.has(work.id)) {
                const resultItem = document.createElement('div');
                resultItem.className = 'p-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition duration-150';
                resultItem.innerHTML = `
                    <div class="font-medium text-gray-800">${work.title}</div>
                    <div class="text-xs text-gray-500 capitalize">${work.type} ${work.year ? `· ${work.year}` : ''}</div>
                `;
                
                resultItem.addEventListener('click', function() {
                    addSelectedWork(work);
                    workSearch.value = '';
                    searchResults.classList.add('hidden');
                });
                
                searchResults.appendChild(resultItem);
            }
        });

        searchResults.classList.remove('hidden');
    }

    // Añadir obra seleccionada
    function addSelectedWork(work) {
        if (selectedWorksMap.has(work.id)) return;

        const workId = work.id;
        selectedWorksMap.set(workId, work);

        const workItem = document.createElement('div');
        workItem.className = 'border border-gray-200 p-3 rounded bg-gray-50';
        workItem.innerHTML = `
            <div class="flex justify-between items-start mb-2">
                <div>
                    <div class="font-medium text-gray-800">${work.title}</div>
                    <div class="text-xs text-gray-500 capitalize">${work.type} ${work.year ? `· ${work.year}` : ''}</div>
                </div>
                <button type="button" onclick="removeWork(${workId})" class="text-rojo-intenso hover:text-rojo-intenso hover:bg-opacity-90">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div>
                <input type="text" 
                       name="character_names[${workId}]" 
                       placeholder="Personaje que interpretaste"
                       class="w-full text-sm border border-gray-300 px-2 py-1 focus:border-azul-profundo focus:ring-azul-profundo">
            </div>
        `;

        selectedWorks.appendChild(workItem);

        // Añadir input hidden para el formulario
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'works[]';
        hiddenInput.value = workId;
        worksInputs.appendChild(hiddenInput);
    }

    // Remover obra seleccionada
    window.removeWork = function(workId) {
        selectedWorksMap.delete(workId);
        
        // Remover elemento visual
        const workItem = document.querySelector(`[onclick="removeWork(${workId})"]`);
        if (workItem) {
            workItem.closest('.border').remove();
        }

        // Remover input hidden
        const hiddenInput = worksInputs.querySelector(`input[value="${workId}"]`);
        if (hiddenInput) {
            hiddenInput.remove();
        }
    }

    // Cerrar resultados al hacer click fuera
    document.addEventListener('click', function(e) {
        if (!workSearch.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });

    // Cargar obras existentes del actor (versión simplificada)
    @if($actor->works && $actor->works->count() > 0)
        @foreach($actor->works as $work)
            @php
                $characterName = '';
                if ($work->pivot) {
                    $characterName = $work->pivot->character_name ?? '';
                }
            @endphp
            addSelectedWork({
                id: {{ $work->id }},
                title: `{{ $work->title }}`,
                type: `{{ $work->type }}`,
                year: `{{ $work->year ?? '' }}`
            });
            
            @if($characterName)
                setTimeout(() => {
                    const characterInput = document.querySelector('input[name="character_names[{{ $work->id }}]"]');
                    if (characterInput) {
                        characterInput.value = `{{ $characterName }}`;
                    }
                }, 200);
            @endif
        @endforeach
    @endif

    // Cargar obras de old() si existen
    @if(old('works') && is_array(old('works')))
        @foreach(old('works') as $workId)
            @php
                $workExists = $actor->works->contains($workId);
            @endphp
            @if(!$workExists)
                @php
                    $work = \App\Models\Work::find($workId);
                @endphp
                @if($work)
                    addSelectedWork({
                        id: {{ $work->id }},
                        title: `{{ $work->title }}`,
                        type: `{{ $work->type }}`,
                        year: `{{ $work->year ?? '' }}`
                    });
                @endif
            @endif
        @endforeach
    @endif
});
</script>

<style>
    * {
        border-radius: 0 !important;
    }
    
    /* Estilos para el toggle switch */
    .peer:checked ~ .peer-checked\:bg-verde-menta {
        background-color: #10b981 !important;
    }
</style>
@endsection