<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $habitacion->tipo }}</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<section class="habitacion-detalle">
  <div class="container">
    <h2>{{ $habitacion->tipo }}</h2>

    <div class="habitacion-info">
      <div class="galeria">
        @foreach ($habitacion->imagenes as $imagen)
        <img src="{{ asset('img/' . $imagen->nombre) }}" alt="Imagen de {{ $habitacion->tipo }}">
        @endforeach
      </div>
      <h3>{{ $habitacion->tipo }} - Capacidad: {{ $habitacion->capacidad }}</h3>
      <p>{{ $habitacion->descripcion }}</p>
      <p>Precio por noche: ${{ $habitacion->precio_noche }}</p>


      <a href="{{ route('reservas.create', $habitacion->id) }}" class="btn btn-reservar">Pagar ahora</a></section>

</body>
</html>