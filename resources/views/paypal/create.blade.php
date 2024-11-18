<!DOCTYPE html>
<html lang="es">
<head>
    <title>Pagar con PayPal</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet"> 
    <style>
        /* Estilos generales */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            display: flex;
            min-height: 100vh;
            flex-direction: column; 
            background-color: #f8f9fa;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 0 20px;
            flex: 1; 
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #28a745; 
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-size: 16px;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #218838;
        }

        /* Estilos del encabezado */
        header {
            background-color: #e67e22; 
            color: #fff;
            padding: 20px 0;
            width: 100%; 
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            text-decoration: none;
            color: #fff;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        nav li {
            display: inline-block;
            margin: 0 15px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #f1c40f;
        }

        /* Estilos para la sección de pago */
        .pago {
            padding: 50px 0;
        }

        .pago .container {
            background-color: #fff;
            border: none;
            padding: 40px; 
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .pago h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .pago p {
            margin-bottom: 15px; 
        }

        .pago pre {
            white-space: pre-wrap; 
            background-color: #eee;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        /* Estilos para el footer */
        footer {
            background-color: #e67e22;
            color: #fff;
            padding: 30px 0;
            width: 100%;
            margin-top: auto;
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
    <div class="container" style="display: flex; align-items: center; justify-content: space-between;"> 
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
            <input type="hidden" name="dni" value="{{ $dni }}"> 
            <button type="submit" class="btn">Pagar con PayPal</button>
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

</body>
</html>