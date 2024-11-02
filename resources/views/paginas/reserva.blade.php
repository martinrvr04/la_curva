<!-- resources/views/paginas/reserva.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<section class="reserva">
    <div class="container">
        <h2>Reserva de Habitación</h2>
        
        <!-- Muestra la información de la habitación -->
        <div class="habitacion-info">
            <h3>{{ $habitacion->tipo }} - Capacidad: {{ $habitacion->capacidad }}</h3>
            <p>{{ $habitacion->descripcion }}</p>
            <p>Precio por noche: ${{ $habitacion->precio_noche }}</p>
        </div>

        <!-- Formulario para seleccionar fechas de entrada y salida -->
        <form action="{{ route('reservas.datos') }}" method="GET">
            <input type="hidden" name="habitacion_id" value="{{ $habitacion->id }}">

            <label for="fecha_entrada">Fecha de Entrada:</label>
            <input type="date" name="fecha_entrada" required>

            <label for="fecha_salida">Fecha de Salida:</label>
            <input type="date" name="fecha_salida" required>

            <button type="submit" class="btn">Siguiente</button>
        </form>
    </div>
</section>

</body>
</html>
