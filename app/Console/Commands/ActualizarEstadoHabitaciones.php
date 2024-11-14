<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Habitacion;
use App\Models\Reserva;
use Carbon\Carbon;

class ActualizarEstadoHabitaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'actualizar:estado_habitaciones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el estado de las habitaciones a disponible si la fecha de salida de la reserva es hoy';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reservas = Reserva::where('fecha_salida', Carbon::today())->get();

        foreach ($reservas as $reserva) {
            $habitacion = Habitacion::find($reserva->habitacion_id);
            if ($habitacion) {
                $habitacion->disponible = 1;
                $habitacion->save();
            }
        }

        $this->info('Estado de las habitaciones actualizado correctamente.');
    }
}