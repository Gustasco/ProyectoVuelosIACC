<?php
require_once 'conexion.php';

echo "🔍 Inspeccionando datos de promociones...\n\n";

$result = $conn->query("SELECT id, titulo, fecha_inicio, fecha_fin, activa, CURDATE() as hoy FROM promociones ORDER BY id");

while ($row = $result->fetch_assoc()) {
    echo "ID: {$row['id']} | {$row['titulo']}\n";
    echo "   Inicio: {$row['fecha_inicio']} | Fin: {$row['fecha_fin']} | Activa: {$row['activa']}\n";
    echo "   Hoy: {$row['hoy']}\n";
    
    // Verificar manualmente si está en rango
    $hoy = $row['hoy'];
    $inicio = $row['fecha_inicio'];
    $fin = $row['fecha_fin'];
    $en_rango = ($hoy >= $inicio && $hoy <= $fin) ? '✅' : '❌';
    echo "   En rango: {$en_rango}\n\n";
}

$conn->close();
?>
