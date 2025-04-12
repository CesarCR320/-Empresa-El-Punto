<?php
function agregarRol() {
    global $conn;
    
    $nombre = trim($conn->real_escape_string($_POST['nombre'] ?? ''));
    $descripcion = trim($conn->real_escape_string($_POST['descripcion'] ?? ''));
    
    if (empty($nombre)) {
        return ['error' => 'El nombre del rol es obligatorio'];
    }
    
    $sql = "INSERT INTO roles (nombre, descripcion) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre, $descripcion);
    
    if ($stmt->execute()) {
        return ['success' => 'Rol agregado correctamente'];
    } else {
        return ['error' => 'Error al agregar el rol: ' . $conn->error];
    }
}
?>

<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-plus-circle"></i> Agregar Nuevo Rol</h2>
        <button class="btn cancel" onclick="cargarContenido('ver_roles.php')">
            <i class="fas fa-arrow-left"></i> Volver
        </button>
    </div>
    
    <div class="card-body">
        <form method="post" class="form-container">
            <input type="hidden" name="action" value="agregar">
            
            <div class="form-group">
                <label for="nombre"><i class="fas fa-tag"></i> Nombre del Rol:*</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="descripcion"><i class="fas fa-align-left"></i> Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" class="form-control"></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn primary">
                    <i class="fas fa-save"></i> Guardar Rol
                </button>
                <button type="reset" class="btn cancel">
                    <i class="fas fa-undo"></i> Limpiar
                </button>
            </div>
        </form>
    </div>
</div>