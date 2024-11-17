<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reserva;
use App\Mail\ReseñaSolicitada;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class EnviarSolicitudesDeReseña extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reseñas:enviar-solicitudes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía solicitudes de reseña a usuarios con reservas pasadas';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Iniciando el proceso de envío de solicitudes de reseña.');

        try {
            // Cargar reservas con usuarios
            Log::info('Antes de obtener las reservas'); 
            $reservas = Reserva::with('usuario')->where('fecha_salida', '<=', now())->get();

            Log::info('Después de obtener las reservas'); 
            Log::info('Cantidad de reservas encontradas: ' . $reservas->count());
            Log::info('Se encontraron ' . $reservas->count() . ' reservas.');

            foreach ($reservas as $reserva) {
                Log::info("Relación usuario cargada correctamente para la reserva {$reserva->id}");

                $usuario = $reserva->usuario()->first(); // <-- Modifica esta línea

                //dd($usuario); // <-- Añade esta línea aquí para inspeccionar $usuario

                Log::info("Procesando reserva con ID: {$reserva->id}");

                if ($usuario instanceof \App\Models\User) {
                    $url = URL::signedRoute('reseñas.crear', ['reserva' => $reserva->id]);
                    Mail::to($usuario->email)->send(new ReseñaSolicitada($reserva, $url)); // Pasa $reserva aquí
                    Log::info("Correo enviado a: " . $usuario->email);
                } else {
                    Log::warning("La reserva con ID {$reserva->id} no tiene un usuario válido.");
                }
            }

        } catch (\Exception $e) {
            Log::error('Error al enviar solicitudes de reseña: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
        }

        Log::info('Proceso de envío de solicitudes de reseña finalizado.');
    }
}