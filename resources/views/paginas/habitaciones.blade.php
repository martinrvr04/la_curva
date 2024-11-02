<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
<body>

<header>
    </header>

<section class="habitaciones">
    <div class="container">
        <h2>Nuestras habitaciones</h2>

        @foreach ($habitaciones as $habitacion)
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
                    <a href="{{ route('reservas.create', $habitacion->id) }}" class="btn">Reservar ahora</a>


                </div>
            </div>
        @endforeach

    </div>
</section>

<footer>
    </footer>

</body>
</html>
