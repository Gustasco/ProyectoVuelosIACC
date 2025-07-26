<?php
include("conexion.php");

// Validación y sanitización de entrada
$origen = trim($_GET['origen'] ?? '');
$destino = trim($_GET['destino'] ?? '');
$fecha = $_GET['fecha'] ?? '';

// Validar que al menos origen o destino estén presentes
if (empty($origen) && empty($destino)) {
    header("Location: form_buscar.html?error=campos_requeridos");
    exit();
}

$sql = "SELECT * FROM vuelo WHERE 1=1";
$params = [];
$tipos = "";

if (!empty($origen)) {
    $sql .= " AND origen LIKE ?";
    $params[] = "%$origen%";
    $tipos .= "s";
}

if (!empty($destino)) {
    $sql .= " AND destino LIKE ?";
    $params[] = "%$destino%";
    $tipos .= "s";
}

if (!empty($fecha)) {
    $sql .= " AND fecha = ?";
    $params[] = $fecha;
    $tipos .= "s";
}

$sql .= " ORDER BY fecha ASC, precio ASC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($tipos, ...$params);
}

$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resultados de Búsqueda - Agencia de Viajes</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <nav>
      <ul>
        <li><a href="index.html">Inicio</a></li>
        <li><a href="form_buscar.html">Nueva Búsqueda</a></li>
        <li><a href="form_vuelo.html">Agregar Vuelo</a></li>
        <li><a href="consulta_reservas.php">Ver Reservas</a></li>
        <li><a href="mostrar_reservas.php">Todas las Reservas</a></li>
      </ul>
    </nav>

    <h2>📋 Resultados de la Búsqueda de Vuelos</h2>
    
    <div class="search-summary">
      <p><strong>Criterios de búsqueda:</strong> 
        <?php if (!empty($origen)): ?>
          <span class="search-criteria">Desde: <?= htmlspecialchars($origen) ?></span>
        <?php endif; ?>
        <?php if (!empty($destino)): ?>
          <span class="search-criteria">Hacia: <?= htmlspecialchars($destino) ?></span>
        <?php endif; ?>
        <?php if (!empty($fecha)): ?>
          <span class="search-criteria">Fecha: <?= htmlspecialchars($fecha) ?></span>
        <?php endif; ?>
      </p>
    </div>

    <?php if ($resultado->num_rows > 0): ?>
      <p class="results-count">✅ Se encontraron <strong><?= $resultado->num_rows ?></strong> vuelo(s)</p>
      <table>
        <thead>
          <tr>
            <th>🛫 Origen</th>
            <th>🛬 Destino</th>
            <th>📅 Fecha</th>
            <th>💺 Plazas Disponibles</th>
            <th>💰 Precio</th>
            <th>🎫 Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($vuelo = $resultado->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($vuelo['origen']) ?></td>
              <td><?= htmlspecialchars($vuelo['destino']) ?></td>
              <td><?= date('d/m/Y', strtotime($vuelo['fecha'])) ?></td>
              <td class="<?= $vuelo['plazas_disponibles'] <= 5 ? 'low-availability' : '' ?>">
                <?= htmlspecialchars($vuelo['plazas_disponibles']) ?>
                <?php if ($vuelo['plazas_disponibles'] <= 5): ?>
                  <span class="warning">⚠️ Pocas plazas</span>
                <?php endif; ?>
              </td>
              <td class="price">$<?= number_format($vuelo['precio'], 2) ?></td>
              <td>
                <?php if ($vuelo['plazas_disponibles'] > 0): ?>
                  <a href="reservar_vuelo.php?id=<?= $vuelo['id'] ?>" class="btn-reservar">✈️ Reservar</a>
                <?php else: ?>
                  <span class="no-disponible">❌ No disponible</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="message no-results">
        <h3>❌ No se encontraron vuelos</h3>
        <p>No se encontraron vuelos que coincidan con los criterios de búsqueda.</p>
        <p>💡 <strong>Sugerencias:</strong></p>
        <ul>
          <li>Verifica la ortografía de las ciudades</li>
          <li>Intenta con fechas diferentes</li>
          <li>Prueba búsquedas más generales</li>
        </ul>
        <a href="form_buscar.html" class="btn">🔍 Nueva Búsqueda</a>
      </div>
    <?php endif; ?>
    
    <div class="action-buttons">
      <a href="form_buscar.html" class="btn">🔍 Nueva Búsqueda</a>
      <a href="index.html" class="btn btn-secondary">🏠 Volver al Inicio</a>
    </div>
  </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
