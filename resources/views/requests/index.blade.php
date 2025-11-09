@extends('layouts.app')

@section('title', 'Mis Solicitudes - Banco de Voces')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Mis Solicitudes</h1>
            <p class="text-gray-600 mt-2">
                @if(auth()->user()->role === 'actor')
                    Gestiona las solicitudes que recibes de clientes
                @else
                    Revisa el estado de las solicitudes que has enviado
                @endif
            </p>
        </div>

        <!-- Filtros -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="flex flex-wrap gap-4 items-center">
                <span class="text-sm font-medium text-gray-700">Filtrar por estado:</span>
                <a href="{{ request()->fullUrlWithQuery(['status' => '']) }}" 
                   class="px-3 py-1 rounded-full text-sm {{ !request('status') ? 'bg-blue-100 text-blue-800' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Todas ({{ $requests->total() }})
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" 
                   class="px-3 py-1 rounded-full text-sm {{ request('status') == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Pendientes ({{ $requests->where('status', 'pending')->count() }})
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'accepted']) }}" 
                   class="px-3 py-1 rounded-full text-sm {{ request('status') == 'accepted' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Aceptadas ({{ $requests->where('status', 'accepted')->count() }})
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'rejected']) }}" 
                   class="px-3 py-1 rounded-full text-sm {{ request('status') == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Rechazadas ({{ $requests->where('status', 'rejected')->count() }})
                </a>
            </div>
        </div>

        <!-- Lista de Solicitudes -->
        @if($requests->count() > 0)
            <div class="space-y-4">
                @foreach($requests as $solicitud)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition duration-300">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <!-- Información según el rol -->
                                @if(auth()->user()->role === 'actor')
                                    <!-- Vista para Actor -->
                                    <div class="flex items-center space-x-4 mb-3">
                                        @if($solicitud->client->actorProfile && $solicitud->client->actorProfile->photo)
                                            <img src="{{ asset('storage/' . $solicitud->client->actorProfile->photo) }}" 
                                                 alt="{{ $solicitud->client->name }}" 
                                                 class="w-12 h-12 rounded-full object-cover">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="font-semibold text-lg">{{ $solicitud->client->name }}</h3>
                                            <p class="text-gray-600 text-sm">{{ $solicitud->client->email }}</p>
                                        </div>
                                    </div>
                                @else
                                    <!-- Vista para Cliente -->
                                    <div class="flex items-center space-x-4 mb-3">
                                        @if($solicitud->actor->actorProfile && $solicitud->actor->actorProfile->photo)
                                            <img src="{{ asset('storage/' . $solicitud->actor->actorProfile->photo) }}" 
                                                 alt="{{ $solicitud->actor->name }}" 
                                                 class="w-12 h-12 rounded-full object-cover">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="font-semibold text-lg">
                                                <a href="{{ route('actors.show', $solicitud->actor->actorProfile) }}" 
                                                   class="hover:text-blue-600">
                                                    {{ $solicitud->actor->name }}
                                                </a>
                                            </h3>
                                            <p class="text-gray-600 text-sm capitalize">
                                                {{ $solicitud->actor->actorProfile->gender }} • 
                                                {{ str_replace('_', ' ', $solicitud->actor->actorProfile->voice_age) }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                <!-- Asunto y Mensaje COMPLETO (sin toggle) -->
                                <div class="mb-4">
                                    <h4 class="font-semibold text-gray-800 mb-2">{{ $solicitud->subject }}</h4>
                                    <div class="bg-gray-50 rounded p-3 mt-2">
                                        <p class="text-gray-700 whitespace-pre-wrap">{{ $solicitud->message }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado y Acciones -->
                            <div class="text-right ml-4">
                                <!-- Badge de Estado -->
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium mb-3
                                    {{ $solicitud->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $solicitud->status == 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $solicitud->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    @if($solicitud->status == 'pending') Pendiente
                                    @elseif($solicitud->status == 'accepted') Aceptada
                                    @elseif($solicitud->status == 'rejected') Rechazada
                                    @endif
                                </span>

                                <!-- Fecha -->
                                <p class="text-sm text-gray-500 mb-3">
                                    {{ $solicitud->created_at->format('d/m/Y H:i') }}
                                </p>

                                <!-- Acciones -->
                                @if(auth()->user()->role === 'actor' && $solicitud->status == 'pending')
                                    <div class="space-y-2">
                                        <form action="{{ route('requests.updateStatus', [$solicitud, 'accepted']) }}" 
                                              method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                                Aceptar
                                            </button>
                                        </form>
                                        <form action="{{ route('requests.updateStatus', [$solicitud, 'rejected']) }}" 
                                              method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                                Rechazar
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                @if(auth()->user()->role === 'client' && $solicitud->status == 'pending')
                                    <form action="{{ route('requests.destroy', $solicitud) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700"
                                                onclick="return confirm('¿Estás seguro de que quieres eliminar esta solicitud?')">
                                            Eliminar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- Información de Contacto (solo para solicitudes aceptadas) -->
                        @if($solicitud->status == 'accepted')
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mt-4">
                                <h4 class="font-semibold text-green-800 mb-2">¡Solicitud Aceptada!</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    @if(auth()->user()->role === 'client')
                                        <div>
                                            <span class="font-semibold">Contacta al actor:</span>
                                            <p class="mt-1">{{ $solicitud->actor->email }}</p>
                                        </div>
                                        <div>
                                            <span class="font-semibold">Nombre:</span>
                                            <p class="mt-1">{{ $solicitud->actor->name }}</p>
                                        </div>
                                    @else
                                        <div>
                                            <span class="font-semibold">Contacta al cliente:</span>
                                            <p class="mt-1">{{ $solicitud->client->email }}</p>
                                        </div>
                                        <div>
                                            <span class="font-semibold">Nombre:</span>
                                            <p class="mt-1">{{ $solicitud->client->name }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-6">
                {{ $requests->links() }}
            </div>
        @else
            <!-- Estado vacío -->
            <div class="text-center py-12">
                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-500 mb-2">
                    @if(auth()->user()->role === 'actor')
                        No has recibido solicitudes
                    @else
                        No has enviado solicitudes
                    @endif
                </h3>
                <p class="text-gray-400 mb-6">
                    @if(auth()->user()->role === 'actor')
                        Cuando los clientes te contacten, aparecerán aquí tus solicitudes.
                    @else
                        Encuentra actores y envíales solicitudes de colaboración.
                    @endif
                </p>
                @if(auth()->user()->role === 'client')
                    <a href="{{ route('actors.index') }}" 
                       class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Explorar Actores
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection