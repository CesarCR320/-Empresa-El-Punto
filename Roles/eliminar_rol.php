<?php
function eliminarRol() {
    global $conn;
    
    $id = intval($_POST['id'] ?? 0);
    
    // Verificar si el rol existe
    $rol = $conn->query("SELECT id FROM roles WHERE id = $id")->fetch_assoc();
    if (!$rol) {
        return ['error' => 'Rol no encontrado'];
    }
    
    // Eliminar el rol
    if ($conn->query("DELETE FROM roles WHERE id = $id")) {
        return ['success' => 'Rol eliminado correctamente'];
    } else {
        return ['error' => 'Error al eliminar el rol: ' . $conn->error];
    }
}
?>