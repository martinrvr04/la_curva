<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;
use App\Models\DisponibilidadHabitacion;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Log; // Importa la fachada Log
use App\Models\Reseña; // Asegúrate de importar el modelo Reseña


class HabitacionController extends Controller
{
    public function index(Request $request)
    {
        // Obtener las fechas de entrada y salida del request
        $fechaEntrada = $request->input('fecha_entrada') ? new DateTime($request->input('fecha_entrada')) : null;
        $fechaSalida = $request->input('fecha_salida') ? new DateTime($request->input('fecha_salida')) : null;

        // Obtener todas las habitaciones
        $habitaciones = Habitacion::all();

        // Filtrar las habitaciones disponibles solo si se proporcionaron fechas
        if ($fechaEntrada && $fechaSalida) {
            $habitacionesDisponibles = $habitaciones->filter(function ($habitacion) use ($fechaEntrada, $fechaSalida) {
                $dias = $fechaEntrada->diff($fechaSalida)->days;
                for ($i = 0; $i <= $dias; $i++) {
                    $fechaActual = clone $fechaEntrada; // Usar clone para copiar la fecha
                    $fechaActual->add(new DateInterval('P' . $i . 'D'));
                    $disponible = DisponibilidadHabitacion::where('habitacion_id', $habitacion->id)
                        ->where('fecha', $fechaActual->format('Y-m-d'))
                        ->where('disponible', true)
                        ->exists();
                    if (!$disponible) {
                        return false; // Si no está disponible en alguna fecha, la habitación no está disponible
                    }
                }
                return true; // Si está disponible en todas las fechas, la habitación está disponible
            });
        } else {
            // Si no se proporcionaron fechas, mostrar todas las habitaciones
            $habitacionesDisponibles = $habitaciones;
        }

        return view('paginas.habitaciones', compact('habitacionesDisponibles', 'fechaEntrada', 'fechaSalida')); 
    }


    public function create()
    {
        // Mostrar el formulario para crear una nueva habitación
        return view('paginas.crear_habitacion'); // Asegúrate de que esta vista exista
    }

    public function store(Request $request)
    {
        // Validar el formulario
        $request->validate([
            'numero' => 'required',
            'tipo' => 'required',
            'capacidad' => 'required|integer',
            'precio_noche' => 'required|numeric',
            'prepago_noche' => 'required|numeric',
            'descripcion' => 'required',
            'imagenes.*' => 'image|mimes:jpg,jpeg,png|max:2048', // Validar cada imagen
        ]);

        // Crear la habitación
        $habitacion = Habitacion::create([
            'numero' => $request->numero,
            'tipo' => $request->tipo,
            'capacidad' => $request->capacidad,
            'precio_noche' => $request->precio_noche,
            'prepago_noche' => $request->prepago_noche,
            'descripcion' => $request->descripcion,
            'disponible' => 1, // O el valor que necesites
        ]);

        // Guardar las imágenes
        if ($request->hasFile('imagenes')) {
            foreach ($request->imagenes as $imagen) {
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('img'), $nombreImagen);
                // Guardar el nombre de la imagen en la tabla imagenes
                $habitacion->imagenes()->create(['nombre' => $nombreImagen]);
            }
        }

        return redirect()->route('habitaciones.index')->with('success', 'Habitación agregada exitosamente.');
    }




    




    public function obtenerReseñas($id)
{
    $habitacion = Habitacion::findOrFail($id);
    $reseñas = $habitacion->reseñas;
    dd($reseñas);
}

    public function show($id)
    {
        $habitacion = Habitacion::findOrFail($id);

        // Obtener las reseñas de la habitación a través de las reservas
        $reseñas = Reseña::whereHas('reserva', function ($query) use ($id) {
            $query->where('habitacion', $id); // Filtra las reservas por el ID de la habitación
        })->get();

        Log::info('Reseñas obtenidas:', $reseñas->toArray());

        // Calcular la calificación promedio general
        $calificacionPromedio = $reseñas->avg('calificacion_general');

        // Calcular el promedio de cada categoría
        $categorias = [
            'personal',
            'limpieza',
            'confort',
            'ubicacion',
            'instalaciones',
            'relacion_calidad_precio',
            'wifi',
        ];
        $promediosCategorias = [];
        Log::info("Reseñas obtenidas:", $reseñas->toArray()); 
        Log::info("Reseñas obtenidas (detalle):", $reseñas->toArray());
        foreach ($categorias as $categoria) {
            $promedio = $reseñas->avg($categoria) * 20; 
            $promediosCategorias[$categoria] = $promedio;
            Log::info("Promedio de $categoria: $promedio"); 
        }

        Log::info("Promedios de categorías:", $promediosCategorias); 

        // Obtener el total de reseñas
        $totalReseñas = $reseñas->count();

        // Pasar los datos a la vista
        return view('paginas.detalle-habitacion', [
            'habitacion' => $habitacion,
            'reseñas' => $reseñas,
            'calificacionPromedio' => $calificacionPromedio,
            'promediosCategorias' => $promediosCategorias,
            'totalReseñas' => $totalReseñas,
            // ... otros datos ...
        ]);
    }
}