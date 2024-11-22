<h1>Crear nueva reserva</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.reservas.store') }}" method="POST">
    @csrf
    <div>
        <label for="usuario">Usuario:</label>
        <select name="id" id="usuario" required> 
    @foreach ($usuarios as $usuario)
        <option value="{{ $usuario->id }}" {{ old('id') == $usuario->id ? 'selected' : '' }}> 
        {{ $usuario->id }} - {{ $usuario->nombre }}
        </option>
    @endforeach
</select>
    </div>
    <div>
        <label for="habitacion">Habitación:</label>
        <select name="habitacion" id="habitacion" required>
            @foreach ($habitaciones as $habitacion)
                <option value="{{ $habitacion->id }}" {{ old('habitacion') == $habitacion->id ? 'selected' : '' }}>
                    {{ $habitacion->nombre }} ({{ $habitacion->tipo }})
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="fecha_entrada">Fecha de entrada:</label>
        <input type="date" name="fecha_entrada" id="fecha_entrada" value="{{ old('fecha_entrada') }}" required>
    </div>
    <div>
        <label for="fecha_salida">Fecha de salida:</label>
        <input type="date" name="fecha_salida" id="fecha_salida" value="{{ old('fecha_salida') }}" required>
    </div>
    <div>
        <label for="num_adultos">Número de adultos:</label>
        <input type="number" name="num_adultos" id="num_adultos" value="{{ old('num_adultos', 1) }}" required>
    </div>
    <div>
        <label for="num_ninos">Número de niños:</label>
        <input type="number" name="num_ninos" id="num_ninos" value="{{ old('num_ninos', 0) }}">
    </div>
    <button type="submit">Crear reserva</button>
</form>