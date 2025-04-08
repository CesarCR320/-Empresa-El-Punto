<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Proveedores</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .menu-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        .menu-buttons {
            margin-top: 20px;
        }
        button {
            display: block;
            width: 200px;
            padding: 10px;
            margin: 10px auto;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            transition: 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Menú Proveedores</h1>
    <div class="menu-container">
        
        <h2>Opciones</h2>
        <div class="menu-buttons">
            <button onclick="location.href='ver_proveedores.php'">Proveedores</button>
            <button onclick="location.href='agregar_proveedor.php'">Agregar Proveedor</button>

        </div>
    </div>
    <?php 
    include 'conexion.php';
    ?>
</body>
</html>
