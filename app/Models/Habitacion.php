<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;

    protected $table = 'habitaciones';

    protected $fillable = [
        'numero',
        'nombre',
        'tipo',
        'capacidad',
        'precio_noche',
        'prepago_noche',
        'descripcion',
        'disponible',
    ];

    public function imagenes()
    {
        return $this->hasMany(Imagen::class);
    }


    // En Habitacion.php

    public function disponibilidad()
    {
        return $this->hasMany(DisponibilidadHabitacion::class);
}


    // En el modelo Habitacion.php

// En el modelo Habitacion.php

   // En el modelo Habitacion.php

public function reseñas()
{
    return $this->hasManyThrough(Reseña::class, Reserva::class, 'habitacion', 'reserva', 'id', 'id');
}
}
