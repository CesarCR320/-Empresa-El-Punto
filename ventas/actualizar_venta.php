<?php
include 'conexion.php';

function redirect($location, $params = []) {
    $query = http_build_query($params);
    header("Location: $location" . ($query ? "?$query" : ""));
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Obtener y validar datos
        $id = $_POST['id'] ?? null;
        $nombre_cliente = htmlspecialchars(trim($_POST['nombre_cliente'] ?? ''));
        $producto = htmlspecialchars(trim($_POST['producto'] ?? ''));
        $cantidad = $_POST['cantidad'] ?? null;
        $fecha_venta = $_POST['fecha_venta'] ?? null;
        $precio = $_POST['precio'] ?? null;
        
        // Validaciones
        if(!is_numeric($id) || !is_numeric($cantidad) || !is_numeric($precio)) {
            redirect('index.php', ['error' => 1, 'message' => 'Datos numéricos inválidos']);
        }
        
        if(empty($nombre_cliente) || empty($producto) || $cantidad <= 0 || empty($fecha_venta) || $precio <= 0) {
            redirect('index.php', ['error' => 1, 'message' => 'Faltan campos obligatorios o valores inválidos']);
        }
        
        if(!strtotime($fecha_venta)) {
            redirect('index.php', ['error' => 1, 'message' => 'Formato de fecha inválido']);
        }
        
        // Preparar consulta
        $sql = "UPDATE ventas SET 
                nombre_cliente = ?, 
                producto = ?, 
                cantidad = ?, 
                fecha_venta = ?, 
                precio = ? 
                WHERE id = ?";
        
        $stmt = $conexion->prepare($sql);
        if($stmt === false) {
            throw new Exception("Error al preparar la consulta: " . $conexion->error);
        }
        
        $stmt->bind_param("ssisdi", $nombre_cliente, $producto, $cantidad, $fecha_venta, $precio, $id);
        
        if(!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
        
        redirect('index.php', ['success' => 1, 'message' => 'Venta actualizada correctamente']);
        
    } catch (Exception $e) {
        error_log("Error en actualización: " . $e->getMessage());
        redirect('index.php', ['error' => 1, 'message' => 'Error al actualizar la venta']);
    } finally {
        if(isset($stmt)) $stmt->close();
        $conexion->close();
    }
} else {
    redirect('index.php');
}
?>