<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;
use App\Models\DisponibilidadHabitacion;
use DateTime;
use DateInterval;

class HabitacionController extends Controller
{
    public function index(Request $request)
    {
        // Obtener las fechas de entrada y salida del request
        $fechaEntrada = $request->input('fecha_entrada') ? new DateTime($request->input('fecha_entrada')) : null;
        $fechaSalida = $request->input('fecha_salida') ? new DateTime($request->input('fecha_salida')) : null;

        // Obtener todas las habitaciones
        $habitaciones = Habitacion::all();

        // Filtrar las habitaciones disponibles solo si se proporcionaron fechas
        if ($fechaEntrada && $fechaSalida) {
            $habitacionesDisponibles = $habitaciones->filter(function ($habitacion) use ($fechaEntrada, $fechaSalida) {
                $dias = $fechaEntrada->diff($fechaSalida)->days;
                for ($i = 0; $i <= $dias; $i++) {
                    $fechaActual = clone $fechaEntrada; // Usar clone para copiar la fecha
                    $fechaActual->add(new DateInterval('P' . $i . 'D'));
                    $disponible = DisponibilidadHabitacion::where('habitacion_id', $habitacion->id)
                        ->where('fecha', $fechaActual->format('Y-m-d'))
                        ->where('disponible', true)
                        ->exists();
                    if (!$disponible) {
                        return false; // Si no está disponible en alguna fecha, la habitación no está disponible
                    }
                }
                return true; // Si está disponible en todas las fechas, la habitación está disponible
            });
        } else {
            // Si no se proporcionaron fechas, mostrar todas las habitaciones
            $habitacionesDisponibles = $habitaciones;
        }

        return view('paginas.habitaciones', compact('habitacionesDisponibles', 'fechaEntrada', 'fechaSalida')); 
    }

    // ... (resto del código del controlador)
}