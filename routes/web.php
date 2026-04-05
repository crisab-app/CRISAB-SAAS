<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
use App\Http\Controllers\FinanceController;
use App\Models\Event; 

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

// 3. Rutas Legales & Herramientas
Route::view('/terminos-de-servicio', 'legales.terminos')->name('terminos');
Route::view('/aviso-de-privacidad', 'legales.privacidad')->name('privacidad');
Route::view('/herramientas/generador', 'generador-activos')->name('generador');

// Ruta para procesar el logout por GET (Evita el 419)
Route::get('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect()->route('despedida');
})->name('logout.get');

// Ruta para la página de despedida
Route::view('/despedida', 'auth.despedida')->name('despedida');

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
    Route::get('/master-panel', [SuperAdminController::class, 'index'])->name('superadmin.index');
    Route::patch('/master-panel/church/{church}/status', [SuperAdminController::class, 'updateStatus'])->name('superadmin.updateStatus');
    Route::get('/master-panel/church/{church}/edit', [SuperAdminController::class, 'editChurch'])->name('superadmin.church.edit');
    Route::put('/master-panel/church/{church}', [SuperAdminController::class, 'updateChurch'])->name('superadmin.church.update');
    Route::delete('/master-panel/church/{church}', [SuperAdminController::class, 'destroyChurch'])->name('superadmin.church.destroy');
    Route::get('/master-panel/church/{church}/users', [SuperAdminController::class, 'churchUsers'])->name('superadmin.churchUsers');
    Route::get('/master-panel/users/{user}/edit', [SuperAdminController::class, 'editUser'])->name('superadmin.users.edit');
    Route::put('/master-panel/users/{user}', [SuperAdminController::class, 'updateUser'])->name('superadmin.users.update');
    Route::put('/master-panel/users/{user}/password', [SuperAdminController::class, 'updatePassword'])->name('superadmin.users.password');
    Route::delete('/master-panel/users/{user}', [SuperAdminController::class, 'destroyUser'])->name('superadmin.users.destroy');
});


// ==========================================================
// ⛪ RUTAS PRIVADAS LOCALES (Sistema SaaS General)
// ==========================================================
Route::middleware(['auth', 'verified', \App\Http\Middleware\CheckChurchStatus::class])->group(function () {
    
   // ==========================================
    // 📊 DASHBOARD GENERAL (CON PARACAÍDAS)
    // ==========================================
    Route::get('/dashboard', function () {
        
        $upcomingActivities = collect(); 

        try {
            // Aún no sabemos el nombre, puse 'start_date' como intento, pero el catch evitará que explote
            $upcomingActivities = \App\Models\Event::where('contract_id', auth()->user()->contract_id)
                ->where('start_date', '>=', now()->startOfDay())
                ->orderBy('start_date', 'asc')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            // Silencio total si la columna vuelve a fallar
        }

        return view('dashboard', compact('upcomingActivities'));
    })->name('dashboard');
    
    // ==========================================
    // ☕ MÓDULO: INVÍTAME UN CAFÉ
    // ==========================================
    Route::get('/invitame-un-cafe', [\App\Http\Controllers\DonationController::class, 'index'])->name('cafe.index');
    Route::post('/invitame-un-cafe/pagar', [\App\Http\Controllers\DonationController::class, 'checkout'])->name('cafe.checkout');

    // 🛡️ MÓDULO DE CONFIGURACIÓN DE IGLESIA (Protegido)
    Route::middleware([\App\Http\Middleware\CheckChurchPermission::class])->group(function () {
        Route::get('/mi-iglesia', [ChurchProfileController::class, 'edit'])->name('church.profile.edit');
        Route::put('/mi-iglesia', [ChurchProfileController::class, 'update'])->name('church.profile.update');
    });
    Route::post('/stripe/webhook', [\App\Http\Controllers\DonationController::class, 'webhook'])->name('cafe.webhook');

    // 🛡️ MÓDULO DE FINANZAS (Protegido)
    Route::middleware([\App\Http\Middleware\CheckFinancePermission::class])->controller(FinanceController::class)->group(function () {
        Route::get('/finanzas', 'index')->name('finances.index'); 
        Route::get('/finanzas/cajas', 'funds')->name('finances.funds'); 
        Route::post('/finanzas/cajas', 'storeFund')->name('finances.funds.store'); 
        Route::get('/finanzas/cajas/{fund}', 'showFund')->name('finances.funds.show'); 
        Route::get('/finanzas/movimientos', 'transactions')->name('finances.transactions'); 
        Route::post('/finanzas/movimientos', 'storeTransaction')->name('finances.transactions.store'); 
        Route::get('/finanzas/movimientos/{transaction}/recibo', 'receipt')->name('finances.receipt'); 
        Route::patch('/finanzas/movimientos/{transaction}/cancelar', 'cancelTransaction')->name('finances.transactions.cancel'); 
        Route::get('/finanzas/cortes', 'closings')->name('finances.closings'); 
        Route::post('/finanzas/cortes', 'storeClosing')->name('finances.closings.store'); 
        Route::patch('/finanzas/cortes/{closing}/cerrar', 'lockClosing')->name('finances.closings.lock'); 
        Route::match(['get', 'post'], '/finanzas/auditoria', 'audit')->name('finances.audit');
    });

    // 🛡️ MÓDULO DE MIEMBROS (Protegido)
    Route::middleware([\App\Http\Middleware\CheckMembersPermission::class])->group(function () {
        Route::patch('/miembros/{miembro}/permisos', [MemberController::class, 'updatePermissions'])->name('miembros.permissions');
        Route::resource('miembros', MemberController::class);
    });

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

    // --- Módulo de Discipulado / Academia ---
    Route::resource('cursos', \App\Http\Controllers\CourseController::class)->parameters(['cursos' => 'curso']);
    
    // Rutas para administrar el Aula Virtual
    Route::post('/cursos/{curso}/enroll', [\App\Http\Controllers\CourseController::class, 'enroll'])->name('cursos.enroll');
    Route::patch('/cursos/{curso}/students/{student}/status', [\App\Http\Controllers\CourseController::class, 'updateStudentStatus'])->name('cursos.students.status');

    // --- Grupos y Sociedades ---
    Route::resource('grupos', GroupController::class)->parameters(['grupos' => 'group']);
    Route::post('/grupos/{group}/assign', [GroupController::class, 'assignMember'])->name('grupos.assign');
    Route::delete('/grupos/{group}/remove/{user}', [GroupController::class, 'removeMember'])->name('grupos.remove');

    // ==========================================
    // RUTAS PARA LA TIENDITA DE LOS GRUPOS
    // ==========================================
    Route::get('/grupos/{group}/tiendita', [App\Http\Controllers\GroupStoreController::class, 'index'])->name('grupos.store.index');
    
    // 1. Ventas
    Route::get('/grupos/{group}/tiendita/ventas', [App\Http\Controllers\GroupStoreController::class, 'pos'])->name('grupos.store.pos');
    Route::post('/grupos/{group}/tiendita/ventas', [App\Http\Controllers\GroupStoreController::class, 'storeSale'])->name('grupos.store.pos.store');

    // 2. Compras
    Route::get('/grupos/{group}/tiendita/compras', [App\Http\Controllers\GroupStoreController::class, 'purchases'])->name('grupos.store.purchases');
    Route::post('/grupos/{group}/tiendita/compras', [App\Http\Controllers\GroupStoreController::class, 'storePurchase'])->name('grupos.store.purchases.store');

    // 3. Inventario
    Route::get('/grupos/{group}/tiendita/inventario', [App\Http\Controllers\GroupStoreController::class, 'inventory'])->name('grupos.store.inventory');
    Route::post('/grupos/{group}/tiendita/inventario', [App\Http\Controllers\GroupStoreController::class, 'storeProduct'])->name('grupos.store.inventory.store');
    Route::delete('/grupos/{group}/tiendita/inventario/{product}', [App\Http\Controllers\GroupStoreController::class, 'destroyProduct'])->name('grupos.store.inventory.destroy');
    
    // 4. Reportes
    Route::get('/grupos/{group}/tiendita/reportes', [App\Http\Controllers\GroupStoreController::class, 'reports'])->name('grupos.store.reports');   
    
    // --- Privilegios y Ministerios ---
    Route::resource('privilegios', SkillController::class)->parameters(['privilegios' => 'skill']);
    Route::post('/privilegios/{skill}/assign', [SkillController::class, 'assignUser'])->name('privilegios.assign');
    Route::delete('/privilegios/{skill}/remove/{user}', [SkillController::class, 'removeUser'])->name('privilegios.remove');

    // 📢 Enviar Aviso Masivo a toda la Iglesia
    Route::post('/notificaciones/enviar-masivo', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $user = auth()->user();
        
        $miembros = \App\Models\User::where('contract_id', $user->contract_id)->get();

        \Illuminate\Support\Facades\Notification::send($miembros, new \App\Notifications\ActivityReminder(
            $request->title,
            $request->message,
            '/dashboard', 
            '📢'
        ));

        return back()->with('success', '¡Aviso enviado exitosamente a ' . $miembros->count() . ' miembros!');
    })->name('notifications.sendMassive');

    // --- Marcar Notificaciones como Leídas ---
    Route::patch('/notificaciones/leer', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAsRead');

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

// ==========================================================
// 📚 MÓDULO DE BIBLIOTECA GLOBAL (Accesible para Master y Locales)
// ==========================================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('biblioteca', \App\Http\Controllers\LibraryController::class)->parameters(['biblioteca' => 'biblioteca']);
});