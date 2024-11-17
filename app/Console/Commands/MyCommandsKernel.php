<?php

namespace App\Console\Commands; // <-- Namespace corregido

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class MyCommandsKernel extends ConsoleKernel // <-- Nombre de la clase actualizado
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\MyCommandsKernel::class,  // <-- Referencia actualizada

        \App\Console\Commands\EnviarSolicitudesDeReseña::class,  // <-- Agregar esta línea

        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
{
    $schedule->command('reseñas:enviar-solicitudes')->everyMinute();
}
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}