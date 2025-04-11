<?php
function editarRol() {
    global $conn;
    
    $id = intval($_POST['id'] ?? 0);
    $nombre = $conn->real_escape_string($_POST['nombre'] ?? '');
    $descripcion = $conn->real_escape_string($_POST['descripcion'] ?? '');
    
    $conn->query("UPDATE roles SET nombre='$nombre', descripcion='$descripcion' WHERE id=$id");
    return ['success' => 'Rol actualizado correctamente'];
}

$id = intval($_GET['id'] ?? 0);
$rol = $conn->query("SELECT * FROM roles WHERE id=$id")->fetch_assoc();
?>

<h2>Editar Rol</h2>

<form method="post" onsubmit="enviarFormulario(this); return false;">
    <input type="hidden" name="action" value="editar">
    <input type="hidden" name="id" value="<?= $rol['id'] ?>">
    
    <label>
        Nombre:
        <input type="text" name="nombre" value="<?= htmlspecialchars($rol['nombre']) ?>" required>
    </label>
    
    <label>
        Descripción:
        <textarea name="descripcion"><?= htmlspecialchars($rol['descripcion']) ?></textarea>
    </label>
    
    <button type="submit">Guardar Cambios</button>
</form>