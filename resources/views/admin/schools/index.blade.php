@extends('layouts.app')

@section('title', 'Gestión de Escuelas - Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-white shadow-md p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Gestión de Escuelas</h1>
                <p class="text-gray-600 mt-2">Administra todas las escuelas de doblaje registradas</p>
            </div>
            <a href="{{ route('admin.schools.create') }}"
                class="bg-blue-600 text-white px-6 py-3 hover:bg-blue-700 transition duration-200 flex items-center font-medium">
                <i class="fas fa-plus mr-2"></i>
                Nueva Escuela
            </a>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white shadow p-4 text-center border border-gray-200">
            <div class="text-2xl font-bold text-blue-600">{{ $schools->total() }}</div>
            <div class="text-sm text-gray-600">Total Escuelas</div>
        </div>
        <div class="bg-white shadow p-4 text-center border border-gray-200">
            <div class="text-2xl font-bold text-orange-600">{{ $schools->sum('actors_count') }}</div>
            <div class="text-sm text-gray-600">Total Actores</div>
        </div>
        <div class="bg-white shadow p-4 text-center border border-gray-200">
            <div class="text-2xl font-bold text-green-600">{{ $schools->sum('teachers_count') }}</div>
            <div class="text-sm text-gray-600">Total Profesores</div>
        </div>
    </div>

    <!-- Filtros Mejorados -->
    <div class="bg-white shadow-md p-4 mb-6 border border-gray-200">
        <form method="GET" action="{{ route('admin.schools') }}" id="filterForm" class="flex flex-wrap gap-4 items-end">
            <!-- Búsqueda por nombre -->
            <div class="min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar Escuela</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Nombre de la escuela..."
                       class="w-full border border-gray-300 px-3 py-2 search-input">
            </div>

            <!-- Ciudad (Select con ciudades únicas) -->
            <div class="min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                <select name="city" class="w-full border border-gray-300 px-3 py-2 filter-select">
                    <option value="">Todas las ciudades</option>
                    @foreach($cities as $city)
                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                        {{ $city }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Estado -->
            <div class="min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select name="status" class="w-full border border-gray-300 px-3 py-2 filter-select">
                    <option value="">Todos</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Con actores</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Sin actores</option>
                </select>
            </div>

            <!-- Ordenar -->
            <div class="min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Ordenar</label>
                <select name="sort" class="w-full border border-gray-300 px-3 py-2 filter-select">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Más recientes</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Más antiguas</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nombre A-Z</option>
                    <option value="actors" {{ request('sort') == 'actors' ? 'selected' : '' }}>Más actores</option>
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 hover:bg-blue-700 transition duration-200 flex items-center h-[42px] font-medium">
                    <i class="fas fa-filter mr-2"></i> Filtrar
                </button>
                <a href="{{ route('admin.schools') }}" class="bg-gray-500 text-white px-4 py-2 hover:bg-gray-600 transition duration-200 flex items-center h-[42px] font-medium">
                    <i class="fas fa-times mr-2"></i> Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Lista de Escuelas -->
    <div class="bg-white shadow-md overflow-hidden border border-gray-200">
        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Escuela
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ciudad
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Año
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actores
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($schools as $school)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <!-- Información de la Escuela -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($school->logo)
                                <img src="{{ asset('storage/' . $school->logo) }}"
                                    alt="{{ $school->name }}"
                                    class="h-12 w-12 object-cover mr-4">
                                @else
                                <div class="h-12 w-12 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center mr-4">
                                    <i class="fas fa-school text-white"></i>
                                </div>
                                @endif
                                <div>
                                    {{-- NOMBRE COMO LINK PARA VER --}}
                                    <a href="{{ route('schools.show', $school) }}"
                                        class="text-sm font-medium text-gray-900 hover:text-blue-600 transition duration-150">
                                        {{ $school->name }}
                                    </a>
                                    @if($school->website)
                                    <div class="text-sm text-gray-500">
                                        <a href="{{ $school->website }}" target="_blank" class="hover:text-blue-600">
                                            {{ parse_url($school->website, PHP_URL_HOST) }}
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Ciudad -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $school->city ?? '-' }}
                            </div>
                        </td>

                        <!-- Año -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if($school->founded_year)
                                {{ $school->founded_year }}
                                @else
                                -
                                @endif
                            </div>
                        </td>

                        <!-- Actores -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">
                                {{ $school->actors_count }}
                            </div>
                            <div class="text-xs text-gray-500">
                                actores formados
                            </div>
                        </td>

                        <!-- Estado -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold 
                                    {{ $school->actors_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $school->actors_count > 0 ? 'Activa' : 'Sin actores' }}
                            </span>
                        </td>

                        <!-- Acciones - SOLO EDITAR Y ELIMINAR -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                {{-- Botón Editar --}}
                                <a href="{{ route('admin.schools.edit', $school) }}"
                                    class="text-yellow-600 hover:text-yellow-900 bg-yellow-100 hover:bg-yellow-200 px-3 py-1 transition duration-150 font-medium">
                                    Editar
                                </a>

                                {{-- Botón Eliminar --}}
                                <form action="{{ route('admin.schools.destroy', $school) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar esta escuela?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 px-3 py-1 transition duration-150 font-medium">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-school text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No hay escuelas registradas</p>
                                <p class="mt-2">Comienza añadiendo la primera escuela</p>
                                <a href="{{ route('admin.schools.create') }}"
                                    class="inline-block mt-4 bg-blue-600 text-white px-6 py-2 hover:bg-blue-700 font-medium">
                                    Crear Primera Escuela
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($schools->hasPages())
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            {{ $schools->links() }}
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    const filterSelects = document.querySelectorAll('.filter-select');
    const searchInput = document.querySelector('.search-input');
    
    let searchTimeout;
    
    // Filtro en tiempo real para selects
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            filterForm.submit();
        });
    });
    
    // Filtro en tiempo real para búsqueda (con debounce)
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            filterForm.submit();
        }, 500);
    });
});
</script>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection