<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Dubivo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full bg-white shadow-md p-6 border border-gray-200">
        <!-- Logo -->
        <div class="text-center mb-6">
            <div class="text-3xl font-bold text-rosa-electrico inline-block">
                DUBIVO
            </div>
            <p class="text-gray-600 mt-2">Iniciar Sesión</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2 font-medium" for="email">Email</label>
                <input id="email" class="w-full border border-gray-300 px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico"
                    type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2 font-medium" for="password">Contraseña</label>
                <input id="password" class="w-full border border-gray-300 px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico"
                    type="password" name="password" required autocomplete="current-password">
                @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Recordarme y Olvidé contraseña en la misma línea -->
            <div class="flex items-center justify-between mb-6">
                <!-- Recordarme -->
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="text-rosa-electrico focus:ring-rosa-electrico" name="remember">
                    <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                </label>

                <!-- Olvidé contraseña -->
                @if (Route::has('password.request'))
                <a class="text-azul-profundo hover:text-azul-profundo hover:bg-opacity-90 text-sm" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
                @endif
            </div>

            <!-- Botón Iniciar Sesión a la DERECHA -->
            <div class="flex justify-end mb-4">
                <button type="submit" class="bg-rosa-electrico hover:bg-rosa-electrico hover:bg-opacity-90 text-white px-8 py-2 font-semibold">
                    Iniciar Sesión
                </button>
            </div>

            <!-- Línea separadora -->
            <div class="border-t border-gray-200 pt-4 text-center">
                <p class="text-gray-600 text-sm">
                    ¿No tienes cuenta?
                    <a href="javascript:void(0)" onclick="openRegisterModal()" class="text-ambar hover:text-ambar hover:bg-opacity-90 font-medium">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </form>
    </div>

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
            console.log('Abriendo modal de registro');
            document.getElementById('registerModal').classList.remove('hidden');
        }

        function closeRegisterModal() {
            console.log('Cerrando modal de registro');
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

        // Prevenir que el enlace "Regístrate aquí" envíe el formulario
        document.addEventListener('DOMContentLoaded', function() {
            const registerLink = document.querySelector('a[onclick="openRegisterModal()"]');
            if (registerLink) {
                registerLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    openRegisterModal();
                });
            }
        });
    </script>
</body>

</html>