@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Actores de Voz</h1>

        @auth
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.actors.create') }}"
            class="bg-verde-menta text-white px-6 py-3 rounded-lg hover:bg-verde-menta hover:bg-opacity-90 transition duration-200 flex items-center font-semibold">
            <i class="fas fa-plus mr-2"></i>
            Nuevo Actor
        </a>
        @endif
        @endauth
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Columna de Filtros -->
        <div class="lg:w-1/4">
            <div class="bg-white p-6 rounded-lg shadow-md sticky top-4 border border-gray-200">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Filtros</h2>

                <form method="GET" action="{{ route('actors.index') }}" id="filter-form">

                    <!-- Favoritos -->
                    @auth
                    @if(Auth::user()->role == 'client')
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Favoritos</label>
                        <select name="favorites" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico">
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
                                    class="rounded text-rosa-electrico focus:ring-rosa-electrico">
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
                                    class="rounded text-naranja-vibrante focus:ring-naranja-vibrante">
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
                                    class="rounded text-azul-profundo focus:ring-azul-profundo">
                                <span class="ml-2 text-sm text-gray-700">{{ $school->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex space-x-2">
                        <button type="submit" class="bg-rosa-electrico text-white px-4 py-2 rounded-lg hover:bg-rosa-electrico hover:bg-opacity-90 flex-1 font-semibold transition duration-200">
                            Aplicar Filtros
                        </button>
                        <a href="{{ route('actors.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 inline-flex items-center font-semibold transition duration-200">
                            <i class="fas fa-times mr-1"></i>Limpiar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Columna de Resultados -->
        <div class="lg:w-3/4">
            <!-- Info de filtros activos -->
            @if(request()->anyFilled(['availability', 'genders', 'voice_ages', 'schools']))
            <div class="bg-rosa-electrico bg-opacity-10 p-4 rounded-lg mb-6 border border-rosa-electrico border-opacity-20">
                <p class="text-sm text-rosa-electrico font-medium">
                    <i class="fas fa-filter mr-2"></i>Filtros activos:
                    @if(request('availability') === '1') <span class="bg-verde-menta bg-opacity-20 text-verde-menta px-2 py-1 rounded mx-1">Disponible</span> @endif
                    @if(request('availability') === '0') <span class="bg-rojo-intenso bg-opacity-20 text-rojo-intenso px-2 py-1 rounded mx-1">No disponible</span> @endif
                    @if(request('genders')) <span class="bg-rosa-electrico bg-opacity-20 text-rosa-electrico px-2 py-1 rounded mx-1">Géneros: {{ implode(', ', request('genders')) }}</span> @endif
                    @if(request('voice_ages')) <span class="bg-naranja-vibrante bg-opacity-20 text-naranja-vibrante px-2 py-1 rounded mx-1">Edades: {{ implode(', ', request('voice_ages')) }}</span> @endif
                    @if(request('schools'))
                    <span class="bg-azul-profundo bg-opacity-20 text-azul-profundo px-2 py-1 rounded mx-1">Escuelas: {{ implode(', ', array_map(function($id) use ($schools) { 
                            return $schools->firstWhere('id', $id)->name ?? ''; 
                        }, request('schools'))) }}</span>
                    @endif
                </p>
            </div>
            @endif

            <!-- Lista de Actores -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($actors as $actor)
                <a href="{{ route('actors.show', $actor) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-200 hover:border-naranja-vibrante hover:scale-105 transform group cursor-pointer">
                    <div class="relative">
                        <!-- BOTÓN DE FAVORITOS -->
                        @auth
                        @if(Auth::user()->role == 'client')
                        <form action="{{ route('actors.favorite.toggle', $actor) }}" method="POST" class="absolute top-2 right-2 z-10" onclick="event.stopPropagation()">
                            @csrf
                            <button type="submit" class="bg-white bg-opacity-90 rounded-full p-2 hover:bg-opacity-100 transition shadow-sm hover:shadow-md"
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
                        <img src="{{ asset('storage/' . $actor->photo) }}" alt="{{ $actor->name }}" class="w-full h-48 object-cover">
                        @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition duration-300">
                            <i class="fas fa-user text-gray-400 text-4xl"></i>
                        </div>
                        @endif
                    </div>

                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-semibold text-gray-800 group-hover:text-naranja-vibrante transition duration-300">{{ $actor->name }}</h3>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                    {{ $actor->is_available ? 'bg-verde-menta bg-opacity-20 text-verde-menta' : 'bg-rojo-intenso bg-opacity-20 text-rojo-intenso' }}">
                                {{ $actor->is_available ? 'Disponible' : 'No disponible' }}
                            </span>
                        </div>

                        <!-- Géneros -->
                        <p class="text-gray-600 mb-1 text-sm">
                            <strong class="text-rosa-electrico">Géneros:</strong> {{ $actor->genders_string ?: 'No especificado' }}
                        </p>

                        <!-- Edades vocales -->
                        <p class="text-gray-600 mb-3 text-sm">
                            <strong class="text-naranja-vibrante">Edades vocales:</strong> {{ $actor->voice_ages_string ?: 'No especificado' }}
                        </p>

                        @if($actor->bio)
                        <p class="text-gray-700 mb-2 text-sm line-clamp-2">{{ Str::limit($actor->bio, 100) }}</p>
                        @endif

                        <div class="mt-4 text-azul-profundo text-sm font-semibold group-hover:text-azul-profundo transition duration-300">
                            Ver perfil completo <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-6">
                {{ $actors->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection