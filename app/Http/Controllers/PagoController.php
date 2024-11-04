<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Epayco\Epayco; 
use App\Models\Reserva;
use Illuminate\Support\Facades\Log;

class PagoController extends Controller
{
    public function create(Request $request)
    {
        $habitacionId = $request->query('habitacion_id');
        $total = $request->query('total');
        $nombre = $request->query('nombre');
        $email = $request->query('email');

        return view('pago.create', compact('habitacionId', 'total', 'nombre', 'email'));
    }

    public function index(Request $request)
    {
        return view('pago.index', [
            'total' => $request->input('total'),
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
            'token' => 'required_if:pasarela,epayco|string', // Validar el token
        ]);
    
        try {
            switch ($request->pasarela) {
                case 'epayco':
                    $epayco = new Epayco([
                        "apiKey" => env('EPAYCO_PUBLIC_KEY'),
                        "privateKey" => env('EPAYCO_PRIVATE_KEY'),
                        "test" => env('EPAYCO_TEST_MODE'),
                        "lenguage" => "ES"
                    ]);

                    // Obtener el token del request
                    $token = $request->input('token'); 

                    // Crear el pago con el token
                    $response = $epayco->payment->create([
                        'token_card' => $token, // Usar el token recibido
                        'doc_type' => 'CC',
                        'doc_number' => '1234567890', // Reemplazar con un número de documento válido
                        'name' => $request->input('nombre'),
                        'email' => $request->input('email'),
                        'description' => 'Pago por reserva de habitación',
                        'value' => $request->input('total'),
                        'currency' => 'COP',
                        'url_confirmation' => route('pagos.confirmacion'), 
                        'url_success' => route('reservas.confirmacion'),  
                        'url_failure' => route('pagos.error'),   
                    ]);

                    Log::debug('Respuesta de la API de ePayco (pago):', (array) $response);

                    if ($response['status'] == 'success') {
                        return redirect($response['data']['url']);
                    } else {
                        return redirect()->back()->withErrors(['error' => 'Error al procesar el pago: ' . $response['message']]);
                    }

                    break;
                // ... (otros casos de pasarela)
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error al procesar el pago: ' . $e->getMessage()]);
        }
    }
    

    public function confirmarPago(Request $request)
    {
        Log::debug('Información recibida en la URL de confirmación:', $request->all());

        // Accede a la información de la transacción
        $ref_payco = $request->input('ref_payco');
        $x_id_invoice = $request->input('x_id_invoice');
        $x_transaction_id = $request->input('x_transaction_id');
        // ... otros datos ...

        // Valida la transacción con ePayco (opcional pero recomendado)

        // Actualiza el estado de la reserva
        $reserva = Reserva::findOrFail($x_id_invoice);
        $reserva->estado = 'pagada';
        $reserva->save();

        return view('pagos.confirmacion', ['reserva' => $reserva]);
    }
}