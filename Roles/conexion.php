<?php

echo"Hola estoy en el archivo de conexion";


$servidor = "localhost";
$usuario = "root";
$pasword = "";
$base_datos = "modolosR";

$conexion = new mysqli($servidor, $usuario, $pasword,$base_datos);
if ($conexion) {
    $sql = "select * from Roles";
    $tablaRoles = $conexion->query($sql);

    if ($tablaRoles->num_rows > 0) {
        while ($fila = $tablaRoles->fetch_assoc()) {
            echo "----------------------ID: " . $fila['id_rol'] . "Nombre: " . $fila['nombre_rol'] . "<br>";
        }
    } else {
        echo "La tabla roles no tiene registros";
    }
} else {
    echo "No estoy conectado revisa";
}

