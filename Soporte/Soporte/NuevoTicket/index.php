<?php
    require_once '../../config/conexion.php';
    if (isset($_SESSION['e_id'])) {
?>

<?php   require_once '../../view/Main/head.php'; ?>
        <title>Soporte :: Nuevo Ticket</title>
    </head>
    <body class="with-side-menu">

        <?php   require_once '../../view/Main/header.php'; ?>

        <div class="mobile-menu-left-overlay"></div>
        
        <?php   require_once '../../view/Main/nav.php'; ?>

        <!-- Contenido de la página -->
        <div class="page-content">
            <div class="container-fluid">
                <header class="section-header">
                    <div class="tbl">
                        <div class="tbl-row">
                            <div class="tbl-cell">
                                <h3>Nuevo Ticket</h3>
                                <ol class="breadcrumb breadcrumb-simple">
                                    <li><a href="../../Home">Inicio</a></li>
                                    <li><a href="../">Soporte</a></li>
                                    <li class="active">Nuevo Ticket</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </header>

                <div class="box-typical box-typical-padding">
                    <form method="post" id="ticket-form">
                        <p class="with-border">Crea un registro de incidente para reportar y solicitar asistencia con un problema que esta presentando</p>

                        <h5 class="m-t-lg with-border semibold">Información de contacto</h5>
                        <div class="row">
                            <div class="col-lg-6">
                                <fieldset class="form-group">
                                    <label class="form-label semibold" for="text">Nombre del usuario</label>
                                    <input type="text" class="form-control" id="usuario-select">
                                </fieldset>
                            </div>
                            <div class="col-lg-6">
                                <fieldset class="form-group">
                                    <label class="form-label semibold" for="us-phone-mask-input">Teléfono de contacto</label>
                                    <input type="phone" class="form-control" id="us-phone-mask-input">
                                </fieldset>
                            </div>
                            <div class="col-lg-6">
                                <fieldset class="form-group">
                                    <label class="form-label semibold" for="area-id">Área</label>
                                    <select id="area-id"  class="form-control">
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-lg-6">
                                <fieldset class="form-group">
                                    <label class="form-label semibold" for="Email">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="Email" placeholder="correo@elpunto.com">
                                </fieldset>
                            </div>
                        </div><!--.row-->

                        <h5 class="m-t-lg with-border semibold">Detalles del problema</h5>
                        <div class="row">
                            <div class="col-lg-6">
                                <fieldset class="form-group">
                                    <label class="form-label semibold" for="ticket-category">Categoría</label>
                                    <select id="ticket-category" class="form-control">
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-lg-6">
                                <fieldset class="form-group">
                                    <label class="form-label semibold" for="subcategory">Subcategoría</label>
                                    <select id="subcategory" class="form-control">
                                        <option value="" disabled selected>- Seleccione una subcategoría -</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset class="form-group">
                                    <label class="form-label semibold" for="short-description">Descripción corta</label>
                                    <input type="text" class="form-control" id="short-description">
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset class="form-group">
                                    <label class="form-label semibold" for="ticket-description">Descripción detallada</label>
                                    <div class="summernote-theme-1">
                                        <textarea id="ticket-description" class="summernote" name="name"></textarea>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" name="action" value="add" class="btn btn-rounded btn-inline btn-primary">Enviar</button>
                            </div>
                        </div><!--.row-->
                    </form><!-- ticket form -->
                </div>
            </div><!--.container-fluid-->
        </div><!--Contenido de la página-->
        <?php   require_once '../../view/Main/js.php'; ?>
        <script type="text/javascript" src="newticket.js"></script>
    </body>
</html>
<?php
    } else {
        header('Location:'.Conectar::ruta().'index.php');
    }
?>
