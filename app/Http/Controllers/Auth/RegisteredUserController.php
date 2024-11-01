<?php 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // Asegúrate de usar el modelo correcto
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


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
            'telefono' => 'nullable|string|max:20',
            'pais' => 'nullable|string|max:50',
            'ciudad_nacimiento' => 'nullable|string|max:50',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'pais' => $request->pais,
            'ciudad_nacimiento' => $request->ciudad_nacimiento,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'rol' => 'cliente',
        ]);

        event(new Registered($user)); // Dispara el evento para enviar el correo de verificación

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
