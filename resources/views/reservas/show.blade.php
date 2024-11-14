<!DOCTYPE html>
<html>
<head>
  <title>Detalles de la Reserva</title>
</head>
<body>
  <h1>Reserva #{{ $reserva->id }}</h1>

  <p><strong>Habitación:</strong> {{ App\Models\Habitacion::find($reserva->habitacion)->nombre }}</p> 
  <p><strong>Fecha de entrada:</strong> {{ $reserva->fecha_entrada }}</p>
  <p><strong>Fecha de salida:</strong> {{ $reserva->fecha_salida }}</p>
  <p><strong>Precio total:</strong> {{ $reserva->precio_total }}</p>
  <p><strong>Código de reserva:</strong> {{ $reserva->codigo }}</p> 

</body>
</html>