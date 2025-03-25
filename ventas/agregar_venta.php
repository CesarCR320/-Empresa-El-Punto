<?php
include 'conexion.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener todos los campos del formulario
    $nombre_cliente = $_POST['nombre_cliente'];
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $fecha_venta = $_POST['fecha_venta']; // Asegúrate de tener este campo en el formulario
    $precio = $_POST['precio']; // Asegúrate de tener este campo en el formulario
    
    // Validación básica
    if(empty($nombre_cliente) || empty($producto) || empty($cantidad) || empty($fecha_venta) || empty($precio)) {
        header("Location: index.php?error=1&message=Faltan campos obligatorios");
        exit();
    }
    
    // Consulta INSERT actualizada con TODOS los campos
    $sql = "INSERT INTO ventas (nombre_cliente, producto, cantidad, fecha_venta, precio) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conexion->prepare($sql);
    
    if($stmt === false) {
        die("Error al preparar la consulta: " . $conexion->error);
    }
    
    // Vincular parámetros (asegúrate que el orden coincida con la consulta SQL)
    // Tipos: s=string, i=integer, d=double
    $stmt->bind_param("ssisd", $nombre_cliente, $producto, $cantidad, $fecha_venta, $precio);
    
    if($stmt->execute()) {
        header("Location: index.php?success=1&message=Venta agregada correctamente");
    } else {
        header("Location: index.php?error=1&message=Error al agregar venta: " . urlencode($stmt->error));
    }
    
    $stmt->close();
    $conexion->close();
} else {
    header("Location: index.php");
}
?>