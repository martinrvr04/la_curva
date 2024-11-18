<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestras Habitaciones - La Curva Apartamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet"> 
    <style>
        /* Estilos generales */
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f4f4; 
            color: #333; 
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            color: #3498db; 
        }

        /* Estilos para el navbar */
        .navbar {
            background-color: #3498db;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #fff !important;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
        }

        /* Estilos para el footer */
        footer {
            background-color: #333;
            color: #fff;
            padding: 10px 0; 
            text-align: center;
        }

        /* Estilos del filtro */
        .filtro {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .filtro-item {
            margin-bottom: 20px;
        }

        .filtro label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .filtro input[type="date"],
        .filtro input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px; 
            box-sizing: border-box;
        }

        .filtro button {
            background-color: #3498db; 
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px; 
            cursor: pointer;
            transition: background-color 0.3s ease; 
        }

        .filtro button:hover {
            background-color: #2980b9; 
        }

        /* Estilos de la lista de habitaciones */
        .lista-habitaciones {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            grid-gap: 20px;
            margin-top: 30px;
        }

        .habitacion {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: box-shadow 0.3s ease; 
        }

        .habitacion:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
        }

        /* Estilos del carrusel */
        .carousel-item img {
            width: 100%;
            height: 350px; 
            object-fit: cover;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            transition: opacity 0.3s ease; 
        }

        .carousel-item img:hover {
            opacity: 0.8; 
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
        }

        .carousel-indicators [data-bs-target] {
            background-color: #3498db; 
            opacity: 0.8;
        }

        .habitacion-info {
            padding: 20px;
        }

        .habitacion-info h3 {
            margin-bottom: 10px;
        }

        .habitacion-info ul {
            list-style: none;
            padding: 0;
            margin-bottom: 10px;
        }

        .precio {
            font-size: 18px;
            font-weight: bold;
            color: #3498db; 
        }

        .btn-reservar {
            display: block;
            background-color: #e67e22; 
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            margin-top: 10px; 
            transition: background-color 0.3s ease;
        }

        .btn-reservar:hover {
            background-color: #d35400; 
        }

        .btn-info {
            display: block;
            background-color: #3498db; 
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .btn-info:hover {
            background-color: #2980b9; 
        }

        /* Centrar botones en la tarjeta */
        .habitacion-info a {
            display: inline-block; 
            width: 48%; 
            margin: 10px 1%; 
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">La Curva Apartamentos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Habitaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="habitaciones">
        <div class="container">
            <h2>Nuestras habitaciones</h2>

            <form action="{{ route('habitaciones.buscar') }}" method="GET" class="filtro">
                <div class="row">
                    <div class="col-md-3 filtro-item">
                        <label for="fecha_entrada">Fecha de entrada:</label>
                        <input type="date" id="fecha_entrada" name="fecha_entrada">
                    </div>
                    <div class="col-md-3 filtro-item">
                        <label for="fecha_salida">Fecha de salida:</label>
                        <input type="date" id="fecha_salida" name="fecha_salida">
                    </div>
                    <div class="col-md-3 filtro-item">
                        <label for="precio_min">Precio mínimo:</label>
                        <input type="number" id="precio_min" name="precio_min">
                    </div>
                    <div class="col-md-3 filtro-item">
                        <label for="precio_max">Precio máximo:</label>
                        <input type="number" id="precio_max" name="precio_max">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Buscar habitaciones</button>
                    </div>
                </div>
            </form>

            <div class="lista-habitaciones">
                @foreach ($habitacionesDisponibles as $habitacion)
                <div class="habitacion">
                    <div id="carousel{{ $habitacion->id }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($habitacion->imagenes as $index => $imagen)
                            <button type="button" data-bs-target="#carousel{{ $habitacion->id }}" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $index + 1 }}">
                            </button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach ($habitacion->imagenes as $index => $imagen)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset('img/' . $imagen->nombre) }}" class="d-block w-100" alt="Imagen de {{ $habitacion->tipo }}">
                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $habitacion->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $habitacion->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                    <div class="habitacion-info">
                    <h3>{{ $habitacion->nombre }} {{ $habitacion->numero }}</h3> 
                        <h4>{{ $habitacion->tipo }} - Capacidad: {{ $habitacion->capacidad }}</h4>
                        <p>{{ $habitacion->descripcion }}</p>
                        <ul>
                            <li>Precio por noche: ${{ $habitacion->precio_noche }}</li>
                            <li>Prepago por noche: ${{ $habitacion->prepago_noche }}</li>
                        </ul>
                        <p class="precio">Desde ${{ $habitacion->precio_noche }} por noche</p>
                        <a href="{{ route('reservas.create', $habitacion->id) }}" class="btn btn-reservar">Reservar ahora</a>
                        <a href="{{ route('habitaciones.show', $habitacion->id) }}" class="btn btn-info">Ver detalles</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2023 La Curva Apartamentos</p> 
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>