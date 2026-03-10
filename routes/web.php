<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ServiceTemplateController; // <-- Importamos el nuevo controlador

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // --- Rutas del Calendario ---
    Route::get('/calendario', [EventController::class, 'index'])->name('calendario');
    Route::get('/calendario/crear', [EventController::class, 'create'])->name('calendario.create');
    Route::post('/calendario', [EventController::class, 'store'])->name('calendario.store');
    Route::get('/calendario/{event}', [App\Http\Controllers\CalendarController::class, 'show'])->name('calendario.show');
    Route::delete('/calendario/{event}', [App\Http\Controllers\CalendarController::class, 'destroy'])->name('calendario.destroy');
    Route::get('/calendario/{event}/edit', [App\Http\Controllers\CalendarController::class, 'edit'])->name('calendario.edit');
    Route::put('/calendario/{event}', [App\Http\Controllers\CalendarController::class, 'update'])->name('calendario.update');
    Route::patch('/calendario/{event}/close', [App\Http\Controllers\CalendarController::class, 'closeEvent'])->name('calendario.close');
    Route::patch('/calendario/items/{item}/assign', [App\Http\Controllers\CalendarController::class, 'assignItem'])->name('calendario.assign');

    // Agrega esta línea para el módulo de miembros:
    Route::resource('miembros', App\Http\Controllers\MemberController::class);
    // Rutas públicas de invitación por ID
    Route::get('/unirme/{contract_id}', [App\Http\Controllers\MemberController::class, 'publicRegistration'])->name('miembros.invitacion');
    Route::post('/unirme/{contract_id}', [App\Http\Controllers\MemberController::class, 'storePublic'])->name('miembros.invitacion.store');
    // Ruta para el formulario público de registro de miembros
    Route::get('/unirme/{slug}', [App\Http\Controllers\MemberController::class, 'publicRegistration'])->name('miembros.invitacion');
    Route::post('/unirme/{slug}', [App\Http\Controllers\MemberController::class, 'storePublic'])->name('miembros.invitacion.store');

    // --- Rutas de Plantillas de Liturgia (Fase 4) ---
    Route::get('/templates', [ServiceTemplateController::class, 'index'])->name('templates.index');
    Route::get('/templates/crear', [ServiceTemplateController::class, 'create'])->name('templates.create');
    Route::post('/templates', [ServiceTemplateController::class, 'store'])->name('templates.store');
    Route::get('/templates/{template}', [ServiceTemplateController::class, 'show'])->name('templates.show');
    Route::post('/templates/{template}/items', [ServiceTemplateController::class, 'storeItem'])->name('templates.items.store');
        // 👇 NUEVAS RUTAS PARA BORRAR 👇
    Route::delete('/templates/{template}', [ServiceTemplateController::class, 'destroy'])->name('templates.destroy');
    Route::delete('/templates/items/{id}', [ServiceTemplateController::class, 'destroyItem'])->name('templates.items.destroy');
    // Rutas para mover el orden
    Route::patch('/templates/items/{id}/up', [ServiceTemplateController::class, 'moveUp'])->name('templates.items.up');
    Route::patch('/templates/items/{id}/down', [ServiceTemplateController::class, 'moveDown'])->name('templates.items.down');

    // --- Perfil ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Grupos y Directivas ---
    Route::resource('grupos', GroupController::class)->parameters([
        'grupos' => 'group'
    ]);
    Route::post('/grupos/{group}/assign', [GroupController::class, 'assignMember'])->name('grupos.assign');
    Route::delete('/grupos/{group}/remove/{user}', [GroupController::class, 'removeMember'])->name('grupos.remove');

    // --- Catálogo de Dones/Privilegios ---
    Route::resource('privilegios', SkillController::class)->parameters([
        'privilegios' => 'skill'
    ]);
    Route::post('/privilegios/{skill}/assign', [SkillController::class, 'assignUser'])->name('privilegios.assign');
    Route::delete('/privilegios/{skill}/remove/{user}', [SkillController::class, 'removeUser'])->name('privilegios.remove');
});

require __DIR__.'/auth.php';