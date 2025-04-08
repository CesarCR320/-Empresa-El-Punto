<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Módulo de Ventas</title>
    <style>
        .modal-header {
            background-color: #343a40;
            color: white;
        }
        .btn-agregar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        include 'conexion.php';
        
        if(!isset($tablaVentas)) {
            die("Error: No se pudo cargar los datos de ventas");
        }
        ?>
        
        <h1 class style="text-align:center;">Módulo de Ventas</h1>
        
        
        <div class="d-flex justify-content-front btn-agregar">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregar">
                <i class="bi bi-plus-circle"></i> AGREGAR NUEVA VENTA
            </button>
        </div>
        
        <table class="table mt-4 table-striped table-dark">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($tablaVentas) > 0): ?>
                    <?php foreach ($tablaVentas as $key => $fila): ?>
                    <tr>
                        <th scope="row"><?= $key + 1 ?></th>
                        <td><?= htmlspecialchars($fila['nombre_cliente']) ?></td>
                        <td><?= htmlspecialchars($fila['producto']) ?></td>
                        <td><?= $fila['cantidad'] ?></td>
                        <td><?= $fila['fecha_venta'] ?></td>
                        <td><?= $fila['precio'] ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar" 
                                onclick="cargarDatosEditar(
                                    '<?= $fila['id'] ?>',
                                    '<?= htmlspecialchars($fila['nombre_cliente'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($fila['producto'], ENT_QUOTES) ?>',
                                    '<?= $fila['cantidad'] ?>',
                                    '<?= $fila['fecha_venta'] ?>',
                                    '<?= $fila['precio'] ?>',
                                )">
                                Editar
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" 
                                onclick="confirmarEliminacion(<?= $fila['id'] ?>)">
                                Eliminar
                            </button>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalVer" 
                            onclick="cargarDatosVer(
                           '<?= $fila['id'] ?>',
                            '<?= htmlspecialchars($fila['nombre_cliente'], ENT_QUOTES) ?>',
                          '<?= htmlspecialchars($fila['producto'], ENT_QUOTES) ?>',
                           '<?= $fila['cantidad'] ?>',
                          '<?= $fila['fecha_venta'] ?>',
                          '<?= $fila['precio'] ?>'
                          )">
                          Ver
                        </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay ventas registradas</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Nueva Venta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="agregar_venta.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre del Cliente</label>
                            <input type="text" class="form-control" name="nombre_cliente" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Producto</label>
                            <input type="text" class="form-control" name="producto" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cantidad</label>
                            <input type="number" class="form-control" name="cantidad" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" class="form-control" name="fecha_venta" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Precio</label>
                            <input type="number" class="form-control" name="precio" min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Venta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="actualizar_venta.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="id_editar" name="id">
                        <div class="mb-3">
                            <label class="form-label">Nombre del Cliente</label>
                            <input type="text" class="form-control" id="nombre_cliente_editar" name="nombre_cliente" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Producto</label>
                            <input type="text" class="form-control" id="producto_editar" name="producto" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad_editar" name="cantidad" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha_venta_editar" name="fecha_venta" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Precio</label>
                            <input type="number" step="0.01" clas="form-control" id="precio_editar" name="precio" min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVer" tabindex="-1" aria-labelledby="modalVerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalVerLabel">Detalles de Venta</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>ID:</strong> <span id="id_ver"></span></p>
                    <p><strong>Cliente:</strong> <span id="nombre_cliente_ver"></span></p>
                    <p><strong>Producto:</strong> <span id="producto_ver"></span></p>
                    <p><strong>Cantidad:</strong> <span id="cantidad_ver"></span></p>
                    <p><strong>Fecha:</strong> <span id="fecha_venta_ver"></span></p>
                    <p><strong>Precio:</strong>$<span id="precio_ver"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function cargarDatosEditar(id, nombre, producto, cantidad, fecha_venta, precio) {
            document.getElementById('id_editar').value = id;
            document.getElementById('nombre_cliente_editar').value = nombre;
            document.getElementById('producto_editar').value = producto;
            document.getElementById('cantidad_editar').value = cantidad;
            document.getElementById('fecha_venta_editar').value = fecha_venta;
            document.getElementById('precio_editar').value = precio;
        }
        function cargarDatosVer(id, nombre, producto, cantidad, fecha_venta, precio) {
            document.getElementById('id_ver').textContent = id;
            document.getElementById('nombre_cliente_ver').textContent = nombre;
            document.getElementById('producto_ver').textContent = producto;
            document.getElementById('cantidad_ver').textContent = cantidad;
            const fecha = new Date(fecha_venta)
            document.getElementById('fecha_venta_ver').textContent = fecha.toLocaleDateString('es-ES');
            document.getElementById('precio_ver').textContent = parseFloat(precio).toFixed(2);
        }
        function confirmarEliminacion(id) {
            if(confirm('¿Estás seguro de eliminar esta venta?')) {
                window.location.href = 'eliminar_venta.php?id=' + id;
            }
        }
    </script>
</body>
</html>