<?php
include("conexion.php");

$error = false;
for ($i = 1; $i <= 10; $i++) {
    $id_cliente = 100 + $i;
    $fecha = date('Y-m-d');
    $id_vuelo = rand(1, 3);
    $id_hotel = rand(1, 3);

    $sql = "INSERT INTO RESERVA (id_cliente, fecha_reserva, id_vuelo, id_hotel)
            VALUES ($id_cliente, '$fecha', $id_vuelo, $id_hotel)";

    if (!$conn->query($sql)) {
        $error = true;
        $error_msg = $conn->error;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Insertar Reservas</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <h2>Registro de Reservas</h2>
    <?php
    if (!$error) {
        echo "<p class='message'>10 reservas creadas exitosamente.</p>";
    } else {
        echo "<p class='message'>Error al insertar reservas: " . htmlspecialchars($error_msg) . "</p>";
    }
    ?>
    <p><a href="index.html">Volver al inicio</a></p>
  </div>
</body>
</html>
