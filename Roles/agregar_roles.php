<?php
require_once 'conexion.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    
    $sql = "INSERT INTO roles (nombre, descripcion) VALUES ('$nombre', '$descripcion')";
    
    if ($conn->query($sql)) {
        header("Location: index.php?mensaje=Rol+agregado+correctamente");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Nuevo Rol</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Agregar Nuevo Rol</h1>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="nombre">Nombre del Rol:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4"></textarea>
            </div>
            
            <button type="submit">Guardar Rol</button>
            <a href="index.php" class="btn">Cancelar</a>
        </form>
    </div>
</body>
</html>