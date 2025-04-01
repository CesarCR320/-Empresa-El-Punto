<?php
include('db.php'); // Incluir la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];

    // Validar que los campos no estén vacíos
    if (!empty($titulo) && !empty($descripcion)) {
        $sql = "INSERT INTO reportes (titulo, descripcion, fecha) VALUES (?, ?, NOW())";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $titulo, $descripcion);

        if ($stmt->execute()) {
            echo "<script>alert('Reporte agregado exitosamente'); window.location.href='ver_reportes.php';</script>";
        } else {
            echo "<script>alert('Error al agregar el reporte'); window.location.href='ver_reportes.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Todos los campos son obligatorios'); window.location.href='ver_reportes.php';</script>";
    }

    $conn->close();
}
?>
