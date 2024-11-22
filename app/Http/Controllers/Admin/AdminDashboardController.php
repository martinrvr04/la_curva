<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserva; // Importa la clase Reserva
use App\Models\Habitacion; // Asegúrate de importar el modelo de Habitacion
use Illuminate\Support\Facades\Log;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check() && Auth::user()->rol === 'administrador') { 
            // El usuario es administrador, muestra el dashboard
            $reservasHoy = Reserva::whereDate('fecha_entrada', today())->count();

            // Calcula la ocupación (ajusta la lógica si es necesario)
            $totalHabitaciones = Habitacion::count();
            $habitacionesOcupadas = Habitacion::where('disponible', false)->count();
            $ocupacion = ($habitacionesOcupadas / $totalHabitaciones) * 100;

            // Calcula los ingresos del mes (ajusta la lógica si es necesario)
            $ingresosMes = Reserva::whereMonth('fecha_entrada', now()->month)->sum('precio_total'); 

            // Obtén las reservas recientes (ajusta la lógica si es necesario)
            $reservasRecientes = Reserva::with('usuario', 'habitacion')
    ->orderBy('creado_en', 'desc')
    ->take(5)
    ->get();


Log::info("Cantidad de reservas recientes: " . $reservasRecientes->count());
foreach ($reservasRecientes as $reserva) {
    if ($reserva->usuario) {
        $reserva->usuario = $reserva->usuario()->first()->toArray();
    }
}



            return view('admin.dashboard', [
                'reservasHoy' => $reservasHoy,
                'ocupacion' => $ocupacion, 
                'ingresosMes' => $ingresosMes,
                'reservasRecientes' => $reservasRecientes, // Pasa la variable a la vista
            ]);
        } else {
            // El usuario no es administrador, redirige a la página de inicio
            return redirect('/'); 
        }
    }
}