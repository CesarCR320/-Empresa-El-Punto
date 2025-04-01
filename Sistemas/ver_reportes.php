<?php
include('db.php'); // Conectar con la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Reportes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Lista de Reportes</h2>

    <!-- Botón para abrir modal de Nuevo Reporte -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNuevoReporte">
        Nuevo Reporte
    </button>

    <!-- Tabla para mostrar los reportes -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM reportes ORDER BY fecha DESC";
            $result = $conexion->query($sql);
            
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $titulo = $row['titulo'];
                $descripcion = $row['descripcion'];
                $fecha = $row['fecha'];

                echo "<tr>
                    <td>{$id}</td>
                    <td>{$titulo}</td>
                    <td>{$descripcion}</td>
                    <td>{$fecha}</td>
                    <td>
                        <!-- Botón de Ver Detalles -->
                        <button class='btn btn-info' data-bs-toggle='modal' data-bs-target='#modalVerDetalles{$id}'>Ver Detalles</button>
                        <!-- Botón de Editar -->
                        <button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#modalEditar{$id}'>Editar</button>
                        <!-- Botón de Eliminar -->
                        <button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#modalEliminar{$id}'>Eliminar</button>
                    </td>
                </tr>";

                // Modal para Ver Detalles del Reporte
                echo "
                <div class='modal fade' id='modalVerDetalles{$id}' tabindex='-1' aria-labelledby='verDetallesReporteLabel{$id}' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='verDetallesReporteLabel{$id}'>Detalles del Reporte</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <h6><strong>Título:</strong> {$titulo}</h6>
                                <p><strong>Descripción:</strong> {$descripcion}</p>
                                <p><strong>Fecha:</strong> {$fecha}</p>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>";

                // Modal para Editar Reporte
                echo "
                <div class='modal fade' id='modalEditar{$id}' tabindex='-1' aria-labelledby='editarReporteLabel{$id}' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='editarReporteLabel{$id}'>Editar Reporte</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <form action='editar_reporte.php' method='POST'>
                                    <input type='hidden' name='id' value='{$id}'>
                                    <div class='mb-3'>
                                        <label for='titulo' class='form-label'>Título</label>
                                        <input type='text' class='form-control' name='titulo' value='{$titulo}' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='descripcion' class='form-label'>Descripción</label>
                                        <textarea class='form-control' name='descripcion' rows='3' required>{$descripcion}</textarea>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='submit' class='btn btn-success'>Guardar cambios</button>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>";

                // Modal para Eliminar Reporte
                echo "
                <div class='modal fade' id='modalEliminar{$id}' tabindex='-1' aria-labelledby='eliminarReporteLabel{$id}' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='eliminarReporteLabel{$id}'>Confirmar Eliminación</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <p>¿Estás seguro de que quieres eliminar este reporte?</p>
                            </div>
                            <div class='modal-footer'>
                                <a href='eliminar_reporte.php?id={$id}' class='btn btn-danger'>Eliminar</a>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- MODAL PARA NUEVO REPORTE -->
<div class="modal fade" id="modalNuevoReporte" tabindex="-1" aria-labelledby="nuevoReporteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoReporteLabel">Agregar Nuevo Reporte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="agregar_reporte.php" method="POST">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
