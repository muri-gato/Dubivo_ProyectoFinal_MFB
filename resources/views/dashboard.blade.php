@extends('layouts.app')

@section('title', 'Inicio - Banco de Voces')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-negro mb-4">Banco de Voces</h1>
        <p class="text-xl text-gris-azulado max-w-2xl mx-auto">
            Encuentra los mejores talentos del doblaje español para tus proyectos
        </p>
    </div>

    <!-- Carrusel de Actores Destacados -->
    @if($featuredActors->count() > 0)
    <div class="mb-20">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-negro">Actores Destacados</h2>
            <a href="{{ route('actors.index') }}" class="text-rosa-electrico hover:text-naranja-vibrante font-semibold transition-colors duration-300">
                Ver todos los actores →
            </a>
        </div>

        <div class="relative max-w-6xl mx-auto h-[700px]">
            <!-- Contenedor del Carrusel -->
            <div class="relative h-full">
                @foreach($featuredActors as $index => $actor)
                @php
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
                    } elseif ($index == 5) {
                        $classes .= 'z-0 scale-70 translate-x-96 opacity-40';
                    } else {
                        $classes .= 'z-0 scale-60 opacity-20';
                    }
                @endphp
                
                <div class="{{ $classes }}" data-index="{{ $index }}">
                    
                    <!-- Tarjeta del Actor -->
                    <a href="{{ route('actors.show', $actor) }}" 
                       class="block bg-white rounded-2xl shadow-2xl overflow-hidden h-[600px] w-80 mx-auto transform transition-all duration-300 hover:scale-105 hover:shadow-3xl cursor-pointer group">
                        
                        <!-- Imagen del Actor -->
                        <div class="relative h-[500px] overflow-hidden">
                            @if($actor->photo)
                                <img src="{{ asset('storage/' . $actor->photo) }}" 
                                     alt="{{ $actor->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-rosa-electrico to-naranja-vibrante flex items-center justify-center">
                                    <i class="fas fa-user text-white text-7xl"></i>
                                </div>
                            @endif
                            
                            <!-- Badge de disponibilidad -->
                            <div class="absolute top-5 right-5">
                                @if($actor->is_available)
                                    <span class="bg-ambar text-negro px-4 py-2 rounded-full text-sm font-semibold shadow-xl">
                                        <i class="fas fa-check mr-1"></i>Disponible
                                    </span>
                                @else
                                    <span class="bg-rojo-intenso text-white px-4 py-2 rounded-full text-sm font-semibold shadow-xl">
                                        <i class="fas fa-times mr-1"></i>No disponible
                                    </span>
                                @endif
                            </div>

                            <!-- Overlay con nombre -->
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-negro/90 via-negro/50 to-transparent p-8">
                                <h3 class="text-white font-bold text-3xl mb-3">{{ $actor->name }}</h3>
                                <div class="flex space-x-4 text-white text-base">
                                    <span class="flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                                        <i class="fas fa-user mr-2"></i>
                                        {{ $actor->genders_array[0] ?? 'N/A' }}
                                    </span>
                                    <span class="flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                                        <i class="fas fa-microphone mr-2"></i>
                                        {{ $actor->voice_ages_array[0] ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Efecto hover overlay -->
                            <div class="absolute inset-0 bg-rosa-electrico opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        </div>

                        <!-- Información del Actor -->
                        <div class="p-6 h-[100px] flex items-center justify-between bg-gradient-to-r from-crema to-blanco-crema">
                            <!-- Estadísticas -->
                            <div class="flex space-x-6">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-naranja-vibrante">{{ $actor->works->count() }}</div>
                                    <div class="text-xs text-gris-azulado font-medium mt-1">PROY.</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-ambar">{{ $actor->schools->count() }}</div>
                                    <div class="text-xs text-gris-azulado font-medium mt-1">ESC.</div>
                                </div>
                            </div>

                            <!-- Indicador de click -->
                            <div class="text-rosa-electrico group-hover:text-naranja-vibrante transition-colors duration-300">
                                <i class="fas fa-external-link-alt text-xl"></i>
                            </div>
                        </div>

                        <!-- Efecto de borde al hover -->
                        <div class="absolute inset-0 border-2 border-transparent group-hover:border-ambar rounded-2xl transition-all duration-300 pointer-events-none"></div>
                    </a>
                </div>
                @endforeach
            </div>

            <!-- Flechas de navegación -->
            <button class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white shadow-2xl text-gris-azulado p-5 rounded-full hover:bg-rosa-electrico hover:text-white transition duration-300 carousel-prev -left-16 z-40">
                <i class="fas fa-chevron-left text-2xl"></i>
            </button>
            <button class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white shadow-2xl text-gris-azulado p-5 rounded-full hover:bg-rosa-electrico hover:text-white transition duration-300 carousel-next -right-16 z-40">
                <i class="fas fa-chevron-right text-2xl"></i>
            </button>
        </div>

        <!-- Indicadores -->
        <div class="flex justify-center mt-16 space-x-3">
            @foreach($featuredActors as $index => $actor)
            <button class="w-3 h-3 rounded-full bg-crema hover:bg-rosa-electrico transition duration-200 carousel-indicator {{ $index === 0 ? 'bg-rosa-electrico' : '' }}" data-index="{{ $index }}"></button>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Sección de Acciones Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition duration-300 border border-crema">
            <div class="bg-rosa-electrico/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-microphone text-rosa-electrico text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-negro mb-3">Explora Actores</h3>
            <p class="text-gris-azulado mb-4">Encuentra el talento vocal perfecto para tu proyecto</p>
            <a href="{{ route('actors.index') }}" class="bg-rosa-electrico text-white px-6 py-2 rounded hover:bg-naranja-vibrante inline-block transition-colors duration-300">
                Ver Actores
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition duration-300 border border-crema">
            <div class="bg-ambar/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-school text-ambar text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-negro mb-3">Descubre Escuelas</h3>
            <p class="text-gris-azulado mb-4">Conoce las mejores escuelas de doblaje de España</p>
            <a href="{{ route('schools.index') }}" class="bg-ambar text-negro px-6 py-2 rounded hover:bg-amarillo-dorado inline-block transition-colors duration-300">
                Ver Escuelas
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition duration-300 border border-crema">
            <div class="bg-naranja-vibrante/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-film text-naranja-vibrante text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-negro mb-3">Explora Obras</h3>
            <p class="text-gris-azulado mb-4">Descubre películas, series y proyectos destacados</p>
            <a href="{{ route('works.index') }}" class="bg-naranja-vibrante text-white px-6 py-2 rounded hover:bg-rojo-intenso inline-block transition-colors duration-300">
                Ver Obras
            </a>
        </div>
    </div>

    <!-- Información para usuarios no autenticados -->
    @guest
    <div class="bg-crema border border-ambar/30 rounded-lg p-8 text-center">
        <h3 class="text-2xl font-semibold text-negro mb-4">¿Eres actor o cliente?</h3>
        <p class="text-gris-azulado mb-6 max-w-2xl mx-auto">
            Únete a nuestra plataforma para conectar con los mejores talentos del doblaje o mostrar tu trabajo
        </p>
        <div class="flex justify-center space-x-4">
            <a href="{{ route('register') }}" class="bg-rosa-electrico text-white px-8 py-3 rounded-lg hover:bg-naranja-vibrante font-semibold transition-colors duration-300">
                Registrarse
            </a>
            <a href="{{ route('login') }}" class="bg-white text-rosa-electrico border border-rosa-electrico px-8 py-3 rounded-lg hover:bg-rosa-electrico/10 font-semibold transition-colors duration-300">
                Iniciar Sesión
            </a>
        </div>
    </div>
    @endguest
</div>

<style>
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    #actorsCarousel {
        scroll-behavior: smooth;
        scroll-snap-type: x mandatory;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.carousel-slide');
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');
    const indicators = document.querySelectorAll('.carousel-indicator');
    
    let currentIndex = 0;
    const totalSlides = {{ $featuredActors->count() }};

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
            indicator.classList.toggle('bg-rosa-electrico', index === currentIndex);
            indicator.classList.toggle('bg-crema', index !== currentIndex);
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
});
</script>
@endsection