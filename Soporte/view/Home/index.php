<?php
    require_once '../../config/conexion.php';
    if (isset($_SESSION['e_id'])) {
?>

<?php   require_once '../Main/head.php'; ?>
        <title>Soporte :: Principal</title>
    </head>
    <body class="with-side-menu">

        <?php   require_once '../Main/header.php'; ?>

        <div class="mobile-menu-left-overlay"></div>
        
        <?php   require_once '../Main/nav.php'; ?>

        <!-- Contenido de la página -->
        <div class="page-content">
            <div class="container-fluid">
                Blank page.
            </div><!--.container-fluid-->
        </div><!--.page-content-->
        <?php   require_once '../Main/js.php'; ?>
        <script type="text/javascript" src="home.js"></script>
    </body>
</html>
<?php
    } else {
        header('Location:'.Conectar::ruta().'index.php');
    }
?>
