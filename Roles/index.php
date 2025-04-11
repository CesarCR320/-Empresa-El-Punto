<?php
require_once 'conexion_r.php';
session_start();

// Procesar acciones POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $response = [];
    
    switch ($action) {
        case 'agregar':
            require_once 'agregar_rol.php';
            $response = agregarRol();
            break;
        case 'editar':
            require_once 'editar_rol.php';
            $response = editarRol();
            break;
        case 'eliminar':
            require_once 'eliminar_rol.php';
            $response = eliminarRol();
            break;
        case 'update_permissions':
            require_once 'permisos_roles.php';
            $response = actualizarPermisos();
            break;
    }
    
    if (!empty($response)) {
        $_SESSION['message'] = $response;
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit();
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Roles</h1>
        
        <?php if (!empty($message)): ?>
            <div class="alert <?= isset($message['error']) ? 'error' : 'success' ?>">
                <?= $message['error'] ?? $message['success'] ?>
            </div>
        <?php endif; ?>
        
        <nav class="menu">
            <button id="ver-roles-btn" class="btn primary">
                <i class="fas fa-list"></i> Ver Roles
            </button>
            <button id="agregar-rol-btn" class="btn success">
                <i class="fas fa-plus"></i> Agregar Rol
            </button>
        </nav>
        
        <div id="content-container">
            <?php include 'ver_roles.php'; ?>
        </div>
    </div>

    <script>
    // Función para cargar contenido dinámico
    async function loadContent(url) {
        try {
            // Mostrar loader
            document.getElementById('content-container').innerHTML = `
                <div class="loader">
                    <i class="fas fa-spinner fa-spin"></i> Cargando...
                </div>`;
            
            const response = await fetch(url);
            if (!response.ok) throw new Error('Error al cargar');
            
            const html = await response.text();
            document.getElementById('content-container').innerHTML = html;
            assignEvents();
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('content-container').innerHTML = `
                <div class="error">
                    <i class="fas fa-exclamation-triangle"></i> Error al cargar el contenido.
                    <button onclick="loadContent('ver_roles.php')" class="btn small">
                        <i class="fas fa-sync-alt"></i> Reintentar
                    </button>
                </div>`;
        }
    }

    // Función para asignar eventos
    function assignEvents() {
        // Botón Ver Roles
        document.getElementById('ver-roles-btn')?.addEventListener('click', () => {
            loadContent('ver_roles.php');
        });
        
        // Botón Agregar Rol
        document.getElementById('agregar-rol-btn')?.addEventListener('click', () => {
            loadContent('agregar_rol.php');
        });
        
        // Botones de acciones en la tabla
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                loadContent(`editar_rol.php?id=${btn.dataset.id}`);
            });
        });
        
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                if (confirm(`¿Estás seguro de eliminar el rol "${btn.dataset.nombre}"?`)) {
                    const formData = new FormData();
                    formData.append('action', 'eliminar');
                    formData.append('id', btn.dataset.id);
                    
                    fetch('index.php', {
                        method: 'POST',
                        body: formData
                    }).then(() => loadContent('ver_roles.php'));
                }
            });
        });
        
        document.querySelectorAll('.permissions-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                loadContent(`permisos_roles.php?id=${btn.dataset.id}`);
            });
        });
        
        // Manejo de formularios
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                
                try {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
                    
                    const formData = new FormData(form);
                    const response = await fetch('index.php', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const result = await response.json();
                    if (result.success) {
                        loadContent('ver_roles.php');
                    }
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            });
        });
    }

    // Inicializar eventos al cargar la página
    document.addEventListener('DOMContentLoaded', assignEvents);
    </script>
</body>
</html>