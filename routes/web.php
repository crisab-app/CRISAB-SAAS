<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ServiceTemplateController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ChurchRegistrationController;
use App\Http\Controllers\BibleController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ChurchProfileController;

Route::get('/', function () {
    return view('welcome');
});

// ==========================================================
// 🔓 RUTAS PÚBLICAS (No requieren iniciar sesión)
// ==========================================================

// 1. Invitaciones para Miembros
Route::get('/unirme/{contract_id}', [MemberController::class, 'publicRegistration'])->name('miembros.invitacion');
Route::post('/unirme/{contract_id}', [MemberController::class, 'storePublic'])->name('miembros.invitacion.store');

// 2. Registro del SaaS (Nuevas Iglesias)
Route::middleware('guest')->group(function () {
    Route::get('/registrar-iglesia', [ChurchRegistrationController::class, 'create'])->name('church.register');
    Route::post('/registrar-iglesia', [ChurchRegistrationController::class, 'store'])->name('church.register.store');
});

// 3. Rutas Legales
Route::view('/terminos-de-servicio', 'legales.terminos')->name('terminos');
Route::view('/aviso-de-privacidad', 'legales.privacidad')->name('privacidad');


// ==========================================================
// 🔒 RUTAS DE CUARENTENA (Para iglesias suspendidas)
// ==========================================================
Route::get('/cuenta-suspendida', function () {
    if (auth()->check() && auth()->user()->contract && auth()->user()->contract->status !== 'suspended') {
        return redirect('/dashboard');
    }
    return view('errors.suspended');
})->middleware(['auth'])->name('cuenta.suspendida');


// ==========================================================
// 👑 RUTAS DEL SUPER ADMIN (Master Panel)
// ==========================================================
Route::middleware(['auth', \App\Http\Middleware\SuperAdminMiddleware::class])->group(function () {
    
    // Panel Principal
    Route::get('/master-panel', [SuperAdminController::class, 'index'])->name('superadmin.index');
    
    // Gestión Rápida de Semáforo
    Route::patch('/master-panel/church/{church}/status', [SuperAdminController::class, 'updateStatus'])->name('superadmin.updateStatus');
    
    // CRUD Iglesias
    Route::get('/master-panel/church/{church}/edit', [SuperAdminController::class, 'editChurch'])->name('superadmin.church.edit');
    Route::put('/master-panel/church/{church}', [SuperAdminController::class, 'updateChurch'])->name('superadmin.church.update');
    Route::delete('/master-panel/church/{church}', [SuperAdminController::class, 'destroyChurch'])->name('superadmin.church.destroy');
    
    // Gestión de Usuarios de las Iglesias
    Route::get('/master-panel/church/{church}/users', [SuperAdminController::class, 'churchUsers'])->name('superadmin.churchUsers');
    Route::get('/master-panel/users/{user}/edit', [SuperAdminController::class, 'editUser'])->name('master.users.edit');
    Route::put('/master-panel/users/{user}', [SuperAdminController::class, 'updateUser'])->name('master.users.update');
    Route::put('/master-panel/users/{user}/password', [SuperAdminController::class, 'updatePassword'])->name('master.users.password');

});


// ==========================================================
// ⛪ RUTAS PRIVADAS (Sistema SaaS General)
// ==========================================================
// Todos deben estar autenticados, verificados y su iglesia NO debe estar suspendida
Route::middleware(['auth', 'verified', 'church.status'])->group(function () {
    
    // Dashboard General
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // --- Perfil de la Iglesia ---
    Route::get('/mi-iglesia', [ChurchProfileController::class, 'edit'])->name('church.profile.edit');
    Route::put('/mi-iglesia', [ChurchProfileController::class, 'update'])->name('church.profile.update');

    // --- Módulo de Calendario y Eventos ---
    Route::controller(CalendarController::class)->group(function () {
        Route::get('/calendario', 'index')->name('calendario');
        Route::get('/calendario/crear', 'create')->name('calendario.create');
        Route::post('/calendario', 'store')->name('calendario.store');
        Route::get('/calendario/{event}', 'show')->name('calendario.show');
        Route::get('/calendario/{event}/edit', 'edit')->name('calendario.edit');
        Route::put('/calendario/{event}', 'update')->name('calendario.update');
        Route::delete('/calendario/{event}', 'destroy')->name('calendario.destroy');
        Route::patch('/calendario/{event}/close', 'closeEvent')->name('calendario.close');
        Route::patch('/calendario/{event}/sermon', 'updateSermon')->name('calendario.sermon.update');
        Route::post('/calendario/item/{item}/assign', 'assignItem')->name('calendario.assignItem');
    });
    // PDF extra para calendario
    Route::get('/calendario/{id}/pdf', [EventController::class, 'exportPdf'])->name('calendario.pdf');

    // --- Módulo de Plantillas de Liturgia ---
    Route::get('/templates', [ServiceTemplateController::class, 'index'])->name('templates.index');
    Route::get('/templates/crear', [ServiceTemplateController::class, 'create'])->name('templates.create');
    Route::post('/templates', [ServiceTemplateController::class, 'store'])->name('templates.store');
    Route::get('/templates/{template}', [ServiceTemplateController::class, 'show'])->name('templates.show');
    Route::post('/templates/{template}/items', [ServiceTemplateController::class, 'storeItem'])->name('templates.items.store');
    Route::delete('/templates/{template}', [ServiceTemplateController::class, 'destroy'])->name('templates.destroy');
    Route::delete('/templates/items/{id}', [ServiceTemplateController::class, 'destroyItem'])->name('templates.items.destroy');
    Route::patch('/templates/items/{id}/up', [ServiceTemplateController::class, 'moveUp'])->name('templates.items.up');
    Route::patch('/templates/items/{id}/down', [ServiceTemplateController::class, 'moveDown'])->name('templates.items.down');

    // --- Grupos y Sociedades ---
    Route::resource('grupos', GroupController::class)->parameters(['grupos' => 'group']);
    Route::post('/grupos/{group}/assign', [GroupController::class, 'assignMember'])->name('grupos.assign');
    Route::delete('/grupos/{group}/remove/{user}', [GroupController::class, 'removeMember'])->name('grupos.remove');

    // --- Privilegios y Ministerios ---
    Route::resource('privilegios', SkillController::class)->parameters(['privilegios' => 'skill']);
    Route::post('/privilegios/{skill}/assign', [SkillController::class, 'assignUser'])->name('privilegios.assign');
    Route::delete('/privilegios/{skill}/remove/{user}', [SkillController::class, 'removeUser'])->name('privilegios.remove');

    // --- Módulo de Miembros Interno ---
    Route::resource('miembros', MemberController::class);

    // --- Biblia API ---
    Route::get('/api/bible/chapters', [BibleController::class, 'getChapters'])->name('bible.chapters');
    Route::get('/api/bible/verses', [BibleController::class, 'getVerses'])->name('bible.verses');
    Route::get('/api/bible/text', [BibleController::class, 'getText'])->name('bible.text');

    // --- Mi Perfil Personal ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';