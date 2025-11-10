@extends('layouts.app')

@section('title', 'Escuelas de Doblaje - Banco de Voces')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Escuelas de Doblaje</h1>
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.schools.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    <i class="fas fa-plus mr-2"></i>Nueva Escuela
                </a>
            @endif
        @endauth
    </div>

    <p class="text-gray-600 mb-8 max-w-3xl">
        Descubre las mejores escuelas de doblaje y formación vocal de España. 
        Cada escuela cuenta con actores profesionales formados en sus aulas.
    </p>

    <!-- Lista de Escuelas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($schools as $school)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
    <div class="p-6">
        {{-- Logo --}}
        @if($school->logo)
            <div class="mb-4 flex justify-center">
                <img src="{{ asset('storage/' . $school->logo) }}" 
                     alt="{{ $school->name }}"
                     class="w-20 h-20 rounded-full object-cover border-2 border-gray-200">
            </div>
        @else
            <div class="mb-4 flex justify-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center border-2 border-gray-200">
                    <i class="fas fa-school text-blue-500 text-2xl"></i>
                </div>
            </div>
        @endif
        
        <h3 class="text-xl font-semibold mb-3 text-blue-600 text-center">{{ $school->name }}</h3>
                    
                    <div class="space-y-2 mb-4">
                        @if($school->city)
                            <p class="text-gray-600">
                                <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                {{ $school->city }}
                            </p>
                        @endif
                        
                        @if($school->founded_year)
                            <p class="text-gray-600">
                                <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                Fundada en {{ $school->founded_year }}
                            </p>
                        @endif
                        
                        <p class="text-gray-600">
                            <i class="fas fa-users mr-2 text-gray-400"></i>
                            {{ $school->actors_count }} actores formados
                        </p>
                    </div>

                    @if($school->description)
                        <p class="text-gray-700 mb-4 line-clamp-3">{{ Str::limit($school->description, 120) }}</p>
                    @endif

                    <div class="flex justify-between items-center">
                        <a href="{{ route('schools.show', $school) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                            Ver Detalles
                        </a>
                        
                        @if($school->website)
                            <a href="{{ $school->website }}" target="_blank" class="text-gray-500 hover:text-blue-600" title="Sitio web">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-school text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-500 mb-2">No hay escuelas registradas</h3>
                <p class="text-gray-400">Próximamente se añadirán las escuelas de doblaje.</p>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if($schools->hasPages())
        <div class="mt-8">
            {{ $schools->links() }}
        </div>
    @endif
</div>
@endsection