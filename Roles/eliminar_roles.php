<?php
function eliminarRol() {
    global $conn;
    
    $id = intval($_POST['id'] ?? 0);
    $conn->query("DELETE FROM roles WHERE id=$id");
    return ['success' => 'Rol eliminado correctamente'];
}
?>