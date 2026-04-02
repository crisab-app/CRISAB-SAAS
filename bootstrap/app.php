<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckChurchStatus;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // 👇 1. AGREGAMOS ESTA LÍNEA PARA COOLIFY (HTTPS) 👇
        $middleware->trustProxies(at: '*');

        // 2. Tu guardia de estatus
        $middleware->alias([
            'church.status' => CheckChurchStatus::class, 
        ]);

        // 3. La excepción para Stripe
        $middleware->validateCsrfTokens(except: [
            'stripe/webhook',
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();