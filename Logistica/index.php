<?php
include 'conexion.php'; // Incluye la conexión a la base de datos
include 'Producto.php'; // Incluye la clase Recurso

// Crear conexión para el formulario de contacto (usando PDO)
$conexion = new Conexion();
$pdo = $conexion->conectar();

// Consulta para traer los datos de la tabla mensajes
$sql = "SELECT id, nombre, email, mensaje, fecha FROM mensajes";
$resultado = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Lógica para eliminar un mensaje
if (isset($_GET['eliminar_mensaje'])) {
    $id = intval($_GET['eliminar_mensaje']);
    $stmt = $pdo->prepare("DELETE FROM mensajes WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php#contacto");
    exit();
}

// Lógica para editar un mensaje
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_id'])) {
    $id = intval($_POST['editar_id']);
    $name = htmlspecialchars($_POST['editar_name']);
    $email = htmlspecialchars($_POST['editar_email']);
    $message = htmlspecialchars($_POST['editar_message']);

    $stmt = $pdo->prepare("UPDATE mensajes SET nombre = ?, email = ?, mensaje = ? WHERE id = ?");
    $stmt->execute([$name, $email, $message, $id]);
    header("Location: index.php#contacto");
    exit();
}

// Lógica para el Módulo de Logística
// Procesar eliminación de un recurso
if (isset($_GET['eliminar_recurso']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM recursos WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php#modulo-logistica");
    exit();
}

// Procesar agregar/editar un recurso
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['recurso_action'])) {
    $nombre = htmlspecialchars($_POST['nombre']);
    $tipo = htmlspecialchars($_POST['tipo']);
    $descripcion = htmlspecialchars($_POST['descripcion']);
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    if ($id) {
        // Editar recurso
        $stmt = $pdo->prepare("UPDATE recursos SET nombre = ?, tipo = ?, descripcion = ? WHERE id = ?");
        $stmt->execute([$nombre, $tipo, $descripcion, $id]);
    } else {
        // Agregar nuevo recurso
        $stmt = $pdo->prepare("INSERT INTO recursos (nombre, tipo, descripcion) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $tipo, $descripcion]);
    }
    header("Location: index.php#modulo-logistica");
    exit();
}

// Obtener todos los recursos
$stmt = $pdo->query("SELECT * FROM recursos");
$recursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DPTO. Logística</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-image: url('Fondo_Logistica.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
        }
        header {
            background-color: rgba(46, 125, 50, 0.6);
            color: white;
            text-align: center;
            padding: 1rem;
        }
        nav {
            background-color: rgba(76, 175, 80, 0.6);
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
            background-color: rgba(255, 255, 255, 0.8);
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
            background-color: rgba(255, 255, 255, 0.8);
        }
        .data-table th, .data-table td {
            padding: 0.75rem;
            text-align: left;
            border: 1px solid #ddd;
        }
        .data-table th {
            background-color: rgba(76, 175, 80, 0.8);
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
            background-color: rgba(46, 125, 50, 0.6);
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
            background-color: rgba(255, 255, 255, 0.8);
        }
        /* Estilos para el Módulo de Logística */
        #modulo-logistica .data-table th, #modulo-logistica .data-table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <header>
        <h1>Departamento De Logística Christopher</h1>
    </header>

    <nav>
        <ul>
            <li><a href="#inicio">Inicio</a></li>
            <li><a href="#servicios">Servicios</a></li>
            <li><a href="#contacto">Contacto</a></li>
            <li><a href="#modulo-logistica">Módulo de Logística</a></li>
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
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['editar_id']) && !isset($_POST['recurso_action'])) {
                $name = htmlspecialchars($_POST['name']);
                $email = htmlspecialchars($_POST['email']);
                $message = htmlspecialchars($_POST['message']);

                $stmt = $pdo->prepare("INSERT INTO mensajes (nombre, email, mensaje) VALUES (?, ?, ?)");
                $stmt->execute([$name, $email, $message]);
                header("Location: index.php#contacto");
                exit();
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

            <!-- Modal para confirmar eliminación de mensaje -->
            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <p>¿Estás seguro de que deseas eliminar este mensaje?</p>
                    <button class="confirm-btn" id="confirmDeleteBtn">Sí, eliminar</button>
                    <button class="cancel-btn" onclick="closeDeleteModal()">Cancelar</button>
                </div>
            </div>

            <!-- Modal para ver detalles de mensaje -->
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

            <!-- Modal para editar mensaje -->
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

            <!-- Tabla para mostrar los mensajes -->
            <h3>Mensajes Recibidos</h3>
            <?php
            if (!empty($resultado)) {
                echo "<table class='data-table'>";
                echo "<thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Mensaje</th><th>Fecha</th><th>Acciones</th></tr></thead>";
                echo "<tbody>";
                foreach ($resultado as $row) {
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

            <!-- Nueva sección: Módulo de Logística -->
            <div class="section" id="modulo-logistica">
                <h2>Módulo de Logística</h2>

                <!-- Botón para agregar nuevo recurso -->
                <div class="mb-3">
                    <button type="button" class="btn btn-success" onclick="showAddRecursoModal()">
                        AGREGAR NUEVO RECURSO
                    </button>
                </div>

                <!-- Tabla de recursos -->
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recursos as $recurso): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($recurso['id']); ?></td>
                                <td><?php echo htmlspecialchars($recurso['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($recurso['tipo']); ?></td>
                                <td><?php echo htmlspecialchars($recurso['descripcion']); ?></td>
                                <td>
                                    <button class="action-btn view-btn" onclick="showViewRecursoModal(<?php echo $recurso['id']; ?>, '<?php echo htmlspecialchars($recurso['nombre'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($recurso['tipo'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($recurso['descripcion'], ENT_QUOTES); ?>')">Ver</button>
                                    <button class="action-btn edit-btn" onclick="showEditRecursoModal(<?php echo $recurso['id']; ?>, '<?php echo htmlspecialchars($recurso['nombre'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($recurso['tipo'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($recurso['descripcion'], ENT_QUOTES); ?>')">Editar</button>
                                    <button class="action-btn delete-btn" onclick="showDeleteRecursoModal(<?php echo $recurso['id']; ?>)">Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Modal para agregar recurso -->
                <div id="addRecursoModal" class="modal">
                    <div class="modal-content">
                        <h3>Agregar Nuevo Recurso</h3>
                        <form id="addRecursoForm" method="POST" action="">
                            <input type="hidden" name="recurso_action" value="add">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" required>

                            <label for="tipo">Tipo:</label>
                            <input type="text" id="tipo" name="tipo" required>

                            <label for="descripcion">Descripción:</label>
                            <textarea id="descripcion" name="descripcion" rows="5" required></textarea>

                            <button type="button" class="confirm-btn" onclick="submitAddRecursoForm()">Agregar</button>
                            <button type="button" class="cancel-btn" onclick="closeAddRecursoModal()">Cancelar</button>
                        </form>
                    </div>
                </div>

                <!-- Modal para ver recurso -->
                <div id="viewRecursoModal" class="modal">
                    <div class="modal-content">
                        <h3>Modal Ver</h3>
                        <p><strong>ID:</strong> <span id="viewRecursoId"></span></p>
                        <p><strong>Nombre:</strong> <span id="viewRecursoNombre"></span></p>
                        <p><strong>Tipo:</strong> <span id="viewRecursoTipo"></span></p>
                        <p><strong>Descripción:</strong> <span id="viewRecursoDescripcion"></span></p>
                        <button class="close-btn" onclick="closeViewRecursoModal()">Cerrar</button>
                    </div>
                </div>

                <!-- Modal para editar recurso -->
                <div id="editRecursoModal" class="modal">
                    <div class="modal-content">
                        <h3>Modal Editar</h3>
                        <form id="editRecursoForm" method="POST" action="">
                            <input type="hidden" id="edit_recurso_id" name="id">
                            <input type="hidden" name="recurso_action" value="edit">
                            <label for="edit_recurso_nombre">Nombre:</label>
                            <input type="text" id="edit_recurso_nombre" name="nombre" required>

                            <label for="edit_recurso_tipo">Tipo:</label>
                            <input type="text" id="edit_recurso_tipo" name="tipo" required>

                            <label for="edit_recurso_descripcion">Descripción:</label>
                            <textarea id="edit_recurso_descripcion" name="descripcion" rows="5" required></textarea>

                            <button type="button" class="confirm-btn" onclick="submitEditRecursoForm()">Guardar Cambios</button>
                            <button type="button" class="cancel-btn" onclick="closeEditRecursoModal()">Cancelar</button>
                        </form>
                    </div>
                </div>

                <!-- Modal para confirmar eliminación de recurso -->
                <div id="deleteRecursoModal" class="modal">
                    <div class="modal-content">
                        <p>¿Estás seguro de que deseas eliminar este recurso?</p>
                        <button class="confirm-btn" id="confirmDeleteRecursoBtn">Sí, eliminar</button>
                        <button class="cancel-btn" onclick="closeDeleteRecursoModal()">Cancelar</button>
                    </div>
                </div>
            </div>
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
        // Funciones para manejar el modal de envío de mensajes
        function showModal() {
            document.getElementById('confirmModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('confirmModal').style.display = 'none';
        }

        function submitForm() {
            document.getElementById('contactForm').submit();
        }

        // Funciones para manejar el modal de eliminación de mensajes
        function showDeleteModal(id) {
            document.getElementById('deleteModal').style.display = 'flex';
            document.getElementById('confirmDeleteBtn').onclick = function() {
                window.location.href = 'index.php?eliminar_mensaje=' + id;
            };
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        // Funciones para manejar el modal de visualización de mensajes
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

        // Funciones para manejar el modal de edición de mensajes
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

        // Funciones para manejar el Módulo de Logística
        // Modal para agregar recurso
        function showAddRecursoModal() {
            document.getElementById('addRecursoModal').style.display = 'flex';
        }

        function closeAddRecursoModal() {
            document.getElementById('addRecursoModal').style.display = 'none';
        }

        function submitAddRecursoForm() {
            document.getElementById('addRecursoForm').submit();
        }

        // Modal para ver recurso
        function showViewRecursoModal(id, nombre, tipo, descripcion) {
            document.getElementById('viewRecursoId').textContent = id;
            document.getElementById('viewRecursoNombre').textContent = nombre;
            document.getElementById('viewRecursoTipo').textContent = tipo;
            document.getElementById('viewRecursoDescripcion').textContent = descripcion;
            document.getElementById('viewRecursoModal').style.display = 'flex';
        }

        function closeViewRecursoModal() {
            document.getElementById('viewRecursoModal').style.display = 'none';
        }

        // Modal para editar recurso
        function showEditRecursoModal(id, nombre, tipo, descripcion) {
            document.getElementById('edit_recurso_id').value = id;
            document.getElementById('edit_recurso_nombre').value = nombre;
            document.getElementById('edit_recurso_tipo').value = tipo;
            document.getElementById('edit_recurso_descripcion').value = descripcion;
            document.getElementById('editRecursoModal').style.display = 'flex';
        }

        function closeEditRecursoModal() {
            document.getElementById('editRecursoModal').style.display = 'none';
        }

        function submitEditRecursoForm() {
            document.getElementById('editRecursoForm').submit();
        }

        // Modal para eliminar recurso
        function showDeleteRecursoModal(id) {
            document.getElementById('deleteRecursoModal').style.display = 'flex';
            document.getElementById('confirmDeleteRecursoBtn').onclick = function() {
                window.location.href = 'index.php?eliminar_recurso&id=' + id;
            };
        }

        function closeDeleteRecursoModal() {
            document.getElementById('deleteRecursoModal').style.display = 'none';
        }

        // Cerrar los modales si se hace clic fuera de ellos
        window.onclick = function(event) {
            var confirmModal = document.getElementById('confirmModal');
            var deleteModal = document.getElementById('deleteModal');
            var viewModal = document.getElementById('viewModal');
            var editModal = document.getElementById('editModal');
            var addRecursoModal = document.getElementById('addRecursoModal');
            var viewRecursoModal = document.getElementById('viewRecursoModal');
            var editRecursoModal = document.getElementById('editRecursoModal');
            var deleteRecursoModal = document.getElementById('deleteRecursoModal');

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
            if (event.target == addRecursoModal) {
                addRecursoModal.style.display = 'none';
            }
            if (event.target == viewRecursoModal) {
                viewRecursoModal.style.display = 'none';
            }
            if (event.target == editRecursoModal) {
                editRecursoModal.style.display = 'none';
            }
            if (event.target == deleteRecursoModal) {
                deleteRecursoModal.style.display = 'none';
            }
        }
    </script>
</body>
</html>

<?php
// Desconectar
$conexion->desconectar();
?>