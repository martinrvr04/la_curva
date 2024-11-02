<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    public function index()
    {
        // Obtener habitaciones disponibles
        $habitaciones = Habitacion::where('disponible', 1)->get();
        return view('paginas.habitaciones', compact('habitaciones'));
    }

    public function create()
    {
        // Mostrar el formulario para crear una nueva habitación
        return view('paginas.crear_habitacion'); // Asegúrate de que esta vista exista
    }

    public function store(Request $request)
    {
        // Validar el formulario
        $request->validate([
            'numero' => 'required',
            'tipo' => 'required',
            'capacidad' => 'required|integer',
            'precio_noche' => 'required|numeric',
            'prepago_noche' => 'required|numeric',
            'descripcion' => 'required',
            'imagenes.*' => 'image|mimes:jpg,jpeg,png|max:2048', // Validar cada imagen
        ]);

        // Crear la habitación
        $habitacion = Habitacion::create([
            'numero' => $request->numero,
            'tipo' => $request->tipo,
            'capacidad' => $request->capacidad,
            'precio_noche' => $request->precio_noche,
            'prepago_noche' => $request->prepago_noche,
            'descripcion' => $request->descripcion,
            'disponible' => 1, // O el valor que necesites
        ]);

        // Guardar las imágenes
        if ($request->hasFile('imagenes')) {
            foreach ($request->imagenes as $imagen) {
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('img'), $nombreImagen);
                // Guardar el nombre de la imagen en la tabla imagenes
                $habitacion->imagenes()->create(['nombre' => $nombreImagen]);
            }
        }

        return redirect()->route('habitaciones.index')->with('success', 'Habitación agregada exitosamente.');
    }
}
