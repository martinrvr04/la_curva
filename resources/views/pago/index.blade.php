<!DOCTYPE html>
<html lang="es">
<head>
    <title>Pagar Reserva</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<section class="pago">
    <div class="container">
        <h2>Opciones de Pago</h2>
        <p>Total a pagar: ${{ $total }}</p>

        <form action="{{ route('pago.procesar') }}" method="POST">
            @csrf
            <input type="hidden" name="total" value="{{ $total }}">

            <button type="submit" class="btn">Realizar Pago</button>
            <!-- Aquí podrías incluir botones o formularios para las pasarelas de pago -->
        </form>
    </div>
</section>

</body>
</html>
