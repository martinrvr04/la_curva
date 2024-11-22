<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagoExitoController extends Controller
{
    public function index(Request $request)
    {
        $ref_payco = $request->input('ref_payco');
        // Puedes obtener la reserva a partir del ref_payco si es necesario

        return view('pagos.exito', ['ref_payco' => $ref_payco]); // Pasa el ref_payco a la vista
    }
}