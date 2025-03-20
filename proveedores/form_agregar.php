<?php
include_once 'conexion.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $telefono = $_POST['telefono'];

    
    if (!empty($nombre) && !empty($contacto) && !empty($telefono)) {
        
        $sql = "INSERT INTO proveedores (nombre, contacto, telefono) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $contacto, $telefono);

        
        if ($stmt->execute()) {
           
            echo "<script>alert('Proveedor agregado correctamente'); window.location.href='ver_proveedores.php';</script>";
        } else {
            
            echo "<script>alert('Error al agregar el proveedor.'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
       
        echo "<script>alert('Por favor, llena todos los campos.'); window.history.back();</script>";
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Proveedor</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Agregar Proveedor</h1>


    <form action="" method="POST">
        <label for="nombre">Nombre del Proveedor:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="contacto">Nombre de Contacto:</label>
        <input type="text" id="contacto" name="contacto" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required>

        <button type="submit">Guardar</button>
    </form>

    <button onclick="location.href='index.php'">Volver al Menú</button>
</body>
</html>
