<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaginaController extends Controller
{
    public function showHabitaciones()
    {
        return view('paginas.habitaciones'); // Asegúrate de que la ruta al archivo Blade sea correcta
    }
}
