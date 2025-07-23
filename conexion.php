<?php
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$bd = 'AGENCIA';

$conn = new mysqli($host, $usuario, $contrasena, $bd);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>