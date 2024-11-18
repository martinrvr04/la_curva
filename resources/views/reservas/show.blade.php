<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalles de la Reserva</title>
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

        h1, h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
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

        /* Estilos para la sección de detalles */
        .detalles {
            padding: 50px 0;
            text-align: center;
        }

        .detalles .container {
            background-color: #fff;
            border: none;
            padding: 40px; 
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .detalles p {
            margin-bottom: 15px; 
            text-align: left;
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
                <li><a href="#">Habitaciones</a></li>
                <li><a href="#">Servicios</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </nav>
    </div>
</header>

<section class="detalles">
    <div class="container">
        <h1>Reserva #{{ $reserva->id }}</h1>

        <p><strong>Habitación:</strong> {{ App\Models\Habitacion::find($reserva->habitacion)->nombre }}</p> 
        <p><strong>Fecha de entrada:</strong> {{ $reserva->fecha_entrada }}</p>
        <p><strong>Fecha de salida:</strong> {{ $reserva->fecha_salida }}</p>
        <p><strong>Precio total:</strong> {{ $reserva->precio_total }}</p>
        <p><strong>Código de reserva:</strong> {{ $reserva->codigo }}</p> 
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