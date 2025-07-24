<?php
/**
 * Script para actualizar las fechas de las promociones
 */

require_once 'conexion.php';

echo "🔄 Actualizando fechas de promociones...\n";

// Actualizar todas las promociones para que sean válidas desde hoy
$fecha_inicio = date('Y-m-d'); // Hoy
$fecha_fin = date('Y-m-d', strtotime('+60 days')); // 60 días desde hoy

$sql = "UPDATE promociones 
        SET fecha_inicio = ?, fecha_fin = ? 
        WHERE activa = TRUE";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $fecha_inicio, $fecha_fin);

if ($stmt->execute()) {
    $affected = $stmt->affected_rows;
    echo "✅ {$affected} promociones actualizadas\n";
    echo "📅 Período válido: {$fecha_inicio} hasta {$fecha_fin}\n";
} else {
    echo "❌ Error actualizando fechas: " . $stmt->error . "\n";
}

$stmt->close();

// Verificar que ahora funcione
echo "\n🧪 Verificando consulta con nuevas fechas...\n";
$result = $conn->query("SELECT COUNT(*) as count FROM promociones WHERE activa = TRUE AND CURDATE() BETWEEN fecha_inicio AND fecha_fin");
$count = $result->fetch_assoc()['count'];
echo "✅ Promociones válidas ahora: {$count}\n";

$conn->close();
?>
