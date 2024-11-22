<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request 
 $request)
    {
        $buscar = $request->input('buscar');
        $ordenar = $request->input('ordenar', 'nombre');
        $direccion = $request->input('direccion', 'asc');

        $usuarios = User::orderBy($ordenar, $direccion)
            ->when($buscar, function ($query, $buscar) {
                return $query->where('nombre', 'like', '%' . $buscar . '%')
                             ->orWhere('email', 'like', '%' . $buscar . '%');
            })
            ->paginate(10);

        return view('admin.usuarios.index', [
            'usuarios' => $usuarios,
            'buscar' => $buscar,
            'ordenar' => $ordenar,
            'direccion' => $direccion,
        ]);
    }


    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:cliente,administrador', // Ajusta los roles según tu aplicación
        ]);

        User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', ['usuario' => $usuario]);
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed', // La contraseña es opcional al editar
            'rol' => 'required|in:cliente,administrador', // Ajusta los roles según tu aplicación
        ]);

        $usuario->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'rol' => $request->rol,
        ]);

        // Actualiza la contraseña solo si se proporciona
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
            $usuario->save();
        }

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}