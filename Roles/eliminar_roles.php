<?php
require_once 'conexion_r.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : die('ID de rol no especificado');

// Procesar confirmación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "DELETE FROM roles WHERE id = $id";
    
    if ($conn->query($sql)) {
        header("Location: index.php?mensaje=Rol+eliminado+correctamente");
        exit();
    } else {
        die("Error al eliminar: " . $conn->error);
    }
}

// Verificar si el rol existe
$sql = "SELECT id FROM roles WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die('Rol no encontrado');
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Rol</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Confirmar Eliminación</h1>
        <p>¿Estás seguro de que deseas eliminar este rol?</p>
        
        <form method="post">
            <button type="submit" class="btn delete">Sí, Eliminar</button>
            <a href="index.php" class="btn">Cancelar</a>
        </form>
    </div>
</body>
</html>