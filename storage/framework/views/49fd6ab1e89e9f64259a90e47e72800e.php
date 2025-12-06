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
        <div id="filterColumn" class="lg:w-1/4 w-full lg:sticky lg:top-20 h-fit lg:block bg-white p-6 shadow-xl border border-gray-100 rounded-xl z-10">
            <div class="lg:hidden flex justify-end mb-4">
                <button id="closeFilters" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <form action="<?php echo e(route('works.index')); ?>" method="GET">

                <div class="mb-6">
                    <label for="search" class="block text-lg font-semibold mb-2">Buscar Obra</label>
                    <input type="text" name="search" id="search" placeholder="Título de la obra..."
                        value="<?php echo e(request('search')); ?>"
                        class="w-full border border-gray-300 p-2 rounded-lg focus:ring-verde-menta focus:border-verde-menta transition duration-150">
                </div>

                <div class="mb-6">
                    <label for="year" class="block text-lg font-semibold mb-2">Año de Producción</label>
                    <input type="number" name="year" id="year" placeholder="Ej: 2024"
                        value="<?php echo e(request('year')); ?>"
                        min="1900" max="<?php echo e(date('Y') + 1); ?>"
                        class="w-full border border-gray-300 p-2 rounded-lg focus:ring-verde-menta focus:border-verde-menta transition duration-150">
                </div>

                <div class="mb-6">
                    <h3 class="font-semibold text-lg mb-2">Tipo de Producción</h3>
                    <div class="space-y-2">
                        <?php $selectedTypes = request('types', []); ?>
                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="types[]" value="<?php echo e($key); ?>"
                                <?php echo e(in_array($key, $selectedTypes) ? 'checked' : ''); ?>

                                class="h-4 w-4 text-rosa-electrico border-gray-300 rounded focus:ring-rosa-electrico">
                            <span><?php echo e($label); ?></span>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="flex flex-col space-y-3 mt-8">
                    <button type="submit"
                        class="bg-verde-menta text-negro px-4 py-2 font-bold rounded-lg 
                       shadow-lg hover:bg-verde-menta/80 transition duration-300">
                        <i class="fas fa-search mr-2"></i>
                        Aplicar Filtros
                    </button>
                    <a href="<?php echo e(route('works.index')); ?>"
                        class="text-center bg-negro text-white px-4 py-2 font-semibold rounded-lg 
                       shadow-lg hover:bg-gray-700 transition duration-300">
                        <i class="fas fa-undo-alt mr-2"></i>
                        Limpiar Filtros
                    </a>
                </div>

            </form>
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

        /* CONTENEDOR DE FILTROS */
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
                /* Inicialmente lo movemos FUERA de la pantalla */
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            /* Cuando añadimos 'is-active', se desliza hacia la pantalla */
            #filterColumn.is-active {
                transform: translateX(0);
            }
        }
    </style>
    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterToggle = document.getElementById('filterToggle');
            const filterColumn = document.getElementById('filterColumn');
            const closeFilters = document.getElementById('closeFilters');

            // Función para abrir el menú (al pulsar 'Mostrar Filtros')
            if (filterToggle) {
                filterToggle.addEventListener('click', function() {
                    // Añadimos la clase 'is-active' para deslizar el menú
                    filterColumn.classList.add('is-active');
                });
            }

            // Función para cerrar el menú (al pulsar la X)
            if (closeFilters) {
                closeFilters.addEventListener('click', function() {
                    // Quitamos la clase 'is-active' para que se deslice fuera
                    filterColumn.classList.remove('is-active');
                });
            }
        });
    </script>
    <?php $__env->stopPush(); ?>


    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/works/index.blade.php ENDPATH**/ ?>