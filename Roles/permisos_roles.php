<?php
require_once 'conexion_r.php';
require_once 'header.php'; // Incluye los estilos

$id_rol = isset($_GET['id']) ? intval($_GET['id']) : 0;
$error = '';

// Obtener información del rol
$sql_rol = "SELECT nombre FROM roles WHERE id = $id_rol";
$result_rol = $conn->query($sql_rol);

if ($result_rol->num_rows === 0) {
    header("Refresh:5;url=http://localhost/proyecto/-Empresa-El-Punto/Roles/index.php");
    die("Rol no encontrado. Redirigiendo en 5 segundos...");
}
$rol = $result_rol->fetch_assoc();

// Procesar actualización de permisos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $permisos = isset($_POST['permisos']) ? $_POST['permisos'] : [];
    
    // Convertir a enteros y limpiar
    $permisos = array_map('intval', $permisos);
    
    // Eliminar permisos actuales
    $conn->query("DELETE FROM rol_permisos WHERE rol_id = $id_rol");
    
    // Insertar nuevos permisos
    foreach ($permisos as $permiso_id) {
        $conn->query("INSERT INTO rol_permisos (rol_id, permiso_id) VALUES ($id_rol, $permiso_id)");
    }
    
    header("Location: index.php?mensaje=Permisos+actualizados+correctamente");
    exit();
}

// Obtener todos los permisos
$permisos = $conn->query("SELECT id, nombre, descripcion FROM permisos")->fetch_all(MYSQLI_ASSOC);

// Obtener permisos asignados
$asignados = $conn->query("SELECT permiso_id FROM rol_permisos WHERE rol_id = $id_rol")->fetch_all(MYSQLI_COLUMN, 0);
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Permisos del Rol: <?php echo htmlspecialchars($rol['nombre']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Permisos del Rol: <?php echo htmlspecialchars($rol['nombre']); ?></h1>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="post">
            <table>
                <thead>
                    <tr>
                        <th>Permiso</th>
                        <th>Descripción</th>
                        <th>Asignado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($permisos as $permiso): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($permiso['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($permiso['descripcion']); ?></td>
                        <td>
                            <input type="checkbox" name="permisos[]" value="<?php echo $permiso['id']; ?>"
                                <?php echo in_array($permiso['id'], $asignados) ? 'checked' : ''; ?>>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <button type="submit">Guardar Permisos</button>
            <a href="index.php" class="btn">Volver</a>
        </form>
    </div>
</body>
</html>