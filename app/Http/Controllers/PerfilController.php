<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Habitacion; 

class PerfilController extends Controller
{
    public function misReservas()
    {
        $reservas = Reserva::where('usuario', auth()->user()->id)->get();

        // Obtener los nombres de las habitaciones (corrección aquí)
        $habitaciones = Habitacion::pluck('nombre', 'id'); 

        return view('perfil.mis-reservas', compact('reservas', 'habitaciones'));
    }
}