@extends('layouts.app')

@section('title', $actor->name . ' - Banco de Voces')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header del perfil -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="md:flex">
            <!-- Foto -->
            <div class="md:w-1/3">
                @if($actor->photo)
                <img src="{{ asset('storage/' . $actor->photo) }}" alt="{{ $actor->name }}" class="w-full h-64 object-cover">
                @else
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">Sin foto</span>
                </div>
                @endif
            </div>

            <!-- Información -->
            <div class="md:w-2/3 p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">{{ $actor->name }}</h1>

                        <div class="flex items-center space-x-4 mb-4">
                            @if($actor->is_available)
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-check mr-1"></i>Disponible
                            </span>
                            @else
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-times mr-1"></i>No disponible
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="flex space-x-3">
{{-- Botón Favoritos --}}
@auth
@if(Auth::user()->role == 'client')
    <form action="{{ route('actors.favorite.toggle', $actor) }}" method="POST" class="inline">
        @csrf
        <button type="submit" 
                class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg flex items-center">
            <svg class="w-4 h-4 mr-2" fill="{{ $actor->isFavoritedBy(Auth::id()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            {{ $actor->isFavoritedBy(Auth::id()) ? 'Quitar Favorito' : 'Añadir Favorito' }}
        </button>
    </form>
@endif
@endauth

    {{-- BOTÓN DE CONTACTO PARA ADMINS Y CLIENTES --}}
    @auth
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'client')
            {{-- Botón Contactar por Email --}}
            <a href="mailto:{{ $actor->user->email }}?subject=Contacto desde Banco de Voces&body=Hola {{ $actor->name }}, me interesa contactar contigo para un proyecto."
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Contactar
            </a>
    @endif
    @endauth
{{-- BOTONES ESPECÍFICOS DE ADMIN --}}
    @auth
    @if(Auth::user()->role == 'admin')
        {{-- Botón Editar Admin --}}
        <a href="{{ route('admin.actors.edit', $actor) }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Editar
        </a>
                            {{-- Botón Eliminar Admin --}}
        <form action="{{ route('admin.actors.destroy', $actor) }}" method="POST"
            onsubmit="return confirm('¿Estás seguro de que quieres eliminar este actor? Esta acción no se puede deshacer.');">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Eliminar
            </button>
        </form>

                        {{-- BOTONES DE ACTOR (SU PROPIO PERFIL) --}}
                        @elseif(Auth::user()->role == 'actor' && Auth::id() == $actor->user_id)
                            {{-- Botón Editar Actor --}}
                            <a href="{{ route('actors.edit', $actor) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Editar Perfil
                            </a>

                            {{-- Botón Eliminar Actor --}}
                            <form action="{{ route('actors.destroy', $actor) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar tu perfil? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Eliminar Perfil
                                </button>
                            </form>

                        {{-- ACTOR VIENDO PERFIL DE OTRO ACTOR --}}
                        @elseif(Auth::user()->role == 'actor')
                            {{-- Mensaje informativo --}}
                            <div class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                No puedes contactar actores
                            </div>
                        @endif
                        @endauth

                        {{-- USUARIO NO LOGUEADO --}}
                        @guest
                            {{-- Botón Contactar (abre modal) --}}
                            <button onclick="openContactModal()"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Contactar Actor
                            </button>
                        @endguest
                    </div>
                </div>

                {{-- Géneros y edades vocales --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <span class="font-semibold">Género:</span>
                        {{ $actor->genders_string ?: 'No especificados' }}
                    </div>
                    <div>
                        <span class="font-semibold">Edad vocal:</span>
                        {{ $actor->voice_ages_string ?: 'No especificadas' }}
                    </div>
                </div>

                <!-- Audio -->
                @if($actor->audio_path)
                <div class="mb-4">
                    <span class="font-semibold block mb-2">Muestra de voz:</span>
                    <audio controls class="w-full">
                        <source src="{{ asset('storage/' . $actor->audio_path) }}" type="audio/mpeg">
                        Tu navegador no soporta el elemento de audio.
                    </audio>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Biografía -->
    @if($actor->bio)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4">Biografía</h2>
        <p class="text-gray-700 leading-relaxed">{{ $actor->bio }}</p>
    </div>
    @endif

    <!-- Escuelas -->
    @if($actor->schools->count() > 0)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4">Formación</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($actor->schools as $school)
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="font-semibold text-lg">{{ $school->name }}</h3>
                <p class="text-gray-600">{{ $school->city }}</p>
                <a href="{{ route('schools.show', $school) }}" class="text-blue-600 hover:underline mt-2 inline-block">
                    Ver escuela
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($actor->isTeacher())
<!-- Sección de Profesor -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h2 class="text-2xl font-bold mb-4 flex items-center">
        <i class="fas fa-chalkboard-teacher text-yellow-500 mr-2"></i>
        Profesor
    </h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($actor->getActiveTeachingSchools() as $school)
        <div class="border border-yellow-200 rounded-lg p-4 bg-yellow-50">
            <h3 class="font-semibold text-lg text-yellow-800">Profesor en {{ $school->name }}</h3>
            @if($school->pivot->subject)
                <p class="text-yellow-700"><strong>Materia:</strong> {{ $school->pivot->subject }}</p>
            @endif
            @if($school->pivot->teaching_bio)
                <p class="text-yellow-600 mt-2">{{ $school->pivot->teaching_bio }}</p>
            @endif
            <a href="{{ route('schools.show', $school) }}" class="text-yellow-600 hover:underline mt-2 inline-block">
                Ver escuela
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

    <!-- Obras -->
    @if($actor->works->count() > 0)
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">Trabajos Destacados</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($actor->works as $work)
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="font-semibold text-lg">{{ $work->title }}</h3>
                <p class="text-gray-600 capitalize">{{ $work->type }} ({{ $work->year }})</p>
                @if($work->pivot->character_name)
                <p class="text-sm text-gray-500">Personaje: {{ $work->pivot->character_name }}</p>
                @endif
                <a href="{{ route('works.show', $work) }}" class="text-blue-600 hover:underline mt-2 inline-block">
                    Ver obra
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

{{-- Modal de Contacto --}}
<div id="contactModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                <i class="fas fa-envelope text-blue-600 text-xl"></i>
            </div>

            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">
                Inicia sesión para contactar
            </h3>

            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Para contactar a <span class="font-semibold">{{ $actor->name }}</span> necesitas una cuenta de <span class="font-semibold">cliente</span>.
                </p>
            </div>

            <div class="items-center px-4 py-3">
                <div class="flex space-x-2">
                    <a href="{{ route('login') }}"
                        class="flex-1 px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 text-center">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register.client') }}"
                        class="flex-1 px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 text-center">
                        Registrarse
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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

</script>

<style>
    #contactModal {
        backdrop-filter: blur(4px);
    }
</style>
@endsection