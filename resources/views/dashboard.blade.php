<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>La Curva Apartamentos</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    /* Estilos generales */
    body {
      font-family: 'Roboto', sans-serif;
      margin: 0;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    h2 {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      text-align: center;
      margin-bottom: 30px;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #786fa6;
      /* Color morado */
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #54497d;
      /* Color morado más oscuro al pasar el mouse */
    }

    /* Estilos del encabezado */
    header {
      background-color: #e67e22;
      /* Color naranja */
      color: #fff;
      padding: 20px 0;
    }

    .logo {
      font-family: 'Playfair Display', serif;
      font-size: 24px;
      font-weight: 700;
      text-decoration: none;
      color: #fff;
      float: left;
    }

    nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
      float: right;
    }

    nav li {
      display: inline-block;
      margin-left: 30px;
    }

    nav a {
      color: #fff;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    nav a:hover {
      color: #f1c40f;
      /* Color amarillo al pasar el mouse */
    }

    /* Estilos de la sección hero */
    .hero {
      background-image: url("https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80");
      /* Imagen de ejemplo */
      background-size: cover;
      background-position: center;
      color: #fff;
      text-align: center;
      padding: 100px 0;
    }

    .hero-content {
      background-color: rgba(0, 0, 0, 0.5);
      /* Fondo semi-transparente */
      padding: 20px;
      border-radius: 10px;
    }

    .hero h2 {
      font-size: 48px;
      margin-bottom: 20px;
    }

    .hero p {
      font-size: 20px;
      margin-bottom: 30px;
    }

    /* Estilos para la sección de información */
    .info {
      padding: 50px 0;
      text-align: center;
    }

    .info .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      /* Responsive */
      grid-gap: 30px;
    }

    .info-item {
      border: 1px solid #ddd;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      /* Centrar el contenido */
    }

    .info-item i {
      /* Para iconos */
      font-size: 36px;
      color: #e67e22;
      margin-bottom: 20px;
    }

    /* Estilos para la sección de galería */
    .galeria {
      padding: 50px 0;
    }

    .galeria .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      grid-gap: 20px;
    }

    .galeria img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
      transition: transform 0.3s ease;
      /* Efecto hover */
    }

    .galeria img:hover {
      transform: scale(1.1);
      /* Efecto hover */
    }

    /* Estilos para la sección "sobre nosotros" */
    .sobre-nosotros {
      padding: 50px 0;
      text-align: center;
    }

    /* Estilos para la sección de testimonios */
    .testimonios {
      background-color: #f5f5f5;
      padding: 50px 0;
    }

    .testimonio {
      border: 1px solid #ddd;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 20px;
      text-align: center;
      /* Centrar el contenido */
    }

    .testimonio .nombre {
      font-weight: bold;
    }

    /* Estilos para el footer */
    footer {
      background-color: #e67e22;
      color: #fff;
      padding: 30px 0;
    }

    footer .container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      /* Para que se ajuste en pantallas pequeñas */
    }

    footer ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    footer li {
      display: inline-block;
      margin: 10px;
      /* Ajustar el margen */
    }

    footer .social-links a {
      color: #fff;
      font-size: 24px;
      margin: 0 10px;
      /* Ajustar el margen */
    }

    /* Ejemplo de separador */
    .separador {
      width: 100%;
      height: 1px;
      background-color: #ddd;
      margin: 30px 0;
    }
  </style>
</head>

<body>

  <header>
    <div class="container">
      <a href="#" class="logo">La Curva Apartamentos</a>
      <nav>
        <ul>
          <li><a href="#">Inicio</a></li>
          <li><a href="{{ route('habitaciones.index') }}">Habitaciones</a></li>
          <li><a href="#">Servicios</a></li>
          <li><a href="#">Contacto</a></li>
          @if (auth()->check())
          <li>
            <a href="{{ route('perfil.mis-reservas') }}">Mis reservas</a>
          </li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit">Cerrar sesión</button>
            </form>
          </li>
          @endif
        </ul>
      </nav>
    </div>
  </header>

  <section class="hero">
    <div class="container">
      <div class="hero-content">
        <h2>Bienvenido a La Curva</h2>
        <p>Disfruta de una estancia inolvidable en Cali</p>
        <a href="#" class="btn">Reserva ahora</a>
      </div>
    </div>
  </section>

  <section class="sobre-nosotros">
    <div class="container">
      <h2>Sobre nosotros</h2>
      <p>La Curva Apartamentos nace del deseo de brindar un espacio acogedor y familiar a quienes visitan la hermosa ciudad de Cali. Nos apasiona ofrecer a nuestros huéspedes una experiencia que combine la comodidad de un hogar con la atención personalizada de un hotel boutique.</p>
    </div>
  </section>

  <section class="info">
    <div class="container">
      <div class="grid">
        <div class="info-item">
          <i class="fas fa-map-marker-alt"></i>
          <h3>Ubicación privilegiada</h3>
          <p>Nos encontramos en Miraflores, una zona tranquila y segura de Cali, con fácil acceso a transporte público y cerca de los principales puntos de interés.</p>
          <a href="#" class="btn">Ver mapa</a>
        </div>
        <div class="info-item">
          <i class="fas fa-bed"></i>
          <h3>Comodidad y confort</h3>
          <p>Nuestros apartamentos están diseñados para ofrecerte una estancia placentera, con todas las comodidades que necesitas para sentirte como en casa.</p>
          <a href="#" class="btn">Ver habitaciones</a>
        </div>
        <div class="info-item">
          <i class="fas fa-plane-arrival"></i> 
          <h3>Recogida en el aeropuerto</h3> 
          <p>¿Necesitas que te recojamos en el aeropuerto? ¡No hay problema! Ofrecemos servicio de transporte para que tu llegada sea más cómoda.</p> 
          <a href="{{ route('recogida.aeropuerto') }}" class="btn">Más información</a>    </div>
  </section>

  <div class="separador"></div>

  <section class="galeria">
    <div class="container">
      <h2>Galería</h2>
      <div class="grid">
        <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="Imagen 1">
        <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="Imagen 2">
        <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="Imagen 3">
        <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="Imagen 4">
      </div>
    </div>
  </section>

  <div class="separador"></div>

  <section class="testimonios">
    <div class="container">
      <h2>Testimonios</h2>
      <div class="testimonio">
        <p>"¡Mi estancia en La Curva fue maravillosa! Los apartamentos son muy cómodos y la atención fue excelente. Definitivamente volveré."</p>
        <p class="nombre">- María García</p>
      </div>
      <div class="testimonio">
        <p>"La ubicación es perfecta, cerca de todo. Además, el personal fue muy amable y servicial. ¡Recomiendo La Curva Apartamentos sin dudarlo!"</p>
        <p class="nombre">- Juan Pérez</p>
      </div>
    </div>
  </section>

  <footer>
    <div class="container">
      <p>&copy; 2023 La Curva Apartamentos</p>
      <ul class="social-links">
        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
      </ul>
    </div>
  </footer>

</body>
</html>