<?php

namespace App\Http\Controllers;

use App\Models\ServicioAdicional;
use Illuminate\Http\Request;

class ServicioAdicionalController extends Controller
{
    public function index()
    {
        $servicios = ServicioAdicional::all();
        return view('servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('servicios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:servicios_adicionales|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
        ]);

        ServicioAdicional::create($request->all());
        return redirect()->route('servicios.index')->with('success', 'Servicio adicional creado exitosamente.');
    }

    public function edit(ServicioAdicional $servicio)
    {
        return view('servicios.edit', compact('servicio'));
    }

    public function update(Request $request, ServicioAdicional $servicio)
    {
        $request->validate([
            'nombre' => 'required|max:100|unique:servicios_adicionales,nombre,' . $servicio->id,
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
        ]);

        $servicio->update($request->all());
        return redirect()->route('servicios.index')->with('success', 'Servicio adicional actualizado exitosamente.');
    }

    public function destroy(ServicioAdicional $servicio)
    {
        $servicio->delete();
        return redirect()->route('servicios.index')->with('success', 'Servicio adicional eliminado exitosamente.');
    }
}
