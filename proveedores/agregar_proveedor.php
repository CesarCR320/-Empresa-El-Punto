<?php
include_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $telefono = $_POST['telefono'];

    if (!empty($nombre) && !empty($contacto) && !empty($telefono)) {
        $sql = "INSERT INTO proveedores (nombre, contacto, telefono) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $contacto, $telefono);

        if ($stmt->execute()) {
            echo "<script>alert('Proveedor agregado correctamente'); window.location.href='ver_proveedores.php';</script>";
        } else {
            echo "<script>alert('Error al agregar el proveedor.'); window.history.back();</script>";
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
    <title>Agregar Proveedor</title>
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
            background-color: #007BFF;
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
            background-color: #45a049;
        }

        .form-container button, .form-container .back-button {
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <h1>Agregar Proveedor</h1>

    <div class="form-container">
        <form action="" method="POST">
            <label for="nombre">Nombre del Proveedor:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="contacto">Nombre de Contacto:</label>
            <input type="text" id="contacto" name="contacto" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <button type="submit">Guardar</button>
        </form>

        <button class="back-button" onclick="location.href='index.php'">Volver al Menú</button>
    </div>

</body>
</html>
