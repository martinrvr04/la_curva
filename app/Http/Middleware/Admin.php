<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    if (auth()->check() && auth()->user()->rol === 'administrador') {
        return $next($request);
    }

    return redirect('/'); // Redirige a los usuarios no autorizados
}
}
