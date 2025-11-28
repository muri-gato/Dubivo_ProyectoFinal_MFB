@extends('layouts.app')

@section('title', 'Escuelas de Doblaje - Dubivo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Escuelas de Doblaje</h1>
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.schools.create') }}" class="bg-verde-menta text-white px-6 py-3 rounded-lg hover:bg-verde-menta hover:bg-opacity-90 transition duration-200 flex items-center font-semibold">
                    <i class="fas fa-plus mr-2"></i>Nueva Escuela
                </a>
            @endif
        @endauth
    </div>

    <p class="text-gray-600 mb-8 max-w-3xl text-lg">
        Descubre las mejores escuelas de doblaje y formación vocal de España. 
        Cada escuela cuenta con actores profesionales formados en sus aulas.
    </p>

    <!-- Lista de Escuelas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($schools as $school)
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 border border-gray-200 hover:shadow-2xl hover:border-ambar hover:scale-105 transform group cursor-pointer relative z-10 flex flex-col min-h-[320px]">
                <a href="{{ route('schools.show', $school) }}" class="block flex-1 p-6 flex flex-col">
                    <!-- Logo y Nombre - Altura fija -->
                    <div class="text-center mb-6 flex-shrink-0">
                        @if($school->logo)
                            <div class="mb-3 flex justify-center">
                                <img src="{{ asset('storage/' . $school->logo) }}" 
                                     alt="{{ $school->name }}"
                                     class="w-20 h-20 rounded-full object-cover border-2 border-ambar border-opacity-30 group-hover:border-ambar transition duration-300">
                            </div>
                        @else
                            <div class="mb-3 flex justify-center">
                                <div class="w-20 h-20 bg-ambar bg-opacity-10 rounded-full flex items-center justify-center border-2 border-ambar border-opacity-30 group-hover:border-ambar transition duration-300">
                                    <i class="fas fa-school text-ambar text-2xl"></i>
                                </div>
                            </div>
                        @endif
                        
                        <h3 class="text-xl font-semibold text-azul-profundo group-hover:text-ambar transition duration-300 line-clamp-2 min-h-[3rem] flex items-center justify-center">
                            {{ $school->name }}
                        </h3>
                    </div>
                    
                    <!-- Información básica - Altura fija -->
                    <div class="space-y-3 mb-6 flex-shrink-0">
                        @if($school->city)
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt mr-3 text-rosa-electrico w-4 flex-shrink-0"></i>
                                <span class="text-sm truncate">{{ $school->city }}</span>
                            </div>
                        @endif
                        
                        @if($school->founded_year)
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar-alt mr-3 text-naranja-vibrante w-4 flex-shrink-0"></i>
                                <span class="text-sm">Fundada en {{ $school->founded_year }}</span>
                            </div>
                        @endif
                        
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-users mr-3 text-verde-menta w-4 flex-shrink-0"></i>
                            <span class="text-sm">{{ $school->actors_count }} actores formados</span>
                        </div>
                    </div>

                    <!-- Descripción - Se expande para ocupar espacio disponible -->
                    @if($school->description)
                        <div class="flex-1 min-h-[60px] mb-4">
                            <p class="text-gray-700 text-sm line-clamp-3 leading-relaxed h-full flex items-start">
                                {{ $school->description }}
                            </p>
                        </div>
                    @else
                        <!-- Espacio vacío si no hay descripción -->
                        <div class="flex-1 min-h-[60px]"></div>
                    @endif
                </a>

                <!-- Footer con acciones - Altura fija -->
                <div class="px-6 pb-4 pt-3 border-t border-gray-100 flex justify-between items-center flex-shrink-0 bg-gray-50">
                    <span class="text-azul-profundo text-sm font-semibold group-hover:text-azul-profundo transition duration-300 flex items-center">
                        Haz clic para ver detalles
                        <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                    </span>
                    
                    @if($school->website)
                        <a href="{{ $school->website }}" target="_blank" class="text-gray-400 hover:text-rosa-electrico transition duration-200 p-1 rounded" title="Sitio web" onclick="event.stopPropagation()">
                            <i class="fas fa-external-link-alt text-sm"></i>
                        </a>
                    @endif
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

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Asegurar que las transformaciones funcionen correctamente */
.transform {
    transform: translateZ(0);
}
</style>
@endsection