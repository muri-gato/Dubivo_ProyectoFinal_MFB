@extends('layouts.app')

@section('title', $actor->name . ' - Dubivo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Navegación -->
    <div class="mb-6">
        <a href="{{ route('actors.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
            <i class="fas fa-arrow-left mr-2"></i>Volver a todos los actores
        </a>
    </div>

<!-- Header del perfil -->
<div class="bg-white shadow-md overflow-hidden mb-6 border border-gray-200">
    <div class="md:flex">
        <!-- Foto cuadrada con Audio Hover - CORREGIDO -->
        <div class="md:w-1/3 relative group flex-shrink-0">
            @if($actor->photo)
            <img src="{{ asset('storage/' . $actor->photo) }}" alt="{{ $actor->name }}"
                class="w-full h-80 md:h-96 object-cover object-center">
            @else
            <div class="w-full h-80 md:h-96 bg-gray-100 flex items-center justify-center">
                <i class="fas fa-user text-gray-400 text-6xl"></i>
            </div>
            @endif

            <!-- Audio Overlay -->
            @if($actor->audio_path)
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                <button id="playButton" class="text-white transform scale-90 group-hover:scale-100 transition-all duration-300">
                    <i class="fas fa-play text-4xl"></i>
                </button>
                <button id="pauseButton" class="text-white transform scale-90 group-hover:scale-100 transition-all duration-300 hidden">
                    <i class="fas fa-pause text-4xl"></i>
                </button>
            </div>

            <!-- Audio oculto -->
            <audio id="actorAudio" class="hidden">
                <source src="{{ asset('storage/' . $actor->audio_path) }}" type="audio/mpeg">
            </audio>
            @endif
        </div>

        <!-- Información -->
        <div class="md:w-2/3 p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold mb-2 text-gray-800">{{ $actor->name }}</h1>
                </div>

                <!-- Botones de acción (solo admin/owner) -->
                <div class="flex space-x-3">
                    @auth
                    @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.actors.edit', $actor) }}"
                        class="bg-[#f59e0b] text-white px-4 py-2 hover:bg-[#d97706] flex items-center font-semibold transition duration-200 shadow-lg border border-[#d97706]">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </a>
                    <form action="{{ route('admin.actors.destroy', $actor) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro de que quieres eliminar este actor?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-[#dc2626] text-white px-4 py-2 hover:bg-[#b91c1c] flex items-center font-semibold transition duration-200 shadow-lg border border-[#b91c1c]">
                            <i class="fas fa-trash mr-2"></i>Eliminar
                        </button>
                    </form>
                    @elseif(Auth::user()->role == 'actor' && Auth::user()->actorProfile && Auth::user()->actorProfile->id == $actor->id)
                    <a href="{{ route('actors.edit', $actor) }}"
                        class="bg-[#f59e0b] text-white px-4 py-2 hover:bg-[#d97706] flex items-center font-semibold transition duration-200 shadow-lg border border-[#d97706]">
                        <i class="fas fa-edit mr-2"></i>Editar Perfil
                    </a>
                    @endif
                    @endauth
                </div>
            </div>

            <!-- Información básica MEJORADA -->
            <div class="space-y-4 mb-6">
                <!-- Géneros -->
                <div>
                    <span class="font-semibold text-lg text-pink-500 block mb-1">Géneros:</span>
                    <span class="text-gray-700 text-lg">{{ $actor->genders_string ?: 'No especificados' }}</span>
                </div>
                
                <!-- Edades vocales -->
                <div>
                    <span class="font-semibold text-lg text-orange-500 block mb-1">Edades vocales:</span>
                    <span class="text-gray-700 text-lg">{{ $actor->voice_ages_string ?: 'No especificadas' }}</span>
                </div>

                <!-- Disponibilidad -->
                <div>
                    <span class="font-semibold text-lg text-gray-700 block mb-1">Estado:</span>
                    @if($actor->is_available)
                    <span class="bg-green-100 text-green-800 px-4 py-2 font-medium border border-green-200 text-lg">
                        <i class="fas fa-check mr-2"></i>Disponible para proyectos
                    </span>
                    @else
                    <span class="bg-red-100 text-red-800 px-4 py-2 font-medium border border-red-200 text-lg">
                        <i class="fas fa-times mr-2"></i>No disponible actualmente
                    </span>
                    @endif
                </div>
            </div>

            <!-- Boton de contacto -->
            <div class="border-t pt-6 mt-6">
                <div class="flex space-x-4">
                    @auth
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'client')
                    <a href="mailto:{{ $actor->user->email }}?subject=Contacto desde Dubivo&body=Hola {{ $actor->name }}, me interesa contactar contigo para un proyecto."
                        class="bg-verde-menta text-white px-6 py-3 hover:bg-green-600 flex items-center font-semibold transition duration-200 text-lg">
                        <i class="fas fa-envelope mr-2"></i>Contactar Actor
                    </a>
                    @endif
                    @else
                    <button onclick="openContactModal()"
                        class="bg-verde-menta text-white px-6 py-3 hover:bg-green-600 flex items-center font-semibold transition duration-200 text-lg">
                        <i class="fas fa-envelope mr-2"></i>Contactar Actor
                    </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="flex flex-col">
        <!-- Contenido Principal -->
        <div class="w-full">
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
                        <h3 class="font-semibold text-lg text-blue-600">{{ $school->name }}</h3>
                        <p class="text-gray-600">{{ $school->city }}</p>
                        <a href="{{ route('schools.show', $school) }}" class="text-blue-600 hover:text-blue-800 hover:underline mt-2 inline-block font-semibold">
                            Ver escuela
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Sección de Profesor -->
            @if($actor->isTeacher())
            <div class="bg-white shadow-md p-6 mb-6 border border-gray-200">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">
                    Profesor
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($actor->getActiveTeachingSchools() as $school)
                    <div class="border border-amber-200 p-4 bg-amber-50">
                        <h3 class="font-semibold text-lg text-amber-700">Profesor en {{ $school->name }}</h3>
                        @if($school->pivot->subject)
                        <p class="text-amber-600"><strong>Materia:</strong> {{ $school->pivot->subject }}</p>
                        @endif
                        @if($school->pivot->teaching_bio)
                        <p class="text-amber-700 mt-2">{{ $school->pivot->teaching_bio }}</p>
                        @endif
                        <a href="{{ route('schools.show', $school) }}" class="text-amber-600 hover:text-amber-800 hover:underline mt-2 inline-block font-semibold">
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
                        <h3 class="font-semibold text-lg text-purple-600">{{ $work->title }}</h3>
                        <p class="text-gray-600 capitalize">{{ $work->type }} @if($work->year)({{ $work->year }})@endif</p>
                        @if($work->pivot->character_name)
                        <p class="text-sm text-purple-600"><strong>Personaje:</strong> {{ $work->pivot->character_name }}</p>
                        @endif
                        <a href="{{ route('works.show', $work) }}" class="text-purple-600 hover:text-purple-800 hover:underline mt-2 inline-block font-semibold">
                            Ver obra
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de Contacto -->
<div id="contactModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 bg-blue-100">
                <i class="fas fa-envelope text-blue-600 text-xl"></i>
            </div>

            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">
                Inicia sesión para contactar
            </h3>

            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Para contactar a <span class="font-semibold text-blue-600">{{ $actor->name }}</span> necesitas una cuenta de cliente.
                </p>
            </div>

            <div class="items-center px-4 py-3">
                <div class="flex space-x-2">
                    <a href="{{ route('login') }}"
                        class="flex-1 px-4 py-2 bg-blue-500 text-white text-base font-medium hover:bg-blue-600 text-center transition duration-200">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register.client') }}"
                        class="flex-1 px-4 py-2 bg-green-500 text-white text-base font-medium hover:bg-green-600 text-center transition duration-200">
                        Registrarse
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Funcionalidad de audio
    let isPlaying = false;
    const audio = document.getElementById('actorAudio');
    const playButton = document.getElementById('playButton');
    const pauseButton = document.getElementById('pauseButton');

    if (playButton) {
        playButton.addEventListener('click', function() {
            if (audio) {
                audio.play();
                isPlaying = true;
                playButton.classList.add('hidden');
                pauseButton.classList.remove('hidden');
            }
        });
    }

    if (pauseButton) {
        pauseButton.addEventListener('click', function() {
            if (audio) {
                audio.pause();
                isPlaying = false;
                pauseButton.classList.add('hidden');
                playButton.classList.remove('hidden');
            }
        });
    }

    if (audio) {
        audio.addEventListener('ended', function() {
            isPlaying = false;
            pauseButton.classList.add('hidden');
            playButton.classList.remove('hidden');
        });
    }

    // Modal de contacto
    function openContactModal() {
        document.getElementById('contactModal').classList.remove('hidden');
    }

    function closeContactModal() {
        document.getElementById('contactModal').classList.add('hidden');
    }

    document.getElementById('contactModal').addEventListener('click', function(e) {
        if (e.target.id === 'contactModal') {
            closeContactModal();
        }
    });
</script>

<style>
    * {
        border-radius: 0 !important;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* CORRECCIÓN PARA LA FOTO */
    .object-cover {
        object-fit: cover;
        object-position: center center;
    }
    
    /* Asegurar que la foto ocupe todo el espacio */
    .md\\:w-1\\/3 {
        flex-shrink: 0;
    }
    
    /* Eliminar cualquier espacio extra */
    .relative.group {
        line-height: 0; /* Elimina espacio fantasma */
    }
    
    /* Asegurar que la imagen llene el contenedor */
    .relative.group img {
        width: 100%;
        height: 100%;
        display: block;
    }
</style>
@endsection