<h2>Reserva #{{ $reserva->id }}</h2>
<p>Código: {{ $reserva->codigo }}</p>
<p>Habitación: {{ $reserva->habitacion }}</p> 
<p>Fecha de entrada: {{ $reserva->fecha_entrada }}</p>
<p>Fecha de salida: {{ $reserva->fecha_salida }}</p>
<p>Estado: {{ $reserva->estado }}</p>

<a href="{{ route('reservas.cancelar', $reserva->id) }}" onclick="return confirm('¿Estás seguro de que quieres cancelar esta reserva?')">Cancelar reserva</a>