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
        $middleware->validateCsrfTokens(except: [
            'login'
            // Agrega aquí otras rutas que deban ser excluidas de la protección CSRF, 
            // pero NO incluyas la ruta 'login'
            ]);

            

        // Agrega el middleware Admin aquí:
       
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();