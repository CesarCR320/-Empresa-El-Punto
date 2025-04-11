<?php
$roles = $conn->query("SELECT * FROM roles ORDER BY nombre")->fetch_all(MYSQLI_ASSOC);
?>

<table>
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
                <td><?= htmlspecialchars($rol['descripcion']) ?></td>
                <td class="actions">
                    <button class="btn edit-btn" data-id="<?= $rol['id'] ?>">Editar</button>
                    <button class="btn delete-btn" data-id="<?= $rol['id'] ?>">Eliminar</button>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No se encontraron roles registrados</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>