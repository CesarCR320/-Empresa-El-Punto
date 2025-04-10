<?php
// index.php - Página principal del módulo de compras

require_once 'config/db.php';
require_once 'clases/managercompras.php';

// Inicializar conexión
$conexion = conectarDB();
$comprasManager = new managercompras($conexion);

// Procesar acciones
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'listar';
$mensaje = '';

// Procesar formulario de agregar/editar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger datos del formulario
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $proveedor_id = $_POST['proveedor_id'];
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $precio_unitario = $_POST['precio_unitario'];
    $fecha_compra = $_POST['fecha_compra'];
    $estado = $_POST['estado'];
    
    // Agregar o actualizar según sea el caso
    if ($id) {
        // Actualizar
        if ($comprasManager->actualizarCompra($id, $proveedor_id, $producto, $cantidad, $precio_unitario, $fecha_compra, $estado)) {
            $mensaje = "Compra actualizada correctamente";
            $accion = 'listar';
        } else {
            $mensaje = "Error al actualizar la compra";
        }
    } else {
        // Agregar nueva
        if ($comprasManager->agregarCompra($proveedor_id, $producto, $cantidad, $precio_unitario, $fecha_compra, $estado)) {
            $mensaje = "Compra agregada correctamente";
            $accion = 'listar';
        } else {
            $mensaje = "Error al agregar la compra";
        }
    }
}

// Eliminar compra
if ($accion == 'eliminar' && isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($comprasManager->eliminarCompra($id)) {
        $mensaje = "Compra eliminada correctamente";
    } else {
        $mensaje = "Error al eliminar la compra";
    }
    $accion = 'listar';
}

// Obtener datos para formularios
$proveedores = $comprasManager->obtenerProveedores();
$compra = null;

// Preparar datos para edición
if ($accion == 'editar' && isset($_GET['id'])) {
    $compra = $comprasManager->obtenerCompra($_GET['id']);
    if (!$compra) {
        $mensaje = "Compra no encontrada";
        $accion = 'listar';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Compras</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">El punto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Compras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Proveedores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Reportes</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Gestión de Compras</h1>
        
        <?php if ($mensaje): ?>
            <div class="alert alert-info alert-dismissible fade show">
                <?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($accion == 'listar'): ?>
            <!-- Listado de compras -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Listado de Compras</h5>
                    <a href="?accion=agregar" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nueva Compra
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Proveedor</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unit.</th>
                                    <th>Total</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($comprasManager->obtenerCompras() as $item): ?>
                                <tr>
                                    <td><?php echo $item['id']; ?></td>
                                    <td><?php echo htmlspecialchars($item['nombre_proveedor']); ?></td>
                                    <td><?php echo htmlspecialchars($item['producto']); ?></td>
                                    <td><?php echo number_format($item['cantidad'], 2); ?></td>
                                    <td>$<?php echo number_format($item['precio_unitario'], 2); ?></td>
                                    <td>$<?php echo number_format($item['total'], 2); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($item['fecha_compra'])); ?></td>
                                    <td>
                                        <span class="badge <?php echo $item['estado'] == 'completada' ? 'bg-success' : ($item['estado'] == 'cancelada' ? 'bg-danger' : 'bg-warning'); ?>">
                                            <?php echo ucfirst($item['estado']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="?accion=editar&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?accion=eliminar&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar esta compra?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                
                                <?php if (empty($comprasManager->obtenerCompras())): ?>
                                <tr>
                                    <td colspan="9" class="text-center">No hay compras registradas</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php elseif ($accion == 'agregar' || $accion == 'editar'): ?>
            <!-- Formulario para agregar/editar -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo ($accion == 'editar') ? 'Editar' : 'Nueva'; ?> Compra</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="index.php">
                        <?php if ($accion == 'editar'): ?>
                            <input type="hidden" name="id" value="<?php echo $compra['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="proveedor_id" class="form-label">Proveedor</label>
                                <select name="proveedor_id" id="proveedor_id" class="form-select" required>
                                    <option value="">Seleccione un proveedor</option>
                                    <?php foreach ($proveedores as $proveedor): ?>
                                        <option value="<?php echo $proveedor['id']; ?>" <?php echo (isset($compra) && $compra['proveedor_id'] == $proveedor['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($proveedor['nombre']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="producto" class="form-label">Producto</label>
                                <input type="text" class="form-control" id="producto" name="producto" required value="<?php echo isset($compra) ? htmlspecialchars($compra['producto']) : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" step="0.01" class="form-control" id="cantidad" name="cantidad" required value="<?php echo isset($compra) ? $compra['cantidad'] : ''; ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="precio_unitario" class="form-label">Precio Unitario</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control" id="precio_unitario" name="precio_unitario" required value="<?php echo isset($compra) ? $compra['precio_unitario'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="fecha_compra" class="form-label">Fecha de Compra</label>
                                <input type="date" class="form-control" id="fecha_compra" name="fecha_compra" required value="<?php echo isset($compra) ? $compra['fecha_compra'] : date('Y-m-d'); ?>">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select name="estado" id="estado" class="form-select" required>
                                <option value="pendiente" <?php echo (isset($compra) && $compra['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="completada" <?php echo (isset($compra) && $compra['estado'] == 'completada') ? 'selected' : ''; ?>>Completada</option>
                                <option value="cancelada" <?php echo (isset($compra) && $compra['estado'] == 'cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php" class="btn btn-secondary me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Calcular total automáticamente
        document.addEventListener('DOMContentLoaded', function() {
            const cantidad = document.getElementById('cantidad');
            const precioUnitario = document.getElementById('precio_unitario');
            
            if (cantidad && precioUnitario) {
                const calcularTotal = function() {
                    const total = parseFloat(cantidad.value || 0) * parseFloat(precioUnitario.value || 0);
                    console.log('Total calculado: ' + total.toFixed(2));
                };
                
                cantidad.addEventListener('input', calcularTotal);
                precioUnitario.addEventListener('input', calcularTotal);
            }
        });
    </script>
</body>
</html>