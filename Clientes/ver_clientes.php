<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <title>Ver Clientes</title>
  </head>
  <body>
    <div class="container mt-5">
      <h2 class="text-center mb-4">Lista de Clientes</h2>

      <table class="table table-bordered table-striped">
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
          <?php
          include "conexion.php";
          
          $sql = "SELECT id, Nombre, Direccion, RFC, Telefono, Correo FROM clientes";
          $result = $conexion->query($sql);

          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row["id"] . "</td>";
                  echo "<td>" . $row["Nombre"] . "</td>";
                  echo "<td>" . $row["Direccion"] . "</td>";
                  echo "<td>" . $row["RFC"] . "</td>";
                  echo "<td>" . $row["Telefono"] . "</td>";
                  echo "<td>" . $row["Correo"] . "</td>";
                  echo "<td>
                          <a href='editar_cliente.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'>Editar</a>
                          <a href='eliminar_cliente.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Seguro que deseas eliminar este cliente?\")'>Eliminar</a>
                        </td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='7' class='text-center'>No hay clientes registrados</td></tr>";
          }

          // Cerrar conexión
          $conexion->close();
          ?>
        </tbody>
      </table>

      <a href="../index.html" class="btn btn-secondary">Volver</a>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
