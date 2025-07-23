<?php
include("conexion.php");

// Obtener datos del formulario con sanitización básica
$nombre = $conn->real_escape_string($_POST['nombre']);
$ubicacion = $conn->real_escape_string($_POST['ubicacion']);
$habitaciones = (int)$_POST['habitaciones'];
$tarifa = (float)$_POST['tarifa'];

$sql = "INSERT INTO HOTEL (nombre, ubicación, habitaciones_disponibles, tarifa_noche)
        VALUES ('$nombre', '$ubicacion', $habitaciones, $tarifa)";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Registrar Hotel</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <h2>Registrar Hotel</h2>
    <?php
    if ($conn->query($sql) === TRUE) {
        echo "<p class='message'>Hotel registrado correctamente.</p>";
    } else {
        echo "<p class='message'>Error: " . htmlspecialchars($conn->error) . "</p>";
    }
    ?>
    <p><a href="form_hotel.html">Volver al formulario</a></p>
  </div>
</body>
</html>
