<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <title>Modulo de Profesor</title>
</head>

<body>

  <div class="container">
    <h1 class="text-center">Hola soy el módulo de profesor</h1>

    <!-- Botón para abrir el modal -->
    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#nuevoprofesor">
      AGREGAR NUEVO PROFESOR
    </button>

    <?php include 'conexion.php'; ?>

    <table class="table mt-4 table-striped table-dark">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tablaProfesores as $key => $fila) { ?>
          <tr>
            <th scope="row"><?php echo $key + 1; ?></th>
            <td><?php echo $fila['NOMBRE']; ?></td>
            <td><?php echo $fila['APELLIDOS']; ?></td>
            <td><?php echo $fila['SALON']; ?></td>
            <td>
              <button type="button" class="btn btn-warning">Editar</button>
              <button type="button" class="btn btn-danger">Eliminar</button>
              <button type="button" class="btn btn-success">Ver</button>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="nuevoprofesor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar Profesor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            Contenido del formulario para agregar un nuevo profesor...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary">Guardar cambios</button>
          </div>
        </div>
      </div>
    </div>

  </div>


</body>

</html>