<!DOCTYPE html>
<html lang="es">
<head>
    <title>Pago exitoso</title>
</head>
<body>

<section class="pago">
    <div class="container">
        <h2>Pago exitoso</h2>
        <p>Tu pago se ha realizado correctamente. ¡Gracias!</p>

        <p>Detalles de la reserva:</p>
        <ul>
            <li>ID de la reserva: {{ $reserva->id }}</li>
            <li>Habitación: {{ $reserva->habitacion->nombre }}</li>
            <li>Fecha de inicio: {{ $reserva->fecha_inicio }}</li>
            <li>Fecha de fin: {{ $reserva->fecha_fin }}</li>
            <li>Total: ${{ $reserva->total }}</li>
        </ul>
    </div>
</section>

</body>
</html>