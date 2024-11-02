<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Servicios Adicionales</title>
</head>
<body>
    <div class="container">
        <h1>Servicios Adicionales</h1>
        <a href="{{ route('servicios.create') }}" class="btn">Agregar Servicio</a>
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
                @foreach($servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->nombre }}</td>
                        <td>{{ $servicio->descripcion }}</td>
                        <td>{{ $servicio->precio }}</td>
                        <td>
                            <a href="{{ route('servicios.edit', $servicio) }}">Editar</a>
                            <form action="{{ route('servicios.destroy', $servicio) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
