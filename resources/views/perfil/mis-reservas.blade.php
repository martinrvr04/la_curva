<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" 
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" 
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 960px; 
            margin: 0 auto; 
            padding: 20px;
        }

        .lista-reservas {
            list-style: none; /* Quita los puntos de la lista */
            padding: 0;
        }

        .lista-reservas li {
            background-color: #fff;
            border: 1px solid #dee2e6;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 15px; 
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Agrega una sombra sutil */
        }

        .lista-reservas h3 {
            font-size: 1.4rem;
            margin-bottom: 10px;
        }

        .lista-reservas p {
            font-size: 1rem;
            line-height: 1.6;
            color: #6c757d; 
        }

        .btn {
            background-color: #007bff; 
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s ease; 
        }

        .btn:hover {
            background-color: #0056b3; 
        }

        /* Estilos para el navbar */
        .navbar {
            background-color: #f8f9fa; 
            padding: 10px 20px;
            border-bottom: 1px solid #dee2e6;
        }

        .navbar-brand {
            font-weight: 600; 
        }

        .navbar-nav .nav-link {
            color: #343a40; 
        }

        /* Estilos para el footer */
        footer {
            background-color: #343a40; 
            color: #fff;
            padding: 20px 0;
            text-align: center; 
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">Nombre del Hotel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto"> 
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Habitaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="mis-reservas">
        <div class="container">
            <h2>Mis Reservas</h2>
            <ul class="lista-reservas">
                @foreach ($reservas as $reserva)
                    <li>
                        <h3>Reserva #{{ $reserva->id }}</h3>
                        <p>Habitación: {{ isset($habitaciones[$reserva->habitacion]) ? $habitaciones[$reserva->habitacion] : 'Habitación no encontrada' }}</p>
                        <p>Fecha de entrada: {{ $reserva->fecha_entrada }}</p>
                        <p>Fecha de salida: {{ $reserva->fecha_salida }}</p>
                        @if ($reserva->fecha_salida < now()) 
                            <a href="{{ route('reseñas.create', ['reserva' => $reserva->id]) }}" class="btn btn-primary">Dejar reseña</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2023 Nombre del Hotel. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>