

<?php $__env->startSection('title', 'Crear Nuevo Actor - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md p-6">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-4 mb-6">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 mr-4">
                    <i class="fas fa-user-plus text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Crear Nuevo Actor</h1>
                    <p class="text-gray-600 mt-1">Crear nuevo usuario y perfil de actor</p>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form action="<?php echo e(route('admin.actors.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>

            <!-- Información del Usuario -->
            <div class="bg-gray-50 p-4 border border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Información del Usuario</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nombre -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" required
                            value="<?php echo e(old('name')); ?>"
                            class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" required
                            value="<?php echo e(old('email')); ?>"
                            class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" id="password" required
                            class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmar Contraseña <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Información del Actor -->
            <div class="bg-gray-50 p-4 border border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Información del Actor</h3>

                <!-- Información Básica -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Géneros -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Géneros que puede interpretar <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center p-3 border border-gray-300 hover:bg-gray-50 cursor-pointer transition duration-150">
                                <input type="checkbox" name="genders[]" value="<?php echo e($gender); ?>"
                                    <?php echo e(in_array($gender, old('genders', [])) ? 'checked' : ''); ?>

                                    class="border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-3 text-sm font-medium text-gray-700"><?php echo e($gender); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php $__errorArgs = ['genders'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Edades Vocales -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Edades vocales que puede interpretar <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            <?php $__currentLoopData = $voiceAges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $age): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center p-3 border border-gray-300 hover:bg-gray-50 cursor-pointer transition duration-150">
                                <input type="checkbox" name="voice_ages[]" value="<?php echo e($age); ?>"
                                    <?php echo e(in_array($age, old('voice_ages', [])) ? 'checked' : ''); ?>

                                    class="border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-3 text-sm font-medium text-gray-700"><?php echo e($age); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php $__errorArgs = ['voice_ages'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Disponibilidad -->
                <div class="mb-6">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="hidden" name="is_available" value="0">
                        <input type="checkbox" name="is_available" value="1"
                            class="border-gray-300 text-blue-600 focus:ring-blue-500"
                            <?php echo e(old('is_available', 1) ? 'checked' : ''); ?>>
                        <span class="text-sm font-medium text-gray-700">Disponible para nuevos proyectos</span>
                    </label>
                    <?php $__errorArgs = ['is_available'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Biografía -->
                <div class="mb-6">
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                        Biografía
                    </label>
                    <textarea name="bio" id="bio" rows="4"
                        class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Describe la experiencia, formación y especialidades del actor..."><?php echo e(old('bio')); ?></textarea>
                    <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Archivos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Foto -->
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                            Foto de Perfil
                        </label>
                        <input type="file" name="photo" id="photo"
                            accept="image/*"
                            class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF. Máx: 2MB</p>
                        <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Audio -->
                    <div>
                        <label for="audio_path" class="block text-sm font-medium text-gray-700 mb-2">
                            Muestra de Voz
                        </label>
                        <input type="file" name="audio_path" id="audio_path"
                            accept="audio/*"
                            class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Formatos: MP3, WAV. Máx: 5MB</p>
                        <?php $__errorArgs = ['audio_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Escuelas -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Formación Académica
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-48 overflow-y-auto border border-gray-200 p-4">
                        <?php $__empty_1 = true; $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" name="schools[]" value="<?php echo e($school->id); ?>"
                                class="border-gray-300 text-blue-600 focus:ring-blue-500"
                                <?php echo e(in_array($school->id, old('schools', [])) ? 'checked' : ''); ?>>
                            <span class="text-sm text-gray-700">
                                <?php echo e($school->name); ?>

                                <?php if($school->city): ?>
                                <span class="text-gray-500">(<?php echo e($school->city); ?>)</span>
                                <?php endif; ?>
                            </span>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-500 text-sm col-span-2">No hay escuelas registradas</p>
                        <?php endif; ?>
                    </div>
                    <?php $__errorArgs = ['schools'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Profesor -->
                <div class="bg-yellow-50 p-6 mb-6 border border-yellow-200">
                    <h2 class="text-xl font-semibold mb-4">Información como Profesor</h2>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Escuelas donde enseña</label>
                        <div class="space-y-3">
                            <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-3 border border-yellow-200 bg-white">
                                <label class="flex items-center">
                                    <input type="checkbox" name="teaching_schools[]" value="<?php echo e($school->id); ?>"
                                        <?php echo e(in_array($school->id, old('teaching_schools', [])) ? 'checked' : ''); ?>

                                        class="text-yellow-600 focus:ring-yellow-500 teaching-school-checkbox">
                                    <span class="ml-2 text-sm text-gray-700"><?php echo e($school->name); ?></span>
                                </label>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <!-- Obras -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Trabajos Destacados
                    </label>
                    <div class="space-y-3 max-h-48 overflow-y-auto border border-gray-200 p-4">
                        <?php $__empty_1 = true; $__currentLoopData = $works; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $work): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" name="works[]" value="<?php echo e($work->id); ?>"
                                class="mt-1 border-gray-300 text-blue-600 focus:ring-blue-500"
                                <?php echo e(in_array($work->id, old('works', [])) ? 'checked' : ''); ?>>
                            <div class="flex-1">
                                <span class="text-sm font-medium text-gray-700"><?php echo e($work->title); ?></span>
                                <div class="text-xs text-gray-500">
                                    <span class="capitalize"><?php echo e($work->type); ?></span>
                                    <?php if($work->year): ?>
                                    · <?php echo e($work->year); ?>

                                    <?php endif; ?>
                                </div>
                                <input type="text" name="character_names[<?php echo e($work->id); ?>]"
                                    placeholder="Personaje que interpretó"
                                    class="mt-1 w-full text-xs border border-gray-300 px-2 py-1"
                                    value="<?php echo e(old('character_names.' . $work->id)); ?>">
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-500 text-sm">No hay obras registradas</p>
                        <?php endif; ?>
                    </div>
                    <?php $__errorArgs = ['works'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="<?php echo e(route('admin.actors')); ?>"
                    class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 transition duration-200 font-medium">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Crear Actor y Usuario
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/admin/actors/create.blade.php ENDPATH**/ ?>