<?php
require_once 'conexion_r.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($conn->real_escape_string($_POST['nombre'] ?? ''));
    $descripcion = trim($conn->real_escape_string($_POST['descripcion'] ?? ''));
    
    if (empty($nombre)) {
        $error = "El nombre del rol es obligatorio";
    } else {
        $sql = "INSERT INTO roles (nombre, descripcion) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nombre, $descripcion);
        
        if ($stmt->execute()) {
            header("Location: index.php?mensaje=Rol+agregado+correctamente");
            exit();
        } else {
            $error = "Error al agregar el rol: " . $conn->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Nuevo Rol</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Agregar Nuevo Rol</h1>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="nombre">Nombre del Rol:*</label>
                <input type="text" id="nombre" name="nombre" required
                       value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4"><?php 
                    echo htmlspecialchars($_POST['descripcion'] ?? ''); 
                ?></textarea>
            </div>
            
            <button type="submit" class="btn">Guardar Rol</button>
            <a href="index.php" class="btn cancelar">Cancelar</a>
        </form>
    </div>
</body>
</html>