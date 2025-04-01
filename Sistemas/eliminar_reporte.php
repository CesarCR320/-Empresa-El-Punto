<?php
// Incluir archivo de conexión a la base de datos
include('db.php');

// Verificar si el ID del reporte ha sido recibido
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta SQL para eliminar el reporte
    $sql = "DELETE FROM reportes WHERE id = ?";

    if ($stmt = $conexion->prepare($sql)) {
        // Vincular el parámetro ID y ejecutar la consulta
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Si la eliminación es exitosa, redirigir al listado de reportes
            header("Location: ver_reportes.php?success=2");
            exit();
        } else {
            // En caso de error, mostrar un mensaje
            echo "Error al eliminar el reporte.";
        }
    } else {
        echo "Error en la preparación de la consulta.";
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
}
?>
