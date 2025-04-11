<?php
function eliminarRol() {
    global $conn;
    
    $id = intval($_POST['id'] ?? 0);
    
    $sql = "DELETE FROM roles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Rol eliminado correctamente";
    } else {
        $_SESSION['message'] = "Error al eliminar el rol: " . $conn->error;
    }
}