<?php
include "conexion.php"; 

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "SELECT * FROM clientes WHERE id = $id";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $cliente = $resultado->fetch_assoc();
    } else {
        echo "Cliente no encontrado.";
        exit();
    }
} else {
    echo "ID de cliente no especificado.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $direccion = $_POST["direccion"];
    $rfc = $_POST["rfc"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];

    $sql = "UPDATE clientes SET 
            Nombre='$nombre', 
            Direccion='$direccion', 
            RFC='$rfc', 
            Telefono='$telefono', 
            Correo='$correo' 
            WHERE id=$id";

    if ($conexion->query($sql) === TRUE) {
        header("Location: ver_clientes.php"); 
        exit();
    } else {
        echo "Error al actualizar cliente: " . $conexion->error;
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="tel"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #388E3C;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Editar Cliente</h1>
        <form action="" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $cliente['Nombre']; ?>" required>

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" value="<?php echo $cliente['Direccion']; ?>" required>

            <label for="rfc">RFC (opcional):</label>
            <input type="text" id="rfc" name="rfc" value="<?php echo $cliente['RFC']; ?>">

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" value="<?php echo $cliente['Telefono']; ?>" required>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" value="<?php echo $cliente['Correo']; ?>" required>

            <button type="submit">Actualizar Cliente</button>
        </form>
    </div>
</body>
</html>
