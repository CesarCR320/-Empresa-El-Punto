<?php
include_once 'conexion.php';

// Obtener todas las nóminas
$sql = "SELECT n.id, e.nombre, n.sueldo, n.fecha_pago FROM nominas n JOIN empleados e ON n.empleado_id = e.id ORDER BY n.fecha_pago DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Nóminas</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        .container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        .add-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .add-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Gestión de Nóminas</h1>
    <div class="container">
        <table>
            <tr>
                <th>ID</th>
                <th>Empleado</th>
                <th>Sueldo</th>
                <th>Fecha de Pago</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['sueldo']; ?> MXN</td>
                    <td><?php echo $row['fecha_pago']; ?></td>
                </tr>
            <?php } ?>
        </table>
        <a href="agregar_nomina.php" class="add-button">Agregar Nómina</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
