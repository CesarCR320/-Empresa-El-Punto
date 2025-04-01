<?php
include_once 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta SQL para eliminar al empleado
    $sql = "DELETE FROM empleados WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Si se elimina correctamente, redirigir a la lista de empleados
        header("Location: ver_empleados.php");
        exit();
    } else {
        echo "Error al eliminar el empleado.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID no proporcionado.";
}
?>
