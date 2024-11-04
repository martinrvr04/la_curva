<!DOCTYPE html>
<html lang="es">
<head>
    <title>Reserva</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
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
    </style>
</head>
<body>

<section class="reserva">
    <div class="container">
        <h2>Datos de la Reserva</h2>

        <div class="habitacion-info">
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

            <label for="num_adultos">Número de Adultos:</label>
            <input type="number" id="num_adultos" name="num_adultos" min="1" value="1" required>

            <label for="num_ninos">Número de Niños:</label>
            <input type="number" id="num_ninos" name="num_ninos" min="0" value="0" required>


            <button type="button" class="btn" id="agregar-servicios">Agregar Servicios Adicionales</button>
            <button type="submit" class="btn">Confirmar Reserva</button>
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

        // Redirigir a la página de pago con los datos necesarios
        // Asegúrate de que la ruta `pagos.create` esté definida correctamente en tu aplicación
        window.location.href = `{{route('pagos.create') }}?habitacion_id=${habitacionId}&total=${total}&nombre=${nombre}&email=${email}&fecha_entrada=${fechaEntrada}&fecha_salida=${fechaSalida}&num_adultos=${numAdultos}&num_ninos=${numNinos}&dni=${dni}`; 
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