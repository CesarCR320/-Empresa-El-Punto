<?php
// Incluir la clase de conexión
require_once 'Conexion.php';

// Datos de conexión
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "elPunto";

// Crear instancia de conexión
$conexion = new Conexion($servername, $username, $password, $dbname);
$conn = $conexion->conectar();

// Procesar acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar_item'])) {
        // Agregar nuevo item
        $nombre = $_POST['nombre'];
        $tipo = $_POST['tipo'];
        $descripcion = $_POST['descripcion'];

        $sql = "INSERT INTO inventarios (nombre, tipo, descripcion) VALUES (:nombre, :tipo, :descripcion)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':nombre' => $nombre, ':tipo' => $tipo, ':descripcion' => $descripcion]);
        
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_POST['editar_item'])) {
        // Editar item existente
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $tipo = $_POST['tipo'];
        $descripcion = $_POST['descripcion'];

        $sql = "UPDATE inventarios SET nombre = :nombre, tipo = :tipo, descripcion = :descripcion WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id, ':nombre' => $nombre, ':tipo' => $tipo, ':descripcion' => $descripcion]);
        
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}

// Procesar eliminación (GET por simplicidad)
if (isset($_GET['eliminar'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM inventarios WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Obtener datos para editar (si aplica)
$itemEditar = null;
if (isset($_GET['editar'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM inventarios WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    $itemEditar = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Obtener datos para ver (si aplica)
$itemVer = null;
if (isset($_GET['ver'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM inventarios WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    $itemVer = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Consulta para obtener todos los items
$sql = "SELECT id, nombre, tipo, descripcion FROM inventarios";
$stmt = $conn->prepare($sql);
$stmt->execute();
$tablaInventario = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Cerrar conexión (al final del script)
$conexion->desconectar();
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
                    <a href="?ver&id=<?php echo $item['id']; ?>" class="btn btn-success btn-sm">Ver</a>
                    <a href="?editar&id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="?eliminar&id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este item?')">Eliminar</a>
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

  <!-- Modal para agregar nuevo item -->
  <div class="modal fade" id="nuevoinventario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="exampleModalLabel">Agregar Item al Inventario</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <form method="POST" action="">
          <div class="modal-body">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
              <label for="tipo" class="form-label">Tipo</label>
              <input type="text" class="form-control" id="tipo" name="tipo" required>
            </div>
            <div class="mb-3">
              <label for="descripcion" class="form-label">Descripción</label>
              <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" name="agregar_item">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal para editar item -->
  <?php if ($itemEditar) { ?>
  <div class="modal fade show" id="editarInventario" tabindex="-1" aria-labelledby="editModalLabel" style="display: block; padding-right: 17px;" aria-modal="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title" id="editModalLabel">Editar Item</h5>
          <a href="?" class="btn-close btn-close-white" aria-label="Cerrar"></a>
        </div>
        <form method="POST" action="">
          <div class="modal-body">
            <input type="hidden" name="id" value="<?php echo $itemEditar['id']; ?>">
            <div class="mb-3">
              <label for="nombre_edit" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre_edit" name="nombre" value="<?php echo htmlspecialchars($itemEditar['nombre']); ?>" required>
            </div>
            <div class="mb-3">
              <label for="tipo_edit" class="form-label">Tipo</label>
              <input type="text" class="form-control" id="tipo_edit" name="tipo" value="<?php echo htmlspecialchars($itemEditar['tipo']); ?>" required>
            </div>
            <div class="mb-3">
              <label for="descripcion_edit" class="form-label">Descripción</label>
              <textarea class="form-control" id="descripcion_edit" name="descripcion" rows="3"><?php echo htmlspecialchars($itemEditar['descripcion']); ?></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <a href="?" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-warning text-white" name="editar_item">Guardar Cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal-backdrop fade show"></div>
  <?php } ?>

  <!-- Modal para ver item -->
  <?php if ($itemVer) { ?>
  <div class="modal fade show" id="verInventario" tabindex="-1" aria-labelledby="viewModalLabel" style="display: block; padding-right: 17px;" aria-modal="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="viewModalLabel">Detalles del Item</h5>
          <a href="?" class="btn-close btn-close-white" aria-label="Cerrar"></a>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-bold">ID</label>
            <p><?php echo htmlspecialchars($itemVer['id']); ?></p>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Nombre</label>
            <p><?php echo htmlspecialchars($itemVer['nombre']); ?></p>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Tipo</label>
            <p><?php echo htmlspecialchars($itemVer['tipo']); ?></p>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Descripción</label>
            <p><?php echo nl2br(htmlspecialchars($itemVer['descripcion'])); ?></p>
          </div>
        </div>
        <div class="modal-footer">
          <a href="?" class="btn btn-secondary">Cerrar</a>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-backdrop fade show"></div>
  <?php } ?>

</body>

</html>