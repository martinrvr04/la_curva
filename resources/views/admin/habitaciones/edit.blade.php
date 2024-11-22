<h1>Editar habitación</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.habitaciones.update', $habitacion) }}" method="POST" enctype="multipart/form-data"> 
    @csrf
    @method('PUT')
    <div>
        <label for="numero">Número:</label>
        <input type="text" name="numero" id="numero" value="{{ old('numero', $habitacion->numero) }}" required>
    </div>
    <div>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $habitacion->nombre) }}" required>
    </div>
    <div>
        <label for="tipo">Tipo:</label>
        <select name="tipo" id="tipo" required>
            <option value="privada" {{ old('tipo', $habitacion->tipo) === 'privada' ? 'selected' : '' }}>Privada</option>
            <option value="compartida" {{ old('tipo', $habitacion->tipo) === 'compartida' ? 'selected' : '' }}>Compartida</option>
        </select>
    </div>
    <div>
        <label for="capacidad">Capacidad:</label>
        <input type="number" name="capacidad" id="capacidad" value="{{ old('capacidad', $habitacion->capacidad) }}" required>
    </div>
    <div>
        <label for="precio_noche">Precio por noche:</label>
        <input type="number" name="precio_noche" id="precio_noche" value="{{ old('precio_noche', $habitacion->precio_noche) }}" required>
    </div>
    <div>
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion">{{ old('descripcion', $habitacion->descripcion) }}</textarea>
    </div>
    <div>
        <label for="imagen">Imagen:</label>
        <input type="file" name="imagen" id="imagen">
    </div>
    <button type="submit">Actualizar habitación</button>
</form>