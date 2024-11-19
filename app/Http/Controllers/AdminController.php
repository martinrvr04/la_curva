<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Habitacion;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB; // Asegúrate de importar DB

class AdminController extends Controller
{
    public function ganancias(Habitacion $habitacion)
    {
        try {
            // Calcula las ganancias totales de la habitación
            // Calcula las ganancias totales de la habitación
            $gananciasTotales = Reserva::where('habitacion', $habitacion->id)->sum('precio_total');
// Ganancias por mes y año
$ganancias = Reserva::where('habitacion', $habitacion->id)
    ->selectRaw('MONTHNAME(fecha_entrada) as mes, YEAR(fecha_entrada) as anio, SUM(precio_total) as total') 
    ->groupBy('mes', 'anio')
    ->orderBy('anio')
    ->orderBy('mes')
    ->get()
    ->toArray(); 



Log::info('Ganancias por mes/año (antes de toArray): ', ['ganancias' => $ganancias]); 

// Asegúrate de que $ganancias siempre sea un array

// Si necesitas un único valor para "Ganancias del año", calcúlalo por separado
$gananciasAnio = Reserva::where('habitacion', $habitacion->id)
    ->whereYear('fecha_entrada', date('Y')) // Filtra por el año actual
    ->sum('precio_total');
Log::info('Ganancias del año:', ['ganancias' => $gananciasAnio]);
            

Log::info('Ganancias por mes/año: ', ['ganancias' => $ganancias]); 
Log::info('Ganancias del año:', ['ganancias' => $gananciasAnio]);

            

            // Ganancias agrupadas por mes para el gráfico de torta
            $gananciasPorMes = Reserva::where('habitacion', $habitacion->id)
                ->selectRaw('MONTH(fecha_entrada) as mes, SUM(precio_total) as total')
                ->groupBy('mes')
                ->orderBy('mes')
                ->get();

            // Formatear los meses como nombres de meses
            $gananciasPorMes = $gananciasPorMes->map(function ($item) {
                $item->mes = Carbon::createFromDate(null, $item->mes)->format('F'); 
                return $item;
            });


            Log::info('Ganancias por mes: ', ['gananciasPorMes' => $gananciasPorMes]);


            // Calcular el promedio de estadía
            $promedioEstadia = Reserva::where('habitacion', $habitacion->id)
                ->selectRaw('AVG(DATEDIFF(fecha_salida, fecha_entrada)) as promedio')
                ->first()
                ->promedio;


            // --- Cálculo de la variación de ganancias por mes ---

            $variacionGanancias = [];
            $meses = CarbonPeriod::create(Carbon::now()->subYear(), '1 month', Carbon::now());

            foreach ($meses as $mes) {
                $gananciasMesActual = Reserva::where('habitacion', $habitacion->id)
                    ->whereMonth('fecha_entrada', $mes->month)
                    ->whereYear('fecha_entrada', $mes->year)
                    ->sum('precio_total');

                $gananciasMesAnterior = Reserva::where('habitacion', $habitacion->id)
                    ->whereMonth('fecha_entrada', $mes->subMonth()->month)
                    ->whereYear('fecha_entrada', $mes->subMonth()->year)
                    ->sum('precio_total');

                $variacion = $gananciasMesAnterior > 0 
                    ? (($gananciasMesActual - $gananciasMesAnterior) / $gananciasMesAnterior) * 100 
                    : 0; 

                $variacionGanancias[] = [
                    'mes' => $mes->format('F'),
                    'variacion' => $variacion
                ];
            }

            // --- Cálculo de ganancias por trimestre ---

            $gananciasTrimestre = [];
            $trimestres = [
                [1, 2, 3], [4, 5, 6], [7, 8, 9], [10, 11, 12]
            ];

            foreach ($trimestres as $index => $trimestre) {
                $gananciasTrimestreTotal = Reserva::where('habitacion', $habitacion->id) // <-- Cambiar nombre de la variable
                    ->whereIn(DB::raw('QUARTER(fecha_entrada)'), [$index + 1])
                    ->sum('precio_total');
            
                $gananciasTrimestre[] = [
                    'trimestre' => 'T' . ($index + 1),
                    'ganancias' => $gananciasTrimestreTotal // <-- Usar la nueva variable
                ];
            }
            


            

            // --- Cálculo de ocupación por mes ---

            $ocupacionMes = [];
            foreach ($meses as $mes) {
                $diasOcupados = Reserva::where('habitacion', $habitacion->id)
                    ->whereMonth('fecha_entrada', '<=', $mes->month)
                    ->whereYear('fecha_entrada', '<=', $mes->year)
                    ->whereMonth('fecha_salida', '>=', $mes->month)
                    ->whereYear('fecha_salida', '>=', $mes->year)
                    ->count();

                $ocupacionMes[] = [
                    'mes' => $mes->format('F'),
                    'ocupacion' => ($diasOcupados / $mes->daysInMonth) * 100
                ];
            }

            // --- Cálculo de tendencia de reservas ---

            $tendenciaReservas = Reserva::where('habitacion', $habitacion->id)
                ->selectRaw('COUNT(*) as cantidad, YEAR(fecha_entrada) as anio, MONTH(fecha_entrada) as mes')
                ->groupBy('anio', 'mes')
                ->orderBy('anio')
                ->orderBy('mes')
                ->get();

            // Formatear los meses como nombres de meses
            $tendenciaReservas = $tendenciaReservas->map(function ($item) {
                $item->mes = Carbon::createFromDate(null, $item->mes)->format('F');
                return $item;
            });



            Log::info('Ganancias totales:', ['gananciasTotales' => $gananciasTotales]);
            Log::info('Ganancias por mes/año:', ['ganancias' => $ganancias]);
            Log::info('Ganancias por mes:', ['gananciasPorMes' => $gananciasPorMes]);
            Log::info('Variación de ganancias:', ['variacionGanancias' => $variacionGanancias]);
            Log::info('Ganancias por trimestre:', ['gananciasTrimestre' => $gananciasTrimestre]);
            Log::info('Ocupación por mes:', ['ocupacionMes' => $ocupacionMes]);
            Log::info('Tendencia de reservas:', ['tendenciaReservas' => $tendenciaReservas]);
            Log::info('Promedio de estadía:', ['promedioEstadia' => $promedioEstadia]);



            return view('admin.ganancias', compact(
                'habitacion', 
                'ganancias', 
                'gananciasPorMes', 
                'gananciasTotales',
                'promedioEstadia',
                'variacionGanancias',
                'gananciasTrimestre',
                'ocupacionMes',
                'tendenciaReservas',
                'gananciasAnio',
            ));

        } catch (\Exception $e) {
            Log::error('Error al obtener las ganancias:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Error al obtener las ganancias.']);
        }
    }

}