<!DOCTYPE html>
<html lang="es">
<head>
    <title>Pagar Reserva</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h2>Pagar Reserva - {{ $habitacion->tipo }}</h2>
        <p>Precio Total: $<span id="total">{{ $total }}</span></p>

        <form action="{{ route('pagos.store') }}" method="POST">
            @csrf
            <input type="hidden" name="habitacion_id" value="{{ $habitacion->id }}">
            <input type="hidden" name="total" value="{{ $total }}">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit" class="btn">Pagar</button>
        </form>
    </div>
</body>
</html>
