<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Curva Apartamentos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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
                    <li><a href="#">Explora Valdivia</a></li>
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

    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h2>Bienvenido a La Curva</h2>
                <p>Disfruta de una estancia inolvidable en Valdivia</p>
                <a href="#" class="btn">Reserva ahora</a>
            </div>
        </div>
    </section>

    <section class="habitaciones">
        <div class="container">
            <h2>Nuestras habitaciones</h2>
            <div class="grid">
                <div class="habitacion">
                    <img src="img/habitacion1.jpg" alt="Habitación Doble">
                    <div class="habitacion-info">
                        <h3>Habitación Doble</h3>
                        <p>Descripción de la habitación doble...</p>
                        <a href="#" class="btn">Ver detalles</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="explora">
        <div class="container">
            <h2>Explora Valdivia</h2>
            <div class="grid">
                <div class="lugar">
                    <img src="img/lugar1.jpg" alt="Mercado Fluvial">
                    <div class="lugar-info">
                        <h3>Mercado Fluvial</h3>
                        <p>Descripción del Mercado Fluvial...</p>
                        <a href="#" class="btn">Más información</a>
                    </div>
                </div> 
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2023 La Curva Apartamentos</p>
        </div>
    </footer>

</body>
</html>