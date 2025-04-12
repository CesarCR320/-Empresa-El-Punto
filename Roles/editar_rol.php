<?php
function editarRol() {
    global $conn;
    
    $id = intval($_POST['id'] ?? 0);
    $nombre = trim($conn->real_escape_string($_POST['nombre'] ?? ''));
    $descripcion = trim($conn->real_escape_string($_POST['descripcion'] ?? ''));
    
    if (empty($nombre)) {
        return ['error' => 'El nombre del rol es obligatorio'];
    }
    
    $sql = "UPDATE roles SET nombre = ?, descripcion = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $descripcion, $id);
    
    if ($stmt->execute()) {
        return ['success' => 'Rol actualizado correctamente'];
    } else {
        return ['error' => 'Error al actualizar el rol: ' . $conn->error];
    }
}

$id = intval($_GET['id'] ?? 0);
$rol = $conn->query("SELECT * FROM roles WHERE id = $id")->fetch_assoc();

if (!$rol) {
    die('<div class="error"><i class="fas fa-exclamation-triangle"></i> Rol no encontrado</div>');
}
?>

<div class="form-container">
    <h2><i class="fas fa-edit"></i> Editar Rol</h2>
    
    <form method="post">
        <input type="hidden" name="action" value="editar">
        <input type="hidden" name="id" value="<?= $rol['id'] ?>">
        
        <div class="form-group">
            <label for="nombre"><i class="fas fa-tag"></i> Nombre del Rol:*</label>
            <input type="text" id="nombre" name="nombre" 
                   value="<?= htmlspecialchars($rol['nombre']) ?>" required>
        </div>
        
        <div class="form-group">
            <label for="descripcion"><i class="fas fa-align-left"></i> Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4"><?= 
                htmlspecialchars($rol['descripcion']) 
            ?></textarea>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn primary">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
            <button type="button" class="btn cancel" onclick="cargarContenido('ver_roles.php')">
                <i class="fas fa-times"></i> Cancelar
            </button>
        </div>
    </form>
</div>