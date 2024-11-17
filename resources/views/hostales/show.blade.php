<h1>{{ $hostal->nombre }}</h1> 

<h2>Comentarios de clientes</h2>

@foreach ($hostal->resenas as $resena) 
    <div class="reseña">
        <p>Calificación general: {{ $resena->calificacion_general }}</p>
        <p>{{ $resena->comentario }}</p>

        <div class="categorias">
            <p>Limpieza: 
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ $resena->limpieza * 10 }}%;" aria-valuenow="{{ $resena->limpieza }}" aria-valuemin="0" aria-valuemax="10"></div>
                </div>
            </p>
            {{-- Repite para las demás categorías: confort, ubicación, instalaciones, personal, relación calidad-precio y wifi --}}
        </div>
    </div>
@endforeach

{{-- Incluye el formulario de reseñas si el usuario está autenticado y tiene una reserva en este hostal --}}
@if (auth()->check() && $usuarioTieneReserva)
    <h3>Deja tu reseña</h3>
    @include('resenas.create', ['reserva' => $reserva]) 
@endif