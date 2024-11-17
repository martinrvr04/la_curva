<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reseña;
use App\Models\Reserva;

class ReseñaController extends Controller
{
    public function create(Reserva $reserva)
    {
        // Verificar si la reserva pertenece al usuario autenticado
        if ($reserva->usuario !== auth()->user()->id) { 
            abort(403, 'No estás autorizado a dejar una reseña para esta reserva.');
        }

        // Verificar si la fecha de salida ya pasó
        if ($reserva->fecha_salida >= now()) {
            return redirect()->route('perfil.mis-reservas')->with('error', 'Aún no puedes dejar una reseña para esta reserva.');
        }

        return view('reseñas.create', compact('reserva'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
            'calificacion_general' => 'required|integer|between:1,5',
            'comentario' => 'nullable|string',
            'limpieza' => 'required|integer|between:1,5',
            'confort' => 'required|integer|between:1,5',
            'ubicacion' => 'required|integer|between:1,5',
            'instalaciones' => 'required|integer|between:1,5',
            'personal' => 'required|integer|between:1,5',
            'relacion_calidad_precio' => 'required|integer|between:1,5',
            'wifi' => 'required|integer|between:1,5',
        ]);

        // Crear la reseña
        Reseña::create([
            'usuario' => auth()->user()->id, // Asumiendo que la columna en la tabla reseñas se llama 'usuario'
            'reserva' => $request->reserva_id, // Asumiendo que la columna en la tabla reseñas se llama 'reserva'
            'calificacion_general' => $request->calificacion_general,
            'comentario' => $request->comentario,
            'limpieza' => $request->limpieza,
            'confort' => $request->confort,
            'ubicacion' => $request->ubicacion,
            'instalaciones' => $request->instalaciones,
            'personal' => $request->personal,
            'relacion_calidad_precio' => $request->relacion_calidad_precio,
            'wifi' => $request->wifi,
        ]);

        return redirect()->route('perfil.mis-reservas')->with('success', 'Reseña enviada correctamente.');
    }
}