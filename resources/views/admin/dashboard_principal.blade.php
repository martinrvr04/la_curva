<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .card {
            flex: 1 0 200px; /* Ajusta el ancho mínimo de las tarjetas */
        }
        /* Estilo para el mapa de calor */
        .heatmap {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(50px, 1fr)); /* Ajusta el tamaño de las celdas */
            gap: 5px;
        }
        .heatmap-cell {
            background-color: #eee;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .heatmap-cell.occupied {
            background-color: #f08080; /* Color para celdas ocupadas */
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <h1>Dashboard Principal</h1>

        <div class="card-container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ganancias totales</h5>
                    <p class="card-text">${{ $gananciasTotales }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ocupación promedio</h5>
                    <p class="card-text">{{ number_format($ocupacionPromedio, 2) }}%</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Promedio de estadía</h5>
                    <p class="card-text">{{ number_format($promedioEstadia, 2) }} noches</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total de reservas</h5>
                    <p class="card-text">{{ $totalReservas }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Cancelaciones</h5>
                    <p class="card-text">{{ $cancelaciones }} ({{ number_format($porcentajeCancelaciones, 2) }}%)</p>
                </div>
            </div>
        </div>

        <h2>Ganancias a lo largo del tiempo</h2>
        <canvas id="gananciasChart"></canvas>

        <h2>Ocupación por mes</h2>
        <canvas id="ocupacionChart"></canvas>

        <h2>Ingresos por tipo de habitación</h2>
        <canvas id="ingresosTipoChart"></canvas>

        <h2>Mapa de calor de ocupación</h2>
        <div class="heatmap">
            @foreach ($mapaCalor as $numero => $diasOcupados)
                <div class="heatmap-cell {{ $diasOcupados > 0 ? 'occupied' : '' }}">
                    {{ $numero }} <br> ({{ $diasOcupados }} días)
                </div>
            @endforeach
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // --- Gráfico de ganancias a lo largo del tiempo ---
        const gananciasPorMes = {!! json_encode($gananciasPorMes) !!};
        const labelsGanancias = gananciasPorMes.map(g => `<span class="math-inline">\{g\.anio\}\-</span>{g.mes}`);
        const dataGanancias = gananciasPorMes.map(g => g.total);

        const ctxGanancias = document.getElementById('gananciasChart').getContext('2d');
        new Chart(ctxGanancias, {
            type: 'line',
            data: {
                labels: labelsGanancias,
                datasets: [{
                    label: 'Ganancias',
                    data: dataGanancias,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            }
        });

        // --- Gráfico de ocupación por mes ---
        const ocupacionPorMes = {!! json_encode($ocupacionPorMes) !!};
        const labelsOcupacion = ocupacionPorMes.map(o => o.mes);
        const dataOcupacion = ocupacionPorMes.map(o => o.ocupacion);

        const ctxOcupacion = document.getElementById('ocupacionChart').getContext('2d');
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

        // --- Gráfico de pastel de ingresos por tipo de habitación ---
        const ingresosPorTipo = {!! json_encode($ingresosPorTipo) !!};
        const labelsIngresosTipo = ingresosPorTipo.map(i => i.tipo);
        const dataIngresosTipo = ingresosPorTipo.map(i => i.total);

        const ctxIngresosTipo = document.getElementById('ingresosTipoChart').getContext('2d');
        new Chart(ctxIngresosTipo, {
            type: 'pie',
            data: {
                labels: labelsIngresosTipo,
                datasets: [{
                    label: 'Ingresos por tipo',
                    data: dataIngresosTipo,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        // ... más colores si es necesario
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        // ... más colores si es necesario
                    ],
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>