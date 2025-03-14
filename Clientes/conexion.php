<?php

echo "Hola estoy en el archivo de conexion";

$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "clientes";

$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

if ($conexion) {
    echo "Estoy conectado";
    $sql = "select * from clientes";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        echo "La tabla clientes tiene regiestros";
    } else {
        echo "La tabla clientes no tiene registros";
    }

} else {
    echo "No estoy conectado";
}
