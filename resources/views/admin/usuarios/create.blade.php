<h1>Crear nuevo usuario</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.usuarios.store') }}" method="POST">
    @csrf
    <div>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
    </div>
    <div>
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" value="{{ old('apellido') }}" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>
    </div>
    <div>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div>
        <label for="password_confirmation">Confirmar contraseña:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
    </div>
    <div>
        <label for="rol">Rol:</label>
        <select name="rol" id="rol" required>
            <option value="cliente" {{ old('rol') === 'cliente' ? 'selected' : '' }}>Cliente</option>
            <option value="administrador" {{ old('rol') === 'administrador' ? 'selected' : '' }}>Administrador</option>
            </select>
    </div>
    <button type="submit">Crear usuario</button>
</form>