<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Recogida</title>
</head>
<body>
    <h1>Hola {{ $solicitud->nombre_cliente }}</h1>
    <p>Tu solicitud de recogida en el aeropuerto ha sido confirmada.</p>
    <p>Detalles de la solicitud:</p>
    <ul>
        <li>Número de vuelo: {{ $solicitud->numero_vuelo }}</li>
        <li>Hora de llegada: {{ $solicitud->hora_llegada }}</li>
        <li>Monto: {{ $solicitud->monto }}</li>
    </ul>
    <p>Gracias por tu preferencia.</p>
</body>
</html>