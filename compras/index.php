<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamento de Compras - ERP Escolar</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include '../includes/sidebar.php'; ?> 
            <!-- Contenido principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Departamento de Compras</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Exportar</button>
                        </div>
                    </div>
                </div>

                <!-- Dashboard de compras -->
                <div class="row">
                    <!-- Tarjeta de órdenes pendientes -->
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Órdenes pendientes</h5>
                                <h2 class="card-text text-primary">
                                    <?php 
                                    // Aquí irá el código PHP para contar órdenes pendientes
                                    echo "12"; 
                                    ?>
                                </h2>
                                <a href="compras/index.php?estado=pendiente" class="btn btn-outline-primary btn-sm">Ver todas</a>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta de proveedores activos -->
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Proveedores activos</h5>
                                <h2 class="card-text text-success">
                                    <?php 
                                    // Aquí irá el código PHP para contar proveedores activos
                                    echo "45"; 
                                    ?>
                                </h2>
                                <a href="proveedores/ver_proveedores.html" class="btn btn-outline-success btn-sm">Gestionar</a>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta de productos por recibir -->
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Productos por recibir</h5>
                                <h2 class="card-text text-warning">
                                    <?php 
                                    // codigo PHP para contar productos por recibir
                                    echo "78"; 
                                    ?>
                                </h2>
                                <a href="Logistica/index.html" class="btn btn-outline-warning btn-sm">Ver detalles</a>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta de total de compras del mes -->
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Compras del mes</h5>
                                <h2 class="card-text text-danger">
                                    <?php 
                                    // codigo PHP para calcular compras del mes
                                    echo "$456,789"; 
                                    ?>
                                </h2>
                                <a href="administracion/gastos.php" class="btn btn-outline-danger btn-sm">Ver reporte</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de últimas órdenes -->
                <h3>Últimas órdenes de compra</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Proveedor</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // bucle para mostrar las últimas órdenes
                            // ejemplo estático:
                            ?>
                            <tr>
                                <td>OC-2025-001</td>
                                <td>15/03/2025</td>
                                <td>Distribuidora XYZ</td>
                                <td>$12,500.00</td>
                                <td><span class="badge bg-warning">Pendiente</span></td>
                                <td>
                                    <a href="compras/ver_orden.php?id=1" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="compras/editar_orden.php?id=1" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>OC-2025-002</td>
                                <td>14/03/2025</td>
                                <td>Suministros ABC</td>
                                <td>$8,750.00</td>
                                <td><span class="badge bg-success">Aprobada</span></td>
                                <td>
                                    <a href="compras/ver_orden.php?id=2" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="compras/editar_orden.php?id=2" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                            <!-- Añadir más filas según sea necesario -->
                        </tbody>
                    </table>
                </div>

                <!-- Acciones rápidas -->
                <h3>Acciones rápidas</h3>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <a href="./compras/crear_orden.php" class="btn btn-primary w-100">
                            <i class="fas fa-plus-circle"></i> Nueva orden
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="proveedores/form_agregar.html" class="btn btn-success w-100">
                            <i class="fas fa-user-plus"></i> Nuevo proveedor
                        </a>
                    </div>
                    <!-- <div class="col-md-3">
                        <a href="cotizaciones/crear_cotizacion.php" class="btn btn-info w-100">
                            <i class="fas fa-file-invoice"></i> Nueva cotización
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="recepcion/registrar_recepcion.php" class="btn btn-warning w-100">
                            <i class="fas fa-truck-loading"></i> Registrar recepción -->
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
    
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/chart.min.js"></script>
    <script src="../assets/js/custom.js"></script>
</body>
</html>