<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitacion;

class BuscadorHabitacionesController extends Controller
{
    public function buscar(Request $request)
    {
        $fechaEntrada = $request->input('fecha_entrada');
        $fechaSalida = $request->input('fecha_salida');

        $habitacionesDisponibles = Habitacion::whereDoesntHave('disponibilidad', function ($query) use ($fechaEntrada, $fechaSalida) {
            $query->where(function ($q) use ($fechaEntrada, $fechaSalida) {
                $q->where('fecha_inicio', '<', $fechaSalida)
                  ->where('fecha_fin', '>', $fechaEntrada);
            });
        })->get();

        return view('paginas.habitaciones', compact('habitacionesDisponibles')); 
    }
}