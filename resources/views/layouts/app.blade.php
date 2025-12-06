<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dubivo')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-negro text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo a la izquierda -->
                <a href="{{ Auth::check() ? route('dashboard') : url('/') }}"
                    class="text-2xl font-bold text-rosa-electrico hover:text-ambar transition-colors duration-300">
                    Dubivo
                </a>

                <!-- Menú de navegación CENTRADO -->
                <nav class="flex space-x-6 items-center absolute left-1/2 transform -translate-x-1/2">
                    <a href="{{ route('actors.index') }}"
                        class="px-4 py-2 text-white hover:text-naranja-vibrante transition-all duration-300 relative group font-semibold">
                        Actores
                        <span class="absolute bottom-1 left-3 right-3 h-1 bg-naranja-vibrante transform scale-x-0 transition-transform duration-300 group-hover:scale-x-100 rounded-full"></span>
                    </a>
                    <a href="{{ route('schools.index') }}"
                        class="px-4 py-2 text-white hover:text-ambar transition-all duration-300 relative group font-semibold">
                        Escuelas
                        <span class="absolute bottom-1 left-3 right-3 h-1 bg-ambar transform scale-x-0 transition-transform duration-300 group-hover:scale-x-100 rounded-full"></span>
                    </a>
                    <a href="{{ route('works.index') }}"
                        class="px-4 py-2 text-white hover:text-rosa-electrico transition-all duration-300 relative group font-semibold">
                        Obras
                        <span class="absolute bottom-1 left-3 right-3 h-1 bg-rosa-electrico transform scale-x-0 transition-transform duration-300 group-hover:scale-x-100 rounded-full"></span>
                    </a>
                </nav>

                <!-- Menú de usuario a la DERECHA -->
                <nav class="flex items-center">
                    @auth
                    <!-- Menú desplegable único -->
                    <div class="relative">
                        <button id="user-menu-button" class="bg-rosa-electrico hover:bg-naranja-vibrante text-white px-4 py-2 flex items-center text-sm font-semibold transition-colors duration-300">
                            {{ auth()->user()->name }}
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white shadow-xl py-2 hidden z-50 border border-gray-200">
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-cog mr-2"></i>Panel de Administración
                            </a>
                            @endif
                            @if(auth()->user()->role !== 'admin')
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                            @endif
                            @if(auth()->user()->role === 'actor')
                            @if(auth()->user()->actorProfile)
                            <a href="{{ route('actors.show', auth()->user()->actorProfile) }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-user mr-2"></i>Mi Perfil
                            </a>
                            @else
                            <a href="{{ route('actors.create') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 text-sm font-medium transition-colors duration-200">
                                <i class="fas fa-plus-circle mr-2"></i>Crear Perfil
                            </a>
                            @endif
                            @endif
                            <div class="border-t border-gray-200 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 text-sm font-medium transition-colors duration-200">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="text-white hover:text-ambar px-3 py-2 text-sm font-semibold transition-colors duration-300">
                        Iniciar Sesión
                    </a>
                    <button onclick="openRegisterModal()"
                        class="bg-ambar hover:bg-amarillo-dorado text-negro px-4 py-2 text-sm font-bold transition-colors duration-300">
                        Registrarse
                    </button>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-negro text-white mt-12">
        <div class="container mx-auto px-4 py-6">
            <p class="text-center text-ambar">&copy; 2025 Dubivo. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Modal de Selección de Registro -->
    <div id="registerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg bg-white border-gray-200">
            <div class="mt-3 text-center">
                <!-- Icono -->
                <div class="mx-auto flex items-center justify-center h-12 w-12 bg-rosa-electrico bg-opacity-20 mb-4">
                    <i class="fas fa-user-plus text-rosa-electrico text-xl"></i>
                </div>

                <h3 class="text-lg leading-6 font-bold text-gray-900 mb-2">
                    Crear Cuenta
                </h3>

                <p class="text-sm text-gray-500 mb-6">
                    Selecciona el tipo de perfil que deseas crear
                </p>

                <!-- Botones de opción -->
                <div class="grid grid-cols-1 gap-4 mb-6">
                    <!-- Botón Actor -->
                    <a href="{{ route('register.actor') }}"
                        class="flex items-center justify-between p-4 border border-gray-200 hover:border-rosa-electrico hover:bg-rosa-electrico hover:bg-opacity-5 transition duration-200 group">
                        <div class="flex items-center">
                            <div class="bg-rosa-electrico bg-opacity-20 w-10 h-10 flex items-center justify-center mr-3 group-hover:bg-rosa-electrico group-hover:bg-opacity-30 transition duration-200">
                                <i class="fas fa-microphone text-rosa-electrico text-lg"></i>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold text-gray-800 group-hover:text-rosa-electrico">Actor/Actriz</div>
                                <div class="text-xs text-gray-500">Talento vocal</div>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-rosa-electrico"></i>
                    </a>

                    <!-- Botón Cliente -->
                    <a href="{{ route('register.client') }}"
                        class="flex items-center justify-between p-4 border border-gray-200 hover:border-ambar hover:bg-ambar hover:bg-opacity-5 transition duration-200 group">
                        <div class="flex items-center">
                            <div class="bg-ambar bg-opacity-20 w-10 h-10 flex items-center justify-center mr-3 group-hover:bg-ambar group-hover:bg-opacity-30 transition duration-200">
                                <i class="fas fa-search text-ambar text-lg"></i>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold text-gray-800 group-hover:text-ambar">Cliente</div>
                                <div class="text-xs text-gray-500">Buscar talento</div>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-ambar"></i>
                    </a>
                </div>

                <!-- Enlace a login -->
                <div class="border-t border-gray-200 pt-4">
                    <p class="text-sm text-gray-600">
                        ¿Ya tienes cuenta?
                        <a href="{{ route('login') }}" class="text-azul-profundo hover:text-azul-profundo hover:bg-opacity-90 font-medium">
                            Inicia sesión
                        </a>
                    </p>
                </div>

                <!-- Botón cerrar -->
                <div class="mt-4">
                    <button onclick="closeRegisterModal()"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 text-sm font-medium transition duration-200">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Funciones para el modal
        function openRegisterModal() {
            document.getElementById('registerModal').classList.remove('hidden');
        }

        function closeRegisterModal() {
            document.getElementById('registerModal').classList.add('hidden');
        }

        // Cerrar modal al hacer click fuera
        document.getElementById('registerModal').addEventListener('click', function(e) {
            if (e.target.id === 'registerModal') {
                closeRegisterModal();
            }
        });

        // Cerrar con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeRegisterModal();
            }
        });

        // Script para el dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownButton = document.getElementById('user-menu-button');
            const dropdownMenu = document.getElementById('user-menu');

            if (dropdownButton && dropdownMenu) {
                dropdownButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                });

                // Cerrar dropdown al hacer click fuera
                document.addEventListener('click', function() {
                    dropdownMenu.classList.add('hidden');
                });

                // Prevenir que el menú se cierre al hacer click en él
                dropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>