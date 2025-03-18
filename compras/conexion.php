<?php

echo "hola estoy en el archivo de conexion";

$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "el punto";

$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

if($conexion){
    echo "estoy conectado";
}
else{
    echo "checale no estoy conectado mibro";
}