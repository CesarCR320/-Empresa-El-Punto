<?php
include 'conexion.php'; // Incluye la conexión a la base de datos

// Consulta para traer los datos de la tabla mensajes
$sql = "SELECT id, nombre, email, mensaje, fecha FROM mensajes";
$resultado = $conexion->query($sql);

// Lógica para eliminar un mensaje
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conexion->prepare("DELETE FROM mensajes WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        // Refrescar la página después de eliminar
        header("Location: index.php");
        exit();
    } else {
        echo "<p style='color: red;'>Error al eliminar: " . $conexion->error . "</p>";
    }
    $stmt->close();
}

// Lógica para editar un mensaje
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_id'])) {
    $id = intval($_POST['editar_id']);
    $name = htmlspecialchars($_POST['editar_name']);
    $email = htmlspecialchars($_POST['editar_email']);
    $message = htmlspecialchars($_POST['editar_message']);

    // Actualizar en la base de datos usando consulta preparada
    $stmt = $conexion->prepare("UPDATE mensajes SET nombre = ?, email = ?, mensaje = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $message, $id);
    if ($stmt->execute()) {
        // Refrescar la consulta después de actualizar
        $resultado = $conexion->query("SELECT id, nombre, email, mensaje, fecha FROM mensajes");
        echo "<p style='color: green;'>Mensaje actualizado correctamente.</p>";
    } else {
        echo "<p style='color: red;'>Error al actualizar: " . $conexion->error . "</p>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DPTO. Logística</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        header {
            background-color: #2e7d32;
            color: white;
            text-align: center;
            padding: 1rem;
        }
        nav {
            background-color: #4caf50;
            padding: 1rem;
        }
        nav ul {
            list-style-type: none;
            display: flex;
            justify-content: center;
            gap: 2rem;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        nav ul li a:hover {
            color: #ffeb3b;
        }
        .main-content {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .section {
            margin-bottom: 2rem;
        }
        .section h2 {
            color: #2e7d32;
            margin-bottom: 1rem;
        }
        .contact-form {
            max-width: 500px;
            margin: 0 auto;
        }
        .contact-form label {
            display: block;
            margin-bottom: 0.5rem;
        }
        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
        }
        .contact-form button {
            background-color: #4caf50;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            cursor: pointer;
        }
        .contact-form button:hover {
            background-color: #2e7d32;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
            background-color: #fff;
        }
        .data-table th, .data-table td {
            padding: 0.75rem;
            text-align: left;
            border: 1px solid #ddd;
        }
        .data-table th {
            background-color: #4caf50;
            color: white;
        }
        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .data-table tr:hover {
            background-color: #f1f1f1;
        }
        .action-btn {
            padding: 5px 10px;
            margin: 0 5px;
            border: none;
            cursor: pointer;
            color: white;
            border-radius: 3px;
        }
        .edit-btn {
            background-color: #2196f3;
        }
        .edit-btn:hover {
            background-color: #1976d2;
        }
        .delete-btn {
            background-color: #f44336;
        }
        .delete-btn:hover {
            background-color: #d32f2f;
        }
        .view-btn {
            background-color: #ff9800;
        }
        .view-btn:hover {
            background-color: #f57c00;
        }
        footer {
            background-color: #2e7d32;
            color: white;
            text-align: center;
            padding: 1rem;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        /* Estilos para los modales */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            width: 400px;
        }
        .modal-content p {
            margin-bottom: 20px;
        }
        .modal-content button {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            cursor: pointer;
        }
        .modal-content .confirm-btn {
            background-color: #4caf50;
            color: white;
        }
        .modal-content .confirm-btn:hover {
            background-color: #2e7d32;
        }
        .modal-content .cancel-btn {
            background-color: #f44336;
            color: white;
        }
        .modal-content .cancel-btn:hover {
            background-color: #d32f2f;
        }
        .modal-content .close-btn {
            background-color: #2196f3;
            color: white;
        }
        .modal-content .close-btn:hover {
            background-color: #1976d2;
        }
        .modal-content label {
            display: block;
            text-align: left;
            margin-bottom: 0.5rem;
        }
        .modal-content input, .modal-content textarea {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <h1>Departamento De Logística</h1>
    </header>

    <nav>
        <ul>
            <li><a href="#inicio">Inicio</a></li>
            <li><a href="#servicios">Servicios</a></li>
            <li><a href="#contacto">Contacto</a></li>
            <li><a href="#acerca-de">Acerca de</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <div class="section" id="inicio">
            <h2>Bienvenido al Departamento de Logística</h2>
            <p>Somos líderes en la gestión y optimización de procesos logísticos. Nuestra misión es garantizar la eficiencia y la satisfacción del cliente en cada paso del camino.</p>
        </div>

        <div class="section" id="servicios">
            <h2>Nuestros Servicios</h2>
            <ul>
                <li>Gestión de transporte</li>
                <li>Almacenamiento y distribución</li>
                <li>Optimización de cadenas de suministro</li>
            </ul>
        </div>

        <div class="section" id="contacto">
            <h2>Contacto</h2>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['editar_id'])) {
                // Obtener y sanitizar los datos del formulario
                $name = htmlspecialchars($_POST['name']);
                $email = htmlspecialchars($_POST['email']);
                $message = htmlspecialchars($_POST['message']);

                // Insertar en la base de datos usando consulta preparada
                $stmt = $conexion->prepare("INSERT INTO mensajes (nombre, email, mensaje) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $name, $email, $message);
                if ($stmt->execute()) {
                    echo "<p style='color: green;'>Mensaje guardado correctamente.</p>";
                    // Refrescar la consulta después de insertar
                    $resultado = $conexion->query("SELECT id, nombre, email, mensaje, fecha FROM mensajes");
                } else {
                    echo "<p style='color: red;'>Error al guardar: " . $conexion->error . "</p>";
                }
                $stmt->close();
            }
            ?>
            <div class="contact-form">
                <form id="contactForm" method="POST" action="">
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="message">Mensaje:</label>
                    <textarea id="message" name="message" rows="5" required></textarea>

                    <button type="button" onclick="showModal()">Enviar</button>
                </form>
            </div>

            <!-- Modal para confirmar envío -->
            <div id="confirmModal" class="modal">
                <div class="modal-content">
                    <p>¿Estás seguro de que deseas enviar los datos?</p>
                    <button class="confirm-btn" onclick="submitForm()">Sí, enviar</button>
                    <button class="cancel-btn" onclick="closeModal()">Cancelar</button>
                </div>
            </div>

            <!-- Modal para confirmar eliminación -->
            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <p>¿Estás seguro de que deseas eliminar este mensaje?</p>
                    <button class="confirm-btn" id="confirmDeleteBtn">Sí, eliminar</button>
                    <button class="cancel-btn" onclick="closeDeleteModal()">Cancelar</button>
                </div>
            </div>

            <!-- Modal para ver detalles -->
            <div id="viewModal" class="modal">
                <div class="modal-content">
                    <h3>Detalles del Mensaje</h3>
                    <p><strong>ID:</strong> <span id="viewId"></span></p>
                    <p><strong>Nombre:</strong> <span id="viewNombre"></span></p>
                    <p><strong>Email:</strong> <span id="viewEmail"></span></p>
                    <p><strong>Mensaje:</strong> <span id="viewMensaje"></span></p>
                    <p><strong>Fecha:</strong> <span id="viewFecha"></span></p>
                    <button class="close-btn" onclick="closeViewModal()">Cerrar</button>
                </div>
            </div>

            <!-- Modal para editar -->
            <div id="editModal" class="modal">
                <div class="modal-content">
                    <h3>Editar Mensaje</h3>
                    <form id="editForm" method="POST" action="">
                        <input type="hidden" id="editar_id" name="editar_id">
                        <label for="editar_name">Nombre:</label>
                        <input type="text" id="editar_name" name="editar_name" required>

                        <label for="editar_email">Email:</label>
                        <input type="email" id="editar_email" name="editar_email" required>

                        <label for="editar_message">Mensaje:</label>
                        <textarea id="editar_message" name="editar_message" rows="5" required></textarea>

                        <button type="button" class="confirm-btn" onclick="submitEditForm()">Guardar Cambios</button>
                        <button type="button" class="cancel-btn" onclick="closeEditModal()">Cancelar</button>
                    </form>
                </div>
            </div>

            <!-- Tabla para mostrar los datos -->
            <h3>Mensajes Recibidos</h3>
            <?php
            if ($resultado && $resultado->num_rows > 0) {
                echo "<table class='data-table'>";
                echo "<thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Mensaje</th><th>Fecha</th><th>Acciones</th></tr></thead>";
                echo "<tbody>";
                while ($row = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['mensaje']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
                    echo "<td>";
                    echo "<button class='action-btn edit-btn' onclick=\"showEditModal(" . $row['id'] . ", '" . htmlspecialchars($row['nombre'], ENT_QUOTES) . "', '" . htmlspecialchars($row['email'], ENT_QUOTES) . "', '" . htmlspecialchars($row['mensaje'], ENT_QUOTES) . "')\">Editar</button>";
                    echo "<button class='action-btn delete-btn' onclick=\"showDeleteModal(" . $row['id'] . ")\">Eliminar</button>";
                    echo "<button class='action-btn view-btn' onclick=\"showViewModal(" . $row['id'] . ", '" . htmlspecialchars($row['nombre'], ENT_QUOTES) . "', '" . htmlspecialchars($row['email'], ENT_QUOTES) . "', '" . htmlspecialchars($row['mensaje'], ENT_QUOTES) . "', '" . htmlspecialchars($row['fecha'], ENT_QUOTES) . "')\">Ver</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>No hay mensajes registrados.</p>";
            }
            ?>
        </div>

        <div class="section" id="acerca-de">
            <h2>Acerca de Nosotros</h2>
            <p>Con más de 10 años de experiencia, nos especializamos en soluciones logísticas innovadoras y sostenibles.</p>
        </div>
    </div>

    <footer>
        <p>© 2025 Departamento De Logística. Todos los derechos reservados.</p>
    </footer>

    <script>
        // Funciones para manejar el modal de envío
        function showModal() {
            document.getElementById('confirmModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('confirmModal').style.display = 'none';
        }

        function submitForm() {
            document.getElementById('contactForm').submit();
        }

        // Funciones para manejar el modal de eliminación
        function showDeleteModal(id) {
            document.getElementById('deleteModal').style.display = 'flex';
            document.getElementById('confirmDeleteBtn').onclick = function() {
                window.location.href = 'index.php?eliminar=' + id;
            };
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        // Funciones para manejar el modal de visualización
        function showViewModal(id, nombre, email, mensaje, fecha) {
            document.getElementById('viewId').textContent = id;
            document.getElementById('viewNombre').textContent = nombre;
            document.getElementById('viewEmail').textContent = email;
            document.getElementById('viewMensaje').textContent = mensaje;
            document.getElementById('viewFecha').textContent = fecha;
            document.getElementById('viewModal').style.display = 'flex';
        }

        function closeViewModal() {
            document.getElementById('viewModal').style.display = 'none';
        }

        // Funciones para manejar el modal de edición
        function showEditModal(id, nombre, email, mensaje) {
            document.getElementById('editar_id').value = id;
            document.getElementById('editar_name').value = nombre;
            document.getElementById('editar_email').value = email;
            document.getElementById('editar_message').value = mensaje;
            document.getElementById('editModal').style.display = 'flex';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function submitEditForm() {
            document.getElementById('editForm').submit();
        }

        // Cerrar los modales si se hace clic fuera de ellos
        window.onclick = function(event) {
            var confirmModal = document.getElementById('confirmModal');
            var deleteModal = document.getElementById('deleteModal');
            var viewModal = document.getElementById('viewModal');
            var editModal = document.getElementById('editModal');
            if (event.target == confirmModal) {
                confirmModal.style.display = 'none';
            }
            if (event.target == deleteModal) {
                deleteModal.style.display = 'none';
            }
            if (event.target == viewModal) {
                viewModal.style.display = 'none';
            }
            if (event.target == editModal) {
                editModal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
<?php
$conexion->close(); // Cierra la conexión al final
?>