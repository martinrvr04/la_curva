<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;

    protected $table = 'imagenes'; // Especifica el nombre de la tabla

    protected $fillable = ['habitacion_id', 'nombre'];

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class);
    }
}
