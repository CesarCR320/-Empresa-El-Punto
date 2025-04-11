<?php
function editarRol() {
    global $conn;
    
    $id = intval($_POST['id'] ?? 0);
    $nombre = trim($conn->real_escape_string($_POST['nombre'] ?? ''));
    $descripcion = trim($conn->real_escape_string($_POST['descripcion'] ?? ''));
    
    if (empty($nombre)) {
        $_SESSION['message'] = "Error: El nombre del rol es obligatorio";
        return;
    }
    
    $sql = "UPDATE roles SET nombre = ?, descripcion = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $descripcion, $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Rol actualizado correctamente";
    } else {
        $_SESSION['message'] = "Error al actualizar el rol: " . $conn->error;
    }
}

$id = intval($_GET['id'] ?? 0);
$rol = $conn->query("SELECT * FROM roles WHERE id = $id")->fetch_assoc();

if (!$rol) {
    die("Rol no encontrado");
}
?>

<h2>Editar Rol</h2>

<form method="post">
    <input type="hidden" name="action" value="editar">
    <input type="hidden" name="id" value="<?= $rol['id'] ?>">
    
    <div class="form-group">
        <label for="nombre">Nombre del Rol:*</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($rol['nombre']) ?>" required>
    </div>
    
    <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4"><?= htmlspecialchars($rol['descripcion']) ?></textarea>
    </div>
    
    <button type="submit" class="btn">Guardar Cambios</button>
    <button type="button" class="btn cancel" onclick="loadContent('ver_roles.php')">Cancelar</button>
</form>