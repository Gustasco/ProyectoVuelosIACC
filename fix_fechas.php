<?php
require_once 'conexion.php';

echo "🔧 Corrigiendo fechas de promociones...\n";

$sql = "UPDATE promociones SET fecha_inicio = CURDATE() WHERE activa = TRUE";
$result = $conn->query($sql);

echo "✅ Promociones actualizadas: " . $conn->affected_rows . "\n";

// Verificar
$check = $conn->query("SELECT COUNT(*) as count FROM promociones WHERE activa = TRUE AND CURDATE() BETWEEN fecha_inicio AND fecha_fin");
$count = $check->fetch_assoc()['count'];
echo "🎯 Promociones válidas ahora: {$count}\n";

$conn->close();
?>
