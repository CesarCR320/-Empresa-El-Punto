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
                        <a href='editar_proveedor.php?id=" . $row["id"] . "' class='btn btn-editar'>Editar</a>
                        <a href='ver_proveedor.php?id=" . $row["id"] . "' class='btn btn-ver'>Ver</a>
                        <a href='eliminar_proveedor.php?id=" . $row["id"] . "' class='btn btn-eliminar' onclick='return confirm(\"¿Seguro que deseas eliminar este proveedor?\");'>Eliminar</a>
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
</body>
</html>
