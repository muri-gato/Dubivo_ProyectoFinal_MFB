@extends('layouts.app')

@section('title', 'Editar ' . $user->name . ' - Admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-4 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <i class="fas fa-user-edit text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Editar Usuario</h1>
                        <p class="text-gray-600 mt-1">{{ $user->name }} ({{ $user->email }})</p>
                    </div>
                </div>
                <div class="text-sm text-gray-500">
                    ID: {{ $user->id }} • Registrado: {{ $user->created_at->format('d/m/Y') }}
                </div>
            </div>
        </div>

        <!-- Información Actual -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-gray-700 mb-2">Información Actual</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium">Rol:</span>
                    <span class="ml-2 capitalize {{ $user->role == 'admin' ? 'text-red-600 font-semibold' : '' }}">{{ $user->role }}</span>
                </div>
                <div>
                    <span class="font-medium">Perfil de actor:</span>
                    <span class="ml-2 {{ $user->actorProfile ? 'text-green-600' : 'text-gray-500' }}">
                        {{ $user->actorProfile ? 'Creado' : 'No creado' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nombre <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       required
                       value="{{ old('name', $user->name) }}"
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
                <input type="email" 
                       name="email" 
                       id="email" 
                       required
                       value="{{ old('email', $user->email) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nueva Contraseña (opcional) -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Nueva Contraseña
                </label>
                <input type="password" 
                       name="password" 
                       id="password" 
                       placeholder="Dejar vacío para mantener la actual"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirmar Nueva Contraseña
                </label>
                <input type="password" 
                       name="password_confirmation" 
                       id="password_confirmation" 
                       placeholder="Repite la nueva contraseña"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Rol -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                    Rol <span class="text-red-500">*</span>
                </label>
                <select name="role" 
                        id="role" 
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="actor" {{ old('role', $user->role) == 'actor' ? 'selected' : '' }}>Actor</option>
                    <option value="client" {{ old('role', $user->role) == 'client' ? 'selected' : '' }}>Cliente</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <div>
                    @if($user->actorProfile)
                        <p class="text-sm text-blue-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            Este actor tiene perfil creado
                        </p>
                    @endif
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.users') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200 font-medium">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar Usuario
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Sección Peligrosa -->
    @if($user->id !== Auth::id())
        <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Zona Peligrosa</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <p class="mb-2">Esta acción no se puede deshacer. Se eliminarán todos los datos del usuario.</p>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm"
                                    onclick="return confirm('¿ESTÁS SEGURO? Esto eliminará permanentemente al usuario {{ $user->name }} y todos sus datos asociados.')">
                                <i class="fas fa-trash mr-1"></i> Eliminar Usuario
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-yellow-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Información</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>No puedes eliminar tu propio usuario por razones de seguridad.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection