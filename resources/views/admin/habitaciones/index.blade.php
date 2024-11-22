<h1>Lista de Habitaciones</h1>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table>
    <thead>
        <tr>
            <th>Número</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Capacidad</th>
            <th>Precio por noche</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($habitaciones as $habitacion)
            <tr>
                <td>{{ $habitacion->numero }}</td>
                <td>{{ $habitacion->nombre }}</td>
                <td>{{ $habitacion->tipo }}</td>
                <td>{{ $habitacion->capacidad }}</td>
                <td>{{ $habitacion->precio_noche }}</td>
                <td>
                    <a href="{{ route('admin.habitaciones.edit', $habitacion) }}">Editar</a>
                    <form action="{{ route('admin.habitaciones.destroy', $habitacion) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('admin.habitaciones.create') }}">Crear nueva habitación</a>