<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'nombre', // Nuevo campo
        'dni',    // Nuevo campo
        'email',
        'codigo'  // Nuevo campo
        
    ];

    // Define las relaciones si es necesario
    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'habitacion');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario');
    }

   // En Reserva.php

    public function disponibilidad()
    {
        return $this->hasOne(DisponibilidadHabitacion::class, 'habitacion_id', 'habitacion'); 
    }
}
