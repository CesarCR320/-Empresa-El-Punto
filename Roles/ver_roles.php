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
        <?php foreach ($roles as $rol): ?>
        <tr>
            <td><?= $rol['id'] ?></td>
            <td><?= htmlspecialchars($rol['nombre']) ?></td>
            <td><?= htmlspecialchars($rol['descripcion']) ?></td>
            <td>
                <button class="editar-btn" data-id="<?= $rol['id'] ?>">Editar</button>
                <button class="eliminar-btn" data-id="<?= $rol['id'] ?>">Eliminar</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>