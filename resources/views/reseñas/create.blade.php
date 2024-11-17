<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dejar reseña</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/rateyo@2.3.2/min/jquery.rateyo.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet"> 
  <style>
    body {
      font-family: 'Poppins', sans-serif; 
      background-color: #f8f9fa; 
    }
    .dejar-reseña {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }
    h2 {
      font-weight: 600;
      color: #343a40; 
    }
    h3 {
      font-weight: 500;
      color: #495057; 
      margin-bottom: 20px;
    }
    .rating {
      display: inline-block;
      unicode-bidi: bidi-override;
      direction: rtl;
      font-size: 2rem;
    }
    .rating > input {
      display: none;
    }
    .rating > label {
      position: relative;
      display: inline-block;
      color: #ccc;
      cursor: pointer;
      transition: color 0.2s; 
    }
    .rating > label:before {
      content: "\2605";
      position: absolute;
      opacity: 0;
      transition: opacity 0.2s; 
    }
    .rating > label:hover:before,
    .rating > label:hover ~ label:before,
    .rating > input:checked ~ label:before {
      opacity: 1;
      color: #ffc107; 
    }
    .rating-container {
      display: flex;
      align-items: center;
      gap: 10px; 
    }
    #slider-relacion-calidad-precio {
      width: 100%; 
      margin-top: 10px; 
    }
    .noUi-connect {
      background: linear-gradient(to right, #e0e0e0, #ffc107); 
    }
    .noUi-handle {
      background: #ffc107; 
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    textarea {
      resize: vertical; 
    }
    .btn-primary {
      background-color: #007bff; 
      border-color: #007bff; 
      transition: background-color 0.3s, border-color 0.3s; 
    }
    .btn-primary:hover {
      background-color: #0069d9; 
      border-color: #0062cc; 
    }
  </style>
</head>
<body>

<section class="dejar-reseña py-5">
  <div class="container">
    <h2 class="text-center mb-4">Dejar reseña para la reserva #{{ $reserva->id }}</h2>
    <form action="{{ route('reseñas.store') }}" method="POST">
      @csrf
      <input type="hidden" name="reserva_id" value="{{ $reserva->id }}">

      <div class="mb-4">
        <h3>Calificación general</h3>
        <div class="rating-container">
          <div class="rating" data-rateyo-rating="0" data-rateyo-num-stars="5" data-rateyo-full-star="true"></div>
        </div>
        <input type="hidden" name="calificacion_general" id="calificacion_general_input">
      </div>

      <div class="mb-4">
        <h3>Calificaciones individuales</h3>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="limpieza" class="form-label">Limpieza:</label>
            <div class="rating-container">
              <div class="rating" data-rateyo-rating="0" data-rateyo-num-stars="5" data-rateyo-full-star="true"></div>
            </div>
            <input type="hidden" name="limpieza" id="limpieza_input">
          </div>
          <div class="col-md-6 mb-3">
            <label for="confort" class="form-label">Confort:</label>
            <div class="rating-container">
              <div class="rating" data-rateyo-rating="0" data-rateyo-num-stars="5" data-rateyo-full-star="true"></div>
            </div>
            <input type="hidden" name="confort" id="confort_input">
          </div>
          <div class="col-md-6 mb-3">
            <label for="ubicacion" class="form-label">Ubicación:</label>
            <div class="rating-container">
              <div class="rating" data-rateyo-rating="0" data-rateyo-num-stars="5" data-rateyo-full-star="true"></div>
            </div>
            <input type="hidden" name="ubicacion" id="ubicacion_input">
          </div>
          <div class="col-md-6 mb-3">
            <label for="instalaciones" class="form-label">Instalaciones:</label>
            <div class="rating-container">
              <div class="rating" data-rateyo-rating="0" data-rateyo-num-stars="5" data-rateyo-full-star="true"></div>
            </div>
            <input type="hidden" name="instalaciones" id="instalaciones_input">
          </div>
          <div class="col-md-6 mb-3">
            <label for="personal" class="form-label">Personal:</label>
            <div class="rating-container">
              <div class="rating" data-rateyo-rating="0" data-rateyo-num-stars="5" data-rateyo-full-star="true"></div>
            </div>
            <input type="hidden" name="personal" id="personal_input">
          </div>
          <div class="col-md-6 mb-3">
            <label for="relacion_calidad_precio" class="form-label">Relación calidad-precio:</label>
            <div id="slider-relacion-calidad-precio"></div>
            <input type="hidden" name="relacion_calidad_precio" id="relacion_calidad_precio_input">
          </div>
          <div class="col-md-6 mb-3">
            <label for="wifi" class="form-label">Wifi:</label>
            <div class="rating-container">
              <div class="rating" data-rateyo-rating="0" data-rateyo-num-stars="5" data-rateyo-full-star="true"></div>
            </div>
            <input type="hidden" name="wifi" id="wifi_input">
          </div>
        </div>
      </div>

      <div class="mb-3">
        <h3>Comentario</h3>
        <textarea name="comentario" id="comentario" rows="5" class="form-control"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Enviar reseña</button>
    </form>
  </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/rateyo@2.3.2/min/jquery.rateyo.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>

<script>
 $(function () {
   // Inicializar RateYo
   $(".rating").rateYo({
     starWidth: "30px", 
     spacing: "5px", 
     normalFill: "#e0e0e0", 
     ratedFill: "#ffc107", 
     onSet: function (rating, rateYoInstance) {
       var inputId = $(this).closest('.rating-container').next('input').attr('id');
       $('#' + inputId).val(rating);
     }
   });

   // Inicializar noUiSlider
   var slider = document.getElementById('slider-relacion-calidad-precio');
   noUiSlider.create(slider, {
     start: [3], 
     connect: true,
     range: {
       'min': 1,
       'max': 5
     },
     step: 1,
     pips: {
       mode: 'steps',
       density: 5
     }
   });

   slider.noUiSlider.on('update', function (values, handle) {
     $('#relacion_calidad_precio_input').val(Math.round(values[handle]));
   });
 });
</script>

</body>
</html>