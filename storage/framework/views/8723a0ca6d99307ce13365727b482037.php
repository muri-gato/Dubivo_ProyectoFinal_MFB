<?php $__env->startSection('title', 'Inicio - Dubivo'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <!-- Información para usuarios no autenticados -->
    <?php if(auth()->guard()->check()): ?>
    <!-- Contenido para usuarios autenticados -->
    <div class="text-center py-12">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">
            ¡Bienvenido, <?php echo e($user->name); ?>!
        </h3>
        <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
            <?php if($user->role == 'actor'): ?>
            Gestiona tu perfil y encuentra nuevas oportunidades
            <?php elseif($user->role == 'client'): ?>
            Encuentra el talento perfecto para tu próximo proyecto
            <?php endif; ?>
        </p>
    </div>
    <?php else: ?>
    <!-- Contenido para usuarios NO autenticados -->
    <div class="text-center py-12 bg-gradient-to-r from-azul-profundo to-morado-vibrante bg-opacity-5 border border-azul-profundo border-opacity-10">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">¿Eres actor o cliente?</h3>
        <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
            Únete a nuestra plataforma para conectar con los mejores talentos del doblaje o mostrar tu trabajo
        </p>
        <div class="flex justify-center space-x-4">
            <button onclick="openRegisterModal()" class="bg-rosa-electrico hover:bg-rosa-electrico hover:bg-opacity-90 text-white px-8 py-3 font-semibold transition duration-200">
                Registrarse
            </button>
            <a href="<?php echo e(route('login')); ?>" class="bg-white text-azul-profundo border border-azul-profundo px-8 py-3 hover:bg-azul-profundo hover:bg-opacity-10 font-semibold transition duration-200">
                Iniciar Sesión
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Carrusel de Actores Destacados -->
    <?php if($featuredActors->count() > 0): ?>
    <div class="mb-20">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Actores Destacados</h2>
            <a href="<?php echo e(route('actors.index')); ?>" class="text-azul-profundo hover:text-azul-profundo hover:bg-opacity-90 font-semibold transition duration-200">
                Ver todos los actores →
            </a>
        </div>

        <div class="relative max-w-6xl mx-auto h-[700px]">
            <!-- Contenedor del Carrusel -->
            <div class="relative h-full">
                <?php $__currentLoopData = $featuredActors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $actor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $classes = 'absolute inset-0 transition-all duration-500 ease-in-out transform carousel-slide ';

                if ($index == 0) {
                $classes .= 'z-30 scale-100 translate-x-0 opacity-100';
                } elseif ($index == 1) {
                $classes .= 'z-20 scale-90 translate-x-40 opacity-80';
                } elseif ($index == 2) {
                $classes .= 'z-20 scale-90 -translate-x-40 opacity-80';
                } elseif ($index == 3) {
                $classes .= 'z-10 scale-80 translate-x-72 opacity-60';
                } elseif ($index == 4) {
                $classes .= 'z-10 scale-80 -translate-x-72 opacity-60';
                } else {
                $classes .= 'z-0 scale-60 opacity-20';
                }
                ?>

                <div class="<?php echo e($classes); ?>" data-index="<?php echo e($index); ?>">

                    <!-- Tarjeta del Actor -->
                    <a href="<?php echo e(route('actors.show', $actor)); ?>" 
   class="block bg-white shadow-md overflow-hidden h-[600px] w-80 mx-auto transform transition-all duration-300 hover:shadow-xl cursor-pointer group border border-gray-200 hover:border-naranja-vibrante hover:scale-105 relative">
    
    <!-- Imagen del Actor que ocupa TODO el espacio -->
    <div class="absolute inset-0 overflow-hidden">
        <?php if($actor->photo): ?>
            <img src="<?php echo e(asset('storage/' . $actor->photo)); ?>"
                        alt="<?php echo e($actor->name); ?>"
                        class="w-full h-full object-cover">
                        <?php else: ?>
                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center group-hover:from-gray-200 group-hover:to-gray-400 transition duration-300">
                            <i class="fas fa-user text-gray-500 text-8xl"></i>
                        </div>
                        <?php endif; ?>
                </div>

                <!-- Badge de disponibilidad -->
                <div class="absolute top-5 right-5 z-10">
                    <?php if($actor->is_available): ?>
                    <span class="bg-verde-menta bg-opacity-90 text-white px-4 py-2 text-sm font-semibold">
                        <i class="fas fa-check mr-1"></i>Disponible
                    </span>
                    <?php else: ?>
                    <span class="bg-rojo-intenso bg-opacity-90 text-white px-4 py-2 text-sm font-semibold">
                        <i class="fas fa-times mr-1"></i>No disponible
                    </span>
                    <?php endif; ?>
                </div>

                <!-- Overlay con nombre y detalles (AHORA MÁS ABAJO) -->
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/95 via-black/70 to-transparent p-6 pt-16">
                    <h3 class="text-white font-bold text-3xl mb-3"><?php echo e($actor->name); ?></h3>
                    <div class="flex flex-wrap gap-3 text-white text-base">
                        <span class="flex items-center bg-white/30 backdrop-blur-sm px-4 py-2">
                            <i class="fas fa-user mr-2"></i>
                            <?php echo e($actor->genders_array[0] ?? 'N/A'); ?>

                        </span>
                        <span class="flex items-center bg-white/30 backdrop-blur-sm px-4 py-2">
                            <i class="fas fa-microphone mr-2"></i>
                            <?php echo e($actor->voice_ages_array[0] ?? 'N/A'); ?>

                        </span>
                    </div>
                </div>

                <!-- Efecto hover overlay suave -->
                <div class="absolute inset-0 bg-azul-profundo opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Flechas de navegación -->
        <button class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white shadow-xl text-gray-600 p-5 hover:bg-azul-profundo hover:text-white transition duration-300 carousel-prev -left-16 z-40 border border-gray-200">
            <i class="fas fa-chevron-left text-2xl"></i>
        </button>
        <button class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white shadow-xl text-gray-600 p-5 hover:bg-azul-profundo hover:text-white transition duration-300 carousel-next -right-16 z-40 border border-gray-200">
            <i class="fas fa-chevron-right text-2xl"></i>
        </button>
    </div>

    <!-- Indicadores -->
    <div class="flex justify-center mt-16 space-x-3">
        <?php $__currentLoopData = $featuredActors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $actor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <button class="w-3 h-3 bg-gray-300 hover:bg-azul-profundo transition duration-200 carousel-indicator <?php echo e($index === 0 ? 'bg-azul-profundo' : ''); ?>" data-index="<?php echo e($index); ?>"></button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>

<!-- Sección de Acciones Rápidas -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <div class="bg-white shadow-md p-6 text-center hover:shadow-lg transition duration-300 border border-gray-200 hover:border-rosa-electrico">
        <div class="bg-rosa-electrico bg-opacity-20 w-16 h-16 flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-microphone text-rosa-electrico text-2xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-3">Explora Actores</h3>
        <p class="text-gray-600 mb-4">Encuentra el talento vocal perfecto para tu proyecto</p>
        <a href="<?php echo e(route('actors.index')); ?>" class="bg-rosa-electrico hover:bg-rosa-electrico hover:bg-opacity-90 text-white px-6 py-2 font-semibold transition duration-200 inline-block">
            Ver Actores
        </a>
    </div>

    <div class="bg-white shadow-md p-6 text-center hover:shadow-lg transition duration-300 border border-gray-200 hover:border-ambar">
        <div class="bg-ambar bg-opacity-20 w-16 h-16 flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-school text-ambar text-2xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-3">Descubre Escuelas</h3>
        <p class="text-gray-600 mb-4">Conoce las mejores escuelas de doblaje de España</p>
        <a href="<?php echo e(route('schools.index')); ?>" class="bg-ambar hover:bg-ambar hover:bg-opacity-90 text-white px-6 py-2 font-semibold transition duration-200 inline-block">
            Ver Escuelas
        </a>
    </div>

    <div class="bg-white shadow-md p-6 text-center hover:shadow-lg transition duration-300 border border-gray-200 hover:border-azul-profundo">
        <div class="bg-azul-profundo bg-opacity-20 w-16 h-16 flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-film text-azul-profundo text-2xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-3">Explora Obras</h3>
        <p class="text-gray-600 mb-4">Descubre películas, series y proyectos destacados</p>
        <a href="<?php echo e(route('works.index')); ?>" class="bg-azul-profundo hover:bg-azul-profundo hover:bg-opacity-90 text-white px-6 py-2 font-semibold transition duration-200 inline-block">
            Ver Obras
        </a>
    </div>
</div>


</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Carrusel de actores destacados
         <?php if($featuredActors->count() > 0): ?>
        const slides = document.querySelectorAll('.carousel-slide');
        const prevBtn = document.querySelector('.carousel-prev');
        const nextBtn = document.querySelector('.carousel-next');
        const indicators = document.querySelectorAll('.carousel-indicator');

        let currentIndex = 0;
        const totalSlides = <?php echo e($featuredActors->count()); ?>;

        function updateCarousel() {
            slides.forEach((slide, index) => {
                const slideIndex = (index - currentIndex + totalSlides) % totalSlides;

                // Reset todas las clases
                slide.className = 'absolute inset-0 transition-all duration-500 ease-in-out transform carousel-slide';

                // Aplicar efectos según la posición
                if (slideIndex === 0) {
                    slide.classList.add('z-30', 'scale-100', 'translate-x-0', 'opacity-100');
                } else if (slideIndex === 1) {
                    slide.classList.add('z-20', 'scale-90', 'translate-x-40', 'opacity-80');
                } else if (slideIndex === totalSlides - 1) {
                    slide.classList.add('z-20', 'scale-90', '-translate-x-40', 'opacity-80');
                } else if (slideIndex === 2) {
                    slide.classList.add('z-10', 'scale-80', 'translate-x-72', 'opacity-60');
                } else if (slideIndex === totalSlides - 2) {
                    slide.classList.add('z-10', 'scale-80', '-translate-x-72', 'opacity-60');
                } else if (slideIndex === 3) {
                    slide.classList.add('z-0', 'scale-70', 'translate-x-96', 'opacity-40');
                } else if (slideIndex === totalSlides - 3) {
                    slide.classList.add('z-0', 'scale-70', '-translate-x-96', 'opacity-40');
                } else {
                    slide.classList.add('z-0', 'scale-60', 'opacity-20');

                    if (slideIndex <= totalSlides / 2) {
                        slide.classList.add('translate-x-[120px]');
                    } else {
                        slide.classList.add('-translate-x-[120px]');
                    }
                }
            });

            // Actualizar indicadores
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('bg-azul-profundo', index === currentIndex);
                indicator.classList.toggle('bg-gray-300', index !== currentIndex);
            });
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % totalSlides;
            updateCarousel();
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
            updateCarousel();
        }

        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', prevSlide);
            nextBtn.addEventListener('click', nextSlide);

            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    currentIndex = index;
                    updateCarousel();
                });
            });

            // Auto-scroll cada 5 segundos
            setInterval(nextSlide, 5000);

            // Inicializar
            updateCarousel();
        }
        <?php endif; ?>
    });
</script>

<style>
    * {
        border-radius: 0 !important;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/dashboard.blade.php ENDPATH**/ ?>