<?php


$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "elpunto";

$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

if ($conexion) {
    $sql = "select * from profesores";
    $tablaProfesores = $conexion->query($sql);

    if ($tablaProfesores->num_rows > 0) {
        while ($fila = $tablaProfesores->fetch_assoc()) {
            // echo "----------------------ID: " . $fila['id'] . "Nombre: " . $fila['nombre'] . "<br>";
        }
    } else {
        echo "La tabla profesor no tiene registros";
    }
} else {
    echo "No estoy conectado revisa";
}
