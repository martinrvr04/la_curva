<h1>Crear nuevo servicio</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.servicios.store') }}" method="POST">
    @csrf
    <div>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
    </div>
    <div>
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion">{{ old('descripcion') }}</textarea>
    </div>
    <div>
        <label for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" value="{{ old('precio') }}" required>
    </div>
    <button type="submit">Crear servicio</button>
</form>