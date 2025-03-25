<?php
// Incluir la clase de conexión
require_once 'Conexion.php';

// Datos de conexión (ajusta estos según tu configuración)
$servidor = "localhost";
$usuario = "root";
$password = "root";
$base_datos = "elPunto";

try {
    // Crear instancia de conexión
    $conexion = new Conexion($servidor, $usuario, $password, $base_datos);
    $conn = $conexion->conectar();

    // Consulta para obtener los items del inventario
    $sql = "SELECT id, nombre, tipo, descripcion FROM inventarios";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $tablaInventario = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Cerrar conexión
    $conexion->desconectar();
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <title>Módulo de Inventario</title>
</head>

<body class="bg-light">
  
  <header class="bg-primary-subtle text-primary-emphasis py-3 d-flex justify-content-center align-items-center">
    <h1 class="fs-1 m-0">Módulo de Inventario</h1>
  </header>

  <div class="container mt-5">
    <div class="bg-white p-4 shadow rounded">
      
      <!-- Botón para abrir el modal -->
      <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#nuevoinventario">
        AGREGAR NUEVO ITEM
      </button>

      <?php if (isset($tablaInventario) && count($tablaInventario) > 0) { ?>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead class="table-primary">
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Tipo</th>
                <th scope="col">Descripción</th>
                <th scope="col" class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($tablaInventario as $item) { ?>
                <tr>
                  <td><?php echo htmlspecialchars($item['id']); ?></td>
                  <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                  <td><?php echo htmlspecialchars($item['tipo']); ?></td>
                  <td><?php echo htmlspecialchars($item['descripcion']); ?></td>
                  <td class="text-center">
                    <button type="button" class="btn btn-warning btn-sm">Editar</button>
                    <button type="button" class="btn btn-danger btn-sm">Eliminar</button>
                    <button type="button" class="btn btn-success btn-sm">Ver</button>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      <?php } else { ?>
        <div class="alert alert-info">
          No hay items en el inventario.
        </div>
      <?php } ?>

    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="nuevoinventario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="exampleModalLabel">Agregar Item al Inventario</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" required>
            </div>
            <div class="mb-3">
              <label for="tipo" class="form-label">Tipo</label>
              <input type="text" class="form-control" id="tipo" required>
            </div>
            <div class="mb-3">
              <label for="descripcion" class="form-label">Descripción</label>
              <textarea class="form-control" id="descripcion" rows="3"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>

</body>

</html>