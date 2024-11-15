<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        Log::info('Inicio del método __invoke en VerifyEmailController'); // Log al inicio del método
        Log::info("Verificando el correo para el usuario: " . $request->user()->id);

        if ($request->user()->hasVerifiedEmail()) {
            Log::info("El correo ya ha sido verificado.");
            return redirect('/dashboard'); // Redirigir al dashboard
        }

        Log::info('Antes de marcar el correo como verificado'); // Log antes de marcar el correo
        if ($request->user()->markEmailAsVerified()) {
            Log::info("El correo ha sido verificado correctamente.");
            event(new Verified($request->user()));
        } else {
            Log::warning("Error al verificar el correo del usuario: " . $request->user()->id);
        }
        Log::info('Después de marcar el correo como verificado'); // Log después de marcar el correo


        Log::info('Fin del método __invoke en VerifyEmailController'); // Log al final del método
        return redirect('/dashboard'); // Redirigir al dashboard
    }
}