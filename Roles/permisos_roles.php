<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-key"></i> Editar Permisos del Rol: <?= htmlspecialchars($rol['nombre']) ?></h2>
        <button class="btn cancel" onclick="navegarA('ver_roles.php')">
            <i class="fas fa-arrow-left"></i> Volver
        </button>
    </div>
    
    <div class="card-body">
        <form method="post">
            <input type="hidden" name="action" value="update_permissions">
            <input type="hidden" name="id_rol" value="<?= $id_rol ?>">
            
            <div class="permissions-list">
                <?php foreach ($permisos as $permiso): ?>
                <div class="permission-item">
                    <label>
                        <input type="checkbox" name="permisos[]" value="<?= $permiso['id'] ?>"
                            <?= in_array($permiso['id'], $asignados) ? 'checked' : '' ?>>
                        <div class="permission-content">
                            <strong><?= htmlspecialchars($permiso['nombre']) ?></strong>
                            <p><?= htmlspecialchars($permiso['descripcion']) ?></p>
                        </div>
                    </label>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn primary">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>