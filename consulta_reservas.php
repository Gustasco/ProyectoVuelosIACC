<?php
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hoteles con más de 2 reservas - Agencia de Viajes</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <nav>
      <ul>
        <li><a href="index.html">Inicio</a></li>
        <li><a href="form_buscar.html">Buscar Vuelos</a></li>
        <li><a href="form_vuelo.html">Agregar Vuelo</a></li>
        <li><a href="form_hotel.html">Agregar Hotel</a></li>
        <li><a href="mostrar_reservas.php">Todas las Reservas</a></li>
      </ul>
    </nav>
    
    <h2>📊 Hoteles con más de 2 reservas</h2>
    <?php
    $sql = "
      SELECT h.nombre, COUNT(*) AS total_reservas
      FROM reserva r
      JOIN hotel h ON r.hotel_id = h.id
      WHERE r.hotel_id IS NOT NULL
      GROUP BY r.hotel_id, h.nombre
      HAVING COUNT(*) > 2
      ORDER BY total_reservas DESC
    ";

    $resultado = $conn->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        echo "<div class='results-section'>";
        while ($fila = $resultado->fetch_assoc()) {
            echo "<div class='hotel-result'>";
            echo "<h3>🏨 " . htmlspecialchars($fila['nombre']) . "</h3>";
            echo "<p class='reservation-count'>📋 Total de reservas: <strong>" . $fila['total_reservas'] . "</strong></p>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<div class='message no-results'>";
        echo "<h3>📊 Sin resultados</h3>";
        echo "<p>No hay hoteles con más de 2 reservas en este momento.</p>";
        echo "<p>💡 <strong>Nota:</strong> Esto puede ser porque:</p>";
        echo "<ul>";
        echo "<li>Los hoteles registrados tienen pocas reservas</li>";
        echo "<li>Las reservas están asociadas principalmente a vuelos</li>";
        echo "<li>Se necesitan más datos de prueba</li>";
        echo "</ul>";
        echo "</div>";
    }

    // Mostrar estadísticas adicionales
    echo "<div class='stats-section'>";
    echo "<h3>📈 Estadísticas Generales</h3>";
    
    // Total de hoteles
    $sql_hoteles = "SELECT COUNT(*) as total FROM hotel WHERE estado = 'activo'";
    $result_hoteles = $conn->query($sql_hoteles);
    $total_hoteles = $result_hoteles->fetch_assoc()['total'];
    
    // Total de reservas de hotel
    $sql_reservas = "SELECT COUNT(*) as total FROM reserva WHERE hotel_id IS NOT NULL";
    $result_reservas = $conn->query($sql_reservas);
    $total_reservas = $result_reservas->fetch_assoc()['total'];
    
    echo "<div class='stat-item'>";
    echo "<span class='stat-label'>🏨 Hoteles registrados:</span>";
    echo "<span class='stat-value'>$total_hoteles</span>";
    echo "</div>";
    
    echo "<div class='stat-item'>";
    echo "<span class='stat-label'>📋 Reservas de hotel:</span>";
    echo "<span class='stat-value'>$total_reservas</span>";
    echo "</div>";
    
    echo "</div>";
    ?>
  </div>
</body>
</html>
