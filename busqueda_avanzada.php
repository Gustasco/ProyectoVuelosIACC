<?php
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Búsqueda Avanzada de Vuelos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4">🔎 Búsqueda Avanzada de Vuelos</h2>

    <form id="busquedaForm" action="busqueda_avanzada.php" method="GET" class="row g-3 mb-4" onsubmit="return validarFormulario()">
      <div class="col-md-4">
        <label for="origen" class="form-label">Origen *</label>
        <input type="text" class="form-control" name="origen" id="origen" placeholder="Ej: Madrid" value="<?=htmlspecialchars($_GET['origen'] ?? '')?>" />
      </div>
      <div class="col-md-4">
        <label for="destino" class="form-label">Destino *</label>
        <input type="text" class="form-control" name="destino" id="destino" placeholder="Ej: París" value="<?=htmlspecialchars($_GET['destino'] ?? '')?>" />
      </div>
      <div class="col-md-4">
        <label for="fecha" class="form-label">Fecha *</label>
        <input type="date" class="form-control" name="fecha" id="fecha" value="<?=htmlspecialchars($_GET['fecha'] ?? '')?>" />
      </div>

      <div class="col-md-3">
        <label for="hora_salida_min" class="form-label">Hora Salida Mínima *</label>
        <input type="time" class="form-control" name="hora_salida_min" id="hora_salida_min" value="<?=htmlspecialchars($_GET['hora_salida_min'] ?? '')?>" />
      </div>
      <div class="col-md-3">
        <label for="hora_salida_max" class="form-label">Hora Salida Máxima *</label>
        <input type="time" class="form-control" name="hora_salida_max" id="hora_salida_max" value="<?=htmlspecialchars($_GET['hora_salida_max'] ?? '')?>" />
      </div>

      <div class="col-md-3">
        <label for="aerolinea" class="form-label">Aerolínea *</label>
        <input type="text" class="form-control" name="aerolinea" id="aerolinea" placeholder="Ej: Iberia" value="<?=htmlspecialchars($_GET['aerolinea'] ?? '')?>" />
      </div>

      <div class="col-md-3">
        <label for="numero_vuelo" class="form-label">Número de Vuelo *</label>
        <input type="text" class="form-control" name="numero_vuelo" id="numero_vuelo" placeholder="Ej: IB3021" value="<?=htmlspecialchars($_GET['numero_vuelo'] ?? '')?>" />
      </div>

      <div class="col-md-3">
        <label for="precio_max" class="form-label">Precio Máximo</label>
        <input type="number" step="0.01" class="form-control" name="precio_max" id="precio_max" placeholder="Ej: 150" value="<?=htmlspecialchars($_GET['precio_max'] ?? '')?>" />
      </div>

      <div class="col-md-3">
        <label for="clase_servicio" class="form-label">Clase de Servicio *</label>
        <select class="form-select" name="clase_servicio" id="clase_servicio">
          <option value="">-- Seleccione --</option>
          <option value="economica" <?= (($_GET['clase_servicio'] ?? '') === 'economica') ? 'selected' : '' ?>>Económica</option>
          <option value="business" <?= (($_GET['clase_servicio'] ?? '') === 'business') ? 'selected' : '' ?>>Business</option>
          <option value="primera" <?= (($_GET['clase_servicio'] ?? '') === 'primera') ? 'selected' : '' ?>>Primera</option>
        </select>
      </div>

      <div class="col-12 mt-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-search"></i> Buscar
        </button>
        <button type="button" class="btn btn-secondary" onclick="limpiarFormulario()">
          <i class="bi bi-x-circle"></i> Limpiar
        </button>
      </div>
    </form>

    <hr />

   <?php
if ($_GET) {
  $origen = $conn->real_escape_string($_GET['origen'] ?? '');
  $destino = $conn->real_escape_string($_GET['destino'] ?? '');
  $fecha = $conn->real_escape_string($_GET['fecha'] ?? '');
  $hora_salida_min = $conn->real_escape_string($_GET['hora_salida_min'] ?? '');
  $hora_salida_max = $conn->real_escape_string($_GET['hora_salida_max'] ?? '');
  $aerolinea = $conn->real_escape_string($_GET['aerolinea'] ?? '');
  $numero_vuelo = $conn->real_escape_string($_GET['numero_vuelo'] ?? '');
  
  $precio_max = isset($_GET['precio_max']) && is_numeric($_GET['precio_max']) ? floatval($_GET['precio_max']) : '';
  
  $clase_servicio = $conn->real_escape_string($_GET['clase_servicio'] ?? '');

  $sql = "SELECT * FROM VUELO WHERE 1=1";

  if ($origen) $sql .= " AND origen LIKE '%$origen%'";
  if ($destino) $sql .= " AND destino LIKE '%$destino%'";
  if ($fecha) $sql .= " AND fecha = '$fecha'";
  if ($hora_salida_min) $sql .= " AND hora_salida >= '$hora_salida_min'";
  if ($hora_salida_max) $sql .= " AND hora_salida <= '$hora_salida_max'";
  if ($aerolinea) $sql .= " AND aerolinea LIKE '%$aerolinea%'";
  if ($numero_vuelo) $sql .= " AND numero_vuelo LIKE '%$numero_vuelo%'";
  if ($precio_max !== '') {
    $sql .= " AND precio <= $precio_max";
  }
  if ($clase_servicio) $sql .= " AND clase_servicio = '$clase_servicio'";

  $sql .= " ORDER BY fecha, hora_salida";

  $result = $conn->query($sql);

  if (!$result) {
    echo "<p class='text-danger'>❌ Error en la consulta SQL: " . $conn->error . "</p>";
    echo "<p>Consulta ejecutada: <code>$sql</code></p>";
  } else {
    if ($result->num_rows > 0) {
      echo "<h4>✈️ Resultados encontrados:</h4>";
      echo "<table class='table table-striped'>";
      echo "<thead><tr>
              <th>Origen</th><th>Destino</th><th>Fecha</th><th>Hora Salida</th>
              <th>Hora Llegada</th><th>Aerolínea</th><th>Nº Vuelo</th><th>Precio</th>
              <th>Clase Servicio</th><th>Plazas Disponibles</th>
            </tr></thead><tbody>";

      while ($vuelo = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($vuelo['origen']) . "</td>
                <td>" . htmlspecialchars($vuelo['destino']) . "</td>
                <td>" . htmlspecialchars($vuelo['fecha']) . "</td>
                <td>" . htmlspecialchars($vuelo['hora_salida']) . "</td>
                <td>" . htmlspecialchars($vuelo['hora_llegada']) . "</td>
                <td>" . htmlspecialchars($vuelo['aerolinea']) . "</td>
                <td>" . htmlspecialchars($vuelo['numero_vuelo']) . "</td>
                <td>$" . number_format($vuelo['precio'], 2) . "</td>
                <td>" . htmlspecialchars($vuelo['clase_servicio']) . "</td>
                <td>" . htmlspecialchars($vuelo['plazas_disponibles']) . "</td>
              </tr>";
      }
      echo "</tbody></table>";
    } else {
      echo "<p class='text-danger'>No se encontraron vuelos con los criterios seleccionados.</p>";
    }
  }
}
?>


  </div>

<script>
  function validarFormulario() {
    const origen = document.getElementById('origen').value.trim();
    const destino = document.getElementById('destino').value.trim();
    const fecha = document.getElementById('fecha').value.trim();
    const horaSalidaMin = document.getElementById('hora_salida_min').value.trim();
    const horaSalidaMax = document.getElementById('hora_salida_max').value.trim();
    const aerolinea = document.getElementById('aerolinea').value.trim();
    const numeroVuelo = document.getElementById('numero_vuelo').value.trim();
    const precioMax = document.getElementById('precio_max').value.trim();
    const claseServicio = document.getElementById('clase_servicio').value;

    if (!origen) {
      alert('Por favor, ingresa el origen.');
      document.getElementById('origen').focus();
      return false;
    }
    if (!destino) {
      alert('Por favor, ingresa el destino.');
      document.getElementById('destino').focus();
      return false;
    }
    if (!fecha) {
      alert('Por favor, selecciona una fecha.');
      document.getElementById('fecha').focus();
      return false;
    }
    if (!horaSalidaMin) {
      alert('Por favor, ingresa la hora mínima de salida.');
      document.getElementById('hora_salida_min').focus();
      return false;
    }
    if (!horaSalidaMax) {
      alert('Por favor, ingresa la hora máxima de salida.');
      document.getElementById('hora_salida_max').focus();
      return false;
    }
    if (!aerolinea) {
      alert('Por favor, ingresa la aerolínea.');
      document.getElementById('aerolinea').focus();
      return false;
    }
    if (!numeroVuelo) {
      alert('Por favor, ingresa el número de vuelo.');
      document.getElementById('numero_vuelo').focus();
      return false;
    }
    if (precioMax && isNaN(precioMax)) {
      alert('El precio máximo debe ser un número válido.');
      document.getElementById('precio_max').focus();
      return false;
    }
    if (!claseServicio) {
      alert('Por favor, selecciona una clase de servicio.');
      document.getElementById('clase_servicio').focus();
      return false;
    }
    return true;
  }

 function limpiarFormulario() {
  const form = document.getElementById('busquedaForm');
  form.reset();

  // Vaciar manualmente todos los campos para eliminar valores cargados desde PHP
  const inputs = form.querySelectorAll('input, select');
  inputs.forEach(input => {
    if (input.type === 'select-one') {
      input.selectedIndex = 0; // seleccionar opción vacía o la primera
    } else {
      input.value = '';
    }
  });
}
</script>

</body>
</html>
