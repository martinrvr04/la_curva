<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HabitacionDashboardController extends Controller
{
    public function show($id)
    {
        $habitacion = Habitacion::findOrFail($id);

        // Ganancias totales
        $gananciasTotales = $habitacion->reservas()->sum('precio_total');

        // Ganancias por mes (últimos 12 meses)
        $gananciasPorMes = $habitacion->reservas()
            ->where('fecha_entrada', '>=', Carbon::now()->subYear())
            ->selectRaw('MONTH(fecha_entrada) as mes, SUM(precio_total) as ganancias')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Convertir los meses a nombres de meses
        $gananciasPorMes = $gananciasPorMes->map(function ($item) {
            $item->mes = Carbon::createFromDate(null, $item->mes)->format('F');
            return $item;
        });

        return view('dashboard.habitaciones.show', [
            'habitacion' => $habitacion,
            'gananciasTotales' => $gananciasTotales,
            'gananciasPorMes' => $gananciasPorMes,
        ]);
    }
}