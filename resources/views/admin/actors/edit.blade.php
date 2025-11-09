@extends('layouts.app')

@section('title', 'Editar ' . $actor->user->name . ' - Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-4 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    @if($actor->photo)
                        <img src="{{ asset('storage/' . $actor->photo) }}" 
                             alt="{{ $actor->user->name }}" 
                             class="w-16 h-16 rounded-full object-cover mr-4">
                    @else
                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-gray-400 text-xl"></i>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Editar Actor</h1>
                        <p class="text-gray-600 mt-1">{{ $actor->user->name }} ({{ $actor->user->email }})</p>
                    </div>
                </div>
                <div class="text-sm text-gray-500">
                    ID: {{ $actor->id }} • Creado: {{ $actor->created_at->format('d/m/Y') }}
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form action="{{ route('admin.actors.update', $actor) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Información Básica -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Géneros (MÚLTIPLE SELECCIÓN) -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-3">
        Géneros que puede interpretar <span class="text-red-500">*</span>
    </label>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        @foreach($genders as $gender)
        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition duration-150">
            <input type="checkbox" name="genders[]" value="{{ $gender }}" 
                   {{ in_array($gender, old('genders', $actor->genders ?? [])) ? 'checked' : '' }}
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
        Edades vocales que puede interpretar <span class="text-red-500">*</span>
    </label>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach($voiceAges as $age)
        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition duration-150">
            <input type="checkbox" name="voice_ages[]" value="{{ $age }}" 
                   {{ in_array($age, old('voice_ages', $actor->voice_ages ?? [])) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <span class="ml-3 text-sm font-medium text-gray-700">{{ $age }}</span>
        </label>
        @endforeach
    </div>
    @error('voice_ages')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
            </div>

            <!-- Disponibilidad -->
            <div>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="is_available" value="1" 
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                           {{ old('is_available', $actor->is_available) ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">Disponible para nuevos proyectos</span>
                </label>
            </div>

            <!-- Biografía -->
            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                    Biografía
                </label>
                <textarea name="bio" id="bio" rows="4"
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Biografía del actor...">{{ old('bio', $actor->bio) }}</textarea>
            </div>

            <!-- Archivos Actuales -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Foto Actual -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Actual
                    </label>
                    @if($actor->photo)
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('storage/' . $actor->photo) }}" 
                                 alt="Foto actual" 
                                 class="w-20 h-20 rounded-full object-cover">
                            <span class="text-sm text-gray-600">Foto actual</span>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No hay foto</p>
                    @endif
                </div>

                <!-- Audio Actual -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Audio Actual
                    </label>
                    @if($actor->audio_path)
                        <div class="flex items-center space-x-4">
                            <i class="fas fa-volume-up text-blue-500 text-xl"></i>
                            <audio controls class="h-8">
                                <source src="{{ asset('storage/' . $actor->audio_path) }}" type="audio/mpeg">
                            </audio>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No hay audio</p>
                    @endif
                </div>
            </div>

            <!-- Nuevos Archivos -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nueva Foto -->
                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                        Cambiar Foto
                    </label>
                    <input type="file" name="photo" id="photo" 
                           accept="image/*"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener la actual</p>
                </div>

                <!-- Nuevo Audio -->
                <div>
                    <label for="audio_path" class="block text-sm font-medium text-gray-700 mb-2">
                        Cambiar Audio
                    </label>
                    <input type="file" name="audio_path" id="audio_path" 
                           accept="audio/*"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener el actual</p>
                </div>
            </div>

            <!-- Escuelas -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Escuelas
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-4">
                    @foreach($schools as $school)
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" name="schools[]" value="{{ $school->id }}" 
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                   {{ in_array($school->id, old('schools', $actor->schools->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">{{ $school->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Obras -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Obras
                </label>
                <div class="space-y-3 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-4">
                    @foreach($works as $work)
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" name="works[]" value="{{ $work->id }}" 
                                   class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                   {{ in_array($work->id, old('works', $actor->works->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <div class="flex-1">
                                <span class="text-sm font-medium text-gray-700">{{ $work->title }}</span>
                                <div class="text-xs text-gray-500 capitalize">
                                    {{ $work->type }} @if($work->year)• {{ $work->year }}@endif
                                </div>
                                @php
                                    $characterName = $actor->works->find($work->id)->pivot->character_name ?? '';
                                @endphp
                                <input type="text" name="character_names[{{ $work->id }}]" 
                                       placeholder="Personaje"
                                       class="mt-1 w-full text-xs border border-gray-300 rounded px-2 py-1"
                                       value="{{ old('character_names.' . $work->id, $characterName) }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <div>
                    <p class="text-sm text-gray-500">
                        <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                        Usuario: {{ $actor->user->email }}
                    </p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.actors') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200 font-medium">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar Actor
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection