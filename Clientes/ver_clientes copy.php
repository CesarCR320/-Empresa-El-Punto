<?php
include "conexion.php";

$sql = "SELECT * FROM clientes";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .container {
            margin-top: 50px;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
            cursor: pointer;
        }
        .btn-custom {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Lista de Clientes</h3>
                <div>
                    <a href="index.html" class="btn btn-light me-2">Volver al Menú</a>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarCliente">+ Agregar Cliente</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="tablaClientes">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>RFC</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row["id"] ?></td>
                                <td><?= $row["Nombre"] ?></td>
                                <td><?= $row["Direccion"] ?></td>
                                <td><?= $row["RFC"] ?></td>
                                <td><?= $row["Telefono"] ?></td>
                                <td><?= $row["Correo"] ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm btn-custom" onclick="verCliente(<?= $row['id'] ?>)">Ver</button>
                                    <button class="btn btn-warning btn-sm btn-custom" onclick="editarCliente(<?= $row['id'] ?>)">Editar</button>
                                    <a href="eliminar_cliente.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">Eliminar</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ver Cliente -->
    <div class="modal fade" id="modalVerCliente" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Detalles del Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6"><strong>ID:</strong> <span id="clienteVerID"></span></div>
                        <div class="col-6"><strong>Nombre:</strong> <span id="clienteVerNombre"></span></div>
                        <div class="col-6"><strong>RFC:</strong> <span id="clienteVerRFC"></span></div>
                        <div class="col-6"><strong>Teléfono:</strong> <span id="clienteVerTelefono"></span></div>
                        <div class="col-12"><strong>Dirección:</strong> <span id="clienteVerDireccion"></span></div>
                        <div class="col-12"><strong>Correo:</strong> <span id="clienteVerCorreo"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Cliente -->
    <div class="modal fade" id="modalEditarCliente" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Editar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarCliente">
                        <input type="hidden" id="clienteEditID" name="id">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="clienteEditNombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="clienteEditDireccion" name="direccion" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">RFC</label>
                            <input type="text" class="form-control" id="clienteEditRFC" name="rfc">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="clienteEditTelefono" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo</label>
                            <input type="email" class="form-control" id="clienteEditCorreo" name="correo" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Cliente -->
    <div class="modal fade" id="modalAgregarCliente" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Agregar Nuevo Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarCliente">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">RFC (opcional)</label>
                            <input type="text" class="form-control" name="rfc">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo</label>
                            <input type="email" class="form-control" name="correo" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function verCliente(id) {
            fetch('get_cliente.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('clienteVerID').textContent = data.id;
                    document.getElementById('clienteVerNombre').textContent = data.Nombre;
                    document.getElementById('clienteVerRFC').textContent = data.RFC;
                    document.getElementById('clienteVerTelefono').textContent = data.Telefono;
                    document.getElementById('clienteVerDireccion').textContent = data.Direccion;
                    document.getElementById('clienteVerCorreo').textContent = data.Correo;

                    var modalVer = new bootstrap.Modal(document.getElementById('modalVerCliente'));
                    modalVer.show();
                });
        }

        function editarCliente(id) {
            fetch('get_cliente.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('clienteEditID').value = data.id;
                    document.getElementById('clienteEditNombre').value = data.Nombre;
                    document.getElementById('clienteEditRFC').value = data.RFC;
                    document.getElementById('clienteEditTelefono').value = data.Telefono;
                    document.getElementById('clienteEditDireccion').value = data.Direccion;
                    document.getElementById('clienteEditCorreo').value = data.Correo;

                    var modalEditar = new bootstrap.Modal(document.getElementById('modalEditarCliente'));
                    modalEditar.show();
                });
        }

        document.getElementById('formEditarCliente').addEventListener('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            fetch('actualizar_cliente.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Cliente actualizado exitosamente');
                    location.reload();
                } else {
                    alert('Error al actualizar: ' + data.error);
                }
            });
        });

        document.getElementById('formAgregarCliente').addEventListener('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            fetch('agregar_cliente_ajax.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    // Cerrar el modal
                    var modalAgregar = bootstrap.Modal.getInstance(document.getElementById('modalAgregarCliente'));
                    modalAgregar.hide();
                    
                    // Recargar la página para mostrar el nuevo cliente
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un problema al agregar el cliente');
            });
        });
    </script>
</body>
</html>