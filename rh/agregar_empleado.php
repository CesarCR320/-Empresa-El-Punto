<?php
include_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $puesto = $_POST['puesto'];
    $telefono = $_POST['telefono'];

    if (!empty($nombre) && !empty($puesto) && !empty($telefono)) {
        $sql = "INSERT INTO empleados (nombre, puesto, telefono) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $puesto, $telefono);

        if ($stmt->execute()) {
            echo "<script>alert('Empleado agregado correctamente'); window.location.href='ver_empleados.php';</script>";
        } else {
            echo "<script>alert('Error al agregar el empleado.'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Por favor, llena todos los campos.'); window.history.back();</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Empleado</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            color: #333;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 20px;
        }

        label {
            font-size: 16px;
            margin-bottom: 10px;
            display: block;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-button {
            width: 100%;
            padding: 12px;
            background-color: #45a049;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #39843c;
        }
    </style>
</head>
<body>

    <h1>Agregar Empleado</h1>

    <div class="form-container">
        <form action="" method="POST">
            <label for="nombre">Nombre del Empleado:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="puesto">Puesto:</label>
            <input type="text" id="puesto" name="puesto" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <button type="submit">Guardar</button>
        </form>

        <button class="back-button" onclick="location.href='index.php'">Volver al Menú</button>
    </div>

</body>
</html>
