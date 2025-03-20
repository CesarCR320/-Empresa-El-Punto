<?php


$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "el punto";

$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

if($conexion){
    $sql = "select * from ventas";
    $tablaVentas = $conexion->query($sql);

    if($tablaVentas->num_rows >0){ 
        while ($fila = $tablaVentas->fetch_assoc()) {
            //echo "ID: ".$fila['id'] . "nombre: " . $fila['nombre_cliente']; 
        }

    }
    else{
        echo "la tabla ventas no tiene registros";
    } 
}
else{
    echo "revisa, no estoy conectado";
}