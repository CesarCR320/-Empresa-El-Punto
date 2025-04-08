<?php
    require_once '../../config/conexion.php';
    if (isset($_SESSION['e_id'])) {
?>

<?php   require_once '../Main/head.php'; ?>
        <title>Soporte :: Nuevo Ticket</title>
    </head>
    <body class="with-side-menu">

        <?php   require_once '../Main/header.php'; ?>

        <div class="mobile-menu-left-overlay"></div>
        
        <?php   require_once '../Main/nav.php'; ?>

        <!-- Contenido de la página -->
        <div class="page-content">
            <div class="container-fluid">
                <header class="section-header">
                    <div class="tbl">
                        <div class="tbl-row">
                            <div class="tbl-cell">
                                <h3>Nuevo Ticket</h3>
                                <ol class="breadcrumb breadcrumb-simple">
                                    <li><a href="../Home">Inicio</a></li>
                                    <li><a href="#">Soporte</a></li>
                                    <li class="active">Nuevo Ticket</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </header>
            </div><!--.container-fluid-->
        </div><!--Contenido de la página-->
        <?php   require_once '../Main/js.php'; ?>
        <script type="text/javascript" src="new-ticket.js"></script>
    </body>
</html>
<?php
    } else {
        header('Location:'.Conectar::ruta().'index.php');
    }
?>
