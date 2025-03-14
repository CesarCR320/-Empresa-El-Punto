<?php
    include 'conexion.php';
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
    <title>Menú Inventarios</title>
</head>
<body class="bg-light">

    <header class="bg-primary-subtle text-primary-emphasis py-3 d-flex justify-content-center align-items-center">
        <h1 class="fs-1 m-0">Menú Inventarios</h1>
    </header>
    

    <div class="container mt-5">
        <div class="mx-auto p-4 bg-white shadow rounded" style="max-width: 600px;">
            <div class="text-center fs-1 fw-bold">
                Inventario
            </div>
            <div class="input-group d-flex justify-content-center mt-3">
                <div class="input-group-text">
                    <img src="eye.svg" style="height: 1.5rem">
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <button type="button" class="btn btn-outline-primary btn-lg" onclick="window.location.href='mostrarInventario.php'">Mostrar</button>
                </div>
            </div>
            <div class="input-group d-flex justify-content-center mt-3">
                <div class="input-group-text">
                    <img src="plus-square.svg" style="height: 1.5rem">
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <button type="button" class="btn btn-outline-primary btn-lg" onclick="window.location.href='agregarInventario.php'">Agregar</button>
                </div>
            </div>
            <div class="input-group d-flex justify-content-center mt-3">
                <div class="input-group-text">
                    <img src="arrow-clockwise.svg" style="height: 1.1rem">
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <button type="button" class="btn btn-outline-primary btn-lg" onclick="window.location.href='actualizarInventario.php'">Actualizar</button>
                </div>
            </div>
            <div class="input-group d-flex justify-content-center mt-3">
                <div class="input-group-text">
                    <img src="x-square.svg" style="height: 1.2rem">
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <button type="button" class="btn btn-outline-primary btn-lg"  onclick="window.location.href='eliminarInventario.php'">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>