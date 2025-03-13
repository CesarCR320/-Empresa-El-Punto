<?php

echo "Hola estoy en el archivo de conexion";

$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "clientes";

$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

if ($conexion) {
    echo "Estoy conectado";
}
else {
    echo "No estoy conectado";
}
