<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Asegúrate de que esta línea esté presente





class LoginController extends Controller
{
    
    public function login(Request $request)
{




     // Agrega este log para verificar que el método está siendo ejecutado
     Log::info("Método de inicio de sesión ejecutado para: " . $request->email);
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Recupera el usuario con el correo ingresado
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        Log::info("Usuario no encontrado con el correo: " . $request->email);
        return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
    }

    // Verifica la contraseña manualmente
    if (!Hash::check($request->password, $user->password)) {
        Log::info("Contraseña incorrecta para el usuario con email: " . $request->email);
        return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
    }

    // Verifica si el correo está verificado
    if (!$user->hasVerifiedEmail()) {
        Log::info("Correo no verificado para el usuario con email: " . $request->email);
        return back()->withErrors(['email' => 'Debes verificar tu correo electrónico antes de iniciar sesión.']);
    }

    // Si todo está correcto, autentica al usuario
    Auth::login($user);
    Log::info("Usuario autenticado: " . $user->email);

    return redirect()->intended('/dashboard');
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
    return view('auth.login'); // Asegúrate de que la vista auth.login exista
}
}