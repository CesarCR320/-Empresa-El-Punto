<?php

include('db.php');  

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];

    if (empty($titulo) || empty($descripcion)) {
        echo "<script>alert('Por favor, complete todos los campos.'); window.location.href='nuevo_reporte.html';</script>";
        exit();
    }

    $sql = "INSERT INTO reportes (titulo, descripcion) VALUES ('$titulo', '$descripcion')";

    if ($conexion->query($sql) === TRUE) {
        echo "<script>alert('Reporte agregado exitosamente.'); window.location.href='ver_reportes.php';</script>";
    } else {
        echo "Error al agregar el reporte: " . $conexion->error;
    }
}

$conexion->close();

?>
