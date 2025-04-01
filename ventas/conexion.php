<?php
$conexion = new mysqli("localhost", "root", "", "el punto");


if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


$sql = "SELECT id, nombre_cliente, producto, cantidad, fecha_venta, precio FROM ventas";
$resultado = $conexion->query($sql);

if ($resultado) {
    
    $tablaVentas = $resultado->fetch_all(MYSQLI_ASSOC);
} else {
    $tablaVentas = [];
    error_log("Error en la consulta: " . $conexion->error);
}

?>