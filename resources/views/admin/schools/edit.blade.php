@extends('layouts.app')

@section('title', 'Editar ' . $school->name . ' - Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md p-6">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-4 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 mr-4">
                        <i class="fas fa-school text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Editar Escuela</h1>
                        <p class="text-gray-600 mt-1">Actualiza la información de {{ $school->name }}</p>
                    </div>
                </div>
                <div class="text-sm text-gray-500">
                    ID: {{ $school->id }} • Creada: {{ $school->created_at->format('d/m/Y') }}
                </div>
            </div>
        </div>

        <!-- Información Actual -->
        <div class="bg-gray-50 p-4 mb-6 border border-gray-200">
            <h3 class="font-semibold text-gray-700 mb-2">Información Actual</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium">Actores formados:</span>
                    <span class="ml-2">{{ $school->actors_count }}</span>
                </div>
                <div>
                    <span class="font-medium">Última actualización:</span>
                    <span class="ml-2">{{ $school->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form action="{{ route('admin.schools.update', $school) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nombre de la Escuela <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       required
                       value="{{ old('name', $school->name) }}"
                       class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ciudad -->
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                    Ciudad <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="city" 
                       id="city" 
                       required
                       value="{{ old('city', $school->city) }}"
                       class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                @error('city')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Año de Fundación -->
            <div>
                <label for="founded_year" class="block text-sm font-medium text-gray-700 mb-2">
                    Año de Fundación
                </label>
                <input type="number" 
                       name="founded_year" 
                       id="founded_year" 
                       value="{{ old('founded_year', $school->founded_year) }}"
                       min="1900" 
                       max="{{ date('Y') }}"
                       class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                @error('founded_year')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Logo -->
            <div>
                <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                    Logo de la escuela
                </label>
                <input type="file" name="logo" id="logo" 
                       class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('logo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sitio Web -->
            <div>
                <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                    Sitio Web
                </label>
                <input type="url" 
                       name="website" 
                       id="website" 
                       value="{{ old('website', $school->website) }}"
                       class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                @error('website')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descripción -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Descripción <span class="text-red-500">*</span>
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="6"
                          required
                          class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">{{ old('description', $school->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <div>
                    @if($school->actors_count > 0)
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                            Esta escuela tiene {{ $school->actors_count }} actor(es) asociado(s)
                        </p>
                    @endif
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.schools') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 transition duration-200 font-medium">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar Escuela
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection