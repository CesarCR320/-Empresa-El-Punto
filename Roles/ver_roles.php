<?php
$roles = $conn->query("SELECT * FROM roles ORDER BY nombre")->fetch_all(MYSQLI_ASSOC);
?>

<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-users"></i> Listado de Roles</h2>
        <div>
            <button class="btn success" onclick="navegarA('agregar_rol.php')">
                <i class="fas fa-plus"></i> Nuevo Rol
            </button>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="roles-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-id-badge"></i> ID</th>
                        <th><i class="fas fa-tag"></i> Nombre</th>
                        <th><i class="fas fa-align-left"></i> Descripción</th>
                        <th><i class="fas fa-cogs"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($roles) > 0): ?>
                        <?php foreach ($roles as $rol): ?>
                        <tr>
                            <td><?= $rol['id'] ?></td>
                            <td><?= htmlspecialchars($rol['nombre']) ?></td>
                            <td><?= htmlspecialchars($rol['descripcion'] ?: 'Sin descripción') ?></td>
                            <td class="actions">
                                <button class="btn small primary editar-btn" data-id="<?= $rol['id'] ?>">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button class="btn small danger eliminar-btn" data-id="<?= $rol['id'] ?>">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                                <button class="btn small info permisos-btn" data-id="<?= $rol['id'] ?>">
                                    <i class="fas fa-key"></i> Permisos
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
    </div>
</div>