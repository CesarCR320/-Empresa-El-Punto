<?php
include 'conexion_r.php';

$id = isset($_GET['id']) ? $_GET['id'] : die('ID de rol no especificado');

try {
    $stmt = $conn->prepare("SELECT id, nombre, descripcion FROM roles WHERE id = ?");
    $stmt->execute([$id]);
    $rol = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$rol) {
        die('Rol no encontrado');
    }
} catch(PDOException $e) {
    die("Error al obtener el rol: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Rol</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Rol</h1>
        
        <form action="procesar_editar.php" method="post">
            <input type="hidden" name="id" value="<?php echo $rol['id']; ?>">
            
            <div class="form-group">
                <label for="nombre">Nombre del Rol:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($rol['nombre']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4"><?php echo htmlspecialchars($rol['descripcion']); ?></textarea>
            </div>
            
            <button type="submit">Guardar Cambios</button>
            <a href="index.html" class="btn">Cancelar</a>
        </form>
    </div>
</body>
</html>