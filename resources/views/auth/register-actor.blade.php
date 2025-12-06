@extends('layouts.app')

@section('title', 'Registrarse como Actor - Dubivo')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 px-4">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Icono y título -->
        <div class="bg-rosa-electrico bg-opacity-20 w-16 h-16 flex items-center justify-center mx-auto mb-4 border border-rosa-electrico">
            <i class="fas fa-microphone text-rosa-electrico text-2xl"></i>
        </div>
        <h2 class="text-center text-3xl font-bold text-gray-800">
            Registrarse como Actor
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Crea tu perfil profesional de actor de doblaje
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-6 shadow-md border border-gray-200">
            <form action="{{ route('register.actor.submit') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nombre completo -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre completo</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                        class="w-full border border-gray-300 px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico">
                    @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                        class="w-full border border-gray-300 px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico">
                    @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                    <input type="password" name="password" id="password" required
                        class="w-full border border-gray-300 px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico">
                    @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar contraseña -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full border border-gray-300 px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico">
                </div>

                <!-- Botón de registro -->
                <div>
                    <button type="submit"
                        class="w-full bg-rosa-electrico hover:bg-rosa-electrico hover:bg-opacity-90 text-white py-3 px-4 font-semibold transition duration-200">
                        Crear perfil de actor
                    </button>
                </div>

                <!-- Enlace a login -->
                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        ¿Ya tienes cuenta?
                        <a href="{{ route('login') }}" class="text-azul-profundo hover:text-azul-profundo hover:bg-opacity-90 font-medium">
                            Inicia sesión
                        </a>
                    </p>
                </div>

                <!-- Enlace a registro cliente -->
                <div class="border-t border-gray-200 pt-4 text-center">
                    <p class="text-sm text-gray-600 mb-2">¿Eres cliente en lugar de actor?</p>
                    <a href="{{ route('register.client') }}" class="text-ambar hover:text-ambar hover:bg-opacity-90 font-medium text-sm">
                        Registrarse como Cliente
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection