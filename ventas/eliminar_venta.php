<?php
// Habilitar mostrar errores (solo para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'conexion.php';

// Verificar que se recibió el ID
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Validar que el ID sea numérico
    if(!is_numeric($id)) {
        header("Location: index.php?error=1&message=ID inválido");
        exit();
    }
    
    // Preparar consulta con sentencia preparada
    $sql = "DELETE FROM ventas WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    
    if($stmt === false) {
        die("Error al preparar la consulta: " . $conexion->error);
    }
    
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        // Redirigir con mensaje de éxito
        header("Location: index.php?success=1&message=Venta eliminada correctamente");
    } else {
        // Redirigir con mensaje de error
        header("Location: index.php?error=1&message=Error al eliminar venta: " . urlencode($stmt->error));
    }
    
    $stmt->close();
} else {
    // Si no se proporcionó ID
    header("Location: index.php?error=1&message=No se especificó ID para eliminar");
}

$conexion->close();
?>