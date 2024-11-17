<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $habitacion->tipo }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" 
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" 
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    body {
      font-family: sans-serif;
    }
    .reseñas-container {
      background-color: #fff;
      border: 1px solid #dee2e6; 
      padding: 20px;
      border-radius: 5px;
    }
    .reseñas-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    .calificacion-promedio {
      display: flex;
      align-items: center;
    }
    .puntuacion {
      font-size: 2rem;
      font-weight: bold;
      color: #007bff; /* Color azul */
      margin-right: 10px;
    }
    .texto {
      font-size: 1.2rem;
    }
    .total-reseñas {
      font-size: 0.9rem;
      color: #6c757d; /* Color gris */
    }
    .categorias {
      margin-bottom: 20px;
    }
    .categoria-rating {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }
    .categoria {
      width: 150px; 
      font-weight: bold;
    }
    .barra-progreso {
      background-color: #e9ecef; /* Color gris claro */
      height: 10px;
      border-radius: 5px;
      margin: 0 10px;
      flex-grow: 1;
    }
    .progreso {
      background-color: #007bff; /* Color azul */
      height: 100%;
      border-radius: 5px;
    }
    .valor {
      font-weight: bold;
    }
    .filtros {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }
    .filtro {
      /* ... */
    }
    .temas {
      display: flex;
      flex-wrap: wrap; 
      gap: 10px;
      margin-bottom: 20px;
    }
    .tema button {
      /* ... */
    }
    .lista-reseñas {
      /* ... */
    }
    .reseña {
      border: 1px solid #dee2e6; 
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<section class="habitacion-detalle">
  <div class="container">
    <h2>{{ $habitacion->tipo }}</h2>

    <div class="habitacion-info">
      <div class="galeria">
        @foreach ($habitacion->imagenes as $imagen)
          <img src="{{ asset('img/' . $imagen->nombre) }}" alt="Imagen de {{ $habitacion->tipo }}">
        @endforeach
      </div>
      <h3>{{ $habitacion->tipo }} - Capacidad: {{ $habitacion->capacidad }}</h3>
      <p>{{ $habitacion->descripcion }}</p>
      <p>Precio por noche: ${{ $habitacion->precio_noche }}</p>
    </div>

    <div class="reseñas-container">
      <div class="reseñas-header">
        <div class="calificacion-promedio">
          <span class="puntuacion">{{ number_format($calificacionPromedio, 1) }}</span> 
          <span class="texto">Bien</span>
          <span class="total-reseñas">{{ $totalReseñas }} comentarios</span>
          <i class="fas fa-info-circle ml-2" data-bs-toggle="tooltip" data-bs-placement="top" 
             title="Nuestro objetivo: comentarios 100% reales"></i> 
        </div>
        <button class="btn btn-primary">Escribe un comentario</button>
      </div>

      <div class="categorias">
        <h3>Categorías:</h3>
        @foreach ($promediosCategorias as $categoria => $valor)
          <div class="categoria-rating">
            <span class="categoria">{{ ucfirst(str_replace('_', ' ', $categoria)) }}</span> 
            <div class="barra-progreso">
              <div class="progreso" style="width: {{ $valor }}%;"></div>
            </div>
            <span class="valor">{{ number_format($valor, 1) }}</span> 
          </div>
        @endforeach
        <div class="categoria-rating mt-2"> 
          <span class="categoria">WiFi gratis <i class="fas fa-arrow-up"></i></span>
          <div class="barra-progreso">
            <div class="progreso" style="width: 100%;"></div> 
          </div>
          <span class="valor">10</span>
        </div>
        <span class="puntuacion-alta"><i class="fas fa-arrow-up"></i> Puntuación alta para Cali</span> 
      </div>

      <div class="filtros">
        <h3>Filtros</h3>
        <div class="filtro">
          <label for="tipo-cliente">Tipos de cliente:</label>
          <select id="tipo-cliente" class="form-select">
            <option value="todos">Todos ({{ $totalReseñas }})</option> 
          </select>
        </div>
        <div class="filtro">
          <label for="puntuaciones">Puntuaciones:</label>
          <select id="puntuaciones" class="form-select">
            <option value="todos">Todas ({{ $totalReseñas }})</option> 
          </select>
        </div>
        <div class="filtro">
          <label for="idiomas">Idiomas:</label>
          <select id="idiomas" class="form-select">
            <option value="todos">Todos ({{ $totalReseñas }})</option> 
          </select>
        </div>
        <div class="filtro">
          <label for="epoca-año">Época del año:</label>
          <select id="epoca-año" class="form-select">
            <option value="todos">Todas ({{ $totalReseñas }})</option> 
          </select>
        </div>
      </div>

      <div class="temas">
        <h3>Elige los temas de los comentarios:</h3>
        <button class="btn btn-outline-secondary">+ Ubicación</button>
        <button class="btn btn-outline-secondary">+ Cama</button>
        <button class="btn btn-outline-secondary">+ Desayuno</button>
        <button class="btn btn-outline-secondary">+ Ruido</button>
        <button class="btn btn-outline-secondary">+ Wifi</button>
        <button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
        <a href="#" class="btn btn-link">Ver más</a>
      </div>

      <div class="lista-reseñas">
        @foreach ($reseñas as $reseña)
          <div class="reseña">
            <p>Calificación general: {{ $reseña->calificacion_general }}</p>
            <p>Comentario: {{ $reseña->comentario }}</p>
          </div>
        @endforeach
      </div>
    </div>

  </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // JavaScript para la interactividad (filtros, AJAX, etc.)
  
  // Inicializar tooltips de Bootstrap
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>

</body>
</html>