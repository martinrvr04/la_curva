<ul>
    @foreach ($reservas as $reserva)
        <li>
            <h3>Reserva #{{ $reserva->id }}</h3>
            <p>Habitación: {{ $habitaciones[$reserva->habitacion] }}</p> 
            <p>Fecha de entrada: {{ $reserva->fecha_entrada }}</p>
            <p>Fecha de salida: {{ $reserva->fecha_salida }}</p>
            @if ($reserva->fecha_salida < now()) 
                <a href="{{ route('reseñas.create', ['reserva' => $reserva->id]) }}" class="btn">Dejar reseña</a>
            @endif
        </li>
    @endforeach
</ul>