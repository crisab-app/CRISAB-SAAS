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

Route::get('/', function () {
    return view('welcome');
});

// ==========================================================
// 🔓 RUTAS PÚBLICAS (No requieren iniciar sesión)
// ==========================================================

// 1. Invitaciones para Miembros (De la iglesia ya existente)
Route::get('/unirme/{contract_id}', [MemberController::class, 'publicRegistration'])->name('miembros.invitacion');
Route::post('/unirme/{contract_id}', [MemberController::class, 'storePublic'])->name('miembros.invitacion.store');

// 2. Registro del SaaS (Nuevas Iglesias)
Route::middleware('guest')->group(function () {
    Route::get('/registrar-iglesia', [ChurchRegistrationController::class, 'create'])->name('church.register');
    Route::post('/registrar-iglesia', [ChurchRegistrationController::class, 'store'])->name('church.register.store');
});
// Rutas Legales
Route::view('/terminos-de-servicio', 'legales.terminos')->name('terminos');
Route::view('/aviso-de-privacidad', 'legales.privacidad')->name('privacidad');


// ==========================================================
// 🔒 RUTAS PRIVADAS (Exigen iniciar sesión)
// ==========================================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Ruta exclusiva para el Súper Admin (Tú)
    Route::get('/master-panel', [\App\Http\Controllers\SuperAdminController::class, 'index'])
        ->name('superadmin.index')        
        ->middleware([\App\Http\Middleware\SuperAdminMiddleware::class]); 
    Route::patch('/master-panel/church/{church}/status', [App\Http\Controllers\SuperAdminController::class, 'updateStatus'])->name('superadmin.updateStatus');
    Route::post('/master-panel/{church}/status', [\App\Http\Controllers\SuperAdminController::class, 'updateStatus'])
        ->name('superadmin.status')
        ->middleware([\App\Http\Middleware\SuperAdminMiddleware::class]); 
    // Rutas para gestionar usuarios desde el Master Panel
    Route::get('/master-panel/users/{user}/edit', [App\Http\Controllers\SuperAdminController::class, 'editUser'])->name('master.users.edit');
    Route::put('/master-panel/users/{user}', [App\Http\Controllers\SuperAdminController::class, 'updateUser'])->name('master.users.update');
    Route::put('/master-panel/users/{user}/password', [App\Http\Controllers\SuperAdminController::class, 'updatePassword'])->name('master.users.password');
    
// Ruta para eliminar iglesia
Route::delete('/master-panel/church/{church}', [App\Http\Controllers\SuperAdminController::class, 'destroyChurch'])->name('superadmin.destroyChurch');

// Ruta para ver el menú de usuarios de la iglesia
Route::get('/master-panel/church/{church}/users', [App\Http\Controllers\SuperAdminController::class, 'churchUsers'])->name('superadmin.churchUsers');

// --- Rutas del Calendario (Unificado en CalendarController) ---
Route::controller(CalendarController::class)->group(function () {
    Route::get('/calendario', 'index')->name('calendario');
    Route::get('/calendario/crear', 'create')->name('calendario.create');
    Route::post('/calendario', 'store')->name('calendario.store');
    Route::get('/calendario/{event}', 'show')->name('calendario.show');
    Route::get('/calendario/{event}/edit', 'edit')->name('calendario.edit');
    Route::put('/calendario/{event}', 'update')->name('calendario.update');
    Route::delete('/calendario/{event}', 'destroy')->name('calendario.destroy');
    Route::patch('/calendario/{event}/close', 'closeEvent')->name('calendario.close');
    Route::patch('/calendario/{id}/sermon', [EventController::class, 'updateSermon'])->name('calendario.sermon.update');
    Route::patch('/calendario/{event}/sermon', 'updateSermon')->name('calendario.sermon.update');
    Route::get('/calendario/{id}/pdf', [App\Http\Controllers\EventController::class, 'exportPdf'])->name('calendario.pdf');
    // Rutas para el Perfil de la Iglesia
    Route::get('/mi-iglesia', [App\Http\Controllers\ChurchProfileController::class, 'edit'])->name('church.profile.edit');
    Route::put('/mi-iglesia', [App\Http\Controllers\ChurchProfileController::class, 'update'])->name('church.profile.update');
    Route::put('/calendario/{event}', [App\Http\Controllers\CalendarController::class, 'update'])->name('calendario.update');
    
    // Ruta para asignar personas a los bloques
    Route::post('/calendario/item/{item}/assign', 'assignItem')->name('calendario.assignItem');
});    

    // --- Módulo de Miembros (Administración interna) ---
    Route::resource('miembros', MemberController::class);

    // --- Rutas de Plantillas de Liturgia (Fase 4) ---
    Route::get('/templates', [ServiceTemplateController::class, 'index'])->name('templates.index');
    Route::get('/templates/crear', [ServiceTemplateController::class, 'create'])->name('templates.create');
    Route::post('/templates', [ServiceTemplateController::class, 'store'])->name('templates.store');
    Route::get('/templates/{template}', [ServiceTemplateController::class, 'show'])->name('templates.show');
    Route::post('/templates/{template}/items', [ServiceTemplateController::class, 'storeItem'])->name('templates.items.store');
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

    // --- RUTAS PARA LA BIBLIA INTELIGENTE ---
    Route::get('/api/bible/chapters', [BibleController::class, 'getChapters'])->name('bible.chapters');
    Route::get('/api/bible/verses', [BibleController::class, 'getVerses'])->name('bible.verses');
    Route::get('/api/bible/text', [BibleController::class, 'getText'])->name('bible.text');

    // Ruta de cuarentena (Cuando están suspendidos)
Route::get('/cuenta-suspendida', function () {
    // Si no están suspendidos, que los regrese al inicio
    if (auth()->user()->contract->status !== 'suspended') return redirect('/dashboard');
    return view('errors.suspended');
})->middleware(['auth'])->name('cuenta.suspendida');


// 👇 APLICAMOS EL GUARDIA A TUS RUTAS PRIVADAS 👇
Route::middleware(['auth', 'verified', 'church.status'])->group(function () {
    
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    
    // Tus rutas de iglesia
    Route::get('/mi-iglesia', [App\Http\Controllers\ChurchProfileController::class, 'edit'])->name('church.profile.edit');
    Route::put('/mi-iglesia', [App\Http\Controllers\ChurchProfileController::class, 'update'])->name('church.profile.update');

    // Tus rutas de calendario
    Route::get('/calendario', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendario');
    // ... (todas tus demás rutas privadas van aquí adentro)
});
});

require __DIR__.'/auth.php';