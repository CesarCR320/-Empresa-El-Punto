<?php
// Conexión a la base de datos
function conectarDB() {
    $servidor = "localhost";
    $usuario = "root";
    $password = "";
    $baseDatos = "compras";
    
    // Crear conexión
    $conexion = new mysqli($servidor, $usuario, $password, $baseDatos);
    
    // Verificar conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    // Configurar charset
    $conexion->set_charset("utf8");
    
    return $conexion;
}

?>