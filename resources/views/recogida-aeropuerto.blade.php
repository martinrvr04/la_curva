<!DOCTYPE html>
<html lang="es">
<head>
  </head>

<body>

  <section class="recogida-aeropuerto">
    <div class="container">
      <h2>Recogida en el aeropuerto</h2>
      <p>Ofrecemos un cómodo servicio de recogida en el Aeropuerto Internacional Alfonso Bonilla Aragón (CLO) para que tu llegada a Cali sea lo más placentera posible.</p>

      <h3>¿Cómo funciona?</h3>
      <ol>
        <li>Reserva tu servicio con al menos 24 horas de anticipación.</li>
        <li>Indícanos tu número de vuelo y la hora de llegada.</li>
        <li>Nuestro conductor te estará esperando en la zona de llegadas con un cartel con tu nombre.</li>
        <li>Te llevaremos directamente a La Curva Apartamentos.</li>
      </ol>

      <h3>Tarifas</h3>
      <p>El costo del servicio es de $100 COP por trayecto.</p>

      <h3>Formulario de solicitud</h3>
      <form action="{{ route('recogida.solicitar') }}" method="POST"> 
        @csrf
        <input type="hidden" name="monto_recogida" value="100"> 

        <div class="form-group">
          <label for="nombre">Nombre completo:</label>
          <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="email">Correo electrónico:</label>
          <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="numero_vuelo">Número de vuelo:</label>
          <input type="text" name="numero_vuelo" id="numero_vuelo" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="hora_llegada">Hora de llegada:</label>
          <input type="datetime-local" name="hora_llegada" id="hora_llegada" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Solicitar recogida</button>
      </form>

    </div>
  </section>


</body>
</html>