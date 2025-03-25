<?php
include_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $telefono = $_POST['telefono'];

    
    $sql = "UPDATE proveedores SET nombre = ?, contacto = ?, telefono = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $contacto, $telefono, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Proveedor actualizado con éxito');</script>";
        echo "<script>window.location.href = 'ver_proveedores.php';</script>"; 
    } else {
        echo "<script>alert('Error al actualizar proveedor');</script>";
    }

    $stmt->close();
}
$conn->close();
?>
