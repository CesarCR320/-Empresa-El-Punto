<?php
include 'conexion.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nombre_cliente = $_POST['nombre_cliente'];
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $fecha_venta = $_POST['fecha_venta']; 
    $precio = $_POST['precio']; 
    
    
    if(empty($nombre_cliente) || empty($producto) || empty($cantidad) || empty($fecha_venta) || empty($precio)) {
        header("Location: index.php?error=1&message=Faltan campos obligatorios");
        exit();
    }
    
    
    $sql = "INSERT INTO ventas (nombre_cliente, producto, cantidad, fecha_venta, precio) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conexion->prepare($sql);
    
    if($stmt === false) {
        die("Error al preparar la consulta: " . $conexion->error);
    }
    
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