

<?php $__env->startSection('title', 'Editar Perfil de Actor - Dubivo'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Editar Perfil de Actor</h1>
    </div>

    
    <?php if(session('success') && str_contains(session('success'), 'Completa tu información adicional')): ?>
    <div class="bg-azul-profundo bg-opacity-10 p-4 mb-6 border border-azul-profundo border-opacity-20">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-star text-azul-profundo text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-azul-profundo">¡Bienvenido a Dubivo!</h3>
                <div class="mt-2 text-sm text-azul-profundo">
                    <p>Completa tu perfil profesional para que los clientes puedan encontrarte.</p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Formulario Principal -->
        <div class="lg:w-3/4">
            <div class="bg-white shadow-md p-6 border border-gray-200">
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Actualiza tu información</h2>
                    <p class="text-gray-600 mt-2">Mantén tu perfil actualizado para más oportunidades</p>
                </div>

                <form action="<?php echo e(route('actors.update', $actor)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <!-- Información Básica -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Géneros -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Géneros que puedes interpretar <span class="text-rojo-intenso">*</span>
                            </label>
                            <div class="filter-scroll-container">
                                <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $currentGenders = is_array(old('genders', $actor->genders ?? [])) 
                                        ? old('genders', $actor->genders ?? []) 
                                        : (is_string($actor->genders ?? '') ? explode(',', $actor->genders) : []);
                                    $isChecked = in_array($gender, $currentGenders);
                                ?>
                                <label class="flex items-center py-1">
                                    <input type="checkbox" name="genders[]" value="<?php echo e($gender); ?>" 
                                           <?php echo e($isChecked ? 'checked' : ''); ?>

                                           class="text-rosa-electrico focus:ring-rosa-electrico">
                                    <span class="ml-2 text-sm text-gray-700"><?php echo e($gender); ?></span>
                                </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php $__errorArgs = ['genders'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-rojo-intenso text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Edades Vocales -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Edades vocales que puedes interpretar <span class="text-rojo-intenso">*</span>
                            </label>
                            <div class="filter-scroll-container">
                                <?php $__currentLoopData = $voiceAges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $age): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $currentVoiceAges = is_array(old('voice_ages', $actor->voice_ages ?? [])) 
                                        ? old('voice_ages', $actor->voice_ages ?? []) 
                                        : (is_string($actor->voice_ages ?? '') ? explode(',', $actor->voice_ages) : []);
                                    $isChecked = in_array($age, $currentVoiceAges);
                                ?>
                                <label class="flex items-center py-1">
                                    <input type="checkbox" name="voice_ages[]" value="<?php echo e($age); ?>" 
                                           <?php echo e($isChecked ? 'checked' : ''); ?>

                                           class="text-naranja-vibrante focus:ring-naranja-vibrante">
                                    <span class="ml-2 text-sm text-gray-700"><?php echo e($age); ?></span>
                                </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php $__errorArgs = ['voice_ages'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-rojo-intenso text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Disponibilidad -->
                    <div>
                        <h3 class="font-medium text-gray-700 mb-3">Disponibilidad</h3>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="is_available" value="1"
                                    <?php echo e(old('is_available', $actor->is_available) ? 'checked' : ''); ?>

                                    class="text-verde-menta focus:ring-verde-menta">
                                <span class="ml-2 text-sm text-gray-700">Disponible</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="is_available" value="0"
                                    <?php echo e(!old('is_available', $actor->is_available) ? 'checked' : ''); ?>

                                    class="text-rojo-intenso focus:ring-rojo-intenso">
                                <span class="ml-2 text-sm text-gray-700">No disponible</span>
                            </label>
                        </div>
                        <?php $__errorArgs = ['is_available'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-rojo-intenso text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Biografía -->
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                            Biografía
                        </label>
                        <textarea name="bio" id="bio" rows="4"
                                  class="w-full border border-gray-300 px-3 py-2 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200"
                                  placeholder="Cuéntanos sobre tu experiencia, formación y especialidades..."><?php echo e(old('bio', $actor->bio)); ?></textarea>
                        <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-rojo-intenso text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Archivos Actuales -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Foto Actual -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Foto de Perfil Actual
                            </label>
                            <?php if($actor->photo): ?>
                                <div class="flex items-center space-x-4">
                                    <img src="<?php echo e(asset('storage/' . $actor->photo)); ?>" 
                                         alt="Foto actual" 
                                         class="w-16 h-16 object-cover border-2 border-ambar">
                                    <span class="text-sm text-gray-600">Foto actual</span>
                                </div>
                            <?php else: ?>
                                <p class="text-sm text-gray-500">No hay foto de perfil</p>
                            <?php endif; ?>
                        </div>

                        <!-- Audio Actual -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Muestra de Voz Actual
                            </label>
                            <?php if($actor->audio_path): ?>
                                <div class="flex items-center space-x-4">
                                    <i class="fas fa-volume-up text-azul-profundo text-xl"></i>
                                    <audio controls class="h-8">
                                        <source src="<?php echo e(asset('storage/' . $actor->audio_path)); ?>" type="audio/mpeg">
                                    </audio>
                                </div>
                            <?php else: ?>
                                <p class="text-sm text-gray-500">No hay muestra de voz</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Nuevos Archivos -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nueva Foto -->
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Cambiar Foto de Perfil
                            </label>
                            <input type="file" name="photo" id="photo" 
                                   accept="image/*"
                                   class="w-full border border-gray-300 px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico transition duration-200">
                            <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener la actual</p>
                            <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-rojo-intenso text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Nuevo Audio -->
                        <div>
                            <label for="audio_path" class="block text-sm font-medium text-gray-700 mb-2">
                                Cambiar Muestra de Voz
                            </label>
                            <input type="file" name="audio_path" id="audio_path" 
                                   accept="audio/*"
                                   class="w-full border border-gray-300 px-3 py-2 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200">
                            <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener la actual</p>
                            <?php $__errorArgs = ['audio_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-rojo-intenso text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Escuelas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Escuelas</label>
                        <div class="filter-scroll-container">
                            <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $actorSchoolIds = $actor->schools->pluck('id')->toArray();
                                    $isChecked = in_array($school->id, old('schools', $actorSchoolIds));
                                ?>
                                <label class="flex items-center py-1">
                                    <input type="checkbox" name="schools[]" value="<?php echo e($school->id); ?>" 
                                           class="text-azul-profundo focus:ring-azul-profundo"
                                           <?php echo e($isChecked ? 'checked' : ''); ?>>
                                    <span class="ml-2 text-sm text-gray-700"><?php echo e($school->name); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php $__errorArgs = ['schools'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-rojo-intenso text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="<?php echo e(route('actors.show', $actor)); ?>" 
                           class="bg-gray-500 text-white px-6 py-2 hover:bg-gray-600 flex items-center font-semibold transition duration-200">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </a>
                        <button type="submit" 
                                class="bg-verde-menta text-white px-6 py-2 hover:bg-verde-menta hover:bg-opacity-90 flex items-center font-semibold transition duration-200">
                            <i class="fas fa-save mr-2"></i>Actualizar Perfil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Columna de Información Lateral -->
        <div class="lg:w-1/4">
            <div class="bg-white p-6 shadow-md sticky top-4 border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Estado del perfil</h2>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Visibilidad:</span>
                        <span class="text-sm font-medium <?php echo e($actor->is_available ? 'text-verde-menta' : 'text-rojo-intenso'); ?>">
                            <?php echo e($actor->is_available ? 'Público' : 'No disponible'); ?>

                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Última actualización:</span>
                        <span class="text-sm text-gray-500"><?php echo e($actor->updated_at->diffForHumans()); ?></span>
                    </div>
                </div>

                <!-- Consejos para mejorar -->
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="font-medium text-gray-700 mb-2">Consejos para mejorar</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <?php if(!$actor->photo): ?>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-camera text-rosa-electrico"></i>
                            <span>Añade una foto profesional</span>
                        </div>
                        <?php endif; ?>
                        <?php if(!$actor->audio_path): ?>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-volume-up text-azul-profundo"></i>
                            <span>Sube una muestra de voz</span>
                        </div>
                        <?php endif; ?>
                        <?php if(!$actor->bio): ?>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-file-alt text-ambar"></i>
                            <span>Completa tu biografía</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.object-cover {
    object-fit: cover;
    object-position: center top;
}

* {
    border-radius: 0 !important;
}

.filter-scroll-container {
    max-height: 10rem;
    overflow-y: auto;
    padding: 8px 12px;
    margin: 0 -12px;
    border: 1px solid #e5e7eb;
    background-color: #f9fafb;
}

.filter-scroll-container label {
    padding: 6px 4px;
    margin: 2px 0;
    border-radius: 0 !important;
}

.filter-scroll-container input[type="checkbox"]:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

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

.bg-verde-menta {
    background-color: #10b981 !important;
}

.bg-rojo-intenso {
    background-color: #ef4444 !important;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/actors/edit.blade.php ENDPATH**/ ?>