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
                <h1 class="text-3xl font-bold mb-2">{{ $actor->name }}</h1>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <span class="font-semibold">Género:</span>
                        <span class="capitalize">{{ $actor->gender }}</span>
                    </div>
                    <div>
                        <span class="font-semibold">Edad vocal:</span>
                        <span class="capitalize">{{ str_replace('_', ' ', $actor->voice_age) }}</span>
                    </div>
                    <div>
                        <span class="font-semibold">Disponibilidad:</span>
                        <span class="{{ $actor->is_available ? 'text-green-600' : 'text-red-600' }}">
                            {{ $actor->is_available ? 'Disponible' : 'No disponible' }}
                        </span>
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

                <!-- Acciones -->
                @auth
                    @if(auth()->user()->role === 'client' && $actor->is_available)
                        <a href="{{ route('requests.create', $actor->user) }}" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                            Contactar
                        </a>
                    @endif
                    
                    @if(auth()->id() === $actor->user_id || auth()->user()->role === 'admin')
                        <a href="{{ route('actors.edit', $actor) }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 ml-2">
                            Editar
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Iniciar sesión para contactar
                    </a>
                @endauth
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
@endsection