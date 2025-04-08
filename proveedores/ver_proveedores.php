<?php
include_once 'conexion.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Proveedores</title>
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

        .tabla-proveedores {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .tabla-proveedores th, .tabla-proveedores td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        .tabla-proveedores th {
            background-color: #007BFF;
            color: white;
            text-transform: uppercase;
        }

        .tabla-proveedores tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .tabla-proveedores tr:hover {
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

       
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: left;
            width: 300px;
        }

        .close {
            cursor: pointer;
            color: red;
            font-size: 20px;
            font-weight: bold;
            float: right;
        }

        .modal-content label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }

        .modal-content input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

    </style>
</head>
<body>
    <h1>Lista de Proveedores</h1>

    <table class="tabla-proveedores">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Contacto</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php
        $sql = "SELECT id, nombre, contacto, telefono FROM proveedores";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["contacto"] . "</td>";
                echo "<td>" . $row["telefono"] . "</td>";
                echo "<td>
                        <button class='btn btn-editar' onclick='openEditModal(" . $row["id"] . ", \"" . $row["nombre"] . "\", \"" . $row["contacto"] . "\", \"" . $row["telefono"] . "\")'>Editar</button>
                        <button class='btn btn-ver' onclick='openViewModal(\"" . $row["id"] . "\", \"" . $row["nombre"] . "\", \"" . $row["contacto"] . "\", \"" . $row["telefono"] . "\")'>Ver</button>
                        <button class='btn btn-eliminar' onclick='openDeleteModal(" . $row["id"] . ")'>Eliminar</button>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay proveedores registrados.</td></tr>";
        }

        $conn->close();
        ?>
    </table>

    <button onclick="location.href='index.php'">Volver al Menú</button>
    <button onclick="location.href='agregar_proveedor.php'" style="background-color: #007BFF;">Agregar</button>

    
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeViewModal()">&times;</span>
            <h2>Detalles del Proveedor</h2>
            <p><strong>Nombre:</strong> <span id="viewNombre"></span></p>
            <p><strong>Contacto:</strong> <span id="viewContacto"></span></p>
            <p><strong>Teléfono:</strong> <span id="viewTelefono"></span></p>
        </div>
    </div>

    
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDeleteModal()">&times;</span>
            <h2>¿Seguro que quieres eliminar este proveedor?</h2>
            <form action="eliminar_proveedor.php" method="POST">
                <input type="hidden" name="id" id="deleteId">
                <button type="submit" style="background-color: #dc3545;">Eliminar</button>
                <button type="button" onclick="closeDeleteModal()" style="background-color: gray;">Cancelar</button>
            </form>
        </div>
    </div>

    
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Editar Proveedor</h2>
            <form action="editar_proveedor.php" method="POST">
                <input type="hidden" name="id" id="editId">
                <label>Nombre:</label>
                <input type="text" name="nombre" id="editNombre">
                <label>Contacto:</label>
                <input type="text" name="contacto" id="editContacto">
                <label>Teléfono:</label>
                <input type="text" name="telefono" id="editTelefono">
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <script>
        function openViewModal(id, nombre, contacto, telefono) {
            document.getElementById('viewNombre').innerText = nombre;
            document.getElementById('viewContacto').innerText = contacto;
            document.getElementById('viewTelefono').innerText = telefono;
            document.getElementById('viewModal').style.display = 'flex';
        }

        function closeViewModal() { document.getElementById('viewModal').style.display = 'none'; }
        function openDeleteModal(id) { document.getElementById('deleteId').value = id; document.getElementById('deleteModal').style.display = 'flex'; }
        function closeDeleteModal() { document.getElementById('deleteModal').style.display = 'none'; }
        function openEditModal(id, nombre, contacto, telefono) { document.getElementById('editId').value = id; document.getElementById('editNombre').value = nombre; document.getElementById('editContacto').value = contacto; document.getElementById('editTelefono').value = telefono; document.getElementById('editModal').style.display = 'flex'; }
        function closeEditModal() { document.getElementById('editModal').style.display = 'none'; }
    </script>

</body>
</html>
