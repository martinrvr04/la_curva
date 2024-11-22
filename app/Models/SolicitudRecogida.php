<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudRecogida extends Model
{
    use HasFactory;


    protected $table = 'solicitudes_recogida'; 


    protected $fillable = [
        'nombre_cliente',
        'email_cliente',
        'numero_vuelo',
        'hora_llegada',
        'monto',
        'estado',
        'paypal_order_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'hora_llegada' => 'datetime', // Asegúrate de que hora_llegada se trate como fecha y hora
    ];


    // Relación con la tabla reservas (opcional)
    // public function reserva()
    // {
    //     return $this->belongsTo(Reserva::class);
    // }

    // Método para obtener el monto formateado en pesos colombianos (opcional)
    public function getMontoFormateadoAttribute()
    {
        return '$' . number_format($this->monto, 0, ',', '.') . ' COP';
    }
}