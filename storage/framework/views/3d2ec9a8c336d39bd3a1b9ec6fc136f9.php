<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dubivo - Plataforma de Actores de Voz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            border-radius: 0 !important;
        }

        /* Estilos vintage color-block */
        .vintage-border {
            border: 6px solid #000;
            box-shadow: 15px 15px 0px rgba(0, 0, 0, 0.3);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .vintage-border:hover {
            transform: translate(-4px, -4px);
            box-shadow: 20px 20px 0px rgba(0, 0, 0, 0.3);
        }

        .color-block-1 {
            background-color: #FF7DB5;
        }

        .color-block-2 {
            background-color: #FC7925;
        }

        .color-block-3 {
            background-color: #FFB700;
        }

        .color-block-4 {
            background-color: #3B82F6;
        }

        .color-block-5 {
            background-color: #8B5CF6;
        }

        .color-block-6 {
            background-color: #02AC66;
        }

        .vintage-text {
            font-family: 'Arial', sans-serif;
            font-weight: 700;
            text-shadow: 3px 3px 0px rgba(0, 0, 0, 0.2);
            letter-spacing: 2px;
        }

        .retro-btn {
            background: #FF7DB5;
            border: 4px solid #000;
            box-shadow: 8px 8px 0px #000;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .retro-btn:hover {
            transform: translate(-2px, -2px);
            box-shadow: 10px 10px 0px #000;
        }

        .retro-btn-secondary {
            background: #3B82F6;
            border: 4px solid #000;
            box-shadow: 8px 8px 0px #000;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .retro-btn-secondary:hover {
            transform: translate(-2px, -2px);
            box-shadow: 10px 10px 0px #000;
        }

        .geometric-pattern {
            background-color: #FAEDD9;
            background-image:
                linear-gradient(45deg, #FF7DB5 25%, transparent 25%),
                linear-gradient(-45deg, #FF7DB5 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #FF7DB5 75%),
                linear-gradient(-45deg, transparent 75%, #FF7DB5 75%);
            background-size: 60px 60px;
            background-position: 0 0, 0 30px, 30px -30px, -30px 0px;
            opacity: 0.1;
        }

        .vintage-film-grain {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.08'/%3E%3C/svg%3E");
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }

        .stagger-1 {
            animation-delay: 0.1s;
        }

        .stagger-2 {
            animation-delay: 0.2s;
        }

        .stagger-3 {
            animation-delay: 0.3s;
        }
    </style>
</head>

<body class="bg-crema vintage-film-grain min-h-screen overflow-x-hidden">
    <!-- Fondo con bloques de color geométricos - SOLO LOS CUADRITOS COLORIDOS -->
    <div class="fixed inset-0 pointer-events-none">
        <!-- Bloques de color vintage -->
        <div class="absolute top-0 left-0 w-1/3 h-1/4 color-block-1 opacity-85"></div>
        <div class="absolute top-10 right-0 w-1/4 h-1/3 color-block-2 opacity-90"></div>
        <div class="absolute bottom-0 left-1/4 w-1/5 h-2/5 color-block-3 opacity-80"></div>
        <div class="absolute bottom-1/4 right-1/3 w-1/6 h-1/2 color-block-4 opacity-85"></div>
        <div class="absolute top-1/3 left-1/2 w-1/4 h-1/4 color-block-5 opacity-75"></div>
        <div class="absolute top-2/3 right-1/4 w-1/5 h-1/3 color-block-6 opacity-80"></div>

        <!-- Patrón geométrico superpuesto -->
        <div class="absolute inset-0 geometric-pattern"></div>
    </div>

    <!-- Contenido principal -->
    <div class="relative z-10 min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-4xl w-full">
            <!-- Header principal -->
            <div class="text-center mb-16 opacity-0 animate-slide-in">
                <h1 class="vintage-text text-7xl md:text-8xl font-bold mb-6 text-black leading-none">
                    DUBIVO
                </h1>
                <div class="w-48 h-2 bg-black mx-auto mb-8"></div>
                <p class="text-2xl md:text-3xl font-semibold text-black uppercase tracking-wider">
                    Banco de Voces
                </p>
            </div>

            <!-- Tarjetas de características CLICKABLES - BIEN ALINEADAS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
                <!-- Tarjeta 1 - Actores -->
                <a href="<?php echo e(route('actors.index')); ?>" class="block group">
                    <div class="bg-white vintage-border p-6 opacity-0 animate-slide-in stagger-1 h-full flex flex-col">
                        <div class="color-block-1 w-16 h-16 flex items-center justify-center mb-6 border-4 border-black">
                            <i class="fas fa-microphone text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-black mb-4 text-black uppercase">Actores</h3>
                        <p class="text-gray-800 mb-6 leading-relaxed flex-grow">
                            Descubre talentos únicos del doblaje español. Voces auténticas para proyectos extraordinarios.
                        </p>
                        <div class="w-full h-1 bg-black mb-3"></div>
                        <p class="text-sm text-black font-semibold group-hover:text-rosa-electrico transition-colors">
                            Haz clic para explorar →
                        </p>
                    </div>
                </a>

                <!-- Tarjeta 2 - Escuelas -->
                <a href="<?php echo e(route('schools.index')); ?>" class="block group">
                    <div class="bg-white vintage-border p-6 opacity-0 animate-slide-in stagger-2 h-full flex flex-col">
                        <div class="color-block-4 w-16 h-16 flex items-center justify-center mb-6 border-4 border-black">
                            <i class="fas fa-school text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-black mb-4 text-black uppercase">Escuelas</h3>
                        <p class="text-gray-800 mb-6 leading-relaxed flex-grow">
                            Las mejores academias de doblaje. Formación de calidad para las voces del futuro.
                        </p>
                        <div class="w-full h-1 bg-black mb-3"></div>
                        <p class="text-sm text-black font-semibold group-hover:text-azul-profundo transition-colors">
                            Haz clic para explorar →
                        </p>
                    </div>
                </a>

                <!-- Tarjeta 3 - Obras -->
                <a href="<?php echo e(route('works.index')); ?>" class="block group">
                    <div class="bg-white vintage-border p-6 opacity-0 animate-slide-in stagger-3 h-full flex flex-col">
                        <div class="color-block-6 w-16 h-16 flex items-center justify-center mb-6 border-4 border-black">
                            <i class="fas fa-film text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-black mb-4 text-black uppercase">Obras</h3>
                        <p class="text-gray-800 mb-6 leading-relaxed flex-grow">
                            Proyectos destacados y trabajos de referencia en el mundo del doblaje profesional.
                        </p>
                        <div class="w-full h-1 bg-black mb-3"></div>
                        <p class="text-sm text-black font-semibold group-hover:text-verde-menta transition-colors">
                            Haz clic para explorar →
                        </p>
                    </div>
                </a>
            </div>

            <!-- Botones de registro y login -->
            <div class="text-center space-y-6 md:space-y-0 md:space-x-8 md:flex md:justify-center mb-12">
                <!-- Botón Registrarse -->
                <button onclick="openRegisterModal()"
                    class="retro-btn px-12 py-4 text-xl font-black text-white uppercase tracking-wider inline-block opacity-0 animate-slide-in stagger-1">
                    Registrarse
                </button>

                <!-- Botón Iniciar Sesión -->
                <a href="<?php echo e(route('login')); ?>"
                    class="retro-btn-secondary px-12 py-4 text-xl font-black text-white uppercase tracking-wider inline-block opacity-0 animate-slide-in stagger-2">
                    Iniciar Sesión
                </a>
            </div>

            <!-- Footer -->
            <div class="text-center mt-16 pt-8 border-t-4 border-black opacity-0 animate-slide-in stagger-3">
                <p class="text-black text-sm font-medium">
                    Conectando voces desde la era analógica hasta la digital
                </p>
            </div>
        </div>
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
                <a href="<?php echo e(route('register.actor')); ?>" 
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
                <a href="<?php echo e(route('register.client')); ?>" 
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
                    <a href="<?php echo e(route('login')); ?>" class="text-azul-profundo hover:text-azul-profundo hover:bg-opacity-90 font-medium">
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
    console.log('Abriendo modal...');
    document.getElementById('registerModal').classList.remove('hidden');
}

function closeRegisterModal() {
    console.log('Cerrando modal...');
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

        document.addEventListener('DOMContentLoaded', function() {
            // Título aparece inmediatamente
            const title = document.querySelector('.vintage-text');
            title.style.animation = 'none';
            title.style.opacity = '1';

            // Animaciones más rápidas
            const animatedElements = document.querySelectorAll('.animate-slide-in');
            animatedElements.forEach((el, index) => {
                el.style.animationDelay = (index * 0.1) + 's';
            });
        });
    </script>
</body>

</html><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/welcome.blade.php ENDPATH**/ ?>