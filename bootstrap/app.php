<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            // Agrega aquí los middlewares globales que necesites
            'csrf' => App\Http\Middleware\VerifyCsrfToken::class, 
        ]);

        // Registra el middleware CSRF globalmente para el grupo web
        $middleware->web(append: \App\Http\Middleware\VerifyCsrfToken::class); 

        $middleware->validateCsrfTokens(except: [
            // Agrega aquí otras rutas que deban ser excluidas de la protección CSRF, 
            // pero NO incluyas la ruta 'login'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();