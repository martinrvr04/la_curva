<form action="{{ route('reservas.buscar_codigo') }}" method="GET">
  <label for="codigo">Código de reserva:</label>
  <input type="text" id="codigo" name="codigo" required>
  <button type="submit">Buscar reserva</button>
</form>