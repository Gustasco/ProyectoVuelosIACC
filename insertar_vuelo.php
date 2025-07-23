<?php
include("conexion.php");

// Sanitización básica
$origen = $conn->real_escape_string($_POST['origen']);
$destino = $conn->real_escape_string($_POST['destino']);
$fecha = $conn->real_escape_string($_POST['fecha']);
$plazas = (int)$_POST['plazas'];
$precio = (float)$_POST['precio'];

$sql = "INSERT INTO VUELO (origen, destino, fecha, plazas_disponibles, precio)
        VALUES ('$origen', '$destino', '$fecha', $plazas, $precio)";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Registrar Vuelo</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <h2>Registrar Vuelo</h2>
    <?php
    if ($conn->query($sql) === TRUE) {
        echo "<p class='message'>Vuelo registrado correctamente.</p>";
    } else {
        echo "<p class='message'>Error: " . htmlspecialchars($conn->error) . "</p>";
    }
    ?>
    <p><a href="form_vuelo.html">Volver al formulario</a></p>
  </div>
</body>
</html>
