<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Habitacion;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class DashboardPrincipalController extends Controller // <-- Asegúrate de que el nombre sea correcto
{
    public function index()
    {
        // --- Ganancias totales ---
        $gananciasTotales = Reserva::sum('precio_total');

        // --- Ocupación promedio ---
        $totalHabitaciones = Habitacion::count();
        $habitacionesOcupadas = Reserva::where('estado', 'ocupada')
                                    ->whereDate('fecha_entrada', '<=', Carbon::now())
                                    ->whereDate('fecha_salida', '>=', Carbon::now())
                                    ->count();
        $ocupacionPromedio = $totalHabitaciones > 0 ? ($habitacionesOcupadas / $totalHabitaciones) * 100 : 0;

        // --- Promedio de estadía ---
        $promedioEstadia = Reserva::selectRaw('AVG(DATEDIFF(fecha_salida, fecha_entrada)) as promedio')->first()->promedio;

        // --- Número total de reservas ---
        $totalReservas = Reserva::count();

        // --- Ingresos por tipo de habitación ---
        $ingresosPorTipo = Reserva::selectRaw('habitaciones.tipo, SUM(reservas.precio_total) as total')
            ->join('habitaciones', 'reservas.habitacion', '=', 'habitaciones.id')
            ->groupBy('habitaciones.tipo')
            ->get();

        // --- Cancelaciones ---
        $cancelaciones = Reserva::where('estado', 'cancelada')->count();
        $porcentajeCancelaciones = $totalReservas > 0 ? ($cancelaciones / $totalReservas) * 100 : 0;

        // --- Gráfico de ganancias a lo largo del tiempo ---
        $gananciasPorMes = Reserva::selectRaw('MONTHNAME(fecha_entrada) as mes, YEAR(fecha_entrada) as anio, SUM(precio_total) as total')
            ->groupBy('mes', 'anio')
            ->orderBy('anio')
            ->orderBy('mes')
            ->get();

        // --- Gráfico de ocupación por mes ---
        $ocupacionPorMes = [];
        $meses = CarbonPeriod::create(Carbon::now()->subYear(), '1 month', Carbon::now());
        foreach ($meses as $mes) {
            $diasEnElMes = $mes->daysInMonth;
            $habitacionesOcupadas = Reserva::whereMonth('fecha_entrada', '<=', $mes->month)
                ->whereYear('fecha_entrada', '<=', $mes->year)
                ->whereMonth('fecha_salida', '>=', $mes->month)
                ->whereYear('fecha_salida', '>=', $mes->year)
                ->select('habitacion')
                ->distinct()
                ->get()
                ->count();
            $ocupacionPorMes[] = [
                'mes' => $mes->format('F Y'),
                'ocupacion' => $totalHabitaciones > 0 ? ($habitacionesOcupadas / $totalHabitaciones) * 100 : 0
            ];
        }

        // --- Mapa de calor de ocupación --- (Ejemplo simple)
        $mapaCalor = [];
        $habitaciones = Habitacion::all();
        foreach ($habitaciones as $habitacion) {
            $diasOcupados = Reserva::where('habitacion', $habitacion->id)
                ->whereDate('fecha_entrada', '<=', Carbon::now())
                ->whereDate('fecha_salida', '>=', Carbon::now())
                ->count();
            $mapaCalor[$habitacion->numero] = $diasOcupados; 
        }

        return view('admin.dashboard_principal', compact(
            'gananciasTotales',
            'ocupacionPromedio',
            'promedioEstadia',
            'totalReservas',
            'ingresosPorTipo',
            'cancelaciones',
            'porcentajeCancelaciones',
            'gananciasPorMes',
            'ocupacionPorMes',
            'mapaCalor'
        ));
    }
}