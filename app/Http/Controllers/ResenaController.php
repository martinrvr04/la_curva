<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResenaController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'calificacion_general' => 'required|integer',
        'comentario' => 'nullable|string',
        // ... otras validaciones para los campos del formulario
    ]);

    Resena::create([
        'usuario' => auth()->user()->id, // Si el usuario está autenticado
        'reserva' => $request->input('reserva_id'), 
        'calificacion_general' => $request->input('calificacion_general'),
        'comentario' => $request->input('comentario'),
        'limpieza' => $request->input('limpieza'), 
        'confort' => $request->input('confort'),
        'ubicacion' => $request->input('ubicacion'),
        'instalaciones' => $request->input('instalaciones'),
        'personal' => $request->input('personal'),
        'relacion_calidad_precio' => $request->input('relacion_calidad_precio'),
        'wifi' => $request->input('wifi')
    ]);

    return redirect()->back()->with('success', 'Reseña enviada con éxito.');
}
}
