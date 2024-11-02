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
}
