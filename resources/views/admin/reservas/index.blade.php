<h1>Lista de Reservas</h1>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table>
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Habitación</th>
            <th>Fecha de entrada</th>
            <th>Fecha de salida</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reservas as $reserva)
            <tr>
                <td>
                    @if (is_object($reserva->usuario))
                        {{ $reserva->usuario->nombre }}
                    @else
                        Usuario ID: {{ $reserva->usuario }} 
                    @endif
                </td>
                <td>
                    @if (is_object($reserva->habitacion))
                        {{ $reserva->habitacion->nombre }}
                    @else
                        Habitación ID: {{ $reserva->habitacion }}
                    @endif
                </td>
                <td>{{ $reserva->fecha_entrada }}</td>
                <td>{{ $reserva->fecha_salida }}</td>
                <td>{{ $reserva->estado }}</td>
                <td>
                    <a href="{{ route('admin.reservas.edit', $reserva) }}">Editar</a>
                    <form action="{{ route('admin.reservas.destroy', $reserva) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form> 1 
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('admin.reservas.create') }}">Crear nueva reserva</a>