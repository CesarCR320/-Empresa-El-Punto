<?php
// Incluir archivo de conexión a la base de datos
include('db.php');

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados desde el formulario
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];

    // Actualizar el reporte en la base de datos
    $sql = "UPDATE reportes SET titulo = ?, descripcion = ? WHERE id = ?";
    
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular los parámetros y ejecutar la consulta
        $stmt->bind_param("ssi", $titulo, $descripcion, $id);
        
        if ($stmt->execute()) {
            // Si la actualización es exitosa, redirigir al listado de reportes
            header("Location: ver_reportes.php?success=1");
            exit();
        } else {
            // En caso de error, mostrar un mensaje de error
            echo "Error al actualizar el reporte.";
        }
    } else {
        echo "Error en la preparación de la consulta.";
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
}
?>
