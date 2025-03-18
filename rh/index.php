<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo de Recursos Humanos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Recursos Humanos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <button class="btn btn-primary m-2" onclick="location.href='index.php'">Inicio</button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-primary m-2" onclick="location.href='empleados.php'">Empleados</button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-primary m-2" onclick="location.href='vacantes.php'">Vacantes</button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-primary m-2" onclick="location.href='reportes.php'">Reportes</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Hola, soy el módulo de Recursos Humanos</h1>
        <p>Selecciona una opción del menú para continuar.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>