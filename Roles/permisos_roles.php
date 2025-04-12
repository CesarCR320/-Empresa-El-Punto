<?php
function actualizarPermisos() {
    global $conn;
    
    $id_rol = intval($_POST['id_rol'] ?? 0);
    $permisos = isset($_POST['permisos']) ? $_POST['permisos'] : [];
    $permisos = array_map('intval', $permisos);
    
    // Eliminar permisos actuales
    $conn->query("DELETE FROM rol_permisos WHERE rol_id = $id_rol");
    
    // Insertar nuevos permisos
    foreach ($permisos as $permiso_id) {
        $conn->query("INSERT INTO rol_permisos (rol_id, permiso_id) VALUES ($id_rol, $permiso_id)");
    }
    
    return ['success' => 'Permisos actualizados correctamente'];
}

$id_rol = intval($_GET['id'] ?? 0);

// Obtener información del rol
$rol = $conn->query("SELECT nombre FROM roles WHERE id = $id_rol")->fetch_assoc();
if (!$rol) {
    die('<div class="error"><i class="fas fa-exclamation-triangle"></i> Rol no encontrado</div>');
}

// Obtener todos los permisos disponibles
$permisos = $conn->query("SELECT id, nombre, descripcion FROM permisos")->fetch_all(MYSQLI_ASSOC);

// Obtener permisos asignados al rol
$asignados = $conn->query("SELECT permiso_id FROM rol_permisos WHERE rol_id = $id_rol")->fetch_all(MYSQLI_COLUMN, 0);
?>

<div class="permissions-container">
    <h2><i class="fas fa-key"></i> Permisos del Rol: <?= htmlspecialchars($rol['nombre']) ?></h2>
    
    <form method="post">
        <input type="hidden" name="action" value="update_permissions">
        <input type="hidden" name="id_rol" value="<?= $id_rol ?>">
        
        <div class="permissions-list">
            <?php foreach ($permisos as $permiso): ?>
            <div class="permission-item">
                <label>
                    <input type="checkbox" name="permisos[]" value="<?= $permiso['id'] ?>"
                        <?= in_array($permiso['id'], $asignados) ? 'checked' : '' ?>>
                    <strong><?= htmlspecialchars($permiso['nombre']) ?></strong>
                    <span><?= htmlspecialchars($permiso['descripcion']) ?></span>
                </label>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn primary">
                <i class="fas fa-save"></i> Guardar Permisos
            </button>
            <button type="button" class="btn cancel" onclick="cargarContenido('ver_roles.php')">
                <i class="fas fa-times"></i> Volver
            </button>
        </div>
    </form>
</div>