@extends('layouts.app')

@section('title', 'Panel de Administración - Dubivo')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6 border-l-4 border-rosa-electrico">
        <h1 class="text-3xl font-bold text-gray-800">Panel de Administración</h1>
        <p class="text-gray-600 mt-2">Gestiona todos los aspectos de la aplicación</p>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Total Usuarios -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-rosa-electrico">
            <div class="flex items-center">
                <div class="bg-rosa-electrico bg-opacity-10 p-3 rounded-full">
                    <i class="fas fa-users text-rosa-electrico text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Usuarios</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Actores -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-naranja-vibrante">
            <div class="flex items-center">
                <div class="bg-naranja-vibrante bg-opacity-10 p-3 rounded-full">
                    <i class="fas fa-user-tie text-naranja-vibrante text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Actores</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_actors'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Clientes -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-ambar">
            <div class="flex items-center">
                <div class="bg-ambar bg-opacity-10 p-3 rounded-full">
                    <i class="fas fa-user text-ambar text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Clientes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_clients'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Administradores -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-rojo-intenso">
            <div class="flex items-center">
                <div class="bg-rojo-intenso bg-opacity-10 p-3 rounded-full">
                    <i class="fas fa-user-shield text-rojo-intenso text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Administradores</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_admins'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Escuelas -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-verde-menta">
            <div class="flex items-center">
                <div class="bg-verde-menta bg-opacity-10 p-3 rounded-full">
                    <i class="fas fa-school text-verde-menta text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Escuelas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_schools'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Obras -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-azul-profundo">
            <div class="flex items-center">
                <div class="bg-azul-profundo bg-opacity-10 p-3 rounded-full">
                    <i class="fas fa-film text-azul-profundo text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Obras</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_works'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Profesores -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-morado-vibrante">
            <div class="flex items-center">
                <div class="bg-morado-vibrante bg-opacity-10 p-3 rounded-full">
                    <i class="fas fa-chalkboard-teacher text-morado-vibrante text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Profesores</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_teacher_actors'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

        <!-- Gestionar Actores -->
        <a href="{{ route('admin.actors') }}"
            class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 border border-gray-200 hover:border-naranja-vibrante group">
            <div class="flex items-center">
                <div class="bg-naranja-vibrante bg-opacity-10 p-3 rounded-full group-hover:bg-naranja-vibrante group-hover:bg-opacity-20 transition-colors duration-300">
                    <i class="fas fa-users text-naranja-vibrante text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800 group-hover:text-naranja-vibrante transition-colors duration-300">Gestionar Actores</h3>
                    <p class="text-gray-600 text-sm mt-1">Administrar todos los actores registrados</p>
                </div>
            </div>
        </a>

        <!-- Gestionar Escuelas -->
        <a href="{{ route('admin.schools') }}"
            class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 border border-gray-200 hover:border-ambar group">
            <div class="flex items-center">
                <div class="bg-ambar bg-opacity-10 p-3 rounded-full group-hover:bg-ambar group-hover:bg-opacity-20 transition-colors duration-300">
                    <i class="fas fa-school text-ambar text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800 group-hover:text-ambar transition-colors duration-300">Gestionar Escuelas</h3>
                    <p class="text-gray-600 text-sm mt-1">Añadir, editar o eliminar escuelas</p>
                </div>
            </div>
        </a>

        <!-- Gestionar Obras -->
        <a href="{{ route('admin.works') }}"
            class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 border border-gray-200 hover:border-verde-menta group">
            <div class="flex items-center">
                <div class="bg-verde-menta bg-opacity-10 p-3 rounded-full group-hover:bg-verde-menta group-hover:bg-opacity-20 transition-colors duration-300">
                    <i class="fas fa-film text-verde-menta text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800 group-hover:text-verde-menta transition-colors duration-300">Gestionar Obras</h3>
                    <p class="text-gray-600 text-sm mt-1">Administrar películas y series</p>
                </div>
            </div>
        </a>

        <!-- Gestionar Usuarios -->
        <a href="{{ route('admin.users') }}"
            class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 border border-gray-200 hover:border-rosa-electrico group">
            <div class="flex items-center">
                <div class="bg-rosa-electrico bg-opacity-10 p-3 rounded-full group-hover:bg-rosa-electrico group-hover:bg-opacity-20 transition-colors duration-300">
                    <i class="fas fa-user-cog text-rosa-electrico text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800 group-hover:text-rosa-electrico transition-colors duration-300">Gestionar Usuarios</h3>
                    <p class="text-gray-600 text-sm mt-1">Administrar usuarios del sistema</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Actividad Reciente -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Últimos Actores Registrados -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Actores Recientes</h2>
            <div class="space-y-3">
                @forelse($recentActors as $actor)
                <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:border-naranja-vibrante transition-colors duration-300">
                    @if($actor->photo)
                    <img src="{{ asset('storage/' . $actor->photo) }}"
                        alt="{{ $actor->user->name }}"
                        class="w-10 h-10 rounded-full object-cover">
                    @else
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    @endif
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">{{ $actor->user->name }}</p>
                        <p class="text-sm text-gray-600 capitalize">
                            {{ $actor->genders_string ?: 'Género no especificado' }}
                            • 
                            {{ $actor->voice_ages_string ?: 'Edad no especificada' }}
                        </p>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No hay actores registrados recientemente</p>
                @endforelse
            </div>
        </div>

        <!-- Espacio para otro widget -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Actividad Reciente</h2>
            <div class="space-y-3">
                <div class="p-3 border border-gray-200 rounded-lg">
                    <p class="text-gray-600">Aquí puedes agregar más estadísticas o información relevante</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection