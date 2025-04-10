<?php
require_once 'conexion_r.php';

// Mostrar mensaje si existe
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<link rel="stylesheet" href="style.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Roles</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Roles</h1>
        
        <?php if ($mensaje): ?>
            <div class="mensaje"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>
        
        <a href="agregar_roles.php" class="btn">Agregar Nuevo Rol</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Rol</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id, nombre, descripcion FROM roles";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while($rol = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($rol['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($rol['nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($rol['descripcion']) . "</td>";
                        echo "<td class='actions'>";
                        echo "<a href='editar_roles.php?id=" . $rol['id'] . "' class='edit'>Editar</a>";
                        echo "<a href='eliminar_roles.php?id=" . $rol['id'] . "' class='delete'>Eliminar</a>";
                        echo "<a href='permisos_roles.php?id=" . $rol['id'] . "'>Permisos</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay roles registrados</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>