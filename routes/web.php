<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GroupController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/calendario', [EventController::class, 'index'])->name('calendario');
    Route::get('/calendario/crear', [EventController::class, 'create'])->name('calendario.create');
    Route::post('/calendario', [EventController::class, 'store'])->name('calendario.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Rutas para Grupos y Directivas
    Route::resource('grupos', GroupController::class);
    // Rutas especiales para asignar y quitar gente
    Route::post('/grupos/{group}/assign', [GroupController::class, 'assignMember'])->name('grupos.assign');
    Route::delete('/grupos/{group}/remove/{user}', [GroupController::class, 'removeMember'])->name('grupos.remove');
});

require __DIR__.'/auth.php';
