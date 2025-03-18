<?php
// Incluir la clase
require_once 'Conexion.php';

// Tus datos de conexión
$servidor = "localhost";
$usuario = "root";
$password = "root";
$base_datos = "elPunto";

// Crear instancia de la clase Conexion
$conexion = new Conexion($servidor, $usuario, $password, $base_datos);

// Abrir la conexión
$conn = $conexion->conectar();

// Comprobar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["Identificador"];
    $nombre = $_POST["Nombre"];
    $tipo = $_POST["Tipo"];
    $descripcion = $_POST["Descripcion"];

    // Procesar la imagen
    $nombre_foto = $_FILES['Foto']['name'];
    $tipo_foto = $_FILES['Foto']['type'];
    $foto_binario = file_get_contents($_FILES['Foto']['tmp_name']);
    $fotoBase64 = base64_encode($foto_binario);

    try {
        // Consulta SQL para insertar los datos
        $sql = "INSERT INTO productos (id, nombre, tipo, descripcion, foto) VALUES ('$id', '$nombre', '$tipo', '$descripcion', '$fotoBase64')";
        $conn->query($sql);

        echo "<div class='alert alert-success' role='alert'>Producto agregado exitosamente.</div>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger' role='alert'>Error al agregar el producto: " . $e->getMessage() . "</div>";
    }

    // Cerrar conexión
    $conexion->desconectar();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Un Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<header class="bg-primary-subtle text-primary-emphasis py-3 d-flex justify-content-center align-items-center">
    <h1 class="fs-1 m-0">Agregar un producto</h1>
</header>

<div class="container mt-5">
    <div class="mx-auto p-4 bg-white shadow rounded" style="max-width: 1000px;">
        <h2 class="text-primary-emphasis text-center mb-4">Ingresa los siguientes datos:</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="identificador" class="form-label fw-bold">ID</label>
                <input type="number" id="identificador" name="Identificador" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label fw-bold">Nombre del producto:</label>
                <input type="text" id="nombre" name="Nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label fw-bold">Tipo de producto:</label>
                <input type="text" id="tipo" name="Tipo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label fw-bold">Descripción del producto:</label>
                <input type="text" id="descripcion" name="Descripcion" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label fw-bold">Foto del producto:</label>
                <input type="file" id="foto" name="Foto" class="form-control" accept="image/*" required>
            </div>
            <div class="mb-5">
                <button type="submit" class="btn btn-primary w-100">Guardar Información</button>
            </div>
        </form>
        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-danger btn-lg" onclick="window.location.href='index.html'">
                Atrás
            </button>
        </div>
    </div>
</div>
</body>
</html>

