<?php

include "conexion.php";

$nombre = $_POST["nombre"];
$direccion = $_POST["direccion"];
$rfc = $_POST["rfc"] ?? NULL;
$telefono = $_POST["telefono"];
$correo = $_POST["correo"];

$sql = "INSERT INTO clientes (Nombre, Direccion, RFC, Telefono, Correo) 
        VALUES ('$nombre', '$direccion', '$rfc', '$telefono', '$correo')";

if ($conexion->query($sql) === TRUE) {
    header("Location: ver_clientes.php"); // Redirige a la lista de clientes
    exit();
} else {
    echo "Error al agregar cliente: " . $conexion->error;
}

// Cerrar la conexión
$conexion->close();
?>
