<?php
include 'conexion.php'; // Incluye la conexión a la base de datos

// Consulta para traer los datos de la tabla solicitudes_asesoria
$sql = "SELECT id, nombre, email, telefono, tipo_consulta, mensaje, archivo, fecha FROM solicitudes_asesoria";
$resultado = $conexion->query($sql);

// Lógica para eliminar una solicitud
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conexion->prepare("DELETE FROM solicitudes_asesoria WHERE id = ?");
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

// Lógica para editar una solicitud
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_id'])) {
    $id = intval($_POST['editar_id']);
    $name = htmlspecialchars($_POST['editar_name']);
    $email = htmlspecialchars($_POST['editar_email']);
    $telefono = htmlspecialchars($_POST['editar_telefono']);
    $tipo_consulta = htmlspecialchars($_POST['editar_tipo_consulta']);
    $message = htmlspecialchars($_POST['editar_message']);

    // Actualizar en la base de datos usando consulta preparada
    $stmt = $conexion->prepare("UPDATE solicitudes_asesoria SET nombre = ?, email = ?, telefono = ?, tipo_consulta = ?, mensaje = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $name, $email, $telefono, $tipo_consulta, $message, $id);
    if ($stmt->execute()) {
        // Refrescar la consulta después de actualizar
        $resultado = $conexion->query("SELECT id, nombre, email, telefono, tipo_consulta, mensaje, archivo, fecha FROM solicitudes_asesoria");
        echo "<p style='color: green;'>Solicitud actualizada correctamente.</p>";
    } else {
        echo "<p style='color: red;'>Error al actualizar: " . $conexion->error . "</p>";
    }
    $stmt->close();
}

// Lógica para manejar el formulario de solicitud de asesoría
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['editar_id'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $tipo_consulta = htmlspecialchars($_POST['tipo_consulta']);
    $message = htmlspecialchars($_POST['message']);
    $archivo = null;

    // Manejo del archivo subido
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/'; // Directorio donde se guardarán los archivos
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Crear el directorio si no existe
        }
        $archivo = $upload_dir . basename($_FILES['archivo']['name']);
        if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $archivo)) {
            $archivo = null;
            echo "<p style='color: red;'>Error al subir el archivo.</p>";
        }
    }

    // Insertar en la base de datos usando consulta preparada
    $stmt = $conexion->prepare("INSERT INTO solicitudes_asesoria (nombre, email, telefono, tipo_consulta, mensaje, archivo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $telefono, $tipo_consulta, $message, $archivo);
    if ($stmt->execute()) {
        echo "<p style='color: green;'>Solicitud de asesoría enviada correctamente.</p>";
        // Refrescar la consulta después de insertar
        $resultado = $conexion->query("SELECT id, nombre, email, telefono, tipo_consulta, mensaje, archivo, fecha FROM solicitudes_asesoria");
    } else {
        echo "<p style='color: red;'>Error al enviar la solicitud: " . $conexion->error . "</p>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DPTO. Legal y Asuntos Jurídicos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-image: url('Fondo_Legal.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
        }
        header {
            background-color: rgba(33, 150, 243, 0.6);
            color: white;
            text-align: center;
            padding: 1rem;
        }
        nav {
            background-color: rgba(66, 165, 245, 0.6);
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
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .section {
            margin-bottom: 2rem;
            padding: 1rem;
        }
        #inicio {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 5px;
            padding: 1.5rem;
        }
        .section h2 {
            color: #1565c0;
            margin-bottom: 1rem;
        }
        .legal-form {
            max-width: 600px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .legal-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #333;
        }
        .legal-form input,
        .legal-form select,
        .legal-form textarea {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            font-size: 1rem;
        }
        .legal-form textarea {
            resize: vertical;
        }
        .legal-form button {
            background-color: #2196f3;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        .legal-form button:hover {
            background-color: #1976d2;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
            background-color: rgba(255, 255, 255, 0.8);
        }
        .data-table th, .data-table td {
            padding: 0.75rem;
            text-align: left;
            border: 1px solid #ddd;
        }
        .data-table th {
            background-color: rgba(66, 165, 245, 0.8);
            color: white;
        }
        .data-table tr:nth-child(even) {
            background-color: rgba(249, 249, 249, 0.8);
        }
        .data-table tr:hover {
            background-color: rgba(241, 241, 241, 0.8);
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
            background-color: rgba(33, 150, 243, 0.6);
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
            background-color: rgba(255, 255, 255, 0.9);
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
            background-color: #2196f3;
            color: white;
        }
        .modal-content .confirm-btn:hover {
            background-color: #1976d2;
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
            background-color: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body>
    <header>
        <h1>Departamento de Legal y Asuntos Jurídicos</h1>
    </header>

    <nav>
        <ul>
            <li><a href="#inicio">Inicio</a></li>
            <li><a href="#servicios">Servicios</a></li>
            <li><a href="#contacto">Solicitud de Asesoría</a></li>
            <li><a href="#acerca-de">Acerca de</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <div class="section" id="inicio">
            <h2>Bienvenido al Departamento de Legal y Asuntos Jurídicos</h2>
            <p>Nos especializamos en brindar asesoría legal, gestión de contratos y cumplimiento normativo para garantizar la seguridad jurídica de la empresa y sus operaciones.</p>
        </div>

        <div class="section" id="servicios">
            <h2>Nuestros Servicios</h2>
            <ul>
                <li>Asesoría legal y resolución de conflictos</li>
                <li>Gestión y revisión de contratos</li>
                <li>Cumplimiento normativo y auditorías legales</li>
                <li>Representación en procedimientos legales</li>
            </ul>
        </div>

        <div class="section" id="contacto">
            <h2>Solicitud de Asesoría Legal</h2>
            <div class="legal-form">
                <form method="POST" action="" enctype="multipart/form-data">
                    <label for="name">Nombre Completo:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" required>

                    <label for="tipo_consulta">Tipo de Consulta:</label>
                    <select id="tipo_consulta" name="tipo_consulta" required>
                        <option value="">Seleccione una opción</option>
                        <option value="Laboral">Laboral</option>
                        <option value="Contractual">Contractual</option>
                        <option value="Penal">Penal</option>
                        <option value="Civil">Civil</option>
                        <option value="Otros">Otros</option>
                    </select>

                    <label for="message">Descripción de la Consulta:</label>
                    <textarea id="message" name="message" rows="5" required placeholder="Describa su consulta o solicitud legal..."></textarea>

                    <label for="archivo">Adjuntar Documento (opcional):</label>
                    <input type="file" id="archivo" name="archivo" accept=".pdf,.doc,.docx">

                    <button type="submit">Enviar Solicitud</button>
                </form>
            </div>

            <!-- Tabla para mostrar las solicitudes -->
            <h3>Solicitudes Recibidas</h3>
            <?php
            if ($resultado && $resultado->num_rows > 0) {
                echo "<table class='data-table'>";
                echo "<thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Tipo de Consulta</th><th>Mensaje</th><th>Archivo</th><th>Fecha</th><th>Acciones</th></tr></thead>";
                echo "<tbody>";
                while ($row = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['telefono']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tipo_consulta']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['mensaje']) . "</td>";
                    echo "<td>";
                    if ($row['archivo']) {
                        echo "<a href='" . htmlspecialchars($row['archivo']) . "' target='_blank'>Ver archivo</a>";
                    } else {
                        echo "N/A";
                    }
                    echo "</td>";
                    echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
                    echo "<td>";
                    echo "<button class='action-btn edit-btn' onclick=\"showEditModal(" . $row['id'] . ", '" . htmlspecialchars($row['nombre'], ENT_QUOTES) . "', '" . htmlspecialchars($row['email'], ENT_QUOTES) . "', '" . htmlspecialchars($row['telefono'], ENT_QUOTES) . "', '" . htmlspecialchars($row['tipo_consulta'], ENT_QUOTES) . "', '" . htmlspecialchars($row['mensaje'], ENT_QUOTES) . "')\">Editar</button>";
                    echo "<button class='action-btn delete-btn' onclick=\"showDeleteModal(" . $row['id'] . ")\">Eliminar</button>";
                    echo "<button class='action-btn view-btn' onclick=\"showViewModal(" . $row['id'] . ", '" . htmlspecialchars($row['nombre'], ENT_QUOTES) . "', '" . htmlspecialchars($row['email'], ENT_QUOTES) . "', '" . htmlspecialchars($row['telefono'], ENT_QUOTES) . "', '" . htmlspecialchars($row['tipo_consulta'], ENT_QUOTES) . "', '" . htmlspecialchars($row['mensaje'], ENT_QUOTES) . "', '" . htmlspecialchars($row['archivo'], ENT_QUOTES) . "', '" . htmlspecialchars($row['fecha'], ENT_QUOTES) . "')\">Ver</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>No hay solicitudes registradas.</p>";
            }
            ?>
        </div>

        <div class="section" id="acerca-de">
            <h2>Acerca de Nosotros</h2>
            <p>Con más de 15 años de experiencia, nuestro equipo legal está comprometido con la excelencia en la protección jurídica y el cumplimiento normativo de la empresa.</p>
        </div>
    </div>

    <!-- Modal para confirmar eliminación -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <p>¿Estás seguro de que deseas eliminar esta solicitud?</p>
            <button class="confirm-btn" id="confirmDeleteBtn">Sí, eliminar</button>
            <button class="cancel-btn" onclick="closeDeleteModal()">Cancelar</button>
        </div>
    </div>

    <!-- Modal para ver detalles -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <h3>Detalles de la Solicitud</h3>
            <p><strong>ID:</strong> <span id="viewId"></span></p>
            <p><strong>Nombre:</strong> <span id="viewNombre"></span></p>
            <p><strong>Email:</strong> <span id="viewEmail"></span></p>
            <p><strong>Teléfono:</strong> <span id="viewTelefono"></span></p>
            <p><strong>Tipo de Consulta:</strong> <span id="viewTipoConsulta"></span></p>
            <p><strong>Mensaje:</strong> <span id="viewMensaje"></span></p>
            <p><strong>Archivo:</strong> <span id="viewArchivo"></span></p>
            <p><strong>Fecha:</strong> <span id="viewFecha"></span></p>
            <button class="close-btn" onclick="closeViewModal()">Cerrar</button>
        </div>
    </div>

    <!-- Modal para editar -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h3>Editar Solicitud</h3>
            <form id="editForm" method="POST" action="">
                <input type="hidden" id="editar_id" name="editar_id">
                <label for="editar_name">Nombre:</label>
                <input type="text" id="editar_name" name="editar_name" required>

                <label for="editar_email">Email:</label>
                <input type="email" id="editar_email" name="editar_email" required>

                <label for="editar_telefono">Teléfono:</label>
                <input type="tel" id="editar_telefono" name="editar_telefono" required>

                <label for="editar_tipo_consulta">Tipo de Consulta:</label>
                <select id="editar_tipo_consulta" name="editar_tipo_consulta" required>
                    <option value="Laboral">Laboral</option>
                    <option value="Contractual">Contractual</option>
                    <option value="Penal">Penal</option>
                    <option value="Civil">Civil</option>
                    <option value="Otros">Otros</option>
                </select>

                <label for="editar_message">Mensaje:</label>
                <textarea id="editar_message" name="editar_message" rows="5" required></textarea>

                <button type="button" class="confirm-btn" onclick="submitEditForm()">Guardar Cambios</button>
                <button type="button" class="cancel-btn" onclick="closeEditModal()">Cancelar</button>
            </form>
        </div>
    </div>

    <footer>
        <p>© 2025 Departamento de Legal y Asuntos Jurídicos. Todos los derechos reservados.</p>
    </footer>

    <script>
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
        function showViewModal(id, nombre, email, telefono, tipo_consulta, mensaje, archivo, fecha) {
            document.getElementById('viewId').textContent = id;
            document.getElementById('viewNombre').textContent = nombre;
            document.getElementById('viewEmail').textContent = email;
            document.getElementById('viewTelefono').textContent = telefono;
            document.getElementById('viewTipoConsulta').textContent = tipo_consulta;
            document.getElementById('viewMensaje').textContent = mensaje;
            document.getElementById('viewArchivo').innerHTML = archivo ? `<a href="${archivo}" target="_blank">Ver archivo</a>` : 'N/A';
            document.getElementById('viewFecha').textContent = fecha;
            document.getElementById('viewModal').style.display = 'flex';
        }

        function closeViewModal() {
            document.getElementById('viewModal').style.display = 'none';
        }

        // Funciones para manejar el modal de edición
        function showEditModal(id, nombre, email, telefono, tipo_consulta, mensaje) {
            document.getElementById('editar_id').value = id;
            document.getElementById('editar_name').value = nombre;
            document.getElementById('editar_email').value = email;
            document.getElementById('editar_telefono').value = telefono;
            document.getElementById('editar_tipo_consulta').value = tipo_consulta;
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
            var deleteModal = document.getElementById('deleteModal');
            var viewModal = document.getElementById('viewModal');
            var editModal = document.getElementById('editModal');
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