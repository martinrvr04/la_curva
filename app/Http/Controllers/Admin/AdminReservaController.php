<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Habitacion;
use Illuminate\Http\Request;
use Carbon\Carbon; 


class AdminReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with('usuario', 'habitacion')->get();
        return view('admin.reservas.index', ['reservas' => $reservas]);
    }

    public function create()
    {
        $usuarios = User::all();
        $habitaciones = Habitacion::where('disponible', true)->get(); 
        return view('admin.reservas.create', ['usuarios' => $usuarios, 'habitaciones' => $habitaciones]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:usuarios,id', 
            'habitacion' => 'required|exists:habitaciones,id',
            'fecha_entrada' => 'required|date|after_or_equal:today',
            'fecha_salida' => 'required|date|after:fecha_entrada',
            'num_adultos' => 'required|integer|min:1',
            'num_ninos' => 'nullable|integer|min:0',
        ]);

        $habitacion = Habitacion::find($request->habitacion);

        $fechaEntrada = Carbon::parse($request->fecha_entrada);
        $fechaSalida = Carbon::parse($request->fecha_salida);

        $precioTotal = $habitacion->precio_noche * $fechaSalida->diffInDays($fechaEntrada); 

        $reserva = new Reserva;
        $reserva->usuario()->associate(Usuario::find($request->id));  // Correcto
        $reserva->habitacion()->associate(Habitacion::find($request->habitacion));
        $reserva->fecha_entrada = $request->fecha_entrada;
        $reserva->fecha_salida = $request->fecha_salida;
        $reserva->num_adultos = $request->num_adultos;
        $reserva->num_ninos = $request->num_ninos;
        $reserva->precio_total = $precioTotal;
        // ... otros campos ...
        $reserva->save();

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva creada correctamente.');
    }

    public function edit(Reserva $reserva)
    {
        $usuarios = User::all();
        $habitaciones = Habitacion::where('disponible', true)
                                  ->orWhere('id', $reserva->habitacion)
                                  ->get();
        return view('admin.reservas.edit', ['reserva' => $reserva, 'usuarios' => $usuarios, 'habitaciones' => $habitaciones]);
    }

    public function update(Request $request, Reserva $reserva)
    {
        $request->validate([
            'id' => 'required|exists:usuarios,id', 
            'habitacion' => 'required|exists:habitaciones,id',
            'fecha_entrada' => 'required|date',
            'fecha_salida' => 'required|date|after:fecha_entrada',
            'num_adultos' => 'required|integer|min:1',
            'num_ninos' => 'nullable|integer|min:0',
        ]);

        $habitacion = Habitacion::find($request->habitacion);

        $fechaEntrada = Carbon::parse($request->fecha_entrada);
        $fechaSalida = Carbon::parse($request->fecha_salida);

        $precioTotal = $habitacion->precio_noche * $fechaSalida->diffInDays($fechaEntrada); 

        $reserva->usuario()->associate(Usuario::find($request->id)); // Correcto
        $reserva->habitacion()->associate(Habitacion::find($request->habitacion));
        $reserva->fecha_entrada = $request->fecha_entrada;
        $reserva->fecha_salida = $request->fecha_salida;
        $reserva->num_adultos = $request->num_adultos;
        $reserva->num_ninos = $request->num_ninos;
        $reserva->precio_total = $precioTotal;
        // ... otros campos ...
        $reserva->save(); 

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva actualizada correctamente.');
    }

    public function destroy(Reserva $reserva)
    {
        $reserva->delete();
        return redirect()->route('admin.reservas.index')->with('success', 'Reserva eliminada correctamente.');
    }
}