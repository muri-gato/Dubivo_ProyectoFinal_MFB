@extends('layouts.app')

@section('title', 'Crear Perfil de Actor - Banco de Voces')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Crear Perfil de Actor</h1>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Columna de Información -->
        <div class="lg:w-3/4">
            <div class="bg-white shadow-md p-6 border border-gray-200">
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Completa tu perfil</h2>
                    <p class="text-gray-600 mt-2">Aparecerás en nuestro banco de voces para que los clientes te encuentren</p>
                </div>

                <form action="{{ route('actors.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Géneros (MÚLTIPLE SELECCIÓN) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Géneros que puedes interpretar <span class="text-rojo-intenso">*</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            @foreach($genders as $gender)
                            <label class="flex items-center p-3 border border-gray-300 hover:border-rosa-electrico cursor-pointer transition duration-150 group">
                                <input type="checkbox" name="genders[]" value="{{ $gender }}" 
                                       {{ in_array($gender, old('genders', [])) ? 'checked' : '' }}
                                       class="text-rosa-electrico focus:ring-rosa-electrico">
                                <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-rosa-electrico">{{ $gender }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('genders')
                            <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Edades Vocales (MÚLTIPLE SELECCIÓN) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Edades vocales que puedes interpretar <span class="text-rojo-intenso">*</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($voiceAges as $age)
                            <label class="flex items-center p-3 border border-gray-300 hover:border-naranja-vibrante cursor-pointer transition duration-150 group">
                                <input type="checkbox" name="voice_ages[]" value="{{ $age }}" 
                                       {{ in_array($age, old('voice_ages', [])) ? 'checked' : '' }}
                                       class="text-naranja-vibrante focus:ring-naranja-vibrante">
                                <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-naranja-vibrante">{{ $age }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('voice_ages')
                            <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Disponibilidad (CHECKBOX ÚNICO) -->
                    <div>
                        <label class="flex items-center space-x-3 cursor-pointer p-3 border border-gray-300 hover:border-verde-menta transition duration-150 group">
                            <input type="checkbox" name="is_available" value="1" 
                                   {{ old('is_available', true) ? 'checked' : '' }}
                                   class="text-verde-menta focus:ring-verde-menta">
                            <span class="text-sm font-medium text-gray-700 group-hover:text-verde-menta">Disponible para nuevos proyectos</span>
                        </label>
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
                                  placeholder="Cuéntanos sobre tu experiencia, formación y especialidades...">{{ old('bio') }}</textarea>
                        @error('bio')
                            <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Archivos -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Foto de Perfil -->
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto de Perfil
                            </label>
                            <input type="file" name="photo" id="photo" 
                                   accept="image/*"
                                   class="w-full border border-gray-300 px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico transition duration-200">
                            <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF. Máx: 2MB</p>
                            @error('photo')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Muestra de Audio -->
                        <div>
                            <label for="audio_path" class="block text-sm font-medium text-gray-700 mb-2">
                                Muestra de Voz
                            </label>
                            <input type="file" name="audio_path" id="audio_path" 
                                   accept="audio/*"
                                   class="w-full border border-gray-300 px-3 py-2 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200">
                            <p class="text-xs text-gray-500 mt-1">Formatos: MP3, WAV. Máx: 5MB</p>
                            @error('audio_path')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Escuelas (MÚLTIPLE SELECCIÓN) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Formación Académica
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-48 overflow-y-auto border border-gray-200 p-4">
                            @forelse($schools as $school)
                                <label class="flex items-center space-x-3 cursor-pointer p-2 hover:bg-gray-50 transition duration-150 group">
                                    <input type="checkbox" name="schools[]" value="{{ $school->id }}" 
                                           class="text-ambar focus:ring-ambar"
                                           {{ in_array($school->id, old('schools', [])) ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700 group-hover:text-ambar">
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

                    <!-- Botones -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('dashboard') }}" 
                           class="px-6 py-2 border border-gray-300 text-gray-700 hover:bg-gray-50 transition duration-200 font-semibold">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-verde-menta text-white hover:bg-verde-menta hover:bg-opacity-90 transition duration-200 font-semibold">
                            Crear Perfil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Columna de Información Lateral -->
        <div class="lg:w-1/4">
            <div class="bg-white p-6 shadow-md sticky top-4 border border-gray-200">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Información importante</h2>
                
                <div class="space-y-4 text-sm text-gray-600">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>Puedes seleccionar <strong>múltiples géneros y edades vocales</strong></span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>Tu perfil será visible para clientes y productores</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>Puedes actualizar tu información en cualquier momento</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>La muestra de voz ayuda a los clientes a conocer tu talento</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>Cuanta más información completes, más visible serás</span>
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
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    // Mostrar resultados de búsqueda
    function displaySearchResults(works) {
        searchResults.innerHTML = '';
        
        if (works.length === 0) {
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
        const workElements = selectedWorks.querySelectorAll('[onclick]');
        workElements.forEach(element => {
            if (element.getAttribute('onclick').includes(workId)) {
                element.closest('.border').remove();
            }
        });

        // Remover input hidden
        const hiddenInputs = worksInputs.querySelectorAll('input');
        hiddenInputs.forEach(input => {
            if (input.value == workId) {
                input.remove();
            }
        });
    }

    // Cerrar resultados al hacer click fuera
    document.addEventListener('click', function(e) {
        if (!workSearch.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });

    // Cargar obras ya seleccionadas (para edición)
    @if(old('works'))
        @foreach(old('works') as $workId)
            @php
                $work = \App\Models\Work::find($workId);
            @endphp
            @if($work)
                addSelectedWork({
                    id: {{ $work->id }},
                    title: '{{ $work->title }}',
                    type: '{{ $work->type }}',
                    year: '{{ $work->year }}'
                });
            @endif
        @endforeach
    @endif
});
</script>

<style>
    * {
        border-radius: 0 !important;
    }
</style>
@endsection