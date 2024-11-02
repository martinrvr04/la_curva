<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HabitacionesController extends Controller
{
    public function index()
    {
        return view('paginas.habitaciones'); // Asegúrate de que la vista esté correctamente referenciada
    }
}
