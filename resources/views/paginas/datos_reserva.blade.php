<!DOCTYPE html>
<html lang="es">
<head>
    <title>Reserva</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Estilos generales */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #786fa6; /* Color morado */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #54497d; /* Color morado más oscuro al pasar el mouse */
        }

        /* Estilos del encabezado */
        header {
            background-color: #e67e22; /* Color naranja */
            color: #fff;
            padding: 20px 0;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            text-decoration: none;
            color: #fff;
            float: left;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            float: right;
        }

        nav li {
            display: inline-block;
            margin-left: 30px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #f1c40f; /* Color amarillo al pasar el mouse */
        }

        /* Estilos para la sección de reserva */
        .reserva {
            padding: 50px 0;
        }

        .reserva .habitacion-info {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Estilos para el formulario */
        #reserva-form {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Dos columnas */
            gap: 20px;
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        #reserva-form input[type="text"],
        #reserva-form input[type="email"],
        #reserva-form input[type="number"],
        #reserva-form input[type="date"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        #reserva-form label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Estilos para el Modal */
        .modal {
            display: none; /* Ocultar por defecto */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4); /* Fondo oscuro */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Ancho del modal */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Estilos para el footer */
        footer {
            background-color: #e67e22;
            color: #fff;
            padding: 30px 0;
            clear: both; /* Limpiar el float del header */
        }

        footer .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        footer ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        footer li {
            display: inline-block;
            margin: 10px;
        }

        footer .social-links a {
            color: #fff;
            font-size: 24px;
            margin: 0 10px;
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <a href="#" class="logo">La Curva Apartamentos</a>
        <nav>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="{{ route('habitaciones.index') }}">Habitaciones</a></li>
                <li><a href="#">Servicios</a></li>
                <li><a href="#">Contacto</a></li>
                @if (auth()->check())
                    <li>
                        <a href="{{ route('perfil.mis-reservas') }}">Mis reservas</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Cerrar sesión</button>
                        </form>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</header>

<section class="reserva">
    <div class="container">
        <h2>Datos de la Reserva</h2>

        <div class="habitacion-info">
            <h2>{{ $habitacion->nombre }}</h2>
            <h3>{{ $habitacion->tipo }} - Capacidad: {{ $habitacion->capacidad }}</h3>
            <p>Precio por noche: $<span id="precio-noche">{{ $habitacion->precio_noche }}</span></p>
            <p>Desde: <span id="fecha-entrada-text"></span> Hasta: <span id="fecha-salida-text"></span></p>
            <p>Total: $<span id="total">0</span></p>
        </div>

        <form id="reserva-form" action="{{ route('reservas.store') }}" method="POST">
            @csrf

            <input type="hidden" name="habitacion_id" id="habitacion_id" value="{{ $habitacion->id }}">
            <input type="hidden" name="fecha_entrada" id="hidden_fecha_entrada" value="">
            <input type="hidden" name="fecha_salida" id="hidden_fecha_salida" value="">
            <input type="hidden" name="precio_habitacion" id="precio_habitacion" value="{{ $habitacion->precio_noche }}">


            <label for="fecha_entrada">Fecha de Entrada:</label>
            <input type="text" id="fecha_entrada" name="fecha_entrada" required>

            <label for="fecha_salida">Fecha de Salida:</label>
            <input type="text" id="fecha_salida" name="fecha_salida" required>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="dni">DNI o Pasaporte:</label>
            <input type="text" id="dni" name="dni" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="num_adultos">Número   
 de Adultos:</label>
            <input type="number" id="num_adultos" name="num_adultos" min="1" value="1" required>

            <label for="num_ninos">Número de Niños:</label>
            <input type="number" id="num_ninos" name="num_ninos" min="0" value="0" required>

            <button type="button" class="btn" id="agregar-servicios">Agregar Servicios Adicionales</button>
            <button type="button" class="btn" id="pagar-btn">Pagar</button>
        </form>
    </div>
</section>

<div id="modal-servicios" class="modal">
    <div class="modal-content">
        <span class="close" id="close-modal">&times;</span>
        <h2>Selecciona Servicios Adicionales</h2>
        <div id="servicios-adicionales">
            @foreach($serviciosAdicionales as $servicio)
                <div>
                    <input type="checkbox" class="servicio" id="servicio-{{ $servicio->id }}" data-precio="{{ $servicio->precio }}">
                    <label for="servicio-{{ $servicio->id }}">{{ $servicio->nombre }} - ${{ $servicio->precio }}</label>
                </div>
            @endforeach
        </div>
        <button id="confirmar-servicios">Confirmar Selección</button>
    </div>
</div>

<footer>
    <div class="container">
        <p>&copy; 2023 La Curva Apartamentos</p>
        <ul class="social-links">
            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
            <li><a href="#"><i class="fab fa-twitter"></i></a></li>   
  

        </ul>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    const precioNoche = parseFloat(document.getElementById('precio-noche').innerText);
    let total = 0;

    // Inicializar flatpickr para las fechas de entrada y salida
    flatpickr("#fecha_entrada", {
        dateFormat: "Y-m-d",
        onChange: function(selectedDates) {
            const fechaEntrada = selectedDates[0];
            document.getElementById('fecha-entrada-text').innerText = fechaEntrada.toLocaleDateString('es-ES');
            document.getElementById('hidden_fecha_entrada').value = fechaEntrada.toISOString().split('T')[0];
            calcularTotal();
        },
    });

    flatpickr("#fecha_salida", {
        dateFormat: "Y-m-d",
        onChange: function(selectedDates) {
            const fechaSalida = selectedDates[0];
            document.getElementById('fecha-salida-text').innerText = fechaSalida.toLocaleDateString('es-ES');
            document.getElementById('hidden_fecha_salida').value = fechaSalida.toISOString().split('T')[0];
            calcularTotal();
        },
    });

    // Agregar event listeners para los cambios en los campos de fecha
    document.getElementById('fecha_entrada').addEventListener('change', calcularTotal);
    document.getElementById('fecha_salida').addEventListener('change', calcularTotal);

    // Mostrar el modal de servicios al hacer clic
    document.getElementById('agregar-servicios').addEventListener('click', function() {
        document.getElementById('modal-servicios').style.display = "block"; // Mostrar el modal
    });

    // Cerrar el modal de servicios
    document.getElementById('close-modal').onclick = function() {
        document.getElementById('modal-servicios').style.display = "none";
    };

    // Confirmar la selección de servicios
    document.getElementById('confirmar-servicios').onclick = function() {
        document.getElementById('modal-servicios').style.display = "none";
        calcularTotal(); // Calcular el total cuando se confirman los servicios
    };

    // Cerrar el modal de servicios al hacer clic fuera de él
    window.onclick = function(event) {
        if (event.target == document.getElementById('modal-servicios')) {
            document.getElementById('modal-servicios').style.display = "none";
        }
    };

    // Redirigir a la vista de pago al hacer clic en "Pagar"
    document.getElementById('pagar-btn').addEventListener('click', function() {

        const habitacionId = document.querySelector('input[name="habitacion_id"]').value;
        const total = document.getElementById('total').innerText;
        const fechaEntrada = document.getElementById('hidden_fecha_entrada').value;
        const fechaSalida = document.getElementById('hidden_fecha_salida').value;
        const nombre = document.getElementById('nombre').value;
        const email = document.getElementById('email').value;
        const numAdultos = document.getElementById('num_adultos').value;
        const numNinos = document.getElementById('num_ninos').value;
        const dni = document.getElementById('dni').value; // Obtener el valor del DNI


        const xhr = new XMLHttpRequest();
        xhr.open('GET', `/habitaciones/disponibilidad?habitacion_id=${habitacionId}&fecha_entrada=${fechaEntrada}&fecha_salida=${fechaSalida}`);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.disponible) {
                    // La habitación está disponible, puedes redirigir o continuar con el proceso de pago
                    window.location.href = `{{ route('pagos.create') }}?habitacion_id=${habitacionId}&total=${total}&nombre=${nombre}&email=${email}&fecha_entrada=${fechaEntrada}&fecha_salida=${fechaSalida}&num_adultos=${numAdultos}&num_ninos=${numNinos}&dni=${dni}`; 
                } else {
                    // Mostrar mensaje de error en la misma página
                    alert("La habitación no está disponible en las fechas seleccionadas.");
                }
            } else {
                console.error("Error al verificar la disponibilidad.");
                alert("Hubo un error al procesar tu solicitud. Por favor, inténtalo de nuevo más tarde.");
            }
        };
        xhr.send();



        // Log de las fechas y total antes de redirigir
        console.log("Habitación ID:", habitacionId);
        console.log("Total a pagar:", total);
        console.log("Fecha de entrada:", fechaEntrada);
        console.log("Fecha de salida:", fechaSalida);

        // Comprobar si las fechas son válidas
        if (!fechaEntrada || !fechaSalida) {
            alert("Por favor, seleccione ambas fechas antes de continuar.");
            return; // No redirigir si las fechas no son válidas
        }

    });

    function calcularTotal() {
        const fechaEntrada = new Date(document.getElementById('fecha_entrada').value);
        const fechaSalida = new Date(document.getElementById('fecha_salida').value);

        if (fechaEntrada && fechaSalida && fechaSalida > fechaEntrada) {
            const diffTime = Math.abs(fechaSalida - fechaEntrada);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // Convirtiendo milisegundos a días
            total = diffDays * precioNoche; // Calcular costo total de la habitación

            // Sumar el costo de los servicios adicionales
            const serviciosSeleccionados = document.querySelectorAll('.servicio:checked');
            serviciosSeleccionados.forEach(servicio => {
                total += parseFloat(servicio.dataset.precio);
            });
        } else {
            total = 0; // Si no hay fechas válidas, total es 0
        }

        document.getElementById('total').innerText = total.toFixed(2); // Mostrar total en la vista
    }
</script>

</body>
</html>

