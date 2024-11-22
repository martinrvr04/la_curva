<h1>Editar servicio</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.servicios.update', $servicio) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $servicio->nombre) }}" required>
    </div>
    <div>
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion">{{ old('descripcion', $servicio->descripcion) }}</textarea>
    </div>
    <div>
        <label for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" value="{{ old('precio', $servicio->precio) }}" required>
    </div>
    <button type="submit">Actualizar servicio</button>
</form>