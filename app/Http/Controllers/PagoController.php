<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;

class PagoController extends Controller
{
    public function create(Request $request)
    {
        // Obtener los parámetros de la solicitud
        $habitacionId = $request->query('habitacion_id');
        $total = $request->query('total');
        $nombre = $request->query('nombre');
        $email = $request->query('email');

        // Aquí podrías buscar la habitación si es necesario
        // $habitacion = Habitacion::findOrFail($habitacionId); // Un ejemplo

        return view('pago.create', compact('habitacionId', 'total', 'nombre', 'email'));
    }

    public function index(Request $request)
    {
        // Aquí puedes manejar la lógica para mostrar las opciones de pago
        return view('pago.index', [
            'total' => $request->input('total'), // Recibe el total desde la vista de reserva
        ]);
    }

    public function procesarPago(Request $request)
{
    $request->validate([
        'habitacion_id' => 'required|integer',
        'total' => 'required|numeric',
        'nombre' => 'required|string',
        'email' => 'required|email',
        'pasarela' => 'required|string',
    ]);

    // Aquí puedes implementar la lógica específica de cada pasarela de pago
    switch ($request->pasarela) {
        case 'pse':
            // Implementar lógica para PSE
            break;
        case 'paypal':
            // Implementar lógica para PayPal
            break;
        case 'boacompra':
            // Implementar lógica para Boacompra
            break;
        default:
            return redirect()->back()->withErrors(['pasarela' => 'Pasarela de pago no válida.']);
    }

    // Redireccionar al usuario después del procesamiento
    return redirect()->route('reservas.confirmacion')->with('success', 'Pago realizado con éxito.');
}

}
