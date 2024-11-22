<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Habitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminHabitacionController extends Controller
{
    public function index(Request $request)
    {
        $habitaciones = Habitacion::all();
        return view('admin.habitaciones.index', ['habitaciones' => $habitaciones]);
    }

    public function create(Request $request)
    {
        return view('admin.habitaciones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|string|max:20|unique:habitaciones',
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:privada,compartida,individual,doble', 
            'capacidad' => 'required|integer|min:1',
            'precio_noche' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'prepago_noche' => 'required|numeric|min:0',
            'imagenes.*' => 'image|mimes:jpg,jpeg,png|max:2048', // Validar cada imagen
        ]);

        $habitacion = Habitacion::create([
            'numero' => $request->numero,
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'capacidad' => $request->capacidad,
            'precio_noche' => $request->precio_noche,
            'descripcion' => $request->descripcion,
            'prepago_noche' => $request->prepago_noche, 
        ]);

        if ($request->hasFile('imagenes')) {
            foreach ($request->imagenes as $imagen) {
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('img'), $nombreImagen);
                // Guardar el nombre de la imagen en la tabla imagenes
                $habitacion->imagenes()->create(['nombre' => $nombreImagen]);
            }
        }

        return redirect()->route('admin.habitaciones.index')->with('success', 'Habitación creada correctamente.');
    }
    

    public function edit(Habitacion $habitacion)
    {
        return view('admin.habitaciones.edit', ['habitacion' => $habitacion]);
    }

    public function update(Request $request, Habitacion $habitacion)
    {
        $request->validate([
            'numero' => 'required|string|max:20|unique:habitaciones,numero,' . $habitacion->id,
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:privada,compartida,individual,doble', 
            'capacidad' => 'required|integer|min:1',
            'precio_noche' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:2048|dimensions:min_width=100,min_height=100', // Validación de imagen
        ]);

        // Manejo de la imagen (si se envía)
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($habitacion->imagen) {
                Storage::delete('public/' . $habitacion->imagen);
            }

            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid() . '.' . $imagen->getClientOriginalExtension();
            $rutaImagen = $imagen->storeAs('public/habitaciones', $nombreImagen);

            $habitacion->imagen = $rutaImagen;
        }

        $habitacion->update([
            'numero' => $request->numero,
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'capacidad' => $request->capacidad,
            'precio_noche' => $request->precio_noche,
            'descripcion' => $request->descripcion, 
        ]);

        return redirect()->route('admin.habitaciones.index')->with('success', 'Habitación actualizada correctamente.');
    }

    public function destroy(Habitacion $habitacion)
    {
        // Eliminar la imagen si existe
        if ($habitacion->imagen) {
            Storage::delete('public/' . $habitacion->imagen);
        }

        $habitacion->delete();
        return redirect()->route('admin.habitaciones.index')->with('success', 'Habitación eliminada correctamente.');
    }
}