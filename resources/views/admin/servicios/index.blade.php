<h1>Lista de Servicios Adicionales</h1>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($servicios as $servicio)
            <tr>
                <td>{{ $servicio->nombre }}</td>
                <td>{{ $servicio->descripcion }}</td>
                <td>{{ $servicio->precio }}</td>
                <td>
                    <a href="{{ route('admin.servicios.edit', $servicio) }}">Editar</a>
                    <form action="{{ route('admin.servicios.destroy', $servicio) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('admin.servicios.create') }}">Crear nuevo servicio</a>