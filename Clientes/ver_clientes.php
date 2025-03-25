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
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            font-family: 'Poppins', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
        }
        .table thead {
            background: #343a40;
            color: white;
        }
        .btn {
            transition: 0.3s;
        }
        .btn:hover {
            transform: scale(1.05);
        }
        .modal-content {
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card p-4">
        <h2 class="mb-3 text-center">Lista de Clientes</h2>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
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
                            <button class="btn btn-info btn-sm" onclick="verCliente(<?= $row['id'] ?>)">👁 Ver</button>
                            <button class="btn btn-primary btn-sm" onclick="abrirModal(<?= $row['id'] ?>)">✏️ Editar</button>
                            <a href="eliminar_cliente.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este cliente?')">🗑 Eliminar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de información del cliente -->
<div class="modal fade" id="verModal" tabindex="-1" aria-labelledby="verModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="verModalLabel">Información del Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item"><strong>ID:</strong> <span id="verId"></span></li>
          <li class="list-group-item"><strong>Nombre:</strong> <span id="verNombre"></span></li>
          <li class="list-group-item"><strong>Dirección:</strong> <span id="verDireccion"></span></li>
          <li class="list-group-item"><strong>RFC:</strong> <span id="verRFC"></span></li>
          <li class="list-group-item"><strong>Teléfono:</strong> <span id="verTelefono"></span></li>
          <li class="list-group-item"><strong>Correo:</strong> <span id="verCorreo"></span></li>
        </ul>
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
        if (data.error) {
          alert("Error: " + data.error);
        } else {
          document.getElementById("verId").innerText = data.id;
          document.getElementById("verNombre").innerText = data.Nombre;
          document.getElementById("verDireccion").innerText = data.Direccion;
          document.getElementById("verRFC").innerText = data.RFC;
          document.getElementById("verTelefono").innerText = data.Telefono;
          document.getElementById("verCorreo").innerText = data.Correo;
          
          var myModal = new bootstrap.Modal(document.getElementById("verModal"));
          myModal.show();
        }
      })
      .catch(error => console.log("Error: " + error));
  }
</script>

</body>
</html>
