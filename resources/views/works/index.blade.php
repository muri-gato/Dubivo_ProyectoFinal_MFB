@extends('layouts.app')

@section('title', 'Obras y Producciones - Dubivo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Obras y Producciones</h1>
        @auth
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.works.create') }}"
            class="bg-verde-menta text-white px-6 py-3 hover:bg-verde-menta hover:bg-opacity-90 transition duration-200 flex items-center font-semibold">
            <i class="fas fa-plus mr-2"></i>Nueva Obra
        </a>
        @endif
        @endauth
    </div>

    <!-- Descripción -->
    <p class="text-gray-600 mb-8 max-w-3xl text-lg">
        Explora nuestro catálogo de películas, series, videojuegos y otras producciones con talento de doblaje español.
    </p>

    <!-- Botón para mostrar/ocultar filtros en móvil -->
    <div class="lg:hidden mb-4">
        <button id="filterToggle" class="bg-azul-profundo text-white px-4 py-2 hover:bg-azul-profundo hover:bg-opacity-90 transition duration-200 flex items-center font-semibold w-full justify-center">
            <i class="fas fa-filter mr-2"></i>
            Mostrar Filtros
        </button>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Columna de Filtros - Desplegable -->
        <div id="filterColumn" class="lg:w-1/4 hidden lg:block">
            <div class="bg-white p-6 shadow-md sticky top-4 border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Filtros</h2>
                    <button id="closeFilters" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <!-- Buscador en Tiempo Real -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Obra</label>
                    <div class="relative">
                        <input type="text"
                            id="searchWork"
                            placeholder="Ej: Película, serie..."
                            class="w-full border border-gray-300 px-4 py-2 pl-10 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Busca por título en tiempo real</p>
                </div>

                <!-- Filtro por Tipo -->
                <div class="mb-6">
                    <h3 class="font-medium text-gray-700 mb-3">Tipo</h3>
                    <div class="filter-scroll-container">
                        @foreach($types as $key => $label)
                        <label class="flex items-center py-1">
                            <input type="checkbox" name="types[]" value="{{ $key }}"
                                class="text-rosa-electrico focus:ring-rosa-electrico type-filter">
                            <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Filtro por Año -->
                <div class="mb-6">
                    <h3 class="font-medium text-gray-700 mb-3">Año mínimo</h3>
                    <input type="number"
                        id="yearFilter"
                        min="1900"
                        max="{{ date('Y') }}"
                        placeholder="Ej: 2000"
                        class="w-full border border-gray-300 px-3 py-2 focus:border-naranja-vibrante focus:ring-naranja-vibrante transition duration-200">
                </div>

                <!-- Filtro por Número de Actores -->
                <div class="mb-6">
                    <h3 class="font-medium text-gray-700 mb-3">Mínimo de actores</h3>
                    <select id="actorsCountFilter" class="w-full border border-gray-300 px-3 py-2 focus:border-verde-menta focus:ring-verde-menta">
                        <option value="">Cualquier cantidad</option>
                        <option value="1">1+ actores</option>
                        <option value="5">5+ actores</option>
                        <option value="10">10+ actores</option>
                        <option value="20">20+ actores</option>
                    </select>
                </div>

                <!-- Botón Limpiar Filtros -->
                <div>
                    <button id="clearFilters" class="bg-gray-500 text-white px-4 py-2 hover:bg-gray-600 w-full inline-flex items-center justify-center font-semibold transition duration-200">
                        <i class="fas fa-times mr-2"></i>Limpiar Filtros
                    </button>
                </div>
            </div>
        </div>

        <!-- Columna de Resultados -->
        <div class="lg:w-3/4">
            <!-- Contador de resultados -->
            <div class="mb-4">
                <p class="text-sm text-gray-600">
                    <span id="resultsCount">{{ $works->count() }}</span> obras encontradas
                </p>
            </div>

            <!-- Lista de Obras -->
<div id="worksContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
    @foreach($works as $work)
    <div class="work-card bg-white shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-200 hover:border-morado-vibrante hover:scale-105 transform group cursor-pointer flex flex-col h-full"
        data-title="{{ strtolower($work->title) }}"
        data-type="{{ $work->type }}"
        data-year="{{ $work->year ?? '' }}"
        data-actors-count="{{ $work->actors_count }}">

        <!-- Poster -->
        <div class="relative">
            @if($work->poster)
            <img src="{{ asset('storage/' . $work->poster) }}"
                alt="{{ $work->title }}"
                class="w-full h-48 object-cover">
            @else
            <div class="w-full h-48 bg-gradient-to-br from-morado-vibrante to-rosa-electrico flex items-center justify-center group-hover:from-rosa-electrico group-hover:to-morado-vibrante transition duration-300">
                @php
                $icon = match($work->type) {
                'movie' => 'film',
                'series' => 'tv',
                'commercial' => 'ad',
                'animation' => 'drawing',
                'videogame' => 'gamepad',
                'documentary' => 'document',
                default => 'film'
                };
                @endphp
                <i class="fas fa-{{ $icon }} text-white text-4xl"></i>
            </div>
            @endif

            <!-- Badge de tipo -->
            <div class="absolute top-3 right-3">
                <span class="bg-azul-profundo bg-opacity-90 text-white text-xs px-2 py-1 capitalize font-medium work-type">
                    {{ $types[$work->type] ?? $work->type }}
                </span>
            </div>
        </div> <!-- Cierre del div relative -->

        <!-- Contenido -->
        <a href="{{ route('works.show', $work) }}" class="block p-4 flex flex-col flex-1">
            <div class="flex justify-between items-start mb-3">
                <h3 class="font-semibold text-lg leading-tight text-gray-800 group-hover:text-morado-vibrante transition duration-300 work-title flex-1 mr-2">
                    {{ $work->title }}
                </h3>
            </div>

            <div class="space-y-2 mb-4 flex-shrink-0">
                @if($work->year)
                <div class="flex items-center text-gray-600">
                    <i class="fas fa-calendar mr-2 text-naranja-vibrante w-4 flex-shrink-0"></i>
                    <span class="text-sm work-year">{{ $work->year }}</span>
                </div>
                @endif

                <div class="flex items-center text-gray-600">
                    <i class="fas fa-users mr-2 text-verde-menta w-4 flex-shrink-0"></i>
                    <span class="text-sm work-actors-count">{{ $work->actors_count }} actores</span>
                </div>
            </div>

            @if($work->description)
            <div class="flex-1 min-h-[60px] mb-4">
                <p class="text-gray-700 text-sm line-clamp-2 leading-relaxed work-description">
                    {{ $work->description }}
                </p>
            </div>
            @else
            <div class="flex-1 min-h-[60px]"></div>
            @endif
        </a>
    </div> <!-- Cierre del div work-card -->
    @endforeach
</div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Remover bordes redondeados */
        * {
            border-radius: 0 !important;
        }

        /* CONTENEDOR DE FILTROS CORREGIDO - SIN CORTAR BORDES */
        .filter-scroll-container {
            max-height: 10rem;
            overflow-y: auto;
            padding: 8px 12px;
            /* Más padding para que no se corten los bordes */
            margin: 0 -12px;
            /* Compensa el padding extra */
            border: 1px solid #e5e7eb;
            /* Borde suave para definir el área */
            background-color: #f9fafb;
            /* Fondo ligeramente diferente */
        }

        /* Espaciado entre items de filtro */
        .filter-scroll-container label {
            padding: 6px 4px;
            /* Espacio interno para cada item */
            margin: 2px 0;
            /* Espacio entre items */
            border-radius: 0 !important;
            /* Asegurar bordes cuadrados */
        }

        /* Mejorar el focus de los checkboxes */
        .filter-scroll-container input[type="checkbox"]:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        /* Personalizar scrollbar */
        .filter-scroll-container::-webkit-scrollbar {
            width: 6px;
        }

        .filter-scroll-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .filter-scroll-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 0;
        }

        .filter-scroll-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Scroll para lista de tipos */
        .max-h-40 {
            max-height: 10rem;
        }

        /* Mejorar la experiencia móvil */
        @media (max-width: 1023px) {
            #filterColumn {
                position: fixed;
                top: 0;
                left: 0;
                width: 80%;
                max-width: 300px;
                height: 100vh;
                z-index: 50;
                overflow-y: auto;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            #filterColumn:not(.hidden) {
                transform: translateX(0);
            }
        }
    </style>
    @endsection