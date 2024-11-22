<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient; // Asegúrate de usar esta importación
use App\Models\SolicitudRecogida;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmacionRecogida; 

class RecogidaAeropuertoController extends Controller
{
    public function index()
    {
        return view('recogida-aeropuerto');
    }

    public function solicitar(Request $request)
    {
        // 1. Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'numero_vuelo' => 'required|string|max:255',
            'hora_llegada' => 'required|date',
        ]);

        // 2. Obtener los datos del formulario
        $nombre = $request->input('nombre');
        $email = $request->input('email');
        $numeroVuelo = $request->input('numero_vuelo');
        $horaLlegada = $request->input('hora_llegada');
        $monto = $request->input('monto_recogida'); 

        // 3. Guardar los datos en la base de datos
        $solicitud = new SolicitudRecogida();
        $solicitud->nombre_cliente = $nombre;
        $solicitud->email_cliente = $email;
        $solicitud->numero_vuelo = $numeroVuelo;
        $solicitud->hora_llegada = $horaLlegada;
        $solicitud->monto = $monto;
        $solicitud->save();

        // 4. Crear la orden de PayPal con srmklive/paypal
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

       
$order = $provider->createOrder([
    "intent" => "CAPTURE",
    "purchase_units" => [[
        "amount" => [
            "currency_code" => "USD", // O la moneda que uses
            "value" => $monto
        ],
        "description" => "Servicio de recogida en el aeropuerto",
        "reference_id" => $solicitud->id, // Agregar esta línea 
    ]],
    "application_context" => [
        "return_url" => route('recogida.procesarPago'), 
        "cancel_url" => route('recogida.cancelar') 
    ]
]);

        // Redirigir a la URL de aprobación de PayPal
        return redirect($order['links'][1]['href']);
    }

    public function procesarPago(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $orderId = $request->input('token');
    
        try {
            $response = $provider->capturePaymentOrder($orderId);
            Log::info('Respuesta de PayPal:', (array)$response); 
    
            // Verificar si la orden ya ha sido capturada
            if (isset($response['error']) && $response['error']['name'] === 'UNPROCESSABLE_ENTITY' 
                && isset($response['error']['details'][0]['issue']) 
                && $response['error']['details'][0]['issue'] === 'ORDER_ALREADY_CAPTURED') 
            {
                // La orden ya ha sido capturada, redirigir a la página de éxito con un mensaje
                return redirect()->route('pagos.exito')->with('warning', 'Este pago ya ha sido procesado.');
            }
    
            $solicitudId = $response['purchase_units'][0]['reference_id'] ?? null; 
            if ($solicitudId) {
                $solicitud = SolicitudRecogida::findOrFail($solicitudId);
                $solicitud->estado = 'pagada';
                $solicitud->paypal_order_id = $orderId;
                $solicitud->save();

                // Enviar el correo electrónico de confirmación
            Mail::to($solicitud->email_cliente)->send(new ConfirmacionRecogida($solicitud));
    
                return redirect()->route('pagos.exito')->with('success', 'Pago realizado con éxito.'); 
            } else {
                return redirect('/')->with('error', 'Error al procesar el pago. No se encontró el ID de la solicitud.');
            }
    
        } catch (\Exception $ex) {
            Log::error('Error al procesar el pago con PayPal', ['exception' => $ex]); 
    
            return redirect('/')->with('error', 'Error al procesar el pago.');
        }
    }

    public function cancelar()
    {
        return redirect('/')->with('error', 'Pago cancelado.');
    }
}