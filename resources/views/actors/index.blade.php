@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Actores de Voz</h1>
    
    @auth
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.actors.create') }}" 
               class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Nuevo Actor
            </a>
        @endif
    @endauth
</div>
    
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Columna de Filtros -->
        <div class="lg:w-1/4">
            <div class="bg-white p-6 rounded-lg shadow-md sticky top-4">
                <h2 class="text-xl font-semibold mb-4">Filtros</h2>
                
                <form method="GET" action="{{ route('actors.index') }}" id="filter-form">
                    
                    <!-- Disponibilidad (Radio buttons) -->
                    <div class="mb-6">
                        <h3 class="font-medium text-gray-700 mb-3">Disponibilidad</h3>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="availability" value="1" 
                                       {{ request('availability') == '1' ? 'checked' : '' }}
                                       class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Disponible</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="availability" value="0"
                                       {{ request('availability') == '0' ? 'checked' : '' }}
                                       class="text-blue-600 focus:ring-blue-500">
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
                                       class="rounded text-blue-600 focus:ring-blue-500">
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
                                       class="rounded text-blue-600 focus:ring-blue-500">
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
                                       class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $school->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex space-x-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex-1">
                            Aplicar Filtros
                        </button>
                        <a href="{{ route('actors.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 inline-flex items-center">
                            <i class="fas fa-times mr-1"></i>Limpiar Filtros
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Columna de Resultados -->
        <div class="lg:w-3/4">
            <!-- Info de filtros activos -->
            @if(request()->anyFilled(['availability', 'genders', 'voice_ages', 'schools']))
            <div class="bg-blue-50 p-4 rounded-lg mb-6">
                <p class="text-sm text-blue-800">
                    Filtros activos: 
                    @if(request('availability') === '1') Disponible @endif
                    @if(request('availability') === '0') No disponible @endif
                    @if(request('genders')) Géneros: {{ implode(', ', request('genders')) }} @endif
                    @if(request('voice_ages')) Edades: {{ implode(', ', request('voice_ages')) }} @endif
                    @if(request('schools')) 
                        Escuelas: {{ implode(', ', array_map(function($id) use ($schools) { 
                            return $schools->firstWhere('id', $id)->name ?? ''; 
                        }, request('schools'))) }}
                    @endif
                </p>
            </div>
            @endif

            <!-- Lista de Actores -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($actors as $actor)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                        @if($actor->photo)
                            <img src="{{ asset('storage/' . $actor->photo) }}" alt="{{ $actor->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">Sin foto</span>
                            </div>
                        @endif
                        
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-semibold">{{ $actor->name }}</h3>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $actor->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $actor->is_available ? 'Disponible' : 'No disponible' }}
                                </span>
                            </div>
                            
                            <!-- Géneros -->
                            <p class="text-gray-600 mb-1 text-sm">
                                <strong>Géneros:</strong> {{ $actor->genders_string ?: 'No especificado' }}
                            </p>
                            
                            <!-- Edades vocales -->
                            <p class="text-gray-600 mb-3 text-sm">
                                <strong>Edades vocales:</strong> {{ $actor->voice_ages_string ?: 'No especificado' }}
                            </p>
                            
                            @if($actor->bio)
                                <p class="text-gray-700 mb-4 text-sm line-clamp-2">{{ Str::limit($actor->bio, 100) }}</p>
                            @endif
                            
                            <a href="{{ route('actors.show', $actor) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full block text-center text-sm">
                                Ver Perfil
                            </a>
                        </div>
                    </div>
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