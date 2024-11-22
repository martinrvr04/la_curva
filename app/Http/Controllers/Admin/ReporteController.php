<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Habitacion;
use DB;
use Carbon\Carbon;
use PDF; // Importa la clase PDF de Snappy
use Maatwebsite\Excel\Facades\Excel; // Importa la clase Excel
use App\Exports\ReportesExport; // Crea una clase para la exportación a Excel


class ReporteController extends Controller
{
    public function index(Request $request)
    {
        // Reservas totales
        $reservasTotales = Reserva::count();

        // Promedio de estadía
        $promedioEstadia = Reserva::select(DB::raw('AVG(DATEDIFF(fecha_salida, fecha_entrada)) as promedio'))->first()->promedio;

        // Obtener el mes seleccionado o el mes actual por defecto
        $mesSeleccionado = $request->input('mes', Carbon::now()->format('Y-m')); 

        // Ocupación e ingresos por tipo de habitación por mes
        $ocupacionIngresosPorMes = [];

        // Calcular solo para el mes seleccionado
        $mes = Carbon::parse($mesSeleccionado);
        $inicioMes = $mes->copy()->startOfMonth();
        $finMes = $mes->copy()->endOfMonth();

        $datosMes = Habitacion::select(
                'tipo',
                DB::raw('SUM(CASE 
                            WHEN EXISTS (
                                SELECT 1 
                                FROM reservas r 
                                WHERE r.habitacion = habitaciones.id 
                                AND r.fecha_entrada <= "' . $finMes->format('Y-m-d') . '" 
                                AND r.fecha_salida >= "' . $inicioMes->format('Y-m-d') . '"
                            ) THEN 1 
                            ELSE 0 
                        END) as ocupadas'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(precio_noche) as ingresos')
            )
            ->groupBy('tipo')
            ->get();

        $ocupacionIngresosPorMes[$mes->format('Y-m')] = $datosMes;

        // Obtener la ocupación por mes de los últimos 12 meses
        $ocupacionPorMes = [];
        for ($i = 11; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $ocupacion = Reserva::whereMonth('fecha_entrada', $mes->month)
                                ->whereYear('fecha_entrada', $mes->year)
                                ->count();
            $ocupacionPorMes[$mes->format('Y-m')] = $ocupacion;
        }

        // Obtener los ingresos por tipo de habitación
        $ingresosPorTipo = Habitacion::select('tipo', DB::raw('SUM(precio_noche) as ingresos'))
                                    ->groupBy('tipo')
                                    ->get();

        return view('admin.reportes.index', [
            'reservasTotales' => $reservasTotales,
            'promedioEstadia' => $promedioEstadia,
            'ocupacionIngresosPorMes' => $ocupacionIngresosPorMes,
            'ocupacionPorMes' => $ocupacionPorMes,
            'ingresosPorTipo' => $ingresosPorTipo,
        ]);
    }

    public function exportarPDF(Request $request)
{
    // Calcular las variables necesarias para el reporte
    $reservasTotales = Reserva::count(); 

    // Obtener el mes seleccionado o el mes actual por defecto
    $mesSeleccionado = $request->input('mes', Carbon::now()->format('Y-m')); 

    // Ocupación e ingresos por tipo de habitación por mes
    $ocupacionIngresosPorMes = [];

    // Calcular solo para el mes seleccionado
    $mes = Carbon::parse($mesSeleccionado);
    $inicioMes = $mes->copy()->startOfMonth();
    $finMes = $mes->copy()->endOfMonth();

    $datosMes = Habitacion::select(
            'tipo',
            DB::raw('SUM(CASE 
                        WHEN EXISTS (
                            SELECT 1 
                            FROM reservas r 
                            WHERE r.habitacion = habitaciones.id 
                            AND r.fecha_entrada <= "' . $finMes->format('Y-m-d') . '" 
                            AND r.fecha_salida >= "' . $inicioMes->format('Y-m-d') . '"
                        ) THEN 1 
                        ELSE 0 
                    END) as ocupadas'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(precio_noche) as ingresos')
        )
        ->groupBy('tipo')
        ->get();

    $ocupacionIngresosPorMes[$mes->format('Y-m')] = $datosMes;

    // Promedio de estadía
    $promedioEstadia = Reserva::select(DB::raw('AVG(DATEDIFF(fecha_salida, fecha_entrada)) as promedio'))->first()->promedio;


    $pdf = PDF::loadView('admin.reportes.pdf', [
        'reservasTotales' => $reservasTotales,
        'ocupacionIngresosPorMes' => $ocupacionIngresosPorMes,
        'promedioEstadia' => $promedioEstadia,
    ]);

    return $pdf->download('reporte.pdf');
}

    

    public function exportarExcel(Request $request)
    {
        return Excel::download(new ReportesExport, 'reporte.xlsx');
    }
}