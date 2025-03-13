<?php // Verificación de sesión activa para mostrar el botón de cerrar sesión
    if(!isset($_SESSION)) {
        session_start();
    }

    $auth = $_SESSION['login'] ?? false;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte Técnico</title>
    <link rel="stylesheet" href="/-Empresa-El-Punto/Soporte/build/css/app.css">
</head>
<body>
    
    <header class="header <?php echo $inicio  ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="/-Empresa-El-Punto/Soporte/build/img/logo.png" alt="Logotipo">
                </a>

                <div class="derecha">
                    <nav class="navegacion">
                        <a href="nuevoticket.php">Nuevo Ticket</a>
                        <a href="seguimiento.php">Seguimiento</a>
                        <a href="contacto.php">Contacto</a>
                        <a href="acceder.php">Acceder</a>
                        <?php if($auth): ?>
                            <a href="cerrar-sesion.php">Cerrar Sesión</a>
                        <?php endif; ?>
                    </nav>
                </div>
                
            </div> <!--.barra-->

            <?php  echo $inicio ? "<h1>Soporte Técnico</h1>" : ''; ?>
        </div>
    </header>
