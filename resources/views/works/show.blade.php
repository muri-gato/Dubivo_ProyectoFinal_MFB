@extends('layouts.app')

@section('title', $work->title . ' - Dubivo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Navegación -->
    <div class="mb-6">
        <a href="{{ route('works.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
            <i class="fas fa-arrow-left mr-2"></i>Volver a todas las obras
        </a>
    </div>

    <!-- Header de la Obra -->
    <div class="bg-white shadow-md overflow-hidden mb-6 border border-gray-200">
        <div class="md:flex">
            <!-- Poster mejorado -->
            <div class="md:w-2/5">
                @if($work->poster)
                <img src="{{ asset('storage/' . $work->poster) }}"
                    alt="{{ $work->title }}"
                    class="w-full h-72 md:h-96 object-contain bg-gray-100 p-4">
                @else
                <div class="w-full h-72 md:h-96 bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                    <i class="fas fa-{{ $work->type == 'movie' ? 'film' : ($work->type == 'series' ? 'tv' : ($work->type == 'videogame' ? 'gamepad' : 'bullhorn')) }} text-white text-6xl"></i>
                </div>
                @endif
            </div>

            <!-- Información -->
            <div class="md:w-3/5 p-8">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-4xl font-bold mb-2 text-gray-800">{{ $work->title }}</h1>

                        <div class="flex items-center space-x-4 mb-4">
                            @php
                            $typeLabels = [
                            'movie' => 'Película',
                            'series' => 'Serie',
                            'commercial' => 'Comercial',
                            'animation' => 'Animación',
                            'videogame' => 'Videojuego',
                            'documentary' => 'Documental'
                            ];
                            $displayType = $typeLabels[$work->type] ?? $work->type;
                            @endphp
                            <span class="bg-azul-profundo text-white px-3 py-1 font-medium border border-azul-profundo">
                                {{ $displayType }}
                            </span>
                            @if($work->year)
                            <span class="text-gray-700 font-medium">
                                <i class="fas fa-calendar-alt mr-1"></i>{{ $work->year }}
                            </span>
                            @endif
                            <span class="text-gray-700 font-medium">
                                <i class="fas fa-users mr-1"></i>{{ $work->actors->count() }} actores
                            </span>
                        </div>
                    </div>

                    @auth
                    @if(Auth::user()->role == 'admin')
                    <div class="flex space-x-3">
                        <!-- Botón Editar -->
                        <a href="{{ route('admin.works.edit', $work) }}"
                            class="bg-[#f59e0b] text-white px-4 py-2 hover:bg-[#d97706] flex items-center font-semibold transition duration-200 shadow-lg border border-[#d97706]">
                            <i class="fas fa-edit mr-2"></i>Editar
                        </a>

                        <!-- Botón Eliminar -->
                        <form action="{{ route('admin.works.destroy', $work) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta obra? Esta acción no se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-[#dc2626] text-white px-4 py-2 hover:bg-[#b91c1c] flex items-center font-semibold transition duration-200 shadow-lg border border-[#b91c1c]">
                                <i class="fas fa-trash mr-2"></i>Eliminar
                            </button>
                        </form>
                    </div>
                    @endif
                    @endauth
                </div>

                @if($work->description)
                <div class="mb-6">
                    <p class="text-gray-700 leading-relaxed text-lg">{{ $work->description }}</p>
                </div>
                @endif

                <!-- Metadatos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-semibold text-gray-600">Tipo:</span>
                        <span class="ml-2">{{ $displayType }}</span>
                    </div>
                    @if($work->year)
                    <div>
                        <span class="font-semibold text-gray-600">Año:</span>
                        <span class="ml-2">{{ $work->year }}</span>
                    </div>
                    @endif
                    <div>
                        <span class="font-semibold text-gray-600">Actores participantes:</span>
                        <span class="ml-2">{{ $work->actors->count() }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-600">Registrada:</span>
                        <span class="ml-2">{{ $work->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actores que participaron -->
    @if($work->actors->count() > 0)
    <div class="bg-white shadow-md p-6 mb-6 border border-gray-200">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Actores que participaron</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($work->actors as $actor)
            <a href="{{ route('actors.show', $actor) }}" class="flex items-center space-x-3 p-3 border border-gray-200 hover:bg-gray-50 transition duration-200 group">
                <!-- Foto -->
                @if($actor->photo)
                <img src="{{ asset('storage/' . $actor->photo) }}"
                    alt="{{ $actor->user->name }}"
                    class="w-12 h-12 object-cover">
                @else
                <div class="w-12 h-12 bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-user text-gray-400"></i>
                </div>
                @endif

                <div class="flex-1">
                    <!-- Nombre -->
                    <h4 class="font-medium text-gray-800 group-hover:text-blue-600">{{ $actor->user->name }}</h4>

                    <p class="text-gray-600 text-sm mb-2">
                        {{ $actor->genders_string ?: 'Género no especificado' }} •
                        {{ $actor->voice_ages_string ?: 'Edad no especificada' }}
                    </p>

                    @if($actor->pivot->character_name)
                    <p class="text-sm text-blue-600 font-medium">
                        Personaje: {{ $actor->pivot->character_name }}
                    </p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    * {
        border-radius: 0 !important;
    }
</style>
@endsection