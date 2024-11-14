<section class="habitaciones">
  <div class="container">
    <h2>Nuestras habitaciones</h2>


    <form action="{{ route('habitaciones.buscar') }}" method="GET">
    <label for="fecha_entrada">Fecha de entrada:</label>
    <input type="date" id="fecha_entrada" name="fecha_entrada" required>

    <label for="fecha_salida">Fecha de salida:</label>
    <input type="date" id="fecha_salida" name="fecha_salida" required>

    <label for="precio_min">Precio mínimo:</label>
    <input type="number" id="precio_min" name="precio_min">

    <label for="precio_max">Precio máximo:</label>
    <input type="number" id="precio_max" name="precio_max">

    <button type="submit">Buscar habitaciones</button>
</form>

</form>
    </form>

    @foreach ($habitacionesDisponibles as $habitacion) 
      <div class="habitacion">
        <div class="galeria">
          @foreach ($habitacion->imagenes as $imagen)
            <img src="{{ asset('img/' . $imagen->nombre) }}" alt="Imagen de {{ $habitacion->tipo }}">
          @endforeach
        </div>
        <div class="habitacion-info">
          <h3>{{ $habitacion->tipo }} - Capacidad: {{ $habitacion->capacidad }}</h3>
          <p>{{ $habitacion->descripcion }}</p>
          <ul>
            <li>Precio por noche: ${{ $habitacion->precio_noche }}</li>
            <li>Prepago por noche: ${{ $habitacion->prepago_noche }}</li>
          </ul>
          <p class="precio">Desde ${{ $habitacion->precio_noche }} por noche</p>
          <a href="{{ route('reservas.create', $habitacion->id) }}" class="btn">Reservar ahora</a> 
        </div>
      </div>
    @endforeach

  </div>
</section>