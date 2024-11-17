<!DOCTYPE html>
<html>
<head>
    <title>¡Comparte tu experiencia!</title>
</head>
<body>
    <p>Hola,</p>
    <p>Te invitamos a compartir tu experiencia en Hostal La Curva.</p>
<a href="{{ route('reseñas.crear', ['reserva' => $reserva->id]) }}">Dejar una reseña</a>
<p>ID de reserva: {{ $reserva->id }}</p>

</body>
</html>