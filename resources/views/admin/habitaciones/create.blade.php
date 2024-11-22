<h1>Crear nueva habitación</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.habitaciones.store') }}" method="POST" enctype="multipart/form-data"> 
    @csrf
    <div>
        <label for="numero">Número:</label>
        <input type="text" name="numero" id="numero" value="{{ old('numero') }}" required>
    </div>
    <div>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
    </div>
    <div>
        <label for="tipo">Tipo:</label>
        <select name="tipo" id="tipo" required>
            <option value="privada" {{ old('tipo') === 'privada' ? 'selected' : '' }}>Privada</option>
            <option value="compartida" {{ old('tipo') === 'compartida' ? 'selected' : '' }}>Compartida</option>
            <option value="individual" {{ old('tipo') === 'individual' ? 'selected' : '' }}>individual</option>
            <option value="doble" {{ old('tipo') === 'doble' ? 'selected' : '' }}>doble</option>

        </select>
    </div>
    <div>
        <label for="capacidad">Capacidad:</label>
        <input type="number" name="capacidad" id="capacidad" value="{{ old('capacidad') }}" required>
    </div>
    <div>
        <label for="precio_noche">Precio por noche:</label>
        <input type="number" name="precio_noche" id="precio_noche" value="{{ old('precio_noche') }}" required>
    </div>
    <div>
        <label for="prepago_noche">Prepago por noche:</label>
        <input type="number" name="prepago_noche" id="prepago_noche" value="{{ old('prepago_noche') }}">
    </div>
    <div>
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion">{{ old('descripcion') }}</textarea>
    </div>
    <div>
        <label for="imagenes">Imágenes:</label>
        <input type="file" name="imagenes[]" id="imagen" multiple> 
    </div>
    <button type="submit">Crear habitación</button>
</form>