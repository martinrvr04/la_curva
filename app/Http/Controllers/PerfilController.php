<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Habitacion; // Asegúrate de importar el modelo Habitacion

class PerfilController extends Controller
{
    public function misReservas()
    {
        $reservas = Reserva::where('usuario', auth()->user()->id)->get();

        // Obtener los nombres de las habitaciones
        $habitaciones = Habitacion::pluck('tipo', 'id'); // Obtener un array con el tipo de habitación y su ID

        return view('perfil.mis-reservas', compact('reservas', 'habitaciones'));
    }
}