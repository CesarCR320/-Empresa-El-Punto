<?php
    require_once "../config/conexion.php";
    require_once "../modelos/Usuario.php";
    $usuario = new Usuarios();
    $datos = $usuario->get_usuario();
    $html = "<option  value='' disabled selected>- Seleccione una opción -</option>";
    if (isset($_GET["op"])) {
        switch ($_GET["op"]) {
            case "combo":
                $data = Array();
                foreach ($datos as $row) {
                    $html .= "<option value='" . $row["e_id"] . "'>" . $row["e_name"] . "</option>";
                }
                echo $html;
            break;
        }
    } else {
        $html = "<option value=''>No hay opciones</option>";
    }
?>
