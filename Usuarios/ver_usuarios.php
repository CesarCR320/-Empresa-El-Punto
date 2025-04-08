<?php
include 'conexion.php';

$query = "SELECT ID, Nombre, ApellidoU, ApellidoD, Rol, Tel, Email FROM usuarios_agenda";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Lista de Usuarios</h1>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Rol</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['ApellidoU']); ?></td>
                            <td><?php echo htmlspecialchars($row['ApellidoD']); ?></td>
                            <td><?php echo htmlspecialchars($row['Rol']); ?></td>
                            <td><?php echo htmlspecialchars($row['Tel']); ?></td>
                            <td><?php echo htmlspecialchars($row['Email']); ?></td>
                            <td>
                                <a href="editar_usuario.php?id=<?php echo $row['ID']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="borrar_usuario.php?id=<?php echo $row['ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas borrar este usuario?');">Borrar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No hay usuarios registrados</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>