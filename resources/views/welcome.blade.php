<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Voces - Encuentra el talento vocal perfecto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Hero Section -->
    <header class="bg-blue-600 text-white">
        <div class="container mx-auto px-4 py-16">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-6">Banco de Voces</h1>
                <p class="text-xl mb-8 max-w-2xl mx-auto">
                    La plataforma líder para conectar actores de voz con oportunidades profesionales en doblaje, publicidad y producción audiovisual.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('actors.index') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                        Explorar Actores
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-blue-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-400 transition duration-300">
                            Mi Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-blue-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-400 transition duration-300">
                            Registrarse
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">¿Por qué elegir nuestro banco de voces?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-microphone text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Talento Verificado</h3>
                    <p class="text-gray-600">Actores profesionales con formación en las mejores escuelas de doblaje.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Búsqueda Avanzada</h3>
                    <p class="text-gray-600">Filtra por género, edad vocal, escuela y experiencia para encontrar la voz perfecta.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-handshake text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Conexión Directa</h3>
                    <p class="text-gray-600">Contacta directamente con los actores y gestiona tus proyectos fácilmente.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-2" id="actors-count">0</div>
                    <div class="text-gray-600">Actores Registrados</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-green-600 mb-2" id="schools-count">0</div>
                    <div class="text-gray-600">Escuelas Asociadas</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-purple-600 mb-2" id="works-count">0</div>
                    <div class="text-gray-600">Obras Registradas</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-orange-600 mb-2" id="projects-count">0</div>
                    <div class="text-gray-600">Proyectos Realizados</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-blue-700 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">¿Eres actor de voz o buscas talento?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Únete a nuestra comunidad y descubre nuevas oportunidades en el mundo del doblaje y la locución.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('register') }}?role=actor" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Soy Actor
                </a>
                <a href="{{ route('register') }}?role=client" class="bg-blue-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-400 transition duration-300">
                    Busco Talentos
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Banco de Voces</h3>
                    <p class="text-gray-400">
                        Conectando talento vocal con oportunidades profesionales desde 2024.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Enlaces Rápidos</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('actors.index') }}" class="text-gray-400 hover:text-white">Actores</a></li>
                        <li><a href="{{ route('schools.index') }}" class="text-gray-400 hover:text-white">Escuelas</a></li>
                        <li><a href="{{ route('works.index') }}" class="text-gray-400 hover:text-white">Obras</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Contacto</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-envelope mr-2"></i>info@bancodevoces.com</li>
                        <li><i class="fas fa-phone mr-2"></i>+34 912 345 678</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Banco de Voces. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // Animación simple para los contadores
        function animateCount(element, finalValue, duration = 2000) {
            let start = 0;
            const increment = finalValue / (duration / 16);
            const timer = setInterval(() => {
                start += increment;
                if (start >= finalValue) {
                    element.textContent = finalValue;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(start);
                }
            }, 16);
        }

        // Simular datos (en un proyecto real, estos vendrían de la base de datos)
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                animateCount(document.getElementById('actors-count'), 150);
                animateCount(document.getElementById('schools-count'), 25);
                animateCount(document.getElementById('works-count'), 300);
                animateCount(document.getElementById('projects-count'), 500);
            }, 500);
        });
    </script>
</body>
</html>