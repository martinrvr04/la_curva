<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reseña extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario',
        'reserva',
        'calificacion_general',
        'comentario',
        'limpieza',
        'confort',
        'ubicacion',
        'instalaciones',
        'personal',
        'relacion_calidad_precio',
        'wifi',
    ];



    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva'); // Relación con la tabla 'reservas'
    }
    
   // En el modelo Reseña.php

// En el modelo Reseña.php

public function habitacion()
{
    return $this->belongsTo(Habitacion::class, 'reserva', 'id'); // Relación con la tabla habitaciones a través de la tabla reservas
}
    // Define las relaciones con los modelos User y Reserva si es necesario
    // ...
}