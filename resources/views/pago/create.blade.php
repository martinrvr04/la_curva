<!DOCTYPE html>
<html lang="es">
<head>
    <title>Pagar Reserva</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<section class="pago">
    <div class="container">
        <h2>Pagar Reserva - Habitación ID: {{ $habitacionId }}</h2>
        <p>Total a pagar: ${{ $total }}</p>

        <form action="{{ route('pagos.store') }}" method="POST">
            @csrf
            <input type="hidden" name="habitacion_id" value="{{ $habitacionId }}">
            <input type="hidden" name="total" value="{{ $total }}">
            
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="pasarela">Selecciona la Pasarela de Pago:</label>
            <select id="pasarela" name="pasarela" required>
                <option value="pse">PSE</option>
                <option value="paypal">PayPal</option>
                <option value="boacompra">Boacompra</option>
            </select>

            <button type="submit" class="btn">Pagar</button>
        </form>
    </div>
</section>

</body>
</html>
