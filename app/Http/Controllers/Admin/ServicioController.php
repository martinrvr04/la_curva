<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servicio; // Asegúrate de importar el modelo Servicio
use Illuminate\Http\Request;


class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::all();
        return view('admin.servicios.index', ['servicios' => $servicios]);
    }

    public function create()
    {
        return view('admin.servicios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
        ]);

        Servicio::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
        ]);

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio creado correctamente.');
    }

    public function edit(Servicio $servicio)
    {
        return view('admin.servicios.edit', ['servicio' => $servicio]);
    }

    public function update(Request $request, Servicio $servicio)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
        ]);

        $servicio->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
        ]);

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->delete();
        return redirect()->route('admin.servicios.index')->with('success', 'Servicio eliminado correctamente.');
    }
}