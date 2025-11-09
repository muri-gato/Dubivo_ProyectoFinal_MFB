@extends('layouts.app')

@section('title', 'Contactar a ' . $actor->name . ' - Banco de Voces')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-4 mb-6">
            <div class="flex items-center space-x-4 mb-4">
                @if($actor->photo)
                    <img src="{{ asset('storage/' . $actor->photo) }}" 
                         alt="{{ $actor->name }}" 
                         class="w-16 h-16 rounded-full object-cover">
                @else
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-400 text-xl"></i>
                    </div>
                @endif
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Contactar a {{ $actor->name }}</h1>
                    <p class="text-gray-600">Envía una solicitud para colaborar con este actor</p>
                </div>
            </div>
            
            <!-- Info del Actor -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-semibold text-gray-700">Género:</span>
                        <span class="ml-2 capitalize">{{ $actor->gender }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-700">Edad vocal:</span>
                        <span class="ml-2 capitalize">{{ str_replace('_', ' ', $actor->voice_age) }}</span>
                    </div>
                    @if($actor->schools->count() > 0)
                        <div class="col-span-2">
                            <span class="font-semibold text-gray-700">Formación:</span>
                            <span class="ml-2">{{ $actor->schools->pluck('name')->implode(', ') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form action="{{ route('requests.store', $actor->user) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Asunto -->
            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                    Asunto del Proyecto <span class="text-red-500">*</span>
                </label>
                <input type="text" name="subject" id="subject" required
                       value="{{ old('subject') }}"
                       placeholder="Ej: Doblaje para comercial de TV, Locución para audioguía..."
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('subject')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mensaje -->
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                    Mensaje Detallado <span class="text-red-500">*</span>
                </label>
                <textarea name="message" id="message" rows="8" required
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Describe tu proyecto, fechas estimadas, presupuesto, y cualquier información relevante...">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                
                <!-- Sugerencias -->
                <div class="mt-2 text-sm text-gray-500">
                    <p class="font-semibold">Sugerencias para incluir en tu mensaje:</p>
                    <ul class="list-disc list-inside mt-1 space-y-1">
                        <li>Tipo de proyecto (comercial, documental, videojuego, etc.)</li>
                        <li>Fechas estimadas de grabación</li>
                        <li>Presupuesto disponible</li>
                        <li>Requisitos técnicos específicos</li>
                    </ul>
                </div>
            </div>

            <!-- Información del Cliente -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h3 class="font-semibold text-gray-700 mb-3">Tu información de contacto</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-semibold">Nombre:</span>
                        <span class="ml-2">{{ auth()->user()->name }}</span>
                    </div>
                    <div>
                        <span class="font-semibold">Email:</span>
                        <span class="ml-2">{{ auth()->user()->email }}</span>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">
                    El actor recibirá esta información para poder contactarte.
                </p>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('actors.show', $actor) }}" 
                   class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 flex items-center">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Enviar Solicitud
                </button>
            </div>
        </form>
    </div>

    <!-- Información Importante -->
    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Información importante</h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <p>• El actor revisará tu solicitud y decidirá si aceptarla o rechazarla</p>
                    <p>• Una vez enviada, podrás ver el estado de tu solicitud en tu panel</p>
                    <p>• Por favor, sé claro y profesional en tu comunicación</p>
                    <p>• El actor se pondrá en contacto contigo si acepta la solicitud</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection