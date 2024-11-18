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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    .container {
      max-width: 960px; 
      margin: 0 auto; /* Centrar el contenedor */
      padding: 20px;
    }

    .habitacion-detalle {
      margin-top: 20px; 
    }

    .habitacion-info h2 {
      font-size: 1.8rem;
      margin-bottom: 10px;
    }

    .habitacion-info h3 {
      font-size: 1.4rem;
      margin-bottom: 10px;
    }

    .habitacion-info p {
      font-size: 1rem;
      line-height: 1.6;
      color: #6c757d; 
    }
    .galeria {
      display: grid;
      grid-template-columns: 2fr 1fr; 
      grid-auto-rows: min-content; /* Ajusta la altura de las filas al mínimo necesario */
      gap: 15px; 
    }
    .imagen-principal img {
      width: 100%;
      height: 400px; 
      object-fit: cover;
      border-radius: 5px;
      grid-row: 1 / 3; /* La imagen principal ocupa dos filas */
    }

    .imagenes-secundarias {
      display: grid;
      grid-auto-flow: row; /*  Asegura que las imágenes se colocan en filas  */
      gap: 15px;
    }

    .imagenes-secundarias img {
      width: 100%;
      height: calc(400px / 2 - 7.5px); 
      object-fit: cover;
      border-radius: 5px;
    }

    .imagenes-restantes { 
      display: flex; /* Cambiar grid a flex para un diseño más sencillo */
      justify-content: center; /* Centrar las imágenes */
      gap: 10px; /* Añade espacio entre las imágenes */
      margin-top: 15px; /* Añade espacio superior */
      grid-column: 1 / -1; /* Que abarque todo el ancho */
      grid-row: 2; /* Colócalo directamente debajo de la principal */
    }

    .imagenes-restantes img {
      width: calc(100% / 6); /* Ajusta el ancho dependiendo del número de imágenes */
      height: 100px; 
      object-fit: cover;
      border-radius: 5px;
    }

    .reseñas-container {
      background-color: #fff;
      border: 1px solid #dee2e6;
      padding: 20px;
      border-radius: 5px;
      margin-top: 20px; 
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
      font-size: 3rem; 
      font-weight: bold;
      color: #007bff; 
      margin-right: 10px;
    }

    .texto {
      font-size: 1.2rem;
      font-weight: 500; 
    }

    .total-reseñas {
      font-size: 0.9rem;
      color: #6c757d; 
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
      font-weight: 500; 
    }

    .barra-progreso {
      background-color: #e9ecef; 
      height: 10px;
      border-radius: 5px;
      margin: 0 10px;
      flex-grow: 1;
    }

    .progreso {
      background-color: #007bff; 
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
      width: 23%; 
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

    .puntuacion-alta {
      display: block; 
      margin-top: 10px; 
      font-size: 0.9rem;
      color: #6c757d; 
    }

    /* Estilos para el carrusel */
    .carousel-item img { 
      max-width: 100%; 
      height: auto; 
      display: block; 
      margin-left: auto;
      margin-right: auto;
    }
  </style>
</head>
<body>

<section class="habitacion-detalle">
  <div class="container">
    <div class="habitacion-info">
      <h2>{{ $habitacion->nombre }}</h2> 
      <div class="galeria">
        <div class="imagen-principal">
          <img src="{{ asset('img/' . $habitacion->imagenes[0]->nombre) }}" alt="Imagen principal">
        </div>
        <div class="imagenes-secundarias">
          <img src="{{ asset('img/' . $habitacion->imagenes[1]->nombre) }}" alt="Imagen secundaria 1">
          <img src="{{ asset('img/' . $habitacion->imagenes[2]->nombre) }}" alt="Imagen secundaria 2">
        </div>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalImagenes">Mostrar imágenes</a>
        <div class="imagenes-restantes">
          @foreach ($habitacion->imagenes->skip(3) as $imagen)
            <img src="{{ asset('img/' . $imagen->nombre) }}" alt="Imagen adicional">
          @endforeach
        </div>
      </div>

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

<div class="modal fade" id="modalImagenes" tabindex="-1" aria-labelledby="modalImagenesLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl"> 
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalImagenesLabel">Imágenes de la habitación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="carruselImagenes" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            @foreach ($habitacion->imagenes as $index => $imagen)
              <div class="carousel-item {{ $index === 0 ? 'active' : '' }}"> 
                <img src="{{ asset('img/' . $imagen->nombre) }}" class="d-block w-100" alt="Imagen {{ $index + 1 }}">
              </div>
            @endforeach
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carruselImagenes" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carruselImagenes" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>