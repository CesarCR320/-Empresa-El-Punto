<?php
include_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $puesto = $_POST['puesto'];
    $telefono = $_POST['telefono'];

    // Consulta SQL para actualizar los datos del empleado
    $sql = "UPDATE empleados SET nombre = ?, puesto = ?, telefono = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $puesto, $telefono, $id);

    if ($stmt->execute()) {
        // Redirigir después de actualizar los datos
        header("Location: ver_empleados.php");
        exit();
    } else {
        echo "Error al actualizar los datos.";
    }

    $stmt->close();
}

$conn->close();
?>
