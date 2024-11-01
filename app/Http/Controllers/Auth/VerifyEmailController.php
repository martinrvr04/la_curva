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
        Log::info("Verificando el correo para el usuario: " . $request->user()->id);

        if ($request->user()->hasVerifiedEmail()) {
            Log::info("El correo ya ha sido verificado.");
            return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            Log::info("El correo ha sido verificado correctamente.");
            event(new Verified($request->user()));
        } else {
            Log::warning("Error al verificar el correo del usuario: " . $request->user()->id);
        }

        return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
    }
}
