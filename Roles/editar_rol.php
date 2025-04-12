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

// Obtener el ID del rol a editar
$id = intval($_GET['id'] ?? 0);

// Consultar el rol existente
$sql = "SELECT * FROM roles WHERE id = $id";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $rol = $resultado->fetch_assoc();
} else {
    die('<div class="error"><i class="fas fa-exclamation-triangle"></i> Rol no encontrado</div>');
}

// Procesar el formulario si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'editar') {
    $result = editarRol();
    if (isset($result['success'])) {
        header("Location: ver_roles.php?success=" . urlencode($result['success']));
        exit();
    } else {
        $error = $result['error'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Rol</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1><i class="fas fa-edit"></i> Editar Rol</h1>
            
            <?php if (isset($error)): ?>
                <div class="alert error">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="post">
                <input type="hidden" name="action" value="editar">
                <input type="hidden" name="id" value="<?= $rol['id'] ?>">
                
                <div class="form-group">
                    <label for="id_rol"><i class="fas fa-id-card"></i> ID:</label>
                    <input type="text" id="id_rol" value="<?= $rol['id'] ?>" class="form-control" disabled>
                </div>
                
                <div class="form-group">
                    <label for="nombre"><i class="fas fa-tag"></i> Nombre del Rol:*</label>
                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($rol['nombre']) ?>" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="descripcion"><i class="fas fa-align-left"></i> Descripción:</label>
                    <textarea id="descripcion" name="descripcion" rows="4" class="form-control"><?= htmlspecialchars($rol['descripcion']) ?></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <button type="button" class="btn cancel" onclick="window.location.href='ver_roles.php'">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>