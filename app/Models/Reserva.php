<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Reserva extends Model
{
    use HasFactory;

    // Especifica los campos que pueden ser asignados masivamente
    protected $fillable = [
        'usuario',
        'habitacion',
        'fecha_entrada',
        'fecha_salida',
        'num_adultos',
        'num_ninos',
        'estado',
        'precio_habitacion',
        'precio_total',
        'nombre', // Campo adicional
        'dni',    // Campo adicional
        'email',
        'codigo'  // Campo adicional
    ];

    /**
     * Relación con el modelo Habitacion
     */
    // En el modelo Reserva
public function habitacion()
{
    return $this->belongsTo(Habitacion::class, 'habitacion'); 
}

    /**
     * Relación con el modelo Usuario (User)
     * Maneja claves foráneas nulas y proporciona un valor predeterminado si es necesario.
     */
    // app/Models/Reserva.php

// ...

   // app/Models/Reserva.php

   public function usuario()
{

    return $this->belongsTo(User::class, 'usuario', 'id'); 
}
// ...
    


    /**
     * Relación con el modelo DisponibilidadHabitacion
     */
    public function disponibilidad()
    {
        return $this->hasOne(DisponibilidadHabitacion::class, 'habitacion_id', 'habitacion'); 
    }

    /**
     * Método para procesar reservas con logging detallado
     */
    public static function procesarReservas()
    {
        $reservas = self::with('usuario')->get();

        foreach ($reservas as $reserva) {
            Log::info("Procesando reserva ID: {$reserva->id}");
            
            if ($reserva->usuario) {
                $email = $reserva->usuario->email;
                Log::info("Usuario encontrado: {$email}");
                // Lógica para enviar correo aquí
            } else {
                Log::warning("La reserva ID {$reserva->id} no tiene un usuario asociado.");
            }
        }
    }


    



    
}
