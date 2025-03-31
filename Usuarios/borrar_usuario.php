<?php
// Incluir archivo de conexión
include_once 'conexion.php';

// Verificar si se recibió el ID por método GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Asegurarse de que el ID sea un número entero

    // Preparar la consulta para borrar el registro
    $sql = "DELETE FROM usuarios_agenda WHERE ID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id); // Vincular el parámetro
        if ($stmt->execute()) {
            echo "Usuario eliminado correctamente. Redirigiendo en 5 segundos...";
            header("refresh:5;url=http://localhost/proyecto/-Empresa-El-Punto/Usuarios/");
        } else {
            echo "Error al eliminar el usuario: " . $stmt->error;
        }
        $stmt->close(); // Cerrar la declaración
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
} else {
    echo "No se recibió un ID válido.";
}

// Cerrar la conexión
$conn->close();
?>