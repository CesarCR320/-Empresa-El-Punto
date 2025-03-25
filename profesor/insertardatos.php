<?php

include 'conexion.php';

// Insertar datos si el formulario es enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $salon = $_POST['salon'];

    $sql = "INSERT INTO profesores VALUES ($id,'$nombre', '$apellidos', $salon)";
    if ($conexion->query($sql) === TRUE) {
        header("Location: http://localhost:8080/-Empresa-El-Punto/profesor/");
    } else {
        echo "<p class='alert alert-danger'>Error: " . $conn->error . "</p>";
    }
}
