<?php
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $direccion = $_POST["direccion"];
    $rfc = $_POST["rfc"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];

    $sql = "UPDATE clientes SET Nombre=?, Direccion=?, RFC=?, Telefono=?, Correo=? WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssi", $nombre, $direccion, $rfc, $telefono, $correo, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "No se pudo actualizar el cliente"]);
    }

    $stmt->close();
    $conexion->close();
}
?>
