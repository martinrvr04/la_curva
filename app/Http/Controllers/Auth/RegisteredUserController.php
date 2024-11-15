<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Importa la fachada Log


class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required|string|confirmed|min:8',
            'telefono' => 'required|string|max:20', // Teléfono ahora es requerido
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'rol' => 'cliente', 
        ]);
        Log::info('Intentando enviar correo de verificación a: ' . $user->email); // Log antes de enviar el correo

        $user->sendEmailVerificationNotification(); // Envía la notificación de correo

        Log::info('Correo de verificación enviado (o al menos eso se intentó).'); // Log después de enviar el cor

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}