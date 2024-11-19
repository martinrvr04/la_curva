<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard de la habitación {{ $habitacion->tipo }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container-fluid">  
    <div class="row">
      <div class="col-12">
        <h1>Dashboard de la habitación {{ $habitacion->tipo }}</h1>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-3"> 
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Ganancias totales</h5>
            <p class="card-text">${{ $gananciasTotales }}</p> 
          </div>
        </div>
      </div>
      <div class="col-md-9"> 
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Ganancias del año</h5>
            <canvas id="miGrafico"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Variación de ganancias por mes</h5>
            <canvas id="variacionGananciasChart"></canvas> 
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Ganancias por trimestre</h5>
            <canvas id="gananciasTrimestreChart"></canvas> 
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Ocupación por mes</h5>
            <canvas id="ocupacionMesChart"></canvas> 
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Promedio de estadía</h5>
            <p class="card-text">{{ $promedioEstadia }} noches</p> 
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Tendencia de reservas</h5>
            <canvas id="tendenciaReservasChart"></canvas> 
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    try {
         // Mostrar ganancias del año
      const gananciasAnioElement = document.getElementById('ganancias-anio');
      if (gananciasAnioElement) {
        gananciasAnioElement.textContent = '$' + {!! json_encode($gananciasAnio) !!}; 
      }

      // Gráfico de ganancias por mes/año
      const ganancias = {!! json_encode($ganancias) !!}; 
      console.log(ganancias); // <-- Agrega esta línea aquí
      const labels = ganancias.map(g => `${g.anio}-${g.mes}`);
      console.log('Labels:', labels);
      const data = ganancias.map(g => g.total); 
      console.log('Data:', data);



      const ctx = document.getElementById('miGrafico').getContext('2d');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: 'Ganancias',
            data: data,
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
          }]
        }
      });



      // --- Gráfico de variación de ganancias por mes ---
      const variacionGanancias = {!! json_encode($variacionGanancias) !!};
      const labelsVariacion = variacionGanancias.map(g => g.mes);
      const dataVariacion = variacionGanancias.map(g => g.variacion);

      const ctxVariacion = document.getElementById('variacionGananciasChart').getContext('2d');
      new Chart(ctxVariacion, {
          type: 'bar',
          data: {
              labels: labelsVariacion,
              datasets: [{
                  label: 'Variación (%)',
                  data: dataVariacion,
                  backgroundColor: 'rgba(255, 159, 64, 0.2)',
                  borderColor: 'rgba(255, 159, 64, 1)',
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });

      // --- Gráfico de ganancias por trimestre ---
      const gananciasTrimestre = {!! json_encode($gananciasTrimestre) !!};
      const labelsTrimestre = gananciasTrimestre.map(g => g.trimestre);
      const dataTrimestre = gananciasTrimestre.map(g => g.ganancias);

      const ctxTrimestre = document.getElementById('gananciasTrimestreChart').getContext('2d');
      new Chart(ctxTrimestre, {
          type: 'bar',
          data: {
              labels: labelsTrimestre,
              datasets: [{
                  label: 'Ganancias',
                  data: dataTrimestre,
                  backgroundColor: 'rgba(75, 192, 192, 0.2)',
                  borderColor: 'rgba(75, 192, 192, 1)',
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });

      // --- Gráfico de ocupación por mes ---
      const ocupacionMes = {!! json_encode($ocupacionMes) !!};
      const labelsOcupacion = ocupacionMes.map(o => o.mes);
      const dataOcupacion = ocupacionMes.map(o => o.ocupacion);

      const ctxOcupacion = document.getElementById('ocupacionMesChart').getContext('2d');
      new Chart(ctxOcupacion, {
          type: 'line',
          data: {
              labels: labelsOcupacion,
              datasets: [{
                  label: 'Ocupación (%)',
                  data: dataOcupacion,
                  fill: true,
                  borderColor: 'rgba(153, 102, 255, 1)',
                  backgroundColor: 'rgba(153, 102, 255, 0.2)',
                  tension: 0.1
              }]
          },
          options: {
              scales: {
                  y: {
                      beginAtZero: true,
                      max: 100 
                  }
              }
          }
      });

      // --- Gráfico de tendencia de reservas ---
      const tendenciaReservas = {!! json_encode($tendenciaReservas) !!};
      const labelsTendencia = tendenciaReservas.map(t => `${t.anio}-${t.mes}`);       const dataTendencia = tendenciaReservas.map(t => t.cantidad);

      const ctxTendencia = document.getElementById('tendenciaReservasChart').getContext('2d');
      new Chart(
          ctxTendencia, {
          type: 'bar',
          data: {
              labels: labelsTendencia,
              datasets: [{
                  label: 'Cantidad de reservas',
                  data: dataTendencia,
                  backgroundColor: 'rgba(54, 162, 235, 0.2)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });
    } catch (error) {
      console.error('Error al crear los gráficos:', error);
      // Mostrar un mensaje de error o gráficos vacíos
    }
 </script>
</body>
</html>