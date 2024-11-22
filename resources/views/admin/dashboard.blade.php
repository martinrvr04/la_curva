<!DOCTYPE html>
<html>
<head>
  <title>Panel de Administrador - Hostal La Curva</title>
</head>
<body>

  <h1>Bienvenido al Panel de Administrador</h1>

  <div class="resumen">
    <h2>Resumen General</h2>
    <div class="metricas">
      <div class="metrica">
        <h3>Reservas de hoy</h3>
        <p>{{ $reservasHoy }}</p>  </div>
      <div class="metrica">
        <h3>Ocupación</h3>
        <p>{{ $ocupacion }}%</p>  </div>
      <div class="metrica">
        <h3>Ingresos del mes</h3>
        <p>{{ $ingresosMes }}</p>  </div>
    </div>
    <div class="grafico">
      </div>
  </div>

  <div class="reservas-recientes">
    <h2>Reservas Recientes</h2>
    <table>
      <thead>
        <tr>
          <th>id huesped</th>
          <th>Nombre huesped</th>
          <th>Fecha de entrada</th>
          <th>Fecha de salida</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($reservasRecientes as $reserva)
        <tr>
        <td>{{ $reserva->id }}</td>
        <td>{{ $reserva->usuario['nombre'] ?? 'Sin nombre' }} {{ $reserva->usuario['apellido'] ?? '' }}</td>
        <td>{{ $reserva->fecha_entrada }}</td>
        <td>{{ $reserva->fecha_salida }}</td>
        <td>{{ $reserva->estado }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="botones">
    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-primary">Gestionar Usuarios</a>
    <a href="{{ route('admin.habitaciones.index') }}" class="btn btn-secondary">Gestionar Habitaciones</a>
    <a href="{{ route('admin.reservas.index') }}" class="btn btn-success">Gestionar Reservas</a>
    <a href="{{ route('admin.servicios.index') }}" class="btn btn-info">Gestionar Servicios</a>
    <a href="{{ route('admin.reportes.index') }}" class="btn btn-warning">Ver Reportes</a>
  </div>

</body>
</html>