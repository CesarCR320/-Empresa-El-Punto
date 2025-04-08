<?php
// Incluir el archivo de conexión
include_once 'conexion.php';

// Verificar si se recibieron los datos necesarios
if (isset($_POST['nombre'], $_POST['apellidoU'], $_POST['apellidoD'], $_POST['rol'], $_POST['tel'], $_POST['email'])) {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $apellidoU = $_POST['apellidoU'];
    $apellidoD = $_POST['apellidoD'];
    $rol = $_POST['rol'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO usuarios_agenda (Nombre, ApellidoU, ApellidoD, Rol, Tel, Email) VALUES (?, ?, ?, ?, ?, ?)";

    // Preparar la declaración
    if ($stmt = $conn->prepare($sql)) {
        // Vincular los parámetros
        $stmt->bind_param("ssssss", $nombre, $apellidoU, $apellidoD, $rol, $tel, $email);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Usuario agregado correctamente. Redirigiendo en 5 segundos...";
            header("refresh:5;url=http://localhost/proyecto/-Empresa-El-Punto/Usuarios/");
        } else {
            echo "Error al agregar el usuario: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
} else {
    echo "Faltan datos necesarios.";
}

// Cerrar la conexión
$conn->close();
?>