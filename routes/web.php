<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SchoolTeacherController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Página principal
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas públicas
Route::get('/actors', [ActorController::class, 'index'])->name('actors.index');
Route::get('/actors/{actor}', [ActorController::class, 'show'])->name('actors.show');

Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index');
Route::get('/schools/{school}', [SchoolController::class, 'show'])->name('schools.show');

Route::get('/works', [WorkController::class, 'index'])->name('works.index');
Route::get('/works/{work}', [WorkController::class, 'show'])->name('works.show');

// Registro específico
Route::middleware('guest')->group(function () {
    Route::get('/register/actor', [App\Http\Controllers\Auth\RegisterController::class, 'showActorRegistrationForm'])
        ->name('register.actor');
    Route::post('/register/actor', [App\Http\Controllers\Auth\RegisterController::class, 'registerActor'])
        ->name('register.actor.submit');

    Route::get('/register/client', [App\Http\Controllers\Auth\RegisterController::class, 'showClientRegistrationForm'])
        ->name('register.client');
    Route::post('/register/client', [App\Http\Controllers\Auth\RegisterController::class, 'registerClient'])
        ->name('register.client.submit');
});

// Autenticación
require __DIR__ . '/auth.php';

// Rutas autenticadas
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Perfil de actor
    Route::prefix('actor/profile')->group(function () {
        Route::get('/create', [ActorController::class, 'create'])->name('actors.create');
        Route::post('/', [ActorController::class, 'store'])->name('actors.store');
        Route::get('/{actor}/edit', [ActorController::class, 'edit'])->name('actors.edit');
        Route::put('/{actor}', [ActorController::class, 'update'])->name('actors.update');
        Route::delete('/{actor}', [ActorController::class, 'destroy'])->name('actors.destroy');
    });

    // AJAX
    Route::put('/actors/{actor}/availability', [ActorController::class, 'updateAvailability'])
        ->name('actors.update-availability');

    // Admin routes
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Escuelas
        Route::get('/schools', [AdminController::class, 'schools'])->name('admin.schools');
        Route::get('/schools/create', [AdminController::class, 'createSchool'])->name('admin.schools.create');
        Route::post('/schools', [AdminController::class, 'storeSchool'])->name('admin.schools.store');
        Route::get('/schools/{school}/edit', [AdminController::class, 'editSchool'])->name('admin.schools.edit');
        Route::put('/schools/{school}', [AdminController::class, 'updateSchool'])->name('admin.schools.update');
        Route::delete('/schools/{school}', [AdminController::class, 'destroySchool'])->name('admin.schools.destroy');

        // Obras
        Route::get('/works', [AdminController::class, 'works'])->name('admin.works');
        Route::get('/works/create', [AdminController::class, 'createWork'])->name('admin.works.create');
        Route::post('/works', [AdminController::class, 'storeWork'])->name('admin.works.store');
        Route::get('/works/{work}/edit', [AdminController::class, 'editWork'])->name('admin.works.edit');
        Route::put('/works/{work}', [AdminController::class, 'updateWork'])->name('admin.works.update');
        Route::delete('/works/{work}', [AdminController::class, 'destroyWork'])->name('admin.works.destroy');

        // Actores
        Route::get('/actors', [AdminController::class, 'actors'])->name('admin.actors');
        Route::get('/actors/create', [AdminController::class, 'createActor'])->name('admin.actors.create');
        Route::post('/actors', [AdminController::class, 'storeActor'])->name('admin.actors.store');
        Route::get('/actors/{actor}/edit', [AdminController::class, 'editActor'])->name('admin.actors.edit');
        Route::put('/actors/{actor}', [AdminController::class, 'updateActor'])->name('admin.actors.update');
        Route::delete('/actors/{actor}', [AdminController::class, 'destroyActor'])->name('admin.actors.destroy');

        // Usuarios
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

        // Profesores
        Route::prefix('schools/{school}/teachers')->group(function () {
            Route::get('/create', [SchoolTeacherController::class, 'create'])->name('admin.schools.teachers.create');
            Route::post('/', [SchoolTeacherController::class, 'store'])->name('admin.schools.teachers.store');
            Route::get('/{actor}/edit', [SchoolTeacherController::class, 'edit'])->name('admin.schools.teachers.edit');
            Route::put('/{actor}', [SchoolTeacherController::class, 'update'])->name('admin.schools.teachers.update');
            Route::delete('/{actor}', [SchoolTeacherController::class, 'destroy'])->name('admin.schools.teachers.destroy');
        });
    });
});