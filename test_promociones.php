<?php
/**
 * Script de prueba simple para verificar que la API funciona
 */

require_once 'conexion.php';

echo "🧪 Probando conexión y consulta directa...\n";

// Consulta directa
$sql = "SELECT 
            id, titulo, descripcion, imagen_url, descuento_porcentaje, 
            precio_desde, destino_relacionado, clicks_totales
        FROM promociones 
        WHERE activa = TRUE 
        AND CURDATE() BETWEEN fecha_inicio AND fecha_fin 
        ORDER BY orden_prioridad ASC 
        LIMIT 6";

$result = $conn->query($sql);

if (!$result) {
    echo "❌ Error en consulta: " . $conn->error . "\n";
    exit;
}

echo "✅ Consulta ejecutada correctamente\n";
echo "📊 Registros encontrados: " . $result->num_rows . "\n\n";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "🎯 ID: {$row['id']} - {$row['titulo']}\n";
        echo "   💰 Desde €{$row['precio_desde']} | -{$row['descuento_porcentaje']}% OFF\n";
        echo "   🌍 {$row['destino_relacionado']} | 👆 {$row['clicks_totales']} clicks\n";
        echo "   🖼️ {$row['imagen_url']}\n\n";
    }
} else {
    echo "⚠️ No se encontraron promociones activas en el rango de fechas\n";
    
    // Verificar todas las promociones sin filtro de fechas
    $all_result = $conn->query("SELECT COUNT(*) as total FROM promociones WHERE activa = TRUE");
    $all_count = $all_result->fetch_assoc()['total'];
    echo "ℹ️ Total de promociones activas (sin filtro de fechas): {$all_count}\n";
}

$conn->close();
?>
