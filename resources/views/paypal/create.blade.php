<!DOCTYPE html>
<html lang="es">
<head>
    <title>Pagar con PayPal</title>
</head>
<body>

<section class="pago">
    <div class="container">
        <h2>Pagar Reserva - Habitación ID: {{ $habitacionId }}</h2>
        <p>Total a pagar: ${{ $total }}</p>

        @if(session('paypal_order'))
            <h2>Detalles de la Orden:</h2>
            <pre>{{ print_r(session('paypal_order'), true) }}</pre>
            <a href="{{ session('paypal_order')->result->links[1]->href }}" class="btn">Continuar con PayPal</a> 
        @endif

        <form method="POST" action="{{ route('paypal.store') }}">
            @csrf
            <input type="hidden" name="habitacion_id" value="{{ $habitacionId }}">
            <input type="hidden" name="total" value="{{ $total }}">
            <input type="hidden" name="nombre" value="{{ $nombre }}"> 
            <input type="hidden" name="email" value="{{ $email }}"> 
            <input type="hidden" name="fecha_entrada" value="{{ $fechaEntrada }}"> 
            <input type="hidden" name="fecha_salida" value="{{ $fechaSalida }}"> 
            <input type="hidden" name="num_adultos" value="{{ $numAdultos }}"> 
            <input type="hidden" name="num_ninos" value="{{ $numNinos }}">
            <input type="hidden" name="dni" value="{{ $dni }}">  <button type="submit" class="btn">Pagar con PayPal</button>
        </form>

    </div>
</section>

</body>
</html>