<?php
/**
 * Configuración de Conexión a la Base de Datos
 * Sistema de Gestión de Agencia de Viajes
 * 
 * @author Gustasco
 * @version 2.0
 */

// Configuración de la base de datos
$host = 'localhost';          // Servidor de base de datos
$usuario = 'root';            // Usuario de MySQL (por defecto en XAMPP)
$contrasena = '';             // Contraseña (vacía por defecto en XAMPP)
$bd = 'agencia_viajes';       // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $bd);

// Verificar conexión
if ($conn->connect_error) {
    die("❌ Error de conexión a la base de datos: " . $conn->connect_error);
}

// Configurar charset para caracteres especiales
$conn->set_charset("utf8mb4");

// Mostrar mensaje de éxito (solo en modo desarrollo)
// echo "✅ Conexión exitosa a la base de datos '$bd'";
?>