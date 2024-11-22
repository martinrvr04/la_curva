<!DOCTYPE html>
<html>
<head>
  <title>Panel de Administrador - Reportes</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
</head>
<body>

  <h1>Reportes y Estadísticas</h1>

  <h2>Reservas Totales</h2>
  <p>Total de reservas: {{ $reservasTotales }}</p>

  <h2>Ocupación e Ingresos por Tipo de Habitación (por mes)</h2>

  <form method="GET" action="{{ route('admin.reportes.index') }}">
    <label for="mes">Selecciona un mes:</label>
    <select name="mes" id="mes">
        @for ($i = 0; $i <= 11; $i++)
            <option value="{{ Carbon\Carbon::now()->subMonths($i)->format('Y-m') }}" 
                    {{ request('mes') == Carbon\Carbon::now()->subMonths($i)->format('Y-m') ? 'selected' : '' }}>
                {{ Carbon\Carbon::now()->subMonths($i)->format('F Y') }} 
            </option>
        @endfor
    </select>
    <button type="submit">Mostrar</button>
</form>

@if (request('mes'))
    <h3>{{ Carbon\Carbon::parse(request('mes'))->format('F Y') }}</h3> 
    <table>
        <thead>
            <tr>
                <th>Tipo de Habitación</th>
                <th>Tasa de Ocupación</th>
                <th>Ingresos Totales</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ocupacionIngresosPorMes[request('mes')] as $tipo)
                <tr>
                    <td>{{ $tipo->tipo }}</td>
                    <td>{{ $tipo->total > 0 ? round(($tipo->ocupadas / $tipo->total) * 100, 2) : 0 }}%</td>
                    <td>{{ $tipo->ingresos }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

  <h2>Promedio de Estadía</h2>
  <p>Promedio de días de estadía: {{ round($promedioEstadia, 2) }}</p>


  <h2>Gráfico de Ocupación por Mes</h2>
  <canvas id="ocupacionChart"></canvas>

  <h2>Gráfico de Ingresos por Tipo de Habitación</h2>
  <canvas id="ingresosChart"></canvas>
  <a href="{{ route('admin.reportes.exportarPDF') }}">Exportar a PDF</a>
  <a href="{{ route('admin.reportes.exportarExcel') }}">Exportar a Excel</a>

  <script>
    // Gráfico de ocupación por mes
    const ocupacionData = {
      labels: {!! json_encode(array_keys($ocupacionPorMes)) !!},
      datasets: [{
        label: 'Ocupación',
        data: {!! json_encode(array_values($ocupacionPorMes)) !!},
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    };

    const ocupacionConfig = {
      type: 'bar', 
      data: ocupacionData,
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    };

    const ocupacionChart = new Chart(
      document.getElementById('ocupacionChart'),
      ocupacionConfig
    );

    // Gráfico de ingresos por tipo de habitación
    const ingresosData = {
      labels: {!! json_encode($ingresosPorTipo->pluck('tipo')) !!},
      datasets: [{
        label: 'Ingresos',
        data: {!! json_encode($ingresosPorTipo->pluck('ingresos')) !!},
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          // Agrega más colores si tienes más tipos de habitación
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          // Agrega más colores si tienes más tipos de habitación
        ],
        borderWidth: 1
      }]
    };

    const ingresosConfig = {
      type: 'pie', 
      data: ingresosData,
    };

    const ingresosChart = new Chart(
      document.getElementById('ingresosChart'),
      ingresosConfig
    );
  </script>

</body>
</html>