<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal;
use Illuminate\Support\Facades\Log;
use App\Models\Reserva; 

class PayPalController extends Controller
{
    public function create(Request $request)
    {
        Log::debug('PayPalController@create: Iniciando la creación del pago.');

        // Captura de los datos desde la solicitud
        $habitacionId = $request->query('habitacion_id');
        $total = $request->query('total');
        $nombre = $request->query('nombre');
        $email = $request->query('email');
        $fechaEntrada = $request->query('fecha_entrada'); 
        $fechaSalida = $request->query('fecha_salida'); 
        $numAdultos = $request->query('num_adultos'); 
        $numNinos = $request->query('num_ninos'); 
        $dni = $request->query('dni'); 

        // Guardar los datos de la reserva en la sesión
        $request->session()->put('reservaData', [
            'habitacion_id' => $habitacionId,
            'fecha_entrada' => $fechaEntrada,
            'fecha_salida' => $fechaSalida,
            'num_adultos' => $numAdultos,
            'num_ninos' => $numNinos,
            'nombre' => $nombre,
            'email' => $email,
            'dni' => $dni,
        ]);


        Log::debug('PayPalController@create: Datos recibidos:', [
            'habitacionId' => $habitacionId,
            'total' => $total,
            'nombre' => $nombre,
            'email' => $email,
            'fechaEntrada' => $fechaEntrada,
            'fechaSalida' => $fechaSalida,
            'numAdultos' => $numAdultos,
            'numNinos' => $numNinos,
            'dni' => $dni, 
        ]);

        return view('paypal.create', compact('habitacionId', 'total', 'nombre', 'email', 'fechaEntrada', 'fechaSalida', 'numAdultos', 'numNinos', 'dni'));
    }

    public function show(Reserva $reserva) 
    {
        return view('reservas.show', compact('reserva')); 
    }


    public function store(Request $request)
    {
        
        Log::debug('PayPalController@store: Iniciando el proceso de pago.');
    
        // Validación de datos 
        $validatedData = $request->validate([
            'habitacion_id' => 'required|integer',
            'total' => 'required|numeric',
            'nombre' => 'required|string',
            'email' => 'required|email',
            // ... otros campos de validación
        ]);
    
        Log::debug('PayPalController@store: Datos validados.');
    
        $provider = new PayPal;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
    
        Log::debug('PayPalController@store: Token de acceso obtenido.');
    
        try {
            // Recuperar los datos de la reserva desde la sesión
            $reservaData = $request->session()->get('reservaData');

            // Crear la orden de PayPal
            $order = $provider->createOrder([
                "intent" => "CAPTURE",
                "purchase_units" => [[
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $validatedData['total'] 
                    ],
                    "reference_id" => json_encode([
                        'habitacion_id' => $reservaData['habitacion_id'], 
                        'nombre' => $reservaData['nombre'], 
                        'email' => $reservaData['email'], 
                        'fecha_entrada' => $reservaData['fecha_entrada'],
                        'fecha_salida' => $reservaData['fecha_salida'],
                        'num_adultos' => $reservaData['num_adultos'],
                        'num_ninos' => $reservaData['num_ninos'],
                        'dni' => $reservaData['dni'],
                        // ... otros datos
                    ]),
                ]],
                "application_context" => [
                    "return_url" => route('paypal.success'),
                    "cancel_url" => route('paypal.cancel'),
                ]
            ]);
    
            Log::debug('PayPalController@store: Orden de PayPal creada:', ['order' => $order]);
    
            // Redirigir a la URL de aprobación de PayPal
            $approvalUrl = $order['links'][1]['href'];
            Log::debug('PayPalController@store: Redirigiendo a la URL de aprobación:', ['approvalUrl' => $approvalUrl]);
            return redirect($approvalUrl);
    
        } catch (\Exception $e) {
            Log::error('PayPalController@store: Error al crear la orden de PayPal:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Error al crear la orden de PayPal. Por favor, inténtalo de nuevo más tarde.']); 
        }
    }

    public function success(Request $request)
    {
        Log::debug('PayPalController@success: Pago exitoso.');

        $provider = new PayPal;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $orderId = $request->input('token');

        Log::debug('PayPalController@success: ID de la orden:', ['orderId' => $orderId]);

        try {
            $response = $provider->capturePaymentOrder($orderId);
            Log::debug('PayPalController@success: Pago capturado:', ['response' => $response]);

            
            if (isset($response['purchase_units'][0]['reference_id'])) {
                $reservaData = json_decode($response['purchase_units'][0]['reference_id'], true);

                try {
                    // Asegúrate de obtener el total del precio correctamente
                    $total = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];

                    // Crear la reserva en la base de datos
                    $reserva = Reserva::create([
                        'usuario' => auth()->user()->id,
                        'habitacion' => $reservaData['habitacion_id'],
                        'fecha_entrada' => $reservaData['fecha_entrada'],
                        'fecha_salida' => $reservaData['fecha_salida'],
                        'num_adultos' => $reservaData['num_adultos'],
                        'num_ninos' => $reservaData['num_ninos'],
                        'nombre' => $reservaData['nombre'],
                        'email' => $reservaData['email'],
                        'precio_habitacion' => $total, 
                        'precio_total' => $total, 
                        'dni' => $reservaData['dni'], 
                    ]);

                    // Limpiar los datos de la sesión
                    $request->session()->forget('reservaData');

                    // Redirigir a la página de confirmación
                    return redirect()->route('reservas.show', $reserva->id)
                        ->with('success', 'Reserva creada con éxito.');

                } catch (\Exception $e) {
                    Log::error('PayPalController@success: Error al crear la reserva:', ['error' => $e->getMessage()]);
                    return redirect()->back()->withErrors(['error' => 'Error al crear la reserva.']);
                }

            } else {
                Log::error('PayPalController@success: Error: reference_id no encontrado en la respuesta de PayPal');
                return redirect()->back()->withErrors(['error' => 'Error al procesar el pago.']);
            }

        } catch (\Exception $e) {
            Log::error('PayPalController@success: Error al capturar el pago:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Error al capturar el pago de PayPal.']);
        }
    }

    public function cancel()
    {
        Log::debug('PayPalController@cancel: Pago cancelado.');
        return view('paypal.cancel');
    }
}