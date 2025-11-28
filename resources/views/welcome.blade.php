<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dubivo - Encuentra el talento vocal perfecto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'rosa-electrico': '#FF7DB5',
                        'rojo-intenso': '#F21F07', 
                        'naranja-vibrante': '#FC7925',
                        'ambar': '#FFB700',
                        'amarillo-dorado': '#FFDD00',
                        'crema': '#FAEDD9',
                        'negro': '#000000',
                        'blanco-crema': '#FFF8F2',
                        'gris-azulado': '#787F8F',
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-blanco-crema">
    <!-- Hero Section -->
    <header class="bg-negro text-white">
        <div class="container mx-auto px-4 py-16">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-6 text-rosa-electrico">Dubivo</h1>
                <p class="text-xl mb-8 max-w-2xl mx-auto text-crema">
                    La plataforma líder para conectar actores de voz con oportunidades profesionales en doblaje, publicidad y producción audiovisual.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('actors.index') }}" class="bg-rosa-electrico text-white px-8 py-3 rounded-lg font-semibold hover:bg-naranja-vibrante transition duration-300">
                        Explorar Actores
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-ambar text-negro px-8 py-3 rounded-lg font-semibold hover:bg-amarillo-dorado transition duration-300">
                            Mi Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-ambar text-negro px-8 py-3 rounded-lg font-semibold hover:bg-amarillo-dorado transition duration-300">
                            Registrarse
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- CTA Section -->
    <section class="py-16 bg-crema">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-8 text-negro">Únete a nuestra comunidad</h2>
            <p class="text-gris-azulado mb-12 max-w-2xl mx-auto">
                Forma parte del banco de voces más completo de España. 
                Elige cómo quieres participar en nuestra plataforma.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Tarjeta Actor -->
                <div class="bg-white rounded-lg shadow-md p-8 border-2 border-rosa-electrico/30 hover:border-rosa-electrico transition duration-300">
                    <div class="bg-rosa-electrico/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-microphone text-rosa-electrico text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-rosa-electrico">Actor/Actriz de Doblaje</h3>
                    <p class="text-gris-azulado mb-6">
                        Muestra tu talento, crea tu perfil profesional y recibe ofertas de trabajo.
                    </p>
                    <ul class="text-sm text-gris-azulado mb-6 space-y-2 text-left">
                        <li><i class="fas fa-check text-ambar mr-2"></i>Perfil profesional visible</li>
                        <li><i class="fas fa-check text-ambar mr-2"></i>Recibe solicitudes de clientes</li>
                        <li><i class="fas fa-check text-ambar mr-2"></i>Conecta con escuelas</li>
                        <li><i class="fas fa-check text-ambar mr-2"></i>Muestra tu portfolio</li>
                    </ul>
                    <a href="{{ route('register.actor') }}" 
                       class="bg-rosa-electrico text-white px-6 py-3 rounded-lg hover:bg-naranja-vibrante transition duration-200 font-medium block">
                        Registrarse como Actor
                    </a>
                </div>

                <!-- Tarjeta Cliente -->
                <div class="bg-white rounded-lg shadow-md p-8 border-2 border-ambar/30 hover:border-ambar transition duration-300">
                    <div class="bg-ambar/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-ambar text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-ambar">Cliente</h3>
                    <p class="text-gris-azulado mb-6">
                        Encuentra las voces perfectas para tus proyectos de doblaje.
                    </p>
                    <ul class="text-sm text-gris-azulado mb-6 space-y-2 text-left">
                        <li><i class="fas fa-check text-ambar mr-2"></i>Acceso a Dubivo</li>
                        <li><i class="fas fa-check text-ambar mr-2"></i>Búsqueda avanzada</li>
                        <li><i class="fas fa-check text-ambar mr-2"></i>Contacta directamente</li>
                        <li><i class="fas fa-check text-ambar mr-2"></i>Gestiona solicitudes</li>
                    </ul>
                    <a href="{{ route('register.client') }}" 
                       class="bg-ambar text-negro px-6 py-3 rounded-lg hover:bg-amarillo-dorado transition duration-200 font-medium block">
                        Registrarse como Cliente
                    </a>
                </div>
            </div>
            
            <p class="text-gris-azulado mt-8">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-rosa-electrico hover:text-naranja-vibrante">Inicia sesión</a>
            </p>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-negro">¿Por qué elegir Dubivo?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-rosa-electrico/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-microphone text-rosa-electrico text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-negro">Talento Verificado</h3>
                    <p class="text-gris-azulado">Actores profesionales con formación en las mejores escuelas de doblaje.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-ambar/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-ambar text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-negro">Búsqueda Avanzada</h3>
                    <p class="text-gris-azulado">Filtra por género, edad vocal, escuela y experiencia para encontrar la voz perfecta.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-naranja-vibrante/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-handshake text-naranja-vibrante text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-negro">Conexión Directa</h3>
                    <p class="text-gris-azulado">Contacta directamente con los actores y gestiona tus proyectos fácilmente.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-crema">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-rosa-electrico mb-2" id="actors-count">0</div>
                    <div class="text-gris-azulado">Actores Registrados</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-ambar mb-2" id="schools-count">0</div>
                    <div class="text-gris-azulado">Escuelas Asociadas</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-naranja-vibrante mb-2" id="works-count">0</div>
                    <div class="text-gris-azulado">Obras Registradas</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-rojo-intenso mb-2" id="projects-count">0</div>
                    <div class="text-gris-azulado">Proyectos Realizados</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-negro text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 text-rosa-electrico">Dubivo</h3>
                    <p class="text-crema">
                        Conectando talento vocal con oportunidades profesionales desde 2025.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 text-ambar">Enlaces Rápidos</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('actors.index') }}" class="text-crema hover:text-ambar">Actores</a></li>
                        <li><a href="{{ route('schools.index') }}" class="text-crema hover:text-ambar">Escuelas</a></li>
                        <li><a href="{{ route('works.index') }}" class="text-crema hover:text-ambar">Obras</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 text-ambar">Contacto</h4>
                    <ul class="space-y-2 text-crema">
                        <li><i class="fas fa-envelope mr-2"></i>info@dubivo.com</li>
                        <li><i class="fas fa-phone mr-2"></i>+34 912 345 678</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-ambar/30 mt-8 pt-8 text-center text-crema">
                <p>&copy; 2025 Dubivo. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
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