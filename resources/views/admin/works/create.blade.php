@extends('layouts.app')

@section('title', 'Crear Nueva Obra - Admin')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-4 mb-6">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full mr-4">
                    <i class="fas fa-film text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Crear Nueva Obra</h1>
                    <p class="text-gray-600 mt-1">Añade una nueva película, serie o producción al sistema</p>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form action="{{ route('admin.works.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Título -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Título <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    name="title"
                    id="title"
                    required
                    value="{{ old('title') }}"
                    placeholder="Ej: El Señor de los Anillos, Breaking Bad..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
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
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"> <!-- ← AÑADIR CLASE -->
                    <option value="">Selecciona un tipo</option>
                    @foreach($types as $key => $label)
                    <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
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
                    value="{{ old('year') }}"
                    min="1900"
                    max="{{ date('Y') + 5 }}"
                    placeholder="Ej: 2023"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                @error('year')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Poster -->
            <div>
                <label for="poster" class="block text-sm font-medium text-gray-700 mb-2">
                    Póster o Imagen
                </label>
                <input type="file"
                    name="poster"
                    id="poster"
                    accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF. Máx: 2MB</p>
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
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">{{ old('description') }}</textarea>
                @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.works') }}"
                    class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200 font-medium">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Crear Obra
                </button>
            </div>
        </form>
    </div>

    <!-- Información de Ayuda -->
    <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-lightbulb text-green-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-green-800">Consejos para crear una obra</h3>
                <div class="mt-2 text-sm text-green-700">
                    <p>• Incluye una descripción atractiva que resuma la trama</p>
                    <p>• El año ayuda a los usuarios a contextualizar la obra</p>
                    <p>• Un buen póster hace más atractiva la presentación</p>
                    <p>• Selecciona el tipo correcto para mejores filtros</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Preview de imagen seleccionada
    document.getElementById('poster').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Podrías agregar aquí un preview de la imagen si quieres
            console.log('Póster seleccionado:', file.name);
        }
    });
</script>
@endsection