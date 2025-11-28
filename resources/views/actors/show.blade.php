@extends('layouts.app')

@section('title', $actor->name . ' - Dubivo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header del perfil -->
    <div class="bg-white shadow-md overflow-hidden mb-6 border border-gray-200">
        <div class="md:flex">
            <!-- Foto con Audio Hover -->
            <div class="md:w-1/3 relative group">
                @if($actor->photo)
                <img src="{{ asset('storage/' . $actor->photo) }}" alt="{{ $actor->name }}" class="w-full h-64 object-cover">
                @else
                <div class="w-full h-64 bg-gray-100 flex items-center justify-center">
                    <i class="fas fa-user text-gray-400 text-6xl"></i>
                </div>
                @endif
                
                <!-- Audio Overlay que aparece al hacer hover -->
                @if($actor->audio_path)
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                    <button id="playButton" class="bg-azul-profundo bg-opacity-90 hover:bg-opacity-100 text-white p-4 transform scale-90 group-hover:scale-100 transition-all duration-300">
                        <i class="fas fa-play text-2xl"></i>
                    </button>
                    <button id="pauseButton" class="bg-azul-profundo bg-opacity-90 hover:bg-opacity-100 text-white p-4 transform scale-90 group-hover:scale-100 transition-all duration-300 hidden">
                        <i class="fas fa-pause text-2xl"></i>
                    </button>
                </div>
                
                <!-- Audio oculto -->
                <audio id="actorAudio" class="hidden">
                    <source src="{{ asset('storage/' . $actor->audio_path) }}" type="audio/mpeg">
                    Tu navegador no soporta el elemento de audio.
                </audio>
                @endif
            </div>

            <!-- Información -->
            <div class="md:w-2/3 p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold mb-2 text-gray-800">{{ $actor->name }}</h1>
                    </div>

                    <!-- Botones de acción (solo editar/eliminar para el propio actor o admin) -->
                    <div class="flex space-x-3">
                        {{-- BOTONES ESPECÍFICOS DE ADMIN --}}
                        @auth
                        @if(Auth::user()->role == 'admin')
                            {{-- Botón Editar Admin --}}
                            <a href="{{ route('admin.actors.edit', $actor) }}"
                                class="bg-ambar hover:bg-ambar hover:bg-opacity-90 text-white px-4 py-2 flex items-center font-semibold transition duration-200">
                                <i class="fas fa-edit mr-2"></i>
                                Editar
                            </a>
                            {{-- Botón Eliminar Admin --}}
                            <form action="{{ route('admin.actors.destroy', $actor) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este actor? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-rojo-intenso hover:bg-rojo-intenso hover:bg-opacity-90 text-white px-4 py-2 flex items-center font-semibold transition duration-200">
                                    <i class="fas fa-trash mr-2"></i>
                                    Eliminar
                                </button>
                            </form>

                        {{-- BOTONES DE ACTOR (SU PROPIO PERFIL) --}}
                        @elseif(Auth::user()->role == 'actor' && Auth::id() == $actor->user_id)
                            {{-- Botón Editar Actor --}}
                            <a href="{{ route('actors.edit', $actor) }}"
                                class="bg-ambar hover:bg-ambar hover:bg-opacity-90 text-white px-4 py-2 flex items-center font-semibold transition duration-200">
                                <i class="fas fa-edit mr-2"></i>
                                Editar Perfil
                            </a>

                            {{-- Botón Eliminar Actor --}}
                            <form action="{{ route('actors.destroy', $actor) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar tu perfil? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-rojo-intenso hover:bg-rojo-intenso hover:bg-opacity-90 text-white px-4 py-2 flex items-center font-semibold transition duration-200">
                                    <i class="fas fa-trash mr-2"></i>
                                    Eliminar Perfil
                                </button>
                            </form>
                        @endif
                        @endauth
                    </div>
                </div>

                {{-- Géneros y edades vocales --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <span class="font-semibold text-azul-profundo">Género:</span>
                        <span class="text-gray-700">{{ $actor->genders_string ?: 'No especificados' }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-naranja-vibrante">Edad vocal:</span>
                        <span class="text-gray-700">{{ $actor->voice_ages_string ?: 'No especificadas' }}</span>
                    </div>
                </div>

                <!-- Toggle de disponibilidad (solo para el propio actor) -->
                @auth
                @if(Auth::user()->role == 'actor' && Auth::id() == $actor->user_id)
                <div class="mb-4">
                    <form id="availabilityForm" action="{{ route('actors.update-availability', $actor) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center space-x-4 bg-gray-50 p-4 border border-gray-200">
                            <span class="text-sm font-medium text-gray-700">Disponibilidad:</span>
                            
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_available" value="1" class="sr-only peer availability-toggle" 
                                       {{ $actor->is_available ? 'checked' : '' }}>
                                <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-verde-menta peer-focus:ring-opacity-30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-verde-menta"></div>
                            </label>
                            
                            <span id="availabilityStatus" class="text-sm font-semibold {{ $actor->is_available ? 'text-verde-menta' : 'text-rojo-intenso' }}">
                                {{ $actor->is_available ? 'Disponible' : 'No disponible' }}
                            </span>
                            
                            <div id="availabilityLoader" class="hidden">
                                <i class="fas fa-spinner fa-spin text-azul-profundo"></i>
                            </div>
                        </div>
                    </form>
                </div>
                @else
                <!-- Estado de disponibilidad para otros usuarios -->
                <div class="mb-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-gray-700">Estado:</span>
                        @if($actor->is_available)
                            <span class="bg-verde-menta bg-opacity-20 text-verde-menta px-3 py-1 text-sm font-medium">
                                <i class="fas fa-check mr-1"></i>Disponible
                            </span>
                        @else
                            <span class="bg-rojo-intenso bg-opacity-20 text-rojo-intenso px-3 py-1 text-sm font-medium">
                                <i class="fas fa-times mr-1"></i>No disponible
                            </span>
                        @endif
                    </div>
                </div>
                @endif
                @endauth

                <!-- Información de contacto -->
                <div class="mb-4">
                    @auth
                        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'client')
                            {{-- Botón Contactar por Email --}}
                            <a href="mailto:{{ $actor->user->email }}?subject=Contacto desde Dubivo&body=Hola {{ $actor->name }}, me interesa contactar contigo para un proyecto."
                               class="bg-verde-menta hover:bg-verde-menta hover:bg-opacity-90 text-white px-6 py-2 flex items-center font-semibold transition duration-200 inline-block">
                                <i class="fas fa-envelope mr-2"></i>
                                Contactar Actor
                            </a>
                        @elseif(Auth::user()->role == 'actor')
                            {{-- Mensaje informativo para actores --}}
                            <div class="bg-gray-100 text-gray-600 px-4 py-2 flex items-center inline-block">
                                <i class="fas fa-info-circle mr-2"></i>
                                No puedes contactar actores
                            </div>
                        @endif
                    @endauth

                    {{-- USUARIO NO LOGUEADO --}}
                    @guest
                        {{-- Botón Contactar (abre modal) --}}
                        <button onclick="openContactModal()"
                            class="bg-verde-menta hover:bg-verde-menta hover:bg-opacity-90 text-white px-6 py-2 flex items-center font-semibold transition duration-200">
                            <i class="fas fa-envelope mr-2"></i>
                            Contactar Actor
                        </button>
                    @endguest
                </div>

                <!-- Botón Favoritos (solo para clientes) -->
                @auth
                @if(Auth::user()->role == 'client')
                <div>
                    <form action="{{ route('actors.favorite.toggle', $actor) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="bg-azul-profundo hover:bg-azul-profundo hover:bg-opacity-90 text-white px-6 py-2 flex items-center font-semibold transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="{{ $actor->isFavoritedBy(Auth::id()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            {{ $actor->isFavoritedBy(Auth::id()) ? 'Quitar Favorito' : 'Añadir Favorito' }}
                        </button>
                    </form>
                </div>
                @endif
                @endauth
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Contenido Principal -->
        <div class="lg:w-3/4">
            <!-- Biografía -->
            @if($actor->bio)
            <div class="bg-white shadow-md p-6 mb-6 border border-gray-200">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Biografía</h2>
                <p class="text-gray-700 leading-relaxed">{{ $actor->bio }}</p>
            </div>
            @endif

            <!-- Escuelas -->
            @if($actor->schools->count() > 0)
            <div class="bg-white shadow-md p-6 mb-6 border border-gray-200">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Formación</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($actor->schools as $school)
                    <div class="border border-gray-200 p-4 hover:bg-gray-50 transition duration-200">
                        <h3 class="font-semibold text-lg text-azul-profundo">{{ $school->name }}</h3>
                        <p class="text-gray-600">{{ $school->city }}</p>
                        <a href="{{ route('schools.show', $school) }}" class="text-azul-profundo hover:text-azul-profundo hover:underline mt-2 inline-block font-semibold">
                            Ver escuela
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($actor->isTeacher())
            <!-- Sección de Profesor -->
            <div class="bg-white shadow-md p-6 mb-6 border border-gray-200">
                <h2 class="text-2xl font-bold mb-4 flex items-center text-gray-800">
                    <i class="fas fa-chalkboard-teacher text-ambar mr-2"></i>
                    Profesor
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($actor->getActiveTeachingSchools() as $school)
                    <div class="border border-ambar border-opacity-30 p-4 bg-amber-50">
                        <h3 class="font-semibold text-lg text-ambar">Profesor en {{ $school->name }}</h3>
                        @if($school->pivot->subject)
                            <p class="text-ambar"><strong>Materia:</strong> {{ $school->pivot->subject }}</p>
                        @endif
                        @if($school->pivot->teaching_bio)
                            <p class="text-amber-700 mt-2">{{ $school->pivot->teaching_bio }}</p>
                        @endif
                        <a href="{{ route('schools.show', $school) }}" class="text-ambar hover:text-ambar hover:underline mt-2 inline-block font-semibold">
                            Ver escuela
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Obras -->
            @if($actor->works->count() > 0)
            <div class="bg-white shadow-md p-6 border border-gray-200">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Trabajos Destacados</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($actor->works as $work)
                    <div class="border border-gray-200 p-4 hover:bg-gray-50 transition duration-200">
                        <h3 class="font-semibold text-lg text-morado-vibrante">{{ $work->title }}</h3>
                        <p class="text-gray-600 capitalize">{{ $work->type }} @if($work->year)({{ $work->year }})@endif</p>
                        @if($work->pivot->character_name)
                        <p class="text-sm text-morado-vibrante"><strong>Personaje:</strong> {{ $work->pivot->character_name }}</p>
                        @endif
                        <a href="{{ route('works.show', $work) }}" class="text-morado-vibrante hover:text-morado-vibrante hover:underline mt-2 inline-block font-semibold">
                            Ver obra
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar de Información -->
        <div class="lg:w-1/4">
            <div class="bg-white p-6 shadow-md sticky top-4 border border-gray-200">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Información del perfil</h2>
                
                <div class="space-y-4">
                    <div>
                        <h3 class="font-medium text-gray-700 mb-2">Estado</h3>
                        <div class="flex items-center space-x-2">
                            @if($actor->is_available)
                            <div class="w-3 h-3 bg-verde-menta"></div>
                            <span class="text-sm text-verde-menta">Disponible</span>
                            @else
                            <div class="w-3 h-3 bg-rojo-intenso"></div>
                            <span class="text-sm text-rojo-intenso">No disponible</span>
                            @endif
                        </div>
                    </div>

                    @if($actor->schools->count() > 0)
                    <div>
                        <h3 class="font-medium text-gray-700 mb-2">Formación</h3>
                        <p class="text-sm text-gray-600">{{ $actor->schools->count() }} escuela(s)</p>
                    </div>
                    @endif

                    @if($actor->works->count() > 0)
                    <div>
                        <h3 class="font-medium text-gray-700 mb-2">Experiencia</h3>
                        <p class="text-sm text-gray-600">{{ $actor->works->count() }} trabajo(s)</p>
                    </div>
                    @endif

                    @if($actor->isTeacher())
                    <div>
                        <h3 class="font-medium text-gray-700 mb-2">Docencia</h3>
                        <p class="text-sm text-ambar">Profesor activo</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal de Contacto --}}
<div id="contactModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 bg-azul-profundo bg-opacity-20">
                <i class="fas fa-envelope text-azul-profundo text-xl"></i>
            </div>

            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">
                Inicia sesión para contactar
            </h3>

            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Para contactar a <span class="font-semibold text-azul-profundo">{{ $actor->name }}</span> necesitas una cuenta de <span class="font-semibold text-verde-menta">cliente</span>.
                </p>
            </div>

            <div class="items-center px-4 py-3">
                <div class="flex space-x-2">
                    <a href="{{ route('login') }}"
                        class="flex-1 px-4 py-2 bg-azul-profundo text-white text-base font-medium hover:bg-azul-profundo hover:bg-opacity-90 text-center transition duration-200">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register.client') }}"
                        class="flex-1 px-4 py-2 bg-verde-menta text-white text-base font-medium hover:bg-verde-menta hover:bg-opacity-90 text-center transition duration-200">
                        Registrarse
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Variables globales
let isPlaying = false;
const audio = document.getElementById('actorAudio');
const playButton = document.getElementById('playButton');
const pauseButton = document.getElementById('pauseButton');

// Función para reproducir audio
function playAudio() {
    if (audio) {
        audio.play();
        isPlaying = true;
        playButton.classList.add('hidden');
        pauseButton.classList.remove('hidden');
    }
}

// Función para pausar audio
function pauseAudio() {
    if (audio) {
        audio.pause();
        isPlaying = false;
        pauseButton.classList.add('hidden');
        playButton.classList.remove('hidden');
    }
}

// Event listeners para los botones
if (playButton) {
    playButton.addEventListener('click', playAudio);
}

if (pauseButton) {
    pauseButton.addEventListener('click', pauseAudio);
}

// Cuando el audio termina naturalmente, volver al botón de play
if (audio) {
    audio.addEventListener('ended', function() {
        pauseAudio();
    });
}

// Pausar audio cuando el mouse sale de la imagen
document.querySelector('.group').addEventListener('mouseleave', function() {
    if (isPlaying) {
        pauseAudio();
    }
});

// Toggle de disponibilidad (solo para el propio actor)
document.addEventListener('DOMContentLoaded', function() {
    const availabilityToggle = document.querySelector('.availability-toggle');
    const availabilityStatus = document.getElementById('availabilityStatus');
    const availabilityLoader = document.getElementById('availabilityLoader');
    const availabilityForm = document.getElementById('availabilityForm');

    if (availabilityToggle) {
        availabilityToggle.addEventListener('change', function() {
            const isAvailable = this.checked;
            
            // Mostrar loader
            availabilityLoader.classList.remove('hidden');
            
            // Actualizar texto temporalmente
            availabilityStatus.textContent = isAvailable ? 'Actualizando...' : 'Actualizando...';
            availabilityStatus.className = 'text-sm font-semibold text-azul-profundo';
            
            // Enviar formulario via AJAX
            fetch(availabilityForm.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    is_available: isAvailable ? 1 : 0,
                    _method: 'PUT'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar estado visual
                    availabilityStatus.textContent = isAvailable ? 'Disponible' : 'No disponible';
                    availabilityStatus.className = `text-sm font-semibold ${isAvailable ? 'text-verde-menta' : 'text-rojo-intenso'}`;
                    
                    // Mostrar mensaje de éxito
                    showNotification('Disponibilidad actualizada correctamente', 'success');
                } else {
                    // Revertir toggle si hay error
                    availabilityToggle.checked = !isAvailable;
                    showNotification('Error al actualizar la disponibilidad', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revertir toggle
                availabilityToggle.checked = !isAvailable;
                showNotification('Error de conexión', 'error');
            })
            .finally(() => {
                // Ocultar loader
                availabilityLoader.classList.add('hidden');
            });
        });
    }
});

function showNotification(message, type) {
    // Crear notificación temporal
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-verde-menta text-white' : 'bg-rojo-intenso text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Remover después de 3 segundos
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function openContactModal() {
    document.getElementById('contactModal').classList.remove('hidden');
}

function closeContactModal() {
    document.getElementById('contactModal').classList.add('hidden');
}

// Cerrar modal al hacer click fuera
document.getElementById('contactModal').addEventListener('click', function(e) {
    if (e.target.id === 'contactModal') {
        closeContactModal();
    }
});

// Pausar audio cuando se cierra la página
window.addEventListener('beforeunload', function() {
    if (audio) {
        audio.pause();
    }
});
</script>

<style>
    * {
        border-radius: 0 !important;
    }
    
    #contactModal {
        backdrop-filter: blur(4px);
    }
    
    /* Estilos para el overlay de audio */
    .group:hover .group-hover\:bg-opacity-40 {
        background-color: rgba(0, 0, 0, 0.4);
    }
    
    /* Estilos para el toggle switch */
    .peer:checked ~ .peer-checked\:bg-verde-menta {
        background-color: #10b981 !important;
    }
</style>
@endsection