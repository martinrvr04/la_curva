<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    use HasFactory;

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

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario'); 
    }

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva'); 
    }
}