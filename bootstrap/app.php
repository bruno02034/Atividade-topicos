<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckAuth; // <<-- IMPORTANTE

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Alias de rota (substitui o antigo $routeMiddleware do Kernel)
        $middleware->alias([
            'check.auth' => CheckAuth::class,
        ]);

        // (Opcional) você poderia criar um grupo:
        // $middleware->group('privado', [ CheckAuth::class ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();