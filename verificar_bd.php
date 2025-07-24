<?php
/**
 * Script para verificar y crear la base de datos si no existe
 */

// Conectar sin especificar base de datos para crearla si no existe
$conn = new mysqli('localhost', 'root', '');

if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

echo "✅ Conexión a MySQL exitosa\n";

// Crear base de datos si no existe
$sql = "CREATE DATABASE IF NOT EXISTS agencia_viajes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if ($conn->query($sql)) {
    echo "✅ Base de datos 'agencia_viajes' verificada/creada\n";
} else {
    echo "❌ Error creando base de datos: " . $conn->error . "\n";
}

// Seleccionar la base de datos
$conn->select_db('agencia_viajes');

// Verificar si la tabla promociones existe
$result = $conn->query("SHOW TABLES LIKE 'promociones'");
if ($result->num_rows == 0) {
    echo "ℹ️ Tabla 'promociones' no existe, será creada por el script de inserción\n";
} else {
    echo "✅ Tabla 'promociones' existe\n";
    
    // Contar registros
    $count = $conn->query("SELECT COUNT(*) as total FROM promociones WHERE activa = TRUE");
    $total = $count->fetch_assoc()['total'];
    echo "📊 Promociones activas: {$total}\n";
}

$conn->close();
echo "🎯 Conexión verificada correctamente\n";
?>
