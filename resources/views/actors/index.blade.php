@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Actores de Voz</h1>

        @auth
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.actors.create') }}"
            class="bg-verde-menta text-white px-6 py-3 hover:bg-verde-menta hover:bg-opacity-90 transition duration-200 flex items-center font-semibold">
            <i class="fas fa-plus mr-2"></i>
            Nuevo Actor
        </a>
        @endif
        @endauth
    </div>

    <!-- Botón para mostrar/ocultar filtros en móvil -->
    <div class="lg:hidden mb-4">
        <button id="filterToggle" class="bg-azul-profundo text-white px-4 py-2 hover:bg-azul-profundo hover:bg-opacity-90 transition duration-200 flex items-center font-semibold w-full justify-center">
            <i class="fas fa-filter mr-2"></i>
            Mostrar Filtros
        </button>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Columna de Filtros - Ahora desplegable -->
        <div id="filterColumn" class="lg:w-1/4 hidden lg:block">
            <div class="bg-white p-6 shadow-md sticky top-4 border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Filtros</h2>
                    <button id="closeFilters" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <form method="GET" action="{{ route('actors.index') }}" id="filter-form">

                    <!-- Buscador en Tiempo Real -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Actor</label>
                        <div class="relative">
                            <input type="text" 
                                   id="searchActor" 
                                   placeholder="Ej: Constantino..."
                                   class="w-full border border-gray-300 px-4 py-2 pl-10 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200"
                                   value="{{ request('search') }}">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Busca por nombre en tiempo real</p>
                    </div>

                    <!-- Favoritos -->
                    @auth
                    @if(Auth::user()->role == 'client')
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Favoritos</label>
                        <select name="favorites" class="w-full border border-gray-300 px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico">
                            <option value="">Todos los actores</option>
                            <option value="true" {{ request('favorites') == 'true' ? 'selected' : '' }}>Solo mis favoritos</option>
                        </select>
                    </div>
                    @endif
                    @endauth

                    <!-- Disponibilidad (Radio buttons) -->
                    <div class="mb-6">
                        <h3 class="font-medium text-gray-700 mb-3">Disponibilidad</h3>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="availability" value="1"
                                    {{ request('availability') == '1' ? 'checked' : '' }}
                                    class="text-verde-menta focus:ring-verde-menta">
                                <span class="ml-2 text-sm text-gray-700">Disponible</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="availability" value="0"
                                    {{ request('availability') == '0' ? 'checked' : '' }}
                                    class="text-rojo-intenso focus:ring-rojo-intenso">
                                <span class="ml-2 text-sm text-gray-700">No disponible</span>
                            </label>
                        </div>
                    </div>

                    <!-- Géneros (Checkboxes) -->
                    <div class="mb-6">
                        <h3 class="font-medium text-gray-700 mb-3">Géneros</h3>
                        <div class="space-y-2">
                            @foreach($genders as $gender)
                            <label class="flex items-center">
                                <input type="checkbox" name="genders[]" value="{{ $gender }}"
                                    {{ in_array($gender, request('genders', [])) ? 'checked' : '' }}
                                    class="text-rosa-electrico focus:ring-rosa-electrico">
                                <span class="ml-2 text-sm text-gray-700">{{ $gender }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Edades Vocales (Checkboxes) -->
                    <div class="mb-6">
                        <h3 class="font-medium text-gray-700 mb-3">Edades Vocales</h3>
                        <div class="space-y-2">
                            @foreach($voiceAges as $age)
                            <label class="flex items-center">
                                <input type="checkbox" name="voice_ages[]" value="{{ $age }}"
                                    {{ in_array($age, request('voice_ages', [])) ? 'checked' : '' }}
                                    class="text-naranja-vibrante focus:ring-naranja-vibrante">
                                <span class="ml-2 text-sm text-gray-700">{{ $age }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Escuelas (Checkboxes) -->
                    <div class="mb-6">
                        <h3 class="font-medium text-gray-700 mb-3">Escuelas</h3>
                        <div class="space-y-2">
                            @foreach($schools as $school)
                            <label class="flex items-center">
                                <input type="checkbox" name="schools[]" value="{{ $school->id }}"
                                    {{ in_array($school->id, request('schools', [])) ? 'checked' : '' }}
                                    class="text-azul-profundo focus:ring-azul-profundo">
                                <span class="ml-2 text-sm text-gray-700">{{ $school->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Botón Limpiar Filtros -->
                    <div>
                        <a href="{{ route('actors.index') }}" class="bg-gray-500 text-white px-4 py-2 hover:bg-gray-600 w-full inline-flex items-center justify-center font-semibold transition duration-200">
                            <i class="fas fa-times mr-2"></i>Limpiar Filtros
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Columna de Resultados -->
        <div class="lg:w-3/4">
            <!-- Info de filtros activos -->
            @if(request()->anyFilled(['availability', 'genders', 'voice_ages', 'schools', 'search']))
            <div class="bg-rosa-electrico bg-opacity-10 p-4 mb-6 border border-rosa-electrico border-opacity-20">
                <p class="text-sm text-rosa-electrico font-medium">
                    <i class="fas fa-filter mr-2"></i>Filtros activos:
                    @if(request('search')) <span class="bg-azul-profundo bg-opacity-20 text-azul-profundo px-2 py-1 mx-1">Búsqueda: "{{ request('search') }}"</span> @endif
                    @if(request('availability') === '1') <span class="bg-verde-menta bg-opacity-20 text-verde-menta px-2 py-1 mx-1">Disponible</span> @endif
                    @if(request('availability') === '0') <span class="bg-rojo-intenso bg-opacity-20 text-rojo-intenso px-2 py-1 mx-1">No disponible</span> @endif
                    @if(request('genders')) <span class="bg-rosa-electrico bg-opacity-20 text-rosa-electrico px-2 py-1 mx-1">Géneros: {{ implode(', ', request('genders')) }}</span> @endif
                    @if(request('voice_ages')) <span class="bg-naranja-vibrante bg-opacity-20 text-naranja-vibrante px-2 py-1 mx-1">Edades: {{ implode(', ', request('voice_ages')) }}</span> @endif
                    @if(request('schools'))
                    <span class="bg-azul-profundo bg-opacity-20 text-azul-profundo px-2 py-1 mx-1">Escuelas: {{ implode(', ', array_map(function($id) use ($schools) { 
                            return $schools->firstWhere('id', $id)->name ?? ''; 
                        }, request('schools'))) }}</span>
                    @endif
                </p>
            </div>
            @endif

            <!-- Contador de resultados -->
            <div class="mb-4">
                <p class="text-sm text-gray-600">
                    <span id="resultsCount">{{ $actors->count() }}</span> actores encontrados
                </p>
            </div>

            <!-- Lista de Actores -->
            <div id="actorsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($actors as $actor)
                <div class="actor-card bg-white shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-200 hover:border-naranja-vibrante hover:scale-105 transform group cursor-pointer flex flex-col h-full"
                     data-name="{{ strtolower($actor->name) }}"
                     data-genders="{{ strtolower($actor->genders_string ?? '') }}"
                     data-voice-ages="{{ strtolower($actor->voice_ages_string ?? '') }}"
                     data-available="{{ $actor->is_available ? 'true' : 'false' }}"
                     data-schools="{{ $actor->schools->pluck('id')->implode(',') }}">
                    
                    <!-- Contenedor de la foto con audio -->
                    <div class="relative flex-1 photo-container" data-audio-src="{{ $actor->audio_path ? asset('storage/' . $actor->audio_path) : '' }}">
                        <!-- CÍRCULO DE DISPONIBILIDAD (arriba a la derecha) -->
                        <div class="absolute top-2 right-2 z-30">
                            @if($actor->is_available)
                            <div class="w-4 h-4 bg-verde-menta border border-white shadow-sm" title="Disponible"></div>
                            @else
                            <div class="w-4 h-4 bg-rojo-intenso border border-white shadow-sm" title="No disponible"></div>
                            @endif
                        </div>

                        <!-- BOTÓN DE FAVORITOS -->
                        @auth
                        @if(Auth::user()->role == 'client')
                        <form action="{{ route('actors.favorite.toggle', $actor) }}" method="POST" class="absolute top-2 left-2 z-20" onclick="event.stopPropagation()">
                            @csrf
                            <button type="submit" class="bg-white bg-opacity-90 p-2 hover:bg-opacity-100 transition shadow-sm hover:shadow-md"
                                title="{{ $actor->isFavoritedBy(Auth::id()) ? 'Quitar de favoritos' : 'Añadir a favoritos' }}">
                                <svg class="w-5 h-5 {{ $actor->isFavoritedBy(Auth::id()) ? 'text-rojo-intenso fill-current' : 'text-gray-400 hover:text-rojo-intenso' }}"
                                    fill="{{ $actor->isFavoritedBy(Auth::id()) ? 'currentColor' : 'none' }}"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </form>
                        @endif
                        @endauth

                        @if($actor->photo)
                        <img src="{{ asset('storage/' . $actor->photo) }}" alt="{{ $actor->name }}" class="w-full h-64 object-cover">
                        @else
                        <div class="w-full h-64 bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition duration-300">
                            <i class="fas fa-user text-gray-400 text-4xl"></i>
                        </div>
                        @endif
                        
                        <!-- Overlay de audio que aparece al hacer hover -->
                        @if($actor->audio_path)
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <button class="bg-azul-profundo bg-opacity-90 hover:bg-opacity-100 text-white p-4 transform scale-90 group-hover:scale-100 transition-all duration-300 audio-play">
                                <i class="fas fa-play text-2xl"></i>
                            </button>
                            <button class="bg-azul-profundo bg-opacity-90 hover:bg-opacity-100 text-white p-4 transform scale-90 group-hover:scale-100 transition-all duration-300 audio-pause hidden">
                                <i class="fas fa-pause text-2xl"></i>
                            </button>
                        </div>
                        @endif
                    </div>

                    <!-- Información del actor (clickable para ir al show) -->
                    <a href="{{ route('actors.show', $actor) }}" class="block p-4 flex flex-col flex-1">
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-naranja-vibrante transition duration-300 leading-tight actor-name mb-3">{{ $actor->name }}</h3>

                        <!-- Géneros -->
                        <div class="mb-2">
                            <p class="text-gray-600 text-sm leading-tight">
                                <strong class="text-rosa-electrico">Géneros:</strong> 
                                <span class="text-gray-700 actor-genders">{{ $actor->genders_string ?: 'No especificado' }}</span>
                            </p>
                        </div>

                        <!-- Edades vocales -->
                        <div class="mb-3">
                            <p class="text-gray-600 text-sm leading-tight">
                                <strong class="text-naranja-vibrante">Edades vocales:</strong> 
                                <span class="text-gray-700 actor-voice-ages">{{ $actor->voice_ages_string ?: 'No especificado' }}</span>
                            </p>
                        </div>

                        @if($actor->bio)
                        <div class="mb-3 flex-1">
                            <p class="text-gray-700 text-sm line-clamp-2 leading-relaxed actor-bio">{{ Str::limit($actor->bio, 100) }}</p>
                        </div>
                        @else
                        <div class="flex-1"></div>
                        @endif
                    </a>
                </div>
                @endforeach
            </div>

            <!-- Mensaje cuando no hay resultados -->
            <div id="noResults" class="hidden text-center py-12">
                <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-500 mb-2">No se encontraron actores</h3>
                <p class="text-gray-400">Intenta con otros términos de búsqueda o ajusta los filtros.</p>
            </div>

            <!-- Paginación -->
            <div id="paginationContainer" class="mt-6">
                {{ $actors->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Audio global para todas las tarjetas -->
<audio id="globalAudio" class="hidden"></audio>

<script>
// Sistema de audio global
let currentAudio = null;
let currentPlayButton = null;
let currentPauseButton = null;

// Sistema de búsqueda y filtros en tiempo real
let searchTimeout = null;

// Sistema de filtros desplegables
document.addEventListener('DOMContentLoaded', function() {
    const filterToggle = document.getElementById('filterToggle');
    const filterColumn = document.getElementById('filterColumn');
    const closeFilters = document.getElementById('closeFilters');

    // Toggle de filtros en móvil
    if (filterToggle && filterColumn) {
        filterToggle.addEventListener('click', function() {
            filterColumn.classList.toggle('hidden');
            filterToggle.innerHTML = filterColumn.classList.contains('hidden') 
                ? '<i class="fas fa-filter mr-2"></i>Mostrar Filtros'
                : '<i class="fas fa-times mr-2"></i>Ocultar Filtros';
        });
    }

    // Cerrar filtros en móvil
    if (closeFilters) {
        closeFilters.addEventListener('click', function() {
            filterColumn.classList.add('hidden');
            filterToggle.innerHTML = '<i class="fas fa-filter mr-2"></i>Mostrar Filtros';
        });
    }

    // Configurar todos los controles de audio en las fotos
    const photoContainers = document.querySelectorAll('.photo-container');
    
    photoContainers.forEach(container => {
        const audioSrc = container.getAttribute('data-audio-src');
        
        if (audioSrc) {
            const playButton = container.querySelector('.audio-play');
            const pauseButton = container.querySelector('.audio-pause');
            
            // Click en la foto para reproducir/pausar
            container.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                if (currentPlayButton === playButton && currentAudio && !currentAudio.paused) {
                    // Si ya está reproduciendo, pausar
                    pauseAudio(playButton, pauseButton);
                } else {
                    // Si no está reproduciendo, reproducir
                    playAudio(audioSrc, playButton, pauseButton);
                }
            });
            
            // Click específico en botones de audio
            if (playButton) {
                playButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    playAudio(audioSrc, playButton, pauseButton);
                });
            }
            
            if (pauseButton) {
                pauseButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    pauseAudio(playButton, pauseButton);
                });
            }
        }
    });

    // Configurar buscador en tiempo real
    const searchInput = document.getElementById('searchActor');
    
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        
        searchTimeout = setTimeout(() => {
            applyAllFilters();
        }, 300);
    });

    // Configurar filtros para aplicar en tiempo real
    const filterInputs = document.querySelectorAll('#filter-form input[type="checkbox"], #filter-form input[type="radio"]');
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            applyAllFilters();
        });
    });

    // Aplicar filtros iniciales si hay parámetros en la URL
    applyAllFilters();
});

function applyAllFilters() {
    const searchTerm = document.getElementById('searchActor').value.toLowerCase().trim();
    const selectedAvailability = document.querySelector('input[name="availability"]:checked')?.value;
    const selectedGenders = Array.from(document.querySelectorAll('input[name="genders[]"]:checked')).map(cb => cb.value.toLowerCase());
    const selectedVoiceAges = Array.from(document.querySelectorAll('input[name="voice_ages[]"]:checked')).map(cb => cb.value.toLowerCase());
    const selectedSchools = Array.from(document.querySelectorAll('input[name="schools[]"]:checked')).map(cb => cb.value);

    filterActors(searchTerm, selectedAvailability, selectedGenders, selectedVoiceAges, selectedSchools);
}

function filterActors(searchTerm, selectedAvailability, selectedGenders, selectedVoiceAges, selectedSchools) {
    const actorCards = document.querySelectorAll('.actor-card');
    const noResults = document.getElementById('noResults');
    const resultsCount = document.getElementById('resultsCount');
    const paginationContainer = document.getElementById('paginationContainer');
    
    let visibleCount = 0;
    
    actorCards.forEach(card => {
        const actorName = card.getAttribute('data-name');
        const actorGenders = card.getAttribute('data-genders').split(',');
        const actorVoiceAges = card.getAttribute('data-voice-ages').split(',');
        const actorAvailable = card.getAttribute('data-available');
        const actorSchools = card.getAttribute('data-schools').split(',');

        // Aplicar todos los filtros con lógica AND entre categorías
        const matchesSearch = !searchTerm || 
                             actorName.includes(searchTerm);
        
        const matchesAvailability = !selectedAvailability || 
                                  (selectedAvailability === '1' && actorAvailable === 'true') ||
                                  (selectedAvailability === '0' && actorAvailable === 'false');
        
        // Lógica OR dentro de cada categoría
        const matchesGenders = selectedGenders.length === 0 || 
                             selectedGenders.some(gender => actorGenders.includes(gender));
        
        const matchesVoiceAges = selectedVoiceAges.length === 0 || 
                               selectedVoiceAges.some(age => actorVoiceAges.includes(age));
        
        const matchesSchools = selectedSchools.length === 0 || 
                             selectedSchools.some(school => actorSchools.includes(school));
        
        // AND entre todas las categorías
        const isVisible = matchesSearch && 
                         matchesAvailability && 
                         matchesGenders && 
                         matchesVoiceAges && 
                         matchesSchools;
        
        if (isVisible) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    // Actualizar contador de resultados
    resultsCount.textContent = visibleCount;
    
    // Mostrar/ocultar mensaje de no resultados
    if (visibleCount === 0) {
        noResults.classList.remove('hidden');
        paginationContainer.classList.add('hidden');
    } else {
        noResults.classList.add('hidden');
        paginationContainer.classList.remove('hidden');
    }
}

function playAudio(audioSrc, playBtn, pauseBtn) {
    const globalAudio = document.getElementById('globalAudio');
    
    // Pausar audio actual si hay uno reproduciéndose
    if (currentAudio && currentAudio !== globalAudio) {
        currentAudio.pause();
        if (currentPlayButton && currentPauseButton) {
            currentPlayButton.classList.remove('hidden');
            currentPauseButton.classList.add('hidden');
        }
    }
    
    // Configurar y reproducir nuevo audio
    globalAudio.src = audioSrc;
    globalAudio.play();
    
    // Actualizar controles
    playBtn.classList.add('hidden');
    pauseBtn.classList.remove('hidden');
    
    // Guardar referencias actuales
    currentAudio = globalAudio;
    currentPlayButton = playBtn;
    currentPauseButton = pauseBtn;
    
    // Cuando el audio termine, resetear controles
    globalAudio.onended = function() {
        pauseAudio(playBtn, pauseBtn);
    };
}

function pauseAudio(playBtn, pauseBtn) {
    const globalAudio = document.getElementById('globalAudio');
    
    if (globalAudio) {
        globalAudio.pause();
        globalAudio.currentTime = 0;
    }
    
    // Resetear controles
    playBtn.classList.remove('hidden');
    pauseBtn.classList.add('hidden');
    
    // Limpiar referencias
    currentAudio = null;
    currentPlayButton = null;
    currentPauseButton = null;
}

// Pausar audio cuando se hace clic en cualquier parte de la tarjeta (excepto la foto)
document.addEventListener('click', function() {
    if (currentAudio && currentPlayButton && currentPauseButton) {
        pauseAudio(currentPlayButton, currentPauseButton);
    }
});

// Pausar audio al cambiar de página
window.addEventListener('beforeunload', function() {
    if (currentAudio) {
        currentAudio.pause();
    }
});
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Mejorar la apariencia de las imágenes verticales */
    .object-cover {
        object-fit: cover;
        object-position: center top;
    }
    
    /* Remover bordes redondeados de todos los elementos */
    * {
        border-radius: 0 !important;
    }

    /* Asegurar que los cuadraditos de disponibilidad sean visibles */
    .bg-verde-menta {
        background-color: #10b981 !important;
    }
    
    .bg-rojo-intenso {
        background-color: #ef4444 !important;
    }

    /* Mejorar la experiencia móvil */
    @media (max-width: 1023px) {
        #filterColumn {
            position: fixed;
            top: 0;
            left: 0;
            width: 80%;
            max-width: 300px;
            height: 100vh;
            z-index: 50;
            overflow-y: auto;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        #filterColumn:not(.hidden) {
            transform: translateX(0);
        }
    }
</style>
@endsection