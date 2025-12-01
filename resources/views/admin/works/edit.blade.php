@extends('layouts.app')

@section('title', 'Editar ' . $work->title . ' - Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md p-6">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-4 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 mr-4">
                        <i class="fas fa-film text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Editar Obra</h1>
                        <p class="text-gray-600 mt-1">Actualiza la información de {{ $work->title }}</p>
                    </div>
                </div>
                <div class="text-sm text-gray-500">
                    ID: {{ $work->id }} • Creada: {{ $work->created_at->format('d/m/Y') }}
                </div>
            </div>
        </div>

        <!-- Información Actual -->
        <div class="bg-gray-50 p-4 mb-6 border border-gray-200">
            <h3 class="font-semibold text-gray-700 mb-2">Información Actual</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium">Actores participantes:</span>
                    <span class="ml-2">{{ $work->actors_count }}</span>
                </div>
                <div>
                    <span class="font-medium">Última actualización:</span>
                    <span class="ml-2">{{ $work->updated_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="col-span-2">
                    @if($work->poster)
                    <span class="font-medium">Póster actual:</span>
                    <img src="{{ asset('storage/' . $work->poster) }}"
                        alt="{{ $work->title }}"
                        class="h-20 object-cover mt-2">
                    @else
                    <span class="font-medium">Póster:</span>
                    <span class="ml-2 text-gray-500">No tiene póster</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form action="{{ route('admin.works.update', $work) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Título -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Título <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    name="title"
                    id="title"
                    required
                    value="{{ old('title', $work->title) }}"
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipo -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                    Tipo <span class="text-red-500">*</span>
                </label>
                <select name="type" id="type" required
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <option value="">Selecciona un tipo</option>
                    @foreach($types as $key => $label)
                    <option value="{{ $key }}" {{ old('type', $work->type) == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
                @error('type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Año -->
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                    Año de Lanzamiento
                </label>
                <input type="number"
                    name="year"
                    id="year"
                    value="{{ old('year', $work->year) }}"
                    min="1900"
                    max="{{ date('Y') + 5 }}"
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                @error('year')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nuevo Poster -->
            <div>
                <label for="poster" class="block text-sm font-medium text-gray-700 mb-2">
                    Cambiar Póster
                </label>
                <input type="file"
                    name="poster"
                    id="poster"
                    accept="image/*"
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener el póster actual</p>
                @error('poster')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descripción -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Descripción
                </label>
                <textarea name="description"
                    id="description"
                    rows="6"
                    placeholder="Describe la obra, su trama, personajes principales..."
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">{{ old('description', $work->description) }}</textarea>
                @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <div>
                    @if($work->actors_count > 0)
                    <p class="text-sm text-gray-500">
                        <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                        Esta obra tiene {{ $work->actors_count }} actor(es) asociado(s)
                    </p>
                    @endif
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.works') }}"
                        class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 transition duration-200 font-medium">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar Obra
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection