<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Mail\ConfirmacionRecogida;
use Illuminate\Support\Facades\Mail;

class ReservaConfirmacionController extends Controller
{
    public function confirmar(Request $request)
    {
        $ref_payco = $request->input('ref_payco'); 

        // Obtener la reserva a partir del ref_payco
        $reserva = Reserva::where('codigo', $ref_payco)->firstOrFail(); 

        // Actualiza el estado de la reserva (opcional)
        $reserva->estado = 'confirmada';
        $reserva->save();

        // Envía el correo electrónico de confirmación
        Mail::to($reserva->usuario->email)->send(new ConfirmacionRecogida($reserva)); 

        // Puedes mostrar una vista de confirmación o redirigir a otra página
        return view('reservas.confirmacion', ['reserva' => $reserva]); 
    }
}