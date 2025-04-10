<?php
include 'conexion_r.php';

$id = isset($_GET['id']) ? $_GET['id'] : die('ID de rol no especificado');

try {
    // Verificar si el rol existe
    $stmt = $conn->prepare("SELECT id FROM roles WHERE id = ?");
    $stmt->execute([$id]);
    
    if ($stmt->rowCount() == 0) {
        die('Rol no encontrado');
    }
    
    // Mostrar confirmación
    echo '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Eliminar Rol</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <h1>Confirmar Eliminación</h1>
            <p>¿Estás seguro de que deseas eliminar este rol?</p>
            
            <form action="procesar_eliminar.php" method="post">
                <input type="hidden" name="id" value="' . $id . '">
                <button type="submit" class="btn delete">Sí, Eliminar</button>
                <a href="index.html" class="btn">Cancelar</a>
            </form>
        </div>
    </body>
    </html>';
    
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>