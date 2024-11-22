<h1>Lista de Usuarios</h1>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('admin.usuarios.index') }}" method="GET">
    <input type="text" name="buscar" placeholder="Buscar por nombre o email" value="{{ $buscar }}">
    <button type="submit">Buscar</button>
</form>

<table>
    <thead>
        <tr>
            <th><a href="{{ route('admin.usuarios.index', ['ordenar' => 'nombre', 'direccion' => $direccion == 'asc' ? 'desc' : 'asc', 'buscar' => $buscar]) }}">Nombre</a></th>
            <th><a href="{{ route('admin.usuarios.index', ['ordenar' => 'email', 'direccion' => $direccion == 'asc' ? 'desc' : 'asc', 'buscar' => $buscar]) }}">Email</a></th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->nombre }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->rol }}</td>
                <td>
                    <a href="{{ route('admin.usuarios.edit', $usuario) }}">Editar</a>
                    <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $usuarios->appends(['buscar' => $buscar, 'ordenar' => $ordenar, 'direccion' => $direccion])->links() }}

<a href="{{ route('admin.usuarios.create') }}">Crear nuevo usuario</a>