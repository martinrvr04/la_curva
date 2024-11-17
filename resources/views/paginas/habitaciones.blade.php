<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestras Habitaciones</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Estilos del filtro */
        .filtro {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #f8f8f8;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .filtro-item {
            margin-right: 20px;
        }

        .filtro label {
            display: block;
            margin-bottom: 5px;
        }

        .filtro input[type="date"],
        .filtro input[type="number"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .filtro button {
            background-color: #007bff; /* Color azul */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Estilos de la lista de habitaciones */
        .lista-habitaciones {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            grid-gap: 20px;
        }

        .habitacion {
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
        }

        .habitacion img {
            width: 100%;
            height: 200px;
            object-fit: cover;
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
            color: #007bff;
        }

        .btn-reservar {
            display: block;
            background-color: #28a745; /* Color verde */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<section class="habitaciones">
    <div class="container">
        <h2>Nuestras habitaciones</h2>

        <form action="{{ route('habitaciones.buscar') }}" method="GET" class="filtro">
            <div class="filtro-item">
                <label for="fecha_entrada">Fecha de entrada:</label>
                <input type="date" id="fecha_entrada" name="fecha_entrada">
            </div>
            <div class="filtro-item">
                <label for="fecha_salida">Fecha de salida:</label>
                <input type="date" id="fecha_salida" name="fecha_salida">
            </div>
            <div class="filtro-item">
                <label for="precio_min">Precio mínimo:</label>
                <input type="number" id="precio_min" name="precio_min">
            </div>
            <div class="filtro-item">
                <label for="precio_max">Precio máximo:</label>
                <input type="number" id="precio_max" name="precio_max">
            </div>
            <button type="submit">Buscar habitaciones</button>
        </form>

        <div class="lista-habitaciones">
            @foreach ($habitacionesDisponibles as $habitacion)
                <div class="habitacion">
                    <div class="galeria">
                        @foreach ($habitacion->imagenes as $imagen)
                            <img src="{{ asset('img/' . $imagen->nombre) }}" alt="Imagen de {{ $habitacion->tipo }}">
                        @endforeach
                    </div>
                    <div class="habitacion-info">
                        <h3>{{ $habitacion->tipo }} - Capacidad: {{ $habitacion->capacidad }}</h3>
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

</body>
</html>