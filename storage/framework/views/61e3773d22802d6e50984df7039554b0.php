

<?php $__env->startSection('title', 'Editar ' . $actor->user->name . ' - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md p-6">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-4 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <?php if($actor->photo): ?>
                    <img src="<?php echo e(asset('storage/' . $actor->photo)); ?>"
                        alt="<?php echo e($actor->user->name); ?>"
                        class="w-16 h-16 object-cover mr-4">
                    <?php else: ?>
                    <div class="w-16 h-16 bg-gray-200 flex items-center justify-center mr-4">
                        <i class="fas fa-user text-gray-400 text-xl"></i>
                    </div>
                    <?php endif; ?>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Editar Actor</h1>
                        <p class="text-gray-600 mt-1"><?php echo e($actor->user->name); ?> (<?php echo e($actor->user->email); ?>)</p>
                    </div>
                </div>
                <div class="text-sm text-gray-500">
                    ID: <?php echo e($actor->id); ?> • Creado: <?php echo e($actor->created_at->format('d/m/Y')); ?>

                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form action="<?php echo e(route('admin.actors.update', $actor)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <input type="hidden" name="user_id" value="<?php echo e($actor->user_id); ?>">
            
            <!-- Información Básica -->
<!-- Distribución mejorada -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Columna Izquierda -->
    <div class="space-y-6">
        <!-- Géneros -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">
                Géneros que puede interpretar <span class="text-rojo-intenso">*</span>
            </label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 p-4 border border-gray-200 bg-gray-50">
                <?php
                    $currentGenders = is_array($actor->genders) ? $actor->genders : json_decode($actor->genders, true) ?? [];
                    $currentGenders = old('genders', $currentGenders);
                ?>
                <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="flex items-center p-3 border border-gray-300 hover:border-rosa-electrico bg-white cursor-pointer transition duration-150">
                    <input type="checkbox" name="genders[]" value="<?php echo e($gender); ?>"
                        <?php echo e(in_array($gender, $currentGenders) ? 'checked' : ''); ?>

                        class="border-gray-300 text-rosa-electrico focus:ring-rosa-electrico">
                    <span class="ml-3 text-sm font-medium text-gray-700"><?php echo e($gender); ?></span>
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
                Edades vocales que puede interpretar <span class="text-rojo-intenso">*</span>
            </label>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 p-4 border border-gray-200 bg-gray-50">
                <?php
                    $currentVoiceAges = is_array($actor->voice_ages) ? $actor->voice_ages : json_decode($actor->voice_ages, true) ?? [];
                    $currentVoiceAges = old('voice_ages', $currentVoiceAges);
                ?>
                <?php $__currentLoopData = $voiceAges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $age): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="flex items-center p-3 border border-gray-300 hover:border-naranja-vibrante bg-white cursor-pointer transition duration-150">
                    <input type="checkbox" name="voice_ages[]" value="<?php echo e($age); ?>"
                        <?php echo e(in_array($age, $currentVoiceAges) ? 'checked' : ''); ?>

                        class="border-gray-300 text-naranja-vibrante focus:ring-naranja-vibrante">
                    <span class="ml-3 text-sm font-medium text-gray-700"><?php echo e($age); ?></span>
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

        <!-- Disponibilidad (NUEVO Toggle) -->
        <div class="p-4 border border-gray-200 bg-gray-50">
            <label class="block text-sm font-medium text-gray-700 mb-3">Estado de disponibilidad</label>
            <div class="flex items-center space-x-4">
                <!-- Toggle Switch Moderno -->
                <button type="button" 
                        id="availabilityToggle"
                        class="relative inline-flex h-8 w-16 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 <?php echo e(old('is_available', $actor->is_available) ? 'bg-verde-menta focus:ring-verde-menta' : 'bg-gray-300 focus:ring-gray-400'); ?>">
                    <span class="inline-block h-6 w-6 transform bg-white rounded-full shadow-lg transition-transform duration-200 <?php echo e(old('is_available', $actor->is_available) ? 'translate-x-9' : 'translate-x-1'); ?>"></span>
                </button>
                <input type="hidden" name="is_available" id="availabilityInput" value="<?php echo e(old('is_available', $actor->is_available) ? '1' : '0'); ?>">
                <div>
                    <span class="text-sm font-medium text-gray-700 block">
                        <?php echo e(old('is_available', $actor->is_available) ? 'Disponible' : 'No disponible'); ?>

                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Columna Derecha -->
    <div class="space-y-6">
        <!-- Biografía -->
        <div>
            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                Biografía
            </label>
            <textarea name="bio" id="bio" rows="8"
                class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-azul-profundo focus:border-azul-profundo transition duration-200"
                placeholder="Biografía profesional del actor..."><?php echo e(old('bio', $actor->bio)); ?></textarea>
        </div>

        <!-- Archivos -->
        <div class="grid grid-cols-1 gap-4">
            <!-- Foto -->
            <div class="p-4 border border-gray-200 bg-gray-50">
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                    Foto de perfil
                </label>
                <?php if($actor->photo): ?>
                <div class="flex items-center space-x-4 mb-3">
                    <img src="<?php echo e(asset('storage/' . $actor->photo)); ?>"
                        alt="Foto actual"
                        class="w-16 h-16 object-cover border-2 border-ambar">
                    <span class="text-sm text-gray-600">Foto actual</span>
                </div>
                <?php endif; ?>
                <input type="file" name="photo" id="photo"
                    accept="image/*"
                    class="w-full border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-rosa-electrico focus:border-rosa-electric0">
                <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener la actual</p>
            </div>

            <!-- Audio -->
            <div class="p-4 border border-gray-200 bg-gray-50">
                <label for="audio_path" class="block text-sm font-medium text-gray-700 mb-2">
                    Muestra de voz
                </label>
                <?php if($actor->audio_path): ?>
                <div class="flex items-center space-x-4 mb-3">
                    <i class="fas fa-volume-up text-azul-profundo text-xl"></i>
                    <audio controls class="h-8">
                        <source src="<?php echo e(asset('storage/' . $actor->audio_path)); ?>" type="audio/mpeg">
                    </audio>
                </div>
                <?php endif; ?>
                <input type="file" name="audio_path" id="audio_path"
                    accept="audio/*"
                    class="w-full border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-azul-profundo focus:border-azul-profundo">
                <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener la actual</p>
            </div>
        </div>
    </div>
</div>

<!-- Escuelas y Obras en nueva fila -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <!-- Escuelas -->
    <div class="p-4 border border-gray-200 bg-gray-50">
        <label class="block text-sm font-medium text-gray-700 mb-3">
            Escuelas de formación
        </label>
        <div class="space-y-2 max-h-60 overflow-y-auto p-3 border border-gray-200 bg-white">
            <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="flex items-center p-2 hover:bg-gray-50 cursor-pointer">
                <input type="checkbox" name="schools[]" value="<?php echo e($school->id); ?>"
                    class="border-gray-300 text-azul-profundo focus:ring-azul-profundo"
                    <?php echo e(in_array($school->id, old('schools', $actor->schools->pluck('id')->toArray())) ? 'checked' : ''); ?>>
                <span class="ml-3 text-sm text-gray-700"><?php echo e($school->name); ?></span>
            </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Obras -->
    <div class="p-4 border border-gray-200 bg-gray-50">
        <label class="block text-sm font-medium text-gray-700 mb-3">
            Obras participadas
        </label>
        <div class="space-y-3 max-h-60 overflow-y-auto p-3 border border-gray-200 bg-white">
            <?php $__currentLoopData = $works; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $work): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-start p-2 hover:bg-gray-50">
                <input type="checkbox" name="works[]" value="<?php echo e($work->id); ?>"
                    class="mt-1 border-gray-300 text-azul-profundo focus:ring-azul-profundo"
                    <?php echo e(in_array($work->id, old('works', $actor->works->pluck('id')->toArray())) ? 'checked' : ''); ?>>
                <div class="ml-3 flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-sm font-medium text-gray-700"><?php echo e($work->title); ?></span>
                            <div class="text-xs text-gray-500 capitalize">
                                <?php echo e($work->type); ?> <?php if($work->year): ?>• <?php echo e($work->year); ?><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    $characterName = $actor->works->find($work->id)->pivot->character_name ?? '';
                    ?>
                    <input type="text" name="character_names[<?php echo e($work->id); ?>]"
                        placeholder="Nombre del personaje"
                        class="mt-2 w-full text-sm border border-gray-300 px-3 py-1 focus:border-azul-profundo focus:ring-azul-profundo"
                        value="<?php echo e(old('character_names.' . $work->id, $characterName)); ?>">
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
                <!-- Géneros -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Géneros que puede interpretar <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <?php
                        $currentGenders = is_array($actor->genders) ? $actor->genders : json_decode($actor->genders, true) ?? [];
                        $currentGenders = old('genders', $currentGenders);
                        ?>
                        <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center p-3 border border-gray-300 hover:bg-gray-50 cursor-pointer transition duration-150">
                            <input type="checkbox" name="genders[]" value="<?php echo e($gender); ?>"
                                <?php echo e(in_array($gender, $currentGenders) ? 'checked' : ''); ?>

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
                        <?php
                        $currentVoiceAges = is_array($actor->voice_ages) ? $actor->voice_ages : json_decode($actor->voice_ages, true) ?? [];
                        $currentVoiceAges = old('voice_ages', $currentVoiceAges);
                        ?>
                        <?php $__currentLoopData = $voiceAges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $age): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center p-3 border border-gray-300 hover:bg-gray-50 cursor-pointer transition duration-150">
                            <input type="checkbox" name="voice_ages[]" value="<?php echo e($age); ?>"
                                <?php echo e(in_array($age, $currentVoiceAges) ? 'checked' : ''); ?>

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

                <!-- Disponibilidad -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-3">Disponibilidad</label>
    <div class="flex items-center space-x-4">
        <!-- Toggle Switch Moderno -->
        <button type="button" 
                id="availabilityToggle"
                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 <?php echo e(old('is_available', $actor->is_available) ? 'bg-verde-menta focus:ring-verde-menta' : 'bg-gray-300 focus:ring-gray-400'); ?>">
            <span class="inline-block h-4 w-4 transform bg-white rounded-full transition-transform <?php echo e(old('is_available', $actor->is_available) ? 'translate-x-6' : 'translate-x-1'); ?>"></span>
        </button>
        <input type="hidden" name="is_available" id="availabilityInput" value="<?php echo e(old('is_available', $actor->is_available) ? '1' : '0'); ?>">
        <span class="text-sm font-medium text-gray-700">
            <?php echo e(old('is_available', $actor->is_available) ? 'Disponible para proyectos' : 'No disponible'); ?>

        </span>
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
                        class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Biografía del actor..."><?php echo e(old('bio', $actor->bio)); ?></textarea>
                </div>

                <!-- Archivos Actuales -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Foto Actual -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Foto Actual
                        </label>
                        <?php if($actor->photo): ?>
                        <div class="flex items-center space-x-4">
                            <img src="<?php echo e(asset('storage/' . $actor->photo)); ?>"
                                alt="Foto actual"
                                class="w-20 h-20 object-cover">
                            <span class="text-sm text-gray-600">Foto actual</span>
                        </div>
                        <?php else: ?>
                        <p class="text-sm text-gray-500">No hay foto</p>
                        <?php endif; ?>
                    </div>

                    <!-- Audio Actual -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Audio Actual
                        </label>
                        <?php if($actor->audio_path): ?>
                        <div class="flex items-center space-x-4">
                            <i class="fas fa-volume-up text-blue-500 text-xl"></i>
                            <audio controls class="h-8">
                                <source src="<?php echo e(asset('storage/' . $actor->audio_path)); ?>" type="audio/mpeg">
                            </audio>
                        </div>
                        <?php else: ?>
                        <p class="text-sm text-gray-500">No hay audio</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Nuevos Archivos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nueva Foto -->
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                            Cambiar Foto
                        </label>
                        <input type="file" name="photo" id="photo"
                            accept="image/*"
                            class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener la actual</p>
                    </div>

                    <!-- Nuevo Audio -->
                    <div>
                        <label for="audio_path" class="block text-sm font-medium text-gray-700 mb-2">
                            Cambiar Audio
                        </label>
                        <input type="file" name="audio_path" id="audio_path"
                            accept="audio/*"
                            class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener el actual</p>
                    </div>
                </div>

                <!-- Sección de Profesor -->
                <div class="bg-white shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-4">Información como Profesor</h2>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Escuelas donde enseña</label>
                        <div class="space-y-3">
                            <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-3 border border-gray-200">
                                <label class="flex items-center">
                                    <input type="checkbox" name="teaching_schools[]" value="<?php echo e($school->id); ?>"
                                        <?php echo e(in_array($school->id, $currentTeachingSchools ?? []) ? 'checked' : ''); ?>

                                        class="text-blue-600 focus:ring-blue-500 teaching-school-checkbox">
                                    <span class="ml-2 text-sm text-gray-700"><?php echo e($school->name); ?></span>
                                </label>

                                <div class="teaching-school-fields ml-4 <?php echo e(in_array($school->id, $currentTeachingSchools ?? []) ? '' : 'hidden'); ?>">
                                    <input type="text" name="teaching_subjects[<?php echo e($school->id); ?>]"
                                        placeholder="Materia que imparte"
                                        value="<?php echo e($actor->teachingSchools->firstWhere('id', $school->id)?->pivot?->subject); ?>"
                                        class="border border-gray-300 px-3 py-1 text-sm w-48">
                                    <textarea name="teaching_bios[<?php echo e($school->id); ?>]"
                                        placeholder="Bio como profesor"
                                        class="border border-gray-300 px-3 py-1 text-sm w-48 ml-2"><?php echo e($actor->teachingSchools->firstWhere('id', $school->id)?->pivot?->teaching_bio); ?></textarea>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <!-- Escuelas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Escuelas
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-48 overflow-y-auto border border-gray-200 p-4">
                        <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" name="schools[]" value="<?php echo e($school->id); ?>"
                                class="border-gray-300 text-blue-600 focus:ring-blue-500"
                                <?php echo e(in_array($school->id, old('schools', $actor->schools->pluck('id')->toArray())) ? 'checked' : ''); ?>>
                            <span class="text-sm text-gray-700"><?php echo e($school->name); ?></span>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Obras -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Obras
                    </label>
                    <div class="space-y-3 max-h-48 overflow-y-auto border border-gray-200 p-4">
                        <?php $__currentLoopData = $works; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $work): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" name="works[]" value="<?php echo e($work->id); ?>"
                                class="mt-1 border-gray-300 text-blue-600 focus:ring-blue-500"
                                <?php echo e(in_array($work->id, old('works', $actor->works->pluck('id')->toArray())) ? 'checked' : ''); ?>>
                            <div class="flex-1">
                                <span class="text-sm font-medium text-gray-700"><?php echo e($work->title); ?></span>
                                <div class="text-xs text-gray-500 capitalize">
                                    <?php echo e($work->type); ?> <?php if($work->year): ?>• <?php echo e($work->year); ?><?php endif; ?>
                                </div>
                                <?php
                                $characterName = $actor->works->find($work->id)->pivot->character_name ?? '';
                                ?>
                                <input type="text" name="character_names[<?php echo e($work->id); ?>]"
                                    placeholder="Personaje"
                                    class="mt-1 w-full text-xs border border-gray-300 px-2 py-1"
                                    value="<?php echo e(old('character_names.' . $work->id, $characterName)); ?>">
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <div>
                    <p class="text-sm text-gray-500">
                        <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                        Usuario: <?php echo e($actor->user->email); ?>

                    </p>
                </div>
                <div class="flex space-x-4">
                    <a href="<?php echo e(route('admin.actors')); ?>"
                        class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 transition duration-200 font-medium">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar Actor
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.teaching-school-checkbox');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const fields = this.closest('.flex').querySelector('.teaching-school-fields');
                if (this.checked) {
                    fields.classList.remove('hidden');
                } else {
                    fields.classList.add('hidden');
                }
            });
        });
    });

document.addEventListener('DOMContentLoaded', function() {
    // Toggle Switch para disponibilidad
    const availabilityToggle = document.getElementById('availabilityToggle');
    const availabilityInput = document.getElementById('availabilityInput');
    const availabilityText = availabilityToggle.nextElementSibling.querySelector('.text-sm');

    if (availabilityToggle) {
        availabilityToggle.addEventListener('click', function() {
            const isAvailable = availabilityInput.value === '1';
            availabilityInput.value = isAvailable ? '0' : '1';
            
            // Cambiar colores del toggle
            if (availabilityInput.value === '1') {
                this.classList.remove('bg-gray-300', 'focus:ring-gray-400');
                this.classList.add('bg-verde-menta', 'focus:ring-verde-menta');
                this.querySelector('span').classList.remove('translate-x-1');
                this.querySelector('span').classList.add('translate-x-9');
                availabilityText.textContent = 'Disponible';
                availabilityText.nextElementSibling.textContent = 'Visible para clientes';
            } else {
                this.classList.remove('bg-verde-menta', 'focus:ring-verde-menta');
                this.classList.add('bg-gray-300', 'focus:ring-gray-400');
                this.querySelector('span').classList.remove('translate-x-9');
                this.querySelector('span').classList.add('translate-x-1');
                availabilityText.textContent = 'No disponible';
            }
        });
    }

    // Toggle para escuelas de profesor
    const teachingCheckboxes = document.querySelectorAll('.teaching-school-checkbox');
    teachingCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const fields = this.closest('.flex').querySelector('.teaching-school-fields');
            if (this.checked) {
                fields.classList.remove('hidden');
            } else {
                fields.classList.add('hidden');
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/admin/actors/edit.blade.php ENDPATH**/ ?>