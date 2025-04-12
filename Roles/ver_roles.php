<?php
$roles = $conn->query("SELECT * FROM roles ORDER BY nombre")->fetch_all(MYSQLI_ASSOC);
?>

<div class="table-responsive">
    <table class="roles-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($roles) > 0): ?>
                <?php foreach ($roles as $rol): ?>
                <tr>
                    <td><?= $rol['id'] ?></td>
                    <td><?= htmlspecialchars($rol['nombre']) ?></td>
                    <td><?= htmlspecialchars($rol['descripcion'] ?: '') ?></td>
                    <td class="actions">
                        <button class="btn small primary editar-btn" data-id="<?= $rol['id'] ?>">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button class="btn small danger eliminar-btn" data-id="<?= $rol['id'] ?>">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="no-data">
                        <i class="fas fa-info-circle"></i> No se encontraron roles registrados
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>