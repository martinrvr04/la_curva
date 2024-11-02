<!DOCTYPE html>
<html lang="es">
<head>
    <title>Reserva</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="modal">
        <h2>Reserva - {{ $habitacion->tipo }}</h2>
        <p>Capacidad: {{ $habitacion->capacidad }}</p>
        <p>Precio por noche: ${{ $habitacion->precio_noche }}</p>
        <p>{{ $habitacion->descripcion }}</p>

        <form action="{{ route('reservas.store') }}" method="POST">
            @csrf
            <input type="hidden" name="habitacion_id" value="{{ $habitacion->id }}">
            <label for="fecha_entrada">Fecha de entrada:</label>
            <input type="date" id="fecha_entrada" name="fecha_entrada" required>

            <label for="fecha_salida">Fecha de salida:</label>
            <input type="date" id="fecha_salida" name="fecha_salida" required>

            <label for="num_adultos">Número de adultos:</label>
            <input type="number" id="num_adultos" name="num_adultos" min="1" required>

            <label for="num_niños">Número de niños:</label>
            <input type="number" id="num_niños" name="num_niños" min="0">

            <button type="submit">Confirmar reserva</button>
        </form>
    </div>
</body>
</html>
