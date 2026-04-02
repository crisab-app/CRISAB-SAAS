<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckChurchStatus; // IMPORTANTE: Agregamos esta línea

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // 1. Aquí mantenemos tu guardia de estatus
        $middleware->alias([
            'church.status' => CheckChurchStatus::class, 
        ]);

        // 2. 👇 AQUÍ AGREGAMOS LA EXCEPCIÓN PARA STRIPE 👇
        $middleware->validateCsrfTokens(except: [
            'stripe/webhook',
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();