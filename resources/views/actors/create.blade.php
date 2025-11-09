@extends('layouts.app')

@section('title', 'Crear Perfil de Actor - Banco de Voces')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Crear Perfil de Actor</h1>
            <p class="text-gray-600 mt-2">Completa tu perfil para aparecer en nuestro banco de voces</p>
        </div>

        <form action="{{ route('actors.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Géneros (MÚLTIPLE SELECCIÓN) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Géneros que puedes interpretar <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @foreach($genders as $gender)
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition duration-150">
                        <input type="checkbox" name="genders[]" value="{{ $gender }}" 
                               {{ in_array($gender, old('genders', [])) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-3 text-sm font-medium text-gray-700">{{ $gender }}</span>
                    </label>
                    @endforeach
                </div>
                @error('genders')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Edades Vocales (MÚLTIPLE SELECCIÓN) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Edades vocales que puedes interpretar <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($voiceAges as $age)
                    <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition duration-150">
                        <input type="checkbox" name="voice_ages[]" value="{{ $age }}" 
                               {{ in_array($age, old('voice_ages', [])) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-3 text-sm font-medium text-gray-700">{{ $age }}</span>
                    </label>
                    @endforeach
                </div>
                @error('voice_ages')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Disponibilidad (CHECKBOX ÚNICO) -->
            <div>
                <label class="flex items-center space-x-3 cursor-pointer p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                    <input type="checkbox" name="is_available" value="1" 
                           {{ old('is_available', true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm font-medium text-gray-700">Disponible para nuevos proyectos</span>
                </label>
                @error('is_available')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Biografía -->
            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                    Biografía
                </label>
                <textarea name="bio" id="bio" rows="4"
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Cuéntanos sobre tu experiencia, formación y especialidades...">{{ old('bio') }}</textarea>
                @error('bio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Archivos -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Foto de Perfil -->
                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                        Foto de Perfil
                    </label>
                    <input type="file" name="photo" id="photo" 
                           accept="image/*"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF. Máx: 2MB</p>
                    @error('photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Muestra de Audio -->
                <div>
                    <label for="audio_path" class="block text-sm font-medium text-gray-700 mb-2">
                        Muestra de Voz
                    </label>
                    <input type="file" name="audio_path" id="audio_path" 
                           accept="audio/*"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Formatos: MP3, WAV. Máx: 5MB</p>
                    @error('audio_path')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Escuelas (MÚLTIPLE SELECCIÓN) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Formación Académica
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-48 overflow-y-auto border border-gray-200 rounded-md p-4">
                    @forelse($schools as $school)
                        <label class="flex items-center space-x-3 cursor-pointer p-2 hover:bg-gray-50 rounded">
                            <input type="checkbox" name="schools[]" value="{{ $school->id }}" 
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                   {{ in_array($school->id, old('schools', [])) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">
                                {{ $school->name }} 
                                @if($school->city)
                                    <span class="text-gray-500">({{ $school->city }})</span>
                                @endif
                            </span>
                        </label>
                    @empty
                        <p class="text-gray-500 text-sm col-span-2">No hay escuelas registradas</p>
                    @endforelse
                </div>
                @error('schools')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Obras (MÚLTIPLE SELECCIÓN) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Trabajos Destacados
                </label>
                <div class="space-y-3 max-h-48 overflow-y-auto border border-gray-200 rounded-md p-4">
                    @forelse($works as $work)
                        <div class="flex items-start space-x-3 p-2 hover:bg-gray-50 rounded">
                            <input type="checkbox" name="works[]" value="{{ $work->id }}" 
                                   class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500 work-checkbox"
                                   {{ in_array($work->id, old('works', [])) ? 'checked' : '' }}>
                            <div class="flex-1">
                                <span class="text-sm font-medium text-gray-700">{{ $work->title }}</span>
                                <div class="text-xs text-gray-500">
                                    <span class="capitalize">{{ $work->type }}</span>
                                    @if($work->year)
                                        · {{ $work->year }}
                                    @endif
                                </div>
                                <!-- Campo para nombre del personaje -->
                                <input type="text" name="character_names[{{ $work->id }}]" 
                                       placeholder="Personaje que interpretaste"
                                       class="mt-1 w-full text-xs border border-gray-300 rounded px-2 py-1 character-name {{ in_array($work->id, old('works', [])) ? '' : 'hidden' }}"
                                       value="{{ old('character_names.' . $work->id) }}">
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No hay obras registradas</p>
                    @endforelse
                </div>
                @error('works')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('dashboard') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                    Crear Perfil
                </button>
            </div>
        </form>
    </div>

    <!-- Información Adicional -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Información importante</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>• Puedes seleccionar <strong>múltiples géneros y edades vocales</strong></p>
                    <p>• Tu perfil será visible para clientes y productores</p>
                    <p>• Puedes actualizar tu información en cualquier momento</p>
                    <p>• La muestra de voz ayuda a los clientes a conocer tu talento</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Mostrar/ocultar campo de personaje cuando se selecciona una obra
document.addEventListener('DOMContentLoaded', function() {
    const workCheckboxes = document.querySelectorAll('.work-checkbox');
    
    workCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const characterNameInput = this.closest('.flex').querySelector('.character-name');
            if (this.checked) {
                characterNameInput.classList.remove('hidden');
            } else {
                characterNameInput.classList.add('hidden');
                characterNameInput.value = '';
            }
        });
        
        // Mostrar campos para obras ya seleccionadas
        if (checkbox.checked) {
            const characterNameInput = checkbox.closest('.flex').querySelector('.character-name');
            characterNameInput.classList.remove('hidden');
        }
    });
});

// Preview de imagen seleccionada
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        console.log('Imagen seleccionada:', file.name);
    }
});

// Preview de audio seleccionado
document.getElementById('audio_path').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        console.log('Audio seleccionado:', file.name);
    }
});
</script>
@endsection