<?php
include_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    
    $sql = "DELETE FROM proveedores WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Proveedor eliminado con éxito');</script>";
        echo "<script>window.location.href = 'ver_proveedores.php';</script>"; 
    } else {
        echo "<script>alert('Error al eliminar proveedor');</script>";
    }

    $stmt->close();
}
$conn->close();
?>
