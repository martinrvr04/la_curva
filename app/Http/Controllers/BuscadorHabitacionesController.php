<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitacion;
use Illuminate\Support\Facades\Log;
 // <-- Agrega esta línea


class BuscadorHabitacionesController extends Controller
{
    public function verificarDisponibilidad(Request $request)
{
    Log::debug('BuscadorHabitacionesController@verificarDisponibilidad: Iniciando verificación de disponibilidad.');

    $habitacionId = $request->input('habitacion_id');
    $fechaEntrada = $request->input('fecha_entrada');
    $fechaSalida = $request->input('fecha_salida');

    Log::debug('BuscadorHabitacionesController@verificarDisponibilidad: Datos recibidos:', [
        'habitacionId' => $habitacionId,
        'fechaEntrada' => $fechaEntrada,
        'fechaSalida' => $fechaSalida,
    ]);

    try {
        // Realiza la consulta a la base de datos para verificar la disponibilidad
        $disponible = Habitacion::where('id', $habitacionId)
            ->whereDoesntHave('disponibilidad', function ($query) use ($fechaEntrada, $fechaSalida) {
                $query->where(function ($q) use ($fechaEntrada, $fechaSalida) {
                    $q->where('fecha_inicio', '<', $fechaSalida)
                      ->where('fecha_fin', '>', $fechaEntrada);
                });
            })
            ->exists();

        Log::debug('BuscadorHabitacionesController@verificarDisponibilidad: Disponibilidad verificada:', ['disponible' => $disponible]);

    } catch (\Exception $e) {
        Log::error('BuscadorHabitacionesController@verificarDisponibilidad: Error al verificar la disponibilidad:', ['error' => $e->getMessage()]);
        return response()->json(['disponible' => false, 'error' => $e->getMessage()], 500);
    }

    // Retorna la respuesta en formato JSON
    return response()->json(['disponible' => $disponible]);
}
}