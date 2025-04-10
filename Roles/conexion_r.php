<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "Mroles";

// Crear conexión
$conn = new mysqli($servidor, $usuario, $password, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error . ". Por favor, contacta al administrador del sistema.");
}

// Establecer el conjunto de caracteres
$conn->set_charset("utf8mb4");

// Opcional: Descomentar para desarrollo (muestra errores SQL)
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>