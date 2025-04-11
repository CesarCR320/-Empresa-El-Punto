<?php
function agregarRol() {
    global $conn;
    
    $nombre = $conn->real_escape_string($_POST['nombre'] ?? '');
    $descripcion = $conn->real_escape_string($_POST['descripcion'] ?? '');
    
    if (empty($nombre)) {
        return ['error' => 'El nombre es requerido'];
    }
    
    $conn->query("INSERT INTO roles (nombre, descripcion) VALUES ('$nombre', '$descripcion')");
    return ['success' => 'Rol agregado correctamente'];
}
?>

<h2>Agregar Nuevo Rol</h2>

<form method="post" onsubmit="enviarFormulario(this); return false;">
    <input type="hidden" name="action" value="agregar">
    
    <label>
        Nombre:
        <input type="text" name="nombre" required>
    </label>
    
    <label>
        Descripción:
        <textarea name="descripcion"></textarea>
    </label>
    
    <button type="submit">Guardar</button>
</form>

<script>
function enviarFormulario(form) {
    const formData = new FormData(form);
    
    fetch('index.php', {
        method: 'POST',
        body: formData
    }).then(() => cargarContenido('ver_roles.php'));
}
</script>