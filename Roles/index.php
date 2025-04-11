<?php
require_once 'conexion_r.php';
session_start();

// Procesar acciones POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'agregar':
            require_once 'agregar_rol.php';
            agregarRol();
            break;
        case 'editar':
            require_once 'editar_rol.php';
            editarRol();
            break;
        case 'eliminar':
            require_once 'eliminar_rol.php';
            eliminarRol();
            break;
    }
    
    // Redirigir para evitar reenvío del formulario
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Mostrar mensajes
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Roles</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Gestor de Roles</h1>
        
        <?php if ($message): ?>
            <div class="alert <?= strpos($message, 'Error') !== false ? 'error' : 'success' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>
        
        <nav class="menu">
            <button onclick="loadContent('ver_roles.php')">Ver Roles</button>
            <button onclick="loadContent('agregar_rol.php')">Agregar Rol</button>
        </nav>
        
        <div id="content-container">
            <?php include 'ver_roles.php'; ?>
        </div>
    </div>

    <script>
    function loadContent(url) {
        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.getElementById('content-container').innerHTML = html;
                // Reasignar eventos después de cargar nuevo contenido
                assignEvents();
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('content-container').innerHTML = '<div class="error">Error al cargar el contenido</div>';
            });
    }
    
    function assignEvents() {
        // Asignar eventos a formularios
        document.querySelectorAll('form').forEach(form => {
            form.onsubmit = function(e) {
                e.preventDefault();
                submitForm(this);
            };
        });
        
        // Asignar eventos a botones de editar
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.onclick = function() {
                loadContent('editar_rol.php?id=' + this.dataset.id);
            };
        });
        
        // Asignar eventos a botones de eliminar
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.onclick = function() {
                if (confirm('¿Estás seguro de eliminar este rol?')) {
                    const formData = new FormData();
                    formData.append('action', 'eliminar');
                    formData.append('id', this.dataset.id);
                    
                    fetch('index.php', {
                        method: 'POST',
                        body: formData
                    }).then(() => loadContent('ver_roles.php'));
                }
            };
        });
    }
    
    function submitForm(form) {
        const formData = new FormData(form);
        
        fetch('index.php', {
            method: 'POST',
            body: formData
        }).then(() => loadContent('ver_roles.php'));
    }
    
    // Inicializar eventos al cargar la página
    document.addEventListener('DOMContentLoaded', assignEvents);
    </script>
</body>
</html>