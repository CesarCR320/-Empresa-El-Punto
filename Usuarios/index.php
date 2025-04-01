<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Usuarios</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Menú Usuarios</h1>
    <div class="menu-container">
        
        <h2>Opciones</h2>
        <div class="menu-buttons">
            <button onclick="location.href='ver_usuarios.php'">Lista de usuarios</button>
            <button onclick="location.href='agregar_usuarios.php'">Agregar Usuario</button>

        </div>
    </div>
    <?php 
    include 'conexion.php';
    ?>
</body>
</html>
