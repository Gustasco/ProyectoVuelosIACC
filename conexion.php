<?php
/**
 * Configuración de Conexión a la Base de Datos
 * Sistema de Gestión de Agencia de Viajes
 * 
 * @author Gustasco
 * @version 2.0
 */

// Configuración de la base de datos
$host = 'localhost:3306';     // Servidor de base de datos (cambiar puerto si es necesario)
$usuario = 'root';            // Usuario de MySQL (por defecto en XAMPP)
$contrasena = 'root';         // Contraseña de MySQL
$bd = 'agencia_viajes';       // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $bd);

// Verificar conexión (no usar die() para APIs)
if ($conn->connect_error) {
    // Para páginas web normales
    if (!isset($_SERVER['HTTP_ACCEPT']) || strpos($_SERVER['HTTP_ACCEPT'], 'application/json') === false) {
        die("❌ Error de conexión a la base de datos: " . $conn->connect_error);
    }
    // Para APIs, lanzar excepción que será manejada apropiadamente
    throw new Exception("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Configurar charset para caracteres especiales
$conn->set_charset("utf8mb4");

// Mostrar mensaje de éxito (solo en modo desarrollo)
// echo "✅ Conexión exitosa a la base de datos '$bd'";
?>