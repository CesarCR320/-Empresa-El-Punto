<?php
require_once 'conexion_r.php';
require_once 'header.php';
?>

<div class="container">
    <h1>Listado de Roles</h1>
    
    <a href="agregar_roles.php" class="btn">Agregar Nuevo Rol</a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Creado</th>
                <th>Actualizado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT id, nombre, descripcion, 
                     DATE_FORMAT(created_at, '%d/%m/%Y %H:%i') as fecha_creacion,
                     DATE_FORMAT(updated_at, '%d/%m/%Y %H:%i') as fecha_actualizacion
                     FROM roles ORDER BY created_at DESC";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while($rol = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($rol['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($rol['nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($rol['descripcion']) . "</td>";
                    echo "<td>" . htmlspecialchars($rol['fecha_creacion']) . "</td>";
                    echo "<td>" . htmlspecialchars($rol['fecha_actualizacion']) . "</td>";
                    echo "<td class='actions'>";
                    echo "<a href='editar_roles.php?id=" . $rol['id'] . "' class='edit'>Editar</a>";
                    echo "<a href='eliminar_roles.php?id=" . $rol['id'] . "' 
                         onclick='return confirm(\"¿Estás seguro de eliminar este rol?\")' 
                         class='delete'>Eliminar</a>";
                    echo "<a href='permisos_roles.php?id=" . $rol['id'] . "' class='permisos'>Permisos</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='no-data'>No se encontraron roles registrados</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>