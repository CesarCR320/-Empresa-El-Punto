<?php
echo "";
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "usuarios";

$conn = new mysqli($servidor, $usuario, $password, $base_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} else {
    echo " ";
}