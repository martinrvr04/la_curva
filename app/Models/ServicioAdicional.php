<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioAdicional extends Model
{
    use HasFactory;

    protected $table = 'servicios_adicionales'; // Especifica el nombre de la tabla

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
    ];
}
