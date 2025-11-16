@extends('layouts.app')

@section('title', 'Crear Nuevo Actor - Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-4 mb-6">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full mr-4">
                    <i class="fas fa-user-plus text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Crear Nuevo Actor</h1>
                    <p class="text-gray-600 mt-1">Crear nuevo usuario y perfil de actor</p>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form action="{{ route('admin.actors.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Información del Usuario -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Información del Usuario</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nombre -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" required
                            value="{{ old('name') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" required
                            value="{{ old('email') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" id="password" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmar Contraseña <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Información del Actor -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Información del Actor</h3>

                <!-- Información Básica -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Géneros -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Géneros que puede interpretar <span class="text-red-500">*</span>
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

                    <!-- Edades Vocales -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Edades vocales que puede interpretar <span class="text-red-500">*</span>
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
                </div>

                <!-- Disponibilidad -->
                <div class="mb-6">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="hidden" name="is_available" value="0">
                        <input type="checkbox" name="is_available" value="1"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            {{ old('is_available', 1) ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-gray-700">Disponible para nuevos proyectos</span>
                    </label>
                    @error('is_available')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Biografía -->
                <div class="mb-6">
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                        Biografía
                    </label>
                    <textarea name="bio" id="bio" rows="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Describe la experiencia, formación y especialidades del actor...">{{ old('bio') }}</textarea>
                    @error('bio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Archivos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Foto -->
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                            Foto de Perfil
                        </label>
                        <input type="file" name="photo" id="photo"
                            accept="image/*"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF. Máx: 2MB</p>
                        @error('photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Audio -->
                    <div>
                        <label for="audio_path" class="block text-sm font-medium text-gray-700 mb-2">
                            Muestra de Voz
                        </label>
                        <input type="file" name="audio_path" id="audio_path"
                            accept="audio/*"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Formatos: MP3, WAV. Máx: 5MB</p>
                        @error('audio_path')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Escuelas -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Formación Académica
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-4">
                        @forelse($schools as $school)
                        <label class="flex items-center space-x-3 cursor-pointer">
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

                <!-- Profesor -->
                <div class="bg-yellow-50 rounded-lg p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4 flex items-center">
                        <i class="fas fa-chalkboard-teacher text-yellow-600 mr-2"></i>
                        Información como Profesor
                    </h2>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Escuelas donde enseña</label>
                        <div class="space-y-3">
                            @foreach($schools as $school)
                            <div class="flex items-center justify-between p-3 border border-yellow-200 rounded-lg bg-white">
                                <label class="flex items-center">
                                    <input type="checkbox" name="teaching_schools[]" value="{{ $school->id }}"
                                        {{ in_array($school->id, old('teaching_schools', [])) ? 'checked' : '' }}
                                        class="rounded text-yellow-600 focus:ring-yellow-500 teaching-school-checkbox">
                                    <span class="ml-2 text-sm text-gray-700">{{ $school->name }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Obras -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Trabajos Destacados
                    </label>
                    <div class="space-y-3 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-4">
                        @forelse($works as $work)
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" name="works[]" value="{{ $work->id }}"
                                class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                {{ in_array($work->id, old('works', [])) ? 'checked' : '' }}>
                            <div class="flex-1">
                                <span class="text-sm font-medium text-gray-700">{{ $work->title }}</span>
                                <div class="text-xs text-gray-500">
                                    <span class="capitalize">{{ $work->type }}</span>
                                    @if($work->year)
                                    · {{ $work->year }}
                                    @endif
                                </div>
                                <input type="text" name="character_names[{{ $work->id }}]"
                                    placeholder="Personaje que interpretó"
                                    class="mt-1 w-full text-xs border border-gray-300 rounded px-2 py-1"
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
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.actors') }}"
                    class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200 font-medium">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Crear Actor y Usuario
                </button>
            </div>
        </form>
    </div>
</div>
@endsection