<?php
require_once 'conexion_r.php';

$query = "SELECT id, nombre, descripcion, 
          DATE_FORMAT(created_at, '%d/%m/%Y %H:%i') as fecha_creacion,
          DATE_FORMAT(updated_at, '%d/%m/%Y %H:%i') as fecha_actualizacion
          FROM roles ORDER BY created_at DESC";
$result = $conn->query($query);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>

<div class="roles-container">
    <h2><i class="fas fa-list"></i> Listado de Roles</h2>
    
    <div class="table-responsive">
        <table class="roles-table">
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
                <?php if ($result->num_rows > 0): ?>
                    <?php while($rol = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($rol['id']) ?></td>
                        <td><?= htmlspecialchars($rol['nombre']) ?></td>
                        <td><?= htmlspecialchars($rol['descripcion']) ?></td>
                        <td><?= htmlspecialchars($rol['fecha_creacion']) ?></td>
                        <td><?= htmlspecialchars($rol['fecha_actualizacion']) ?></td>
                        <td class="actions">
                            <button class="btn edit-btn" data-id="<?= $rol['id'] ?>">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button class="btn delete-btn" data-id="<?= $rol['id'] ?>" data-nombre="<?= htmlspecialchars($rol['nombre']) ?>">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                            <button class="btn permissions-btn" data-id="<?= $rol['id'] ?>">
                                <i class="fas fa-key"></i> Permisos
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="no-data">
                            <i class="fas fa-info-circle"></i> No se encontraron roles registrados
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$conn->close();
?>