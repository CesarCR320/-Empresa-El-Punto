<?php
    $servidor = "localhost";
    $usuario = "root";
    $password = "root";
    $base_datos = "elPunto";

    $conexion = new mysqli($servidor, $usuario, $password, $base_datos);

    if($conexion){
        echo "estoy conectado";
    } else {
        echo "no estoy conectado revisa";
    }
