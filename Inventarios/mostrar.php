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

// Ejecutar la consulta para obtener productos
$sql = "SELECT id, nombre, tipo, descripcion FROM inventarios";
$result = $conn->query($sql);

// Verificar si hay productos
if ($result->rowCount() > 0) {
    $productos = $result->fetchAll(PDO::FETCH_ASSOC);
} else {
    $productos = [];
}

// Cerrar conexión
$conexion->desconectar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<header class="bg-primary-subtle text-primary-emphasis py-3 d-flex justify-content-center align-items-center">
    <h1 class="fs-1 m-0">Lista de Productos</h1>
</header>

<div class="container mt-5">
    <div class="bg-white p-4 shadow rounded">
        <?php
        if (count($productos) > 0) {
            foreach ($productos as $row) {
                echo '<div class="row mb-4">';
                echo '<div class="col-md-9">';
                echo '<p><b>ID:</b> ' . htmlspecialchars($row['id']) . '</p>';
                echo '<p><b>Nombre:</b> ' . htmlspecialchars($row['nombre']) . '</p>';
                echo '<p><b>Tipo:</b> ' . htmlspecialchars($row['tipo']) . '</p>';
                echo '<p><b>Descripción:</b> ' . htmlspecialchars($row['descripcion']) . '</p>';
                echo '</div>';
                echo '</div>';
                echo '<hr>'; // Línea horizontal
            }
        } else {
            echo '<p>No hay productos disponibles.</p>';
        }
        ?>
    </div>
    <div class="d-flex justify-content-center mt-4">
        <button type="button" class="btn btn-danger btn-lg" onclick="window.location.href='index.html'">
            Atrás
        </button>
    </div>
</div>
</body>
</html>
