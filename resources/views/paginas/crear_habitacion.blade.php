<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nueva Habitación - La Curva Apartamentos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<header>
    <h1>Agregar Nueva Habitación</h1>
</header>

<section>
    <form action="{{ route('habitaciones.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="numero">Número:</label>
            <input type="text" name="numero" required>
        </div>
        <div>
            <label for="tipo">Tipo:</label>
            <select name="tipo" required>
                <option value="privada">Privada</option>
                <option value="compartida">Compartida</option>
            </select>
        </div>
        <div>
            <label for="capacidad">Capacidad:</label>
            <input type="number" name="capacidad" required>
        </div>
        <div>
            <label for="precio_noche">Precio por noche:</label>
            <input type="text" name="precio_noche" required>
        </div>
        <div>
            <label for="prepago_noche">Prepago por noche:</label>
            <input type="text" name="prepago_noche" required>
        </div>
        <div>
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" required></textarea>
        </div>
        <div>
            <label for="imagenes">Imágenes:</label>
            <input type="file" name="imagenes[]" multiple required>
        </div>
        <button type="submit">Agregar Habitación</button>
    </form>
</section>

<footer>
    <p>&copy; {{ date('Y') }} La Curva Apartamentos</p>
</footer>

</body>
</html>
