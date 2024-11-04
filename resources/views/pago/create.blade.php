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
        <p>Total a pagar: $<span id="total">{{ $total }}</span></p>

        <form id="payment-form" method="POST" action="{{ route('pagos.store') }}">
            @csrf
            <input type="hidden" name="habitacion_id" id="habitacion_id" value="{{ $habitacionId }}"> 
            <input type="hidden" name="total" value="{{ $total }}">
            <input type="hidden" name="token" id="token">  

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="{{ $nombre }}" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="{{ $email }}" required>

            <label for="pasarela">Selecciona la Pasarela de Pago:</label>
            <select id="pasarela" name="pasarela" required>
                <option value="pse">PSE</option>
                <option value="paypal">PayPal</option> 
            </select>

            <button type="submit" class="btn">Pagar</button>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() { 
        console.log("DOM cargado correctamente.");

        document.getElementById('payment-form').addEventListener('submit', function(e) {
            e.preventDefault(); 
            console.log("Formulario enviado.");

            const pasarela = document.getElementById('pasarela').value;
            console.log("Pasarela seleccionada:", pasarela);

            if (pasarela === 'paypal') { 
                console.log("Procesando pago con PayPal.");

                // Obtener los parámetros de la URL
                const urlParams = new URLSearchParams(window.location.search);
                const fechaEntrada = urlParams.get('fecha_entrada');
                const fechaSalida = urlParams.get('fecha_salida');
                const numAdultos = urlParams.get('num_adultos');
                const numNinos = urlParams.get('num_ninos');
                const dni = urlParams.get('dni'); // Obtener el DNI de la URL

                // Redirigir al usuario a la ruta de PayPal, incluyendo todos los datos necesarios, incluyendo el DNI
                window.location.href = "{{ route('paypal.create') }}?habitacion_id=" + 
                    document.getElementById('habitacion_id').value + 
                    "&total=" + document.getElementById('total').innerText +
                    "&nombre=" + document.getElementById('nombre').value +
                    "&email=" + document.getElementById('email').value +
                    "&fecha_entrada=" + encodeURIComponent(fechaEntrada) + 
                    "&fecha_salida=" + encodeURIComponent(fechaSalida) + 
                    "&num_adultos=" + numAdultos +  
                    "&num_ninos=" + numNinos +
                    "&dni=" + encodeURIComponent(dni); // Incluir el DNI en la URL

            } else {
                console.log("Enviando formulario para otra pasarela.");
                this.submit(); 
            }
        });
    });
</script>

</body>
</html>