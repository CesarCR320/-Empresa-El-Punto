<?php
require_once 'conexion_r.php';

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $nombre = $conn->real_escape_string($_POST['nombre'] ?? '');
    $descripcion = $conn->real_escape_string($_POST['descripcion'] ?? '');

    $sql = "UPDATE roles SET nombre = ?, descripcion = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $descripcion, $id);
    
    if ($stmt->execute()) {
        header("Location: index.php?mensaje=Rol+actualizado+correctamente");
        exit();
    } else {
        die("Error al actualizar: " . $conn->error);
    }
}

// Obtener datos del rol
$id = isset($_GET['id']) ? intval($_GET['id']) : die('ID de rol no especificado');
$sql = "SELECT id, nombre, descripcion FROM roles WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die('Rol no encontrado');
}

$rol = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Rol</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Editar Rol</h1>
        
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $rol['id']; ?>">
            
            <div class="form-group">
                <label for="nombre">Nombre del Rol:</label>
                <input type="text" id="nombre" name="nombre" 
                       value="<?php echo htmlspecialchars($rol['nombre']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4"><?php 
                    echo htmlspecialchars($rol['descripcion']); 
                ?></textarea>
            </div>
            
            <button type="submit" class="btn">Guardar Cambios</button>
            <a href="index.php" class="btn cancelar">Cancelar</a>
        </form>
    </div>
</body>
</html>