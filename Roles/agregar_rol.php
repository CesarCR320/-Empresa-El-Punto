<?php
function agregarRol() {
    global $conn;
    
    $nombre = trim($conn->real_escape_string($_POST['nombre'] ?? ''));
    $descripcion = trim($conn->real_escape_string($_POST['descripcion'] ?? ''));
    
    if (empty($nombre)) {
        $_SESSION['message'] = "Error: El nombre del rol es obligatorio";
        return;
    }
    
    $sql = "INSERT INTO roles (nombre, descripcion) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre, $descripcion);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Rol agregado correctamente";
    } else {
        $_SESSION['message'] = "Error al agregar el rol: " . $conn->error;
    }
}
?>

<h2>Agregar Nuevo Rol</h2>

<form method="post">
    <input type="hidden" name="action" value="agregar">
    
    <div class="form-group">
        <label for="nombre">Nombre del Rol:*</label>
        <input type="text" id="nombre" name="nombre" required>
    </div>
    
    <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4"></textarea>
    </div>
    
    <button type="submit" class="btn">Guardar Rol</button>
    <button type="button" class="btn cancel" onclick="loadContent('ver_roles.php')">Cancelar</button>
</form>