<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "el_punto";

$conexion = new mysqli($servidor, $usuario, $password, $base_datos);
if ($conexion->connect_error) {
    die("No estoy conectado, revisa: " . $conexion->connect_error);
}
?>