<?php
include_once 'conexion_r.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Roles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 5px 10px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-editar {
            background-color: #ffc107;
        }
        .btn-eliminar {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <h1>Lista de Roles</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        <?php
        $sql = "SELECT id, nombre FROM roles";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>
                        <button class='btn btn-editar' onclick=\"location.href='editar_rol.php?id=" . $row["id"] . "'\">Editar</button>
                        <button class='btn btn-eliminar' onclick=\"if(confirm('¿Eliminar este rol?')) { location.href='eliminar_rol.php?id=" . $row["id"] . "'; }\">Eliminar</button>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No hay roles registrados</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    <button onclick="location.href='index.php'">Volver al Menú</button>
</body>
</html>