

<?php $__env->startSection('title', 'Obras y Producciones - Dubivo'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Obras y Producciones</h1>
        <?php if(auth()->guard()->check()): ?>
        <?php if(auth()->user()->role === 'admin'): ?>
        <a href="<?php echo e(route('admin.works.create')); ?>"
            class="bg-verde-menta text-white px-6 py-3 hover:bg-verde-menta hover:bg-opacity-90 transition duration-200 flex items-center font-semibold">
            <i class="fas fa-plus mr-2"></i>Nueva Obra
        </a>
        <?php endif; ?>
        <?php endif; ?>
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
                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center py-1">
                            <input type="checkbox" name="types[]" value="<?php echo e($key); ?>"
                                class="text-rosa-electrico focus:ring-rosa-electrico type-filter">
                            <span class="ml-2 text-sm text-gray-700"><?php echo e($label); ?></span>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Filtro por Año -->
                <div class="mb-6">
                    <h3 class="font-medium text-gray-700 mb-3">Año mínimo</h3>
                    <input type="number"
                        id="yearFilter"
                        min="1900"
                        max="<?php echo e(date('Y')); ?>"
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
                    <span id="resultsCount"><?php echo e($works->count()); ?></span> obras encontradas
                </p>
            </div>

            <!-- Lista de Obras -->
<div id="worksContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
    <?php $__currentLoopData = $works; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $work): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="work-card bg-white shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-200 hover:border-morado-vibrante hover:scale-105 transform group cursor-pointer flex flex-col h-full"
        data-title="<?php echo e(strtolower($work->title)); ?>"
        data-type="<?php echo e($work->type); ?>"
        data-year="<?php echo e($work->year ?? ''); ?>"
        data-actors-count="<?php echo e($work->actors_count); ?>">

        <!-- Poster -->
        <div class="relative">
            <?php if($work->poster): ?>
            <img src="<?php echo e(asset('storage/' . $work->poster)); ?>"
                alt="<?php echo e($work->title); ?>"
                class="w-full h-48 object-cover">
            <?php else: ?>
            <div class="w-full h-48 bg-gradient-to-br from-morado-vibrante to-rosa-electrico flex items-center justify-center group-hover:from-rosa-electrico group-hover:to-morado-vibrante transition duration-300">
                <?php
                $icon = match($work->type) {
                'movie' => 'film',
                'series' => 'tv',
                'commercial' => 'ad',
                'animation' => 'drawing',
                'videogame' => 'gamepad',
                'documentary' => 'document',
                default => 'film'
                };
                ?>
                <i class="fas fa-<?php echo e($icon); ?> text-white text-4xl"></i>
            </div>
            <?php endif; ?>

            <!-- Badge de tipo -->
            <div class="absolute top-3 right-3">
                <span class="bg-azul-profundo bg-opacity-90 text-white text-xs px-2 py-1 capitalize font-medium work-type">
                    <?php echo e($types[$work->type] ?? $work->type); ?>

                </span>
            </div>
        </div> <!-- Cierre del div relative -->

        <!-- Contenido -->
        <a href="<?php echo e(route('works.show', $work)); ?>" class="block p-4 flex flex-col flex-1">
            <div class="flex justify-between items-start mb-3">
                <h3 class="font-semibold text-lg leading-tight text-gray-800 group-hover:text-morado-vibrante transition duration-300 work-title flex-1 mr-2">
                    <?php echo e($work->title); ?>

                </h3>
            </div>

            <div class="space-y-2 mb-4 flex-shrink-0">
                <?php if($work->year): ?>
                <div class="flex items-center text-gray-600">
                    <i class="fas fa-calendar mr-2 text-naranja-vibrante w-4 flex-shrink-0"></i>
                    <span class="text-sm work-year"><?php echo e($work->year); ?></span>
                </div>
                <?php endif; ?>

                <div class="flex items-center text-gray-600">
                    <i class="fas fa-users mr-2 text-verde-menta w-4 flex-shrink-0"></i>
                    <span class="text-sm work-actors-count"><?php echo e($work->actors_count); ?> actores</span>
                </div>
            </div>

            <?php if($work->description): ?>
            <div class="flex-1 min-h-[60px] mb-4">
                <p class="text-gray-700 text-sm line-clamp-2 leading-relaxed work-description">
                    <?php echo e($work->description); ?>

                </p>
            </div>
            <?php else: ?>
            <div class="flex-1 min-h-[60px]"></div>
            <?php endif; ?>
        </a>
    </div> <!-- Cierre del div work-card -->
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/works/index.blade.php ENDPATH**/ ?>