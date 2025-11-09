<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Voces - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-blue-600 text-white shadow-md">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Banco de Voces</h1>
                <nav class="flex space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="hover:bg-blue-500 px-3 py-2 rounded">Dashboard</a>
                        <a href="{{ route('actors.index') }}" class="hover:bg-blue-500 px-3 py-2 rounded">Actores</a>
                        <a href="{{ route('schools.index') }}" class="hover:bg-blue-500 px-3 py-2 rounded">Escuelas</a>
                        <a href="{{ route('works.index') }}" class="hover:bg-blue-500 px-3 py-2 rounded">Obras</a>
                        
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="bg-blue-700 hover:bg-blue-600 px-3 py-2 rounded">Admin</a>
                        @endif
                        
                        @if(auth()->user()->role === 'actor' && auth()->user()->actorProfile)
                            <a href="{{ route('actors.show', auth()->user()->actorProfile) }}" class="hover:bg-blue-500 px-3 py-2 rounded">Mi Perfil</a>
                        @elseif(auth()->user()->role === 'actor')
                            <a href="{{ route('actors.create') }}" class="hover:bg-blue-500 px-3 py-2 rounded">Crear Perfil</a>
                        @endif
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="hover:bg-blue-500 px-3 py-2 rounded">Cerrar Sesión</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:bg-blue-500 px-3 py-2 rounded">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="hover:bg-blue-500 px-3 py-2 rounded">Registrarse</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Bienvenido al Banco de Voces</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                    <h3 class="text-xl font-semibold text-blue-800 mb-2">Actores de Voz</h3>
                    <p class="text-blue-600 mb-4">Encuentra el talento vocal perfecto para tu proyecto</p>
                    <a href="{{ route('actors.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Explorar Actores
                    </a>
                </div>
                
                <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                    <h3 class="text-xl font-semibold text-green-800 mb-2">Escuelas</h3>
                    <p class="text-green-600 mb-4">Descubre las mejores escuelas de doblaje</p>
                    <a href="{{ route('schools.index') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Ver Escuelas
                    </a>
                </div>
                
                <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
                    <h3 class="text-xl font-semibold text-purple-800 mb-2">Obras</h3>
                    <p class="text-purple-600 mb-4">Explora películas, series y más</p>
                    <a href="{{ route('works.index') }}" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                        Ver Obras
                    </a>
                </div>
            </div>

            @auth
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Tu Perfil</h3>
                    
                    @if(auth()->user()->role === 'actor')
                        @if(auth()->user()->actorProfile)
                            <p class="text-gray-600 mb-4">Tienes un perfil de actor activo.</p>
                            <a href="{{ route('actors.show', auth()->user()->actorProfile) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Ver Mi Perfil
                            </a>
                        @else
                            <p class="text-gray-600 mb-4">Aún no tienes un perfil de actor.</p>
                            <a href="{{ route('actors.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                Crear Perfil de Actor
                            </a>
                        @endif
                    @elseif(auth()->user()->role === 'client')
                        <p class="text-gray-600 mb-4">Eres un cliente. Puedes contactar con actores para tus proyectos.</p>
                        <a href="{{ route('actors.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Buscar Actores
                        </a>
                    @elseif(auth()->user()->role === 'admin')
                        <p class="text-gray-600 mb-4">Eres administrador. Tienes acceso al panel de control.</p>
                        <a href="{{ route('admin.dashboard') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                            Panel de Admin
                        </a>
                    @endif
                </div>
            @else
                <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200">
                    <h3 class="text-xl font-semibold text-yellow-800 mb-4">Únete a nuestra comunidad</h3>
                    <p class="text-yellow-600 mb-4">Regístrate como actor o cliente para acceder a todas las funcionalidades.</p>
                    <div class="flex space-x-4">
                        <a href="{{ route('register') }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                            Registrarse
                        </a>
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Iniciar Sesión
                        </a>
                    </div>
                </div>
            @endauth
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-6">
            <p class="text-center">&copy; 2024 Banco de Voces. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>