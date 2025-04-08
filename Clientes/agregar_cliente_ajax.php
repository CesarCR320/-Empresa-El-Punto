<?php
include "conexion.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger y limpiar los datos del formulario
    $nombre = $conexion->real_escape_string($_POST["nombre"]);
    $direccion = $conexion->real_escape_string($_POST["direccion"]);
    $rfc = !empty($_POST["rfc"]) ? $conexion->real_escape_string($_POST["rfc"]) : NULL;
    $telefono = $conexion->real_escape_string($_POST["telefono"]);
    $correo = $conexion->real_escape_string($_POST["correo"]);

    
    $sql = "INSERT INTO clientes (Nombre, Direccion, RFC, Telefono, Correo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    
    
    $stmt->bind_param("sssss", $nombre, $direccion, $rfc, $telefono, $correo);

    
    if ($stmt->execute()) {
        echo json_encode([
            "success" => true, 
            "message" => "Cliente agregado exitosamente",
            "id" => $stmt->insert_id
        ]);
    } else {
        echo json_encode([
            "success" => false, 
            "message" => "Error al agregar cliente: " . $stmt->error
        ]);
    }

    
    $stmt->close();
}


$conexion->close();
?>