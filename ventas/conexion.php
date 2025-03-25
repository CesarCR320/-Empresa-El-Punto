<?php
$conexion = new mysqli("localhost", "root", "", "el punto");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener datos
$sql = "SELECT id, nombre_cliente, producto, cantidad, fecha_venta, precio FROM ventas";
$resultado = $conexion->query($sql);

if ($resultado) {
    // Convertir el resultado a un array asociativo
    $tablaVentas = $resultado->fetch_all(MYSQLI_ASSOC);
} else {
    $tablaVentas = [];
    error_log("Error en la consulta: " . $conexion->error);
}

// No cierres la conexión aquí si la vas a usar después
?>