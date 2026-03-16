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
        $middleware->alias([
            'church.status' => CheckChurchStatus::class, // Aquí registramos el guardia
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();