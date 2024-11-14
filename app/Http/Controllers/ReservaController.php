<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Reserva; // Asegúrate de importar el modelo de Reserva
use App\Models\ServicioAdicional; // Importa el modelo de ServicioAdicional
use Illuminate\Http\Request;
use App\Models\DisponibilidadHabitacion; // Agrega esta línea


class ReservaController extends Controller
{
    public function create($habitacionId)
    {
        $habitacion = Habitacion::findOrFail($habitacionId);
        $serviciosAdicionales = ServicioAdicional::all(); // Obtiene todos los servicios adicionales
        return view('paginas.datos_reserva', [
            'habitacion' => $habitacion,
            'serviciosAdicionales' => $serviciosAdicionales, // Pasa los servicios a la vista
            'fecha_entrada' => now()->format('Y-m-d'),
            'fecha_salida' => now()->addDay()->format('Y-m-d'),
        ]);
    }

    public function show(Reserva $reserva) 
    {
        $reserva->load('habitacion'); // Carga la relación 'habitacion'
        return view('reservas.show', compact('reserva')); 
    }
    
    public function store(Request $request)
    {
        // Validaciones
        $request->validate([
            'habitacion_id' => 'required|exists:habitaciones,id',
            'fecha_entrada' => 'required|date',
            'fecha_salida' => 'required|date|after:fecha_entrada',
            'nombre' => 'required|string|max:255',
            'dni' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'servicios' => 'array', // Asegúrate de que el campo sea un arreglo
            'servicios.*' => 'exists:servicios_adicionales,id', // Valida que los servicios existan
        ]);
    
        // Crear reserva
        $reserva = new Reserva();
        $reserva->habitacion_id = $request->habitacion_id;
        $reserva->fecha_entrada = $request->fecha_entrada;
        $reserva->fecha_salida = $request->fecha_salida;
        $reserva->nombre = $request->nombre;
        $reserva->dni = $request->dni;
        $reserva->email = $request->email;

        // Calcular precio
        $habitacion = Habitacion::find($request->habitacion_id);
        $num_noches = (new \DateTime($request->fecha_salida))->diff(new \DateTime($request->fecha_entrada))->days;

        $precioHabitacion = $habitacion->precio_noche * $num_noches; // Precio de la habitación
        $precioServicios = 0; // Inicializa el precio de servicios

        if ($request->has('servicios')) {
            $serviciosSeleccionados = ServicioAdicional::whereIn('id', $request->servicios)->get();
            foreach ($serviciosSeleccionados as $servicio) {
                $precioServicios += $servicio->precio; // Suma el precio de los servicios seleccionados
            }
        }

        // Guarda el precio total
        $reserva->precio_habitacion = $precioHabitacion;
        $reserva->precio_total = $precioHabitacion + $precioServicios; // Total

        $reserva->save();

        // Redirigir a la página de pago o a otra página de éxito
        return redirect()->route('pago.index', ['reserva' => $reserva->id])->with('success', 'Reserva creada exitosamente.');
    }




    // En ReservaController.php
    public function buscarPorCodigo(Request $request)
    {
        $codigo = $request->input('codigo');

        $reserva = Reserva::where('codigo', $codigo)->first();

        if ($reserva) {
            // Si la reserva existe, mostrar la vista con la información de la reserva y el botón para cancelar
            return view('reservas.mostrar', compact('reserva')); // Asegúrate de crear esta vista
        } else {
            return redirect()->back()->withErrors(['error' => 'No se encontró ninguna reserva con ese código.']);
        }
    }


    // En ReservaController.php
        // En ReservaController.php
    public function cancelar(Reserva $reserva)
    {
        // Verificar que la reserva pueda ser cancelada (por ejemplo, que no haya pasado la fecha de entrada)
        if ($reserva->fecha_entrada < now()) {
            return redirect()->back()->withErrors(['error' => 'No se puede cancelar una reserva que ya ha comenzado.']);
        }

        // Eliminar el registro de disponibilidad asociado a la reserva (corregido)
        DisponibilidadHabitacion::where('habitacion_id', $reserva->habitacion)
                                ->where('fecha_inicio', $reserva->fecha_entrada)
                                ->where('fecha_fin', $reserva->fecha_salida)
                                ->delete();

        // Actualizar el estado de la reserva a "cancelada"
        $reserva->estado = 'cancelada';
        $reserva->save();

        return redirect('/')->with('success', 'Reserva cancelada con éxito.'); 
    }
}
