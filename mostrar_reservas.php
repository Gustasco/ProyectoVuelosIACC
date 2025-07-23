<?php
include("conexion.php");

$resultado = $conn->query("SELECT * FROM RESERVA");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Reservas Registradas</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <h2>Reservas registradas</h2>
    <?php if ($resultado->num_rows > 0): ?>
      <table>
        <thead>
          <tr>
            <th>ID Reserva</th>
            <th>ID Cliente</th>
            <th>Fecha</th>
            <th>ID Vuelo</th>
            <th>ID Hotel</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($fila['id_reserva']) ?></td>
              <td><?= htmlspecialchars($fila['id_cliente']) ?></td>
              <td><?= htmlspecialchars($fila['fecha_reserva']) ?></td>
              <td><?= htmlspecialchars($fila['id_vuelo']) ?></td>
              <td><?= htmlspecialchars($fila['id_hotel']) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No hay reservas registradas.</p>
    <?php endif; ?>
    <p><a href="index.html">Volver al inicio</a></p>
  </div>
</body>
</html>
