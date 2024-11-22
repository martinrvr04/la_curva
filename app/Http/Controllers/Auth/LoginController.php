<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        Log::info("Método de inicio de sesión ejecutado para: " . $request->email);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Log::info("Usuario no encontrado con el correo: " . $request->email);
            return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
        }

        if (!Hash::check($request->password, $user->password)) {
            Log::info("Contraseña incorrecta para el usuario con email: " . $request->email);
            return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
        }

        if (!$user->hasVerifiedEmail()) {
            Log::info("Correo no verificado para el usuario con email: " . $request->email);
            return back()->withErrors(['email' => 'Debes verificar tu correo electrónico antes de iniciar sesión.']);
        }

        Auth::login($user);
        Log::info("Usuario autenticado: " . $user->email);

        // Redirige al usuario según su rol
        if (auth()->user()->rol === 'administrador') {
            return redirect('/admin/dashboard'); // Redirige al dashboard del administrador
        } else {
            return redirect()->intended('/dashboard'); // Redirige al dashboard principal
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}