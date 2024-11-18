<!DOCTYPE html>
<html lang="es">
<head>
    <title>Pagar Reserva</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet"> 
    <style>
        /* Estilos generales */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #786fa6; /* Color morado */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #54497d; /* Color morado más oscuro al pasar el mouse */
        }

        /* Estilos del encabezado */
        header {
            background-color: #e67e22; /* Color naranja */
            color: #fff;
            padding: 20px 0;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            text-decoration: none;
            color: #fff;
            float: left;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            float: right;
        }

        nav li {
            display: inline-block;
            margin-left: 30px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #f1c40f; /* Color amarillo al pasar el mouse */
        }

        /* Estilos para la sección de pago */
        .pago {
            padding: 50px 0;
        }

        .pago .container {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .pago h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .pago label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold; 
        }

        .pago input[type="text"],
        .pago input[type="email"],
        .pago select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 3px;
            box-sizing: border-box;
        }

        /* Estilos para el footer */
        footer {
            background-color: #e67e22;
            color: #fff;
            padding: 30px 0;
            clear: both; /* Limpiar el float del header */
        }

        footer .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        footer ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        footer li {
            display: inline-block;
            margin: 10px;
        }

        footer .social-links a {
            color: #fff;
            font-size: 24px;
            margin: 0 10px;
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <a href="#" class="logo">La Curva Apartamentos</a>
        <nav>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="{{ route('habitaciones.index') }}">Habitaciones</a></li>
                <li><a href="#">Servicios</a></li>
                <li><a href="#">Contacto</a></li>
                @if (auth()->check())
                    <li>
                        <a href="{{ route('perfil.mis-reservas') }}">Mis reservas</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Cerrar sesión</button>
                        </form>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</header>

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
                <option value="paypal">PayPal</option> 
            </select>

            <button type="submit" class="btn">Pagar</button>
        </form>
    </div>
</section>

<footer>
    <div class="container">
        <p>&copy; 2023 La Curva Apartamentos</p>
        <ul class="social-links">
            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
            <li><a href="#"><i class="fab fa-twitter"></i></a></li>   
        </ul>
    </div>
</footer>

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
                const dni = urlParams.get('dni'); 

                // Redirigir al usuario a la ruta de PayPal, incluyendo todos los datos necesarios
                window.location.href = "{{ route('paypal.create') }}?habitacion_id=" + 
                    document.getElementById('habitacion_id').value + 
                    "&total=" + document.getElementById('total').innerText +
                    "&nombre=" + document.getElementById('nombre').value +
                    "&email=" + document.getElementById('email').value +
                    "&fecha_entrada=" + encodeURIComponent(fechaEntrada) + 
                    "&fecha_salida=" + encodeURIComponent(fechaSalida) + 
                    "&num_adultos=" + numAdultos +  
                    "&num_ninos=" + numNinos +
                    "&dni=" + encodeURIComponent(dni); 

            } else {
                console.log("Enviando formulario para otra pasarela.");
                this.submit(); 
            }
        });
    });
</script>

</body>
</html>