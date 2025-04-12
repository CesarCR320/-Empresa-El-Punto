<?php
include 'conexion_r.php';

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

// Solo procesar POST si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'editar') {
    header('Content-Type: application/json');
    echo json_encode(editarRol());
    exit();
}

$id = intval($_GET['id'] ?? 0);
$rol = $conn->query("SELECT * FROM roles WHERE id = $id")->fetch_assoc();

if (!$rol) {
    die('<div class="error"><i class="fas fa-exclamation-triangle"></i> Rol no encontrado</div>');
}
?>

<div class="card">
    <div class="card-body">
        <h2><i class="fas fa-edit"></i> Editar Rol</h2>
        
        <form method="post" id="form-editar-rol">
            <input type="hidden" name="action" value="editar">
            <input type="hidden" name="id" value="<?= $rol['id'] ?>">
            
            <div class="form-group">
                <label for="id_rol">ID:</label>
                <input type="text" id="id_rol" value="<?= $rol['id'] ?>" class="form-control" disabled>
            </div>
            
            <div class="form-group">
                <label for="nombre">Nombre del Rol:*</label>
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($rol['nombre']) ?>" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" class="form-control"><?= htmlspecialchars($rol['descripcion']) ?></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn primary" id="btn-guardar">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
                <button type="button" class="btn cancel" onclick="window.location.href='ver_roles.php'">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-editar-rol');
    const btnGuardar = document.getElementById('btn-guardar');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Mostrar estado de carga
        btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        btnGuardar.disabled = true;
        
        const formData = new FormData(form);
        
        fetch('editar_rol.php', {  // Cambiado a editar_rol.php
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                window.location.href = 'ver_roles.php?success=' + encodeURIComponent(data.success);
            } else {
                alert('Error: ' + (data.error || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al conectar con el servidor: ' + error.message);
        })
        .finally(() => {
            btnGuardar.innerHTML = '<i class="fas fa-save"></i> Guardar Cambios';
            btnGuardar.disabled = false;
        });
    });
});
</script>