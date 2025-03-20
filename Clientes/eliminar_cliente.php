<?php

include "conexion.php";
$id = $_GET["id"];

$sql = "DELETE FROM clientes WHERE id = '$id'";
if ($conexion->query($sql) === TRUE) {
    header("Location: ver_clientes.php"); // Redirige a la lista de clientes
    exit();
} else {
    echo "Error al agregar cliente: " . $conexion->error;
}