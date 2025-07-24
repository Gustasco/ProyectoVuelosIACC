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
      SELECT H.nombre, COUNT(*) AS total_reservas
      FROM RESERVA R
      JOIN HOTEL H ON R.id_hotel = H.id_hotel
      GROUP BY R.id_hotel
      HAVING COUNT(*) > 2
    ";

    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<p>Hotel: <strong>" . htmlspecialchars($fila['nombre']) . "</strong> - Reservas: <strong>" . $fila['total_reservas'] . "</strong></p>";
        }
    } else {
        echo "<p>No hay hoteles con más de 2 reservas.</p>";
    }
    ?>
  </div>
</body>
</html>
