<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Módulo de Ventas</h2>
        <form>
            <label for="cliente">Nombre del Cliente:</label>
            <input type="text" id="cliente" name="cliente" required>

            <label for="producto">Producto:</label>
            <select id="producto" name="producto" required>
                <option value="producto1">Producto 1</option>
                <option value="producto2">Producto 2</option>
                <option value="producto3">Producto 3</option>
            </select>

            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" min="1" required>

            <label for="precio">Precio Unitario:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>

            <button type="submit">Procesar Venta</button>
        </form>
    </div>
    <?php
        include 'conexion.php';
    ?>
    </body>
</body>
</html>