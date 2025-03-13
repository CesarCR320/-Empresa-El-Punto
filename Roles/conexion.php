<?php

echo"Hola estoy en el archivo de conexion";


$servidor = "localhost";
$usuario = "root";
$pasword = "";
$base_datos = "elpunto";

$conexion = new mysqli($servidor, $usuario, $pasword,$base_datos);
if ($conexion) {
    echo "estoy conectado";    
} else {
    echo "no estoy conectado revisa";
}

