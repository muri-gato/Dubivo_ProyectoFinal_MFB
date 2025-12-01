

<?php $__env->startSection('title', 'Gestión de Usuarios - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Gestión de Usuarios</h1>
                <p class="text-gray-600 mt-2">Administra todos los usuarios del sistema</p>
            </div>
            <a href="<?php echo e(route('admin.users.create')); ?>"
                class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Nuevo Usuario
            </a>
        </div>
    </div>
    <?php if($user->role == 'client' && !$user->actorProfile): ?>
    <a href="<?php echo e(route('admin.actors.create-from-user', $user)); ?>" 
       class="text-green-600 hover:text-green-900 text-sm font-medium">
       Convertir en actor
    </a>
<?php endif; ?>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="<?php echo e(route('admin.users')); ?>" class="flex flex-wrap gap-4 items-end">
            <div class="min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                <select name="role" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Todos los roles</option>
                    <option value="admin" <?php echo e(request('role') == 'admin' ? 'selected' : ''); ?>>Administrador</option>
                    <option value="actor" <?php echo e(request('role') == 'actor' ? 'selected' : ''); ?>>Actor</option>
                    <option value="client" <?php echo e(request('role') == 'client' ? 'selected' : ''); ?>>Cliente</option>
                </select>
            </div>
            <div class="flex-1 min-w-[300px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                    placeholder="Buscar por nombre o email..."
                    class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 h-[42px]">
                    <i class="fas fa-search mr-1"></i> Buscar
                </button>
                <a href="<?php echo e(route('admin.users')); ?>" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 h-[42px] inline-flex items-center">
                    <i class="fas fa-times mr-1"></i> Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-blue-600"><?php echo e($users->total()); ?></div>
            <div class="text-sm text-gray-600">Total Usuarios</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-green-600"><?php echo e($users->where('role', 'actor')->count()); ?></div>
            <div class="text-sm text-gray-600">Actores</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-purple-600"><?php echo e($users->where('role', 'client')->count()); ?></div>
            <div class="text-sm text-gray-600">Clientes</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-red-600"><?php echo e($users->where('role', 'admin')->count()); ?></div>
            <div class="text-sm text-gray-600">Administradores</div>
        </div>
    </div>

    <!-- Lista de Usuarios -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Usuario
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rol
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Perfil
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Registrado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($user->name); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($user->email); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    <?php echo e($user->role == 'admin' ? 'bg-red-100 text-red-800' : ''); ?>

                                    <?php echo e($user->role == 'actor' ? 'bg-green-100 text-green-800' : ''); ?>

                                    <?php echo e($user->role == 'client' ? 'bg-blue-100 text-blue-800' : ''); ?> capitalize">
                                <?php echo e($user->role); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($user->role == 'actor' && $user->actorProfile): ?>
                            <span class="text-green-600 text-sm">Perfil creado</span>
                            <?php elseif($user->role == 'actor'): ?>
                            <span class="text-gray-500 text-sm">Sin perfil</span>
                            <?php else: ?>
                            <span class="text-gray-400 text-sm">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($user->created_at->format('d/m/Y')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="<?php echo e(route('admin.users.edit', $user)); ?>"
                                    class="text-green-600 hover:text-green-900"
                                    title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if($user->id !== Auth::id()): ?>
                                <form action="<?php echo e(route('admin.users.destroy', $user)); ?>"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('¿Estás seguro de que quieres eliminar este usuario?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900"
                                        title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <?php else: ?>
                                <span class="text-gray-400 cursor-not-allowed" title="No puedes eliminar tu propio usuario">
                                    <i class="fas fa-trash"></i>
                                </span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-users text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No hay usuarios registrados</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($users->hasPages()): ?>
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            <?php echo e($users->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/admin/users/index.blade.php ENDPATH**/ ?>