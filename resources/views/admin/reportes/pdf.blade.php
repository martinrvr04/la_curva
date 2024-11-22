<!DOCTYPE html>
<html>
<head>
  <title>Reporte de Hostal</title>
</head>
<body>

  <h1>Reportes y Estadísticas</h1>

  <h2>Reservas Totales</h2>
  <p>Total de reservas: {{ $reservasTotales }}</p>

  <h2>Ocupación e Ingresos por Tipo de Habitación (por mes)</h2>

  @foreach ($ocupacionIngresosPorMes as $mes => $datos)
      <h3>{{ $mes }}</h3>
      <table>
          <thead>
              <tr>
                  <th>Tipo de Habitación</th>
                  <th>Tasa de Ocupación</th>
                  <th>Ingresos Totales</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($datos as $tipo)
                  <tr>
                      <td>{{ $tipo->tipo }}</td>
                      <td>{{ $tipo->total > 0 ? round(($tipo->ocupadas / $tipo->total) * 100, 2) : 0 }}%</td>
                      <td>{{ $tipo->ingresos }}</td>
                  </tr>
              @endforeach
          </tbody>
      </table>
  @endforeach

  <h2>Promedio de Estadía</h2>
  <p>Promedio de días de estadía: {{ round($promedioEstadia, 2) }}</p>

</body>
</html>