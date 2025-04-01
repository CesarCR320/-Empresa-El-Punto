<?php
include_once 'conexion.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Empleados</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        .tabla-empleados {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .tabla-empleados th, .tabla-empleados td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        .tabla-empleados th {
            background-color: #007BFF;
            color: white;
            text-transform: uppercase;
        }

        .tabla-empleados tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .tabla-empleados tr:hover {
            background-color: #ddd;
        }

        .btn {
            border: none;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            margin: 2px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-editar { background-color: #ffc107; color: black; }
        .btn-ver { background-color: #17a2b8; color: white; }
        .btn-eliminar { background-color: #dc3545; color: white; }

        .btn-editar:hover { background-color: #e0a800; }
        .btn-ver:hover { background-color: #138496; }
        .btn-eliminar:hover { background-color: #c82333; }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            border-radius: 5px;
        }

        button:hover {
            background-color: #218838;
        }

        /* Estilo del Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Lista de Empleados</h1>

    <table class="tabla-empleados">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Puesto</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php
        $sql = "SELECT id, nombre, puesto, telefono FROM empleados";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["puesto"] . "</td>";
                echo "<td>" . $row["telefono"] . "</td>";
                echo "<td>
                        <button class='btn btn-editar' onclick='openEditModal(" . $row["id"] . ", \"" . $row["nombre"] . "\", \"" . $row["puesto"] . "\", \"" . $row["telefono"] . "\")'>Editar</button>
                        <button class='btn btn-ver' onclick='openViewModal(\"" . $row["id"] . "\", \"" . $row["nombre"] . "\", \"" . $row["puesto"] . "\", \"" . $row["telefono"] . "\")'>Ver</button>
                        <button class='btn btn-eliminar' onclick='openDeleteModal(" . $row["id"] . ")'>Eliminar</button>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay empleados registrados.</td></tr>";
        }

        $conn->close();
        ?>
    </table>

    <button onclick="location.href='index.php'">Volver al Menú</button>
    <button onclick="location.href='agregar_empleado.php'" style="background-color: #007BFF;">Agregar</button>

    <!-- Modal de ver -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('viewModal')">&times;</span>
            <h2>Detalles del Empleado</h2>
            <p id="viewNombre"></p>
            <p id="viewPuesto"></p>
            <p id="viewTelefono"></p>
        </div>
    </div>

    <!-- Modal de eliminar -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteModal')">&times;</span>
            <h2>Eliminar Empleado</h2>
            <p>¿Seguro que deseas eliminar este empleado?</p>
            <button onclick="deleteEmployee()">Eliminar</button>
            <button onclick="closeModal('deleteModal')">Cancelar</button>
        </div>
    </div>

    <!-- Modal de editar -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h2>Editar Empleado</h2>
            <form id="editForm" method="POST">
                <input type="hidden" id="editId" name="id">
                <label for="editNombre">Nombre</label>
                <input type="text" id="editNombre" name="nombre" required><br><br>
                <label for="editPuesto">Puesto</label>
                <input type="text" id="editPuesto" name="puesto" required><br><br>
                <label for="editTelefono">Teléfono</label>
                <input type="text" id="editTelefono" name="telefono" required><br><br>
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <script>
        function openViewModal(id, nombre, puesto, telefono) {
            document.getElementById('viewNombre').innerText = "Nombre: " + nombre;
            document.getElementById('viewPuesto').innerText = "Puesto: " + puesto;
            document.getElementById('viewTelefono').innerText = "Teléfono: " + telefono;
            document.getElementById('viewModal').style.display = "block";
        }

        function openDeleteModal(id) {
            window.deleteId = id;
            document.getElementById('deleteModal').style.display = "block";
        }

        function deleteEmployee() {
            window.location.href = 'eliminar_empleado.php?id=' + window.deleteId;
        }

        function openEditModal(id, nombre, puesto, telefono) {
            document.getElementById('editId').value = id;
            document.getElementById('editNombre').value = nombre;
            document.getElementById('editPuesto').value = puesto;
            document.getElementById('editTelefono').value = telefono;
            document.getElementById('editModal').style.display = "block";
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                closeModal(event.target.id);
            }
        };
    </script>

</body>
</html>
