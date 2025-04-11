<?php
function eliminarRol() {
    global $conn;
    
    $id = intval($_POST['id'] ?? 0);
    
    // Primero eliminamos los permisos asociados
    $conn->query("DELETE FROM rol_permisos WHERE rol_id = $id");
    
    // Luego eliminamos el rol
    $sql = "DELETE FROM roles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        return ['success' => 'Rol eliminado correctamente'];
    } else {
        return ['error' => 'Error al eliminar el rol: ' . $conn->error];
    }
}
?>