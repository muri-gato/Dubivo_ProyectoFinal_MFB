

<?php $__env->startSection('title', 'Escuelas de Doblaje - Dubivo'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Escuelas de Doblaje</h1>
        <?php if(auth()->guard()->check()): ?>
        <?php if(auth()->user()->role === 'admin'): ?>
        <a href="<?php echo e(route('admin.schools.create')); ?>"
            class="bg-verde-menta text-white px-6 py-3 hover:bg-verde-menta hover:bg-opacity-90 transition duration-200 flex items-center font-semibold">
            <i class="fas fa-plus mr-2"></i>Nueva Escuela
        </a>
        <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Descripción -->
    <p class="text-gray-600 mb-8 max-w-3xl text-lg">
        Descubre las mejores escuelas de doblaje y formación vocal de España.
        Cada escuela cuenta con actores profesionales formados en sus aulas.
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Escuela</label>
                    <div class="relative">
                        <input type="text"
                            id="searchSchool"
                            placeholder="Ej: Escuela de doblaje..."
                            class="w-full border border-gray-300 px-4 py-2 pl-10 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Busca por nombre en tiempo real</p>
                </div>

                <!-- Filtro por Ciudad -->
                <div class="mb-6">
                    <h3 class="font-medium text-gray-700 mb-3">Ciudad</h3>
                    <div class="filter-scroll-container">
                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center py-1">
                            <input type="checkbox" name="cities[]" value="<?php echo e($city); ?>"
                                class="text-rosa-electrico focus:ring-rosa-electrico city-filter">
                            <span class="ml-2 text-sm text-gray-700"><?php echo e($city); ?></span>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Filtro por Año de Fundación -->
                <div class="mb-6">
                    <h3 class="font-medium text-gray-700 mb-3">Fundada después de</h3>
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
                        <option value="50">50+ actores</option>
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
                    <span id="resultsCount"><?php echo e($schools->count()); ?></span> escuelas encontradas
                </p>
            </div>

            <!-- Lista de Escuelas -->
            <div id="schoolsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="school-card bg-white shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-200 hover:border-ambar hover:scale-105 transform group cursor-pointer flex flex-col h-full"
                    data-name="<?php echo e(strtolower($school->name)); ?>"
                    data-city="<?php echo e(strtolower($school->city ?? '')); ?>"
                    data-year="<?php echo e($school->founded_year ?? ''); ?>"
                    data-actors-count="<?php echo e($school->actors_count); ?>">

                    <a href="<?php echo e(route('schools.show', $school)); ?>" class="block flex-1 p-6 flex flex-col">
                        <!-- Logo y Nombre -->
                        <div class="text-center mb-6 flex-shrink-0">
                            <?php if($school->logo): ?>
                            <div class="mb-3 flex justify-center">
                                <img src="<?php echo e(asset('storage/' . $school->logo)); ?>"
                                    alt="<?php echo e($school->name); ?>"
                                    class="w-20 h-20 object-cover border-2 border-ambar border-opacity-30 group-hover:border-ambar transition duration-300">
                            </div>
                            <?php else: ?>
                            <div class="mb-3 flex justify-center">
                                <div class="w-20 h-20 bg-ambar bg-opacity-10 flex items-center justify-center border-2 border-ambar border-opacity-30 group-hover:border-ambar transition duration-300">
                                    <i class="fas fa-school text-ambar text-2xl"></i>
                                </div>
                            </div>
                            <?php endif; ?>

                            <h3 class="text-xl font-semibold text-azul-profundo group-hover:text-ambar transition duration-300 line-clamp-2 min-h-[3rem] flex items-center justify-center school-name">
                                <?php echo e($school->name); ?>

                            </h3>
                        </div>

                        <!-- Información básica -->
                        <div class="space-y-3 mb-6 flex-shrink-0">
                            <?php if($school->city): ?>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt mr-3 text-rosa-electrico w-4 flex-shrink-0"></i>
                                <span class="text-sm truncate school-city"><?php echo e($school->city); ?></span>
                            </div>
                            <?php endif; ?>

                            <?php if($school->founded_year): ?>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar-alt mr-3 text-naranja-vibrante w-4 flex-shrink-0"></i>
                                <span class="text-sm school-year">Fundada en <?php echo e($school->founded_year); ?></span>
                            </div>
                            <?php endif; ?>

                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-users mr-3 text-verde-menta w-4 flex-shrink-0"></i>
                                <span class="text-sm school-actors-count"><?php echo e($school->actors_count); ?> actores formados</span>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <?php if($school->description): ?>
                        <div class="flex-1 min-h-[60px] mb-4">
                            <p class="text-gray-700 text-sm line-clamp-3 leading-relaxed h-full flex items-start school-description">
                                <?php echo e($school->description); ?>

                            </p>
                        </div>
                        <?php else: ?>
                        <div class="flex-1 min-h-[60px]"></div>
                        <?php endif; ?>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Mensaje cuando no hay resultados -->
            <div id="noResults" class="hidden text-center py-12">
                <i class="fas fa-school text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-500 mb-2">No se encontraron escuelas</h3>
                <p class="text-gray-400">Intenta con otros términos de búsqueda o ajusta los filtros.</p>
            </div>

            <!-- Paginación -->
            <div id="paginationContainer" class="mt-6">
                <?php echo e($schools->links()); ?>

            </div>
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

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
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
        margin: 0 -12px;
        border: 1px solid #e5e7eb;
        background-color: #f9fafb;
    }

    /* Espaciado entre items de filtro */
    .filter-scroll-container label {
        padding: 6px 4px;
        margin: 2px 0;
        border-radius: 0 !important;
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/schools/index.blade.php ENDPATH**/ ?>