<?php
// Include database connection
include_once 'conexion.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch user data based on ID
    $query = "SELECT ID, Nombre, ApellidoU, ApellidoD, Rol, Tel, Email FROM usuarios_agenda WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Usuario no encontrado.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidou = $_POST['apellidou'];
    $apellidod = $_POST['apellidod'];
    $rol = $_POST['rol'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];

    // Update user data
    $updateQuery = "UPDATE usuarios_agenda SET Nombre = ?, ApellidoU = ?, ApellidoD = ?, Rol = ?, Tel = ?, Email = ? WHERE ID = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssssi", $nombre, $apellidou, $apellidod, $rol, $tel, $email, $id);

    if ($stmt->execute()) {
        echo "Usuario modificado correctamente. Redirigiendo en 5 segundos...";
        header("refresh:5;url=http://localhost/proyecto/-Empresa-El-Punto/Usuarios/");
        exit;
    } else {
        echo "Error al actualizar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Editar Usuario</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user['Nombre']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="apellidoU" class="form-label">Primer apellido</label>
            <input type="text" class="form-control" id="apellidoU" name="apellidou" value="<?php echo htmlspecialchars($user['ApellidoU']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="apellidod" class="form-label">Segundo apellido</label>
            <input type="text" class="form-control" id="apellidod" name="apellidod" value="<?php echo htmlspecialchars($user['ApellidoD']); ?>" required>
        </div>
        <div class="mb-3">
                <label for="rol" class="form-label">Rol</label>
                <select class="form-select" id="rol" name="rol" required>
                    <option value="" selected disabled>Seleccione un rol</option>
                    <option value="admin">Administrador</option>
                    <option value="user">Usuario</option>
                </select>
        </div>
        <div class="mb-3">
            <label for="tel" class="form-label">Teléfono</label>
            <input type="tel" class="form-control" id="tel" name="tel" value="<?php echo htmlspecialchars($user['Tel']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="lista_usuarios.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>