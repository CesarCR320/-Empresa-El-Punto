<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous" />
  <title>Modulo de Profesor</title>
</head>

<body>

  <div class="container">
    <h1 class="text-center">Hola soy el modulo de profesor</h1>
    <button type="button" class="text-center mt-3 btn btn-primary">AGREGAR NUEVO PROFESOR</button>
    <?php
    include 'conexion.php';
    ?>
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

        <?php
        foreach ($tablaProfesores as $key => $fila) {

        ?>
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
        <?php
        }
        ?>




      </tbody>
    </table>
  </div>


</body>

</html>