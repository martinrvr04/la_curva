<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisponibilidadHabitacion extends Model
{
    use HasFactory;
    protected $table = 'disponibilidad_habitaciones'; // <-- Aquí va la línea


    protected $fillable = [
        'habitacion_id',
        'fecha_inicio',
        'fecha_fin',
    ];

    protected $dates = [
        'fecha_inicio',
        'fecha_fin',
    ];
}