<!-- resources/views/servicios/create.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Servicio Adicional</title>
</head>
<body>
    <h1>Crear Servicio Adicional</h1>
    <form action="{{ route('servicios.store') }}" method="POST">
        @csrf
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion"></textarea>
        
        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>
