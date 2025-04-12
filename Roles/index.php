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

// Mostrar mensajes almacenados en sesión
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Roles</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos adicionales para el layout principal */
        .main-container {
            max-width: 1400px;
            margin: 20px auto;
            padding: 0 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 28px;
        }
        .header-actions {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="header">
            <h1><i class="fas fa-users-cog"></i> Gestión de Roles y Permisos</h1>
            <div class="header-actions">
                <button class="btn primary" onclick="cargarContenido('ver_roles.php')">
                    <i class="fas fa-list"></i> Ver Roles
                </button>
                <button class="btn success" onclick="cargarContenido('agregar_rol.php')">
                    <i class="fas fa-plus"></i> Nuevo Rol
                </button>
            </div>
        </div>
        
        <?php if (!empty($message)): ?>
            <div class="alert <?= isset($message['error']) ? 'error' : 'success' ?>">
                <i class="fas <?= isset($message['error']) ? 'fa-exclamation-circle' : 'fa-check-circle' ?>"></i>
                <?= $message['error'] ?? $message['success'] ?>
            </div>
        <?php endif; ?>
        
        <div id="contenido-dinamico">
            <?php include 'ver_roles.php'; ?>
        </div>
    </div>

    <script>
    // Función mejorada para cargar contenido dinámico
    async function cargarContenido(url) {
        try {
            // Mostrar loader
            document.getElementById('contenido-dinamico').innerHTML = `
                <div class="loader">
                    <i class="fas fa-spinner fa-spin"></i> Cargando...
                </div>
            `;
            
            const response = await fetch(url);
            if (!response.ok) throw new Error('Error en la respuesta');
            
            const html = await response.text();
            document.getElementById('contenido-dinamico').innerHTML = html;
            
            // Actualizar la URL en el navegador
            history.pushState(null, null, url);
            
            asignarEventos();
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('contenido-dinamico').innerHTML = `
                <div class="error">
                    <i class="fas fa-exclamation-triangle"></i> Error al cargar el contenido: ${error.message}
                </div>
            `;
        }
    }
    
    // Manejar el botón de retroceso del navegador
    window.addEventListener('popstate', function() {
        const url = window.location.pathname.split('/').pop() || 'ver_roles.php';
        cargarContenido(url);
    });
    
    // Asignar eventos a elementos dinámicos
    function asignarEventos() {
        // Manejo de formularios
        document.querySelectorAll('form').forEach(form => {
            form.onsubmit = async (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                const submitBtn = form.querySelector('button[type="submit"]');
                
                try {
                    // Mostrar estado de carga
                    if (submitBtn) {
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
                        submitBtn.disabled = true;
                    }
                    
                    const response = await fetch('index.php', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const result = await response.json();
                    if (result.success) {
                        cargarContenido('ver_roles.php');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    if (submitBtn) {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                }
            };
        });
        
        // Asignar eventos a botones de acciones
        document.querySelectorAll('.editar-btn').forEach(btn => {
            btn.onclick = () => cargarContenido(`editar_rol.php?id=${btn.dataset.id}`);
        });
        
        document.querySelectorAll('.eliminar-btn').forEach(btn => {
            btn.onclick = () => confirmarEliminacion(btn.dataset.id);
        });
        
        document.querySelectorAll('.permisos-btn').forEach(btn => {
            btn.onclick = () => cargarContenido(`permisos_roles.php?id=${btn.dataset.id}`);
        });
    }
    
    // Confirmar eliminación de rol
    async function confirmarEliminacion(id) {
        if (confirm('¿Estás seguro de eliminar este rol? Esta acción no se puede deshacer.')) {
            const formData = new FormData();
            formData.append('action', 'eliminar');
            formData.append('id', id);
            
            try {
                const response = await fetch('index.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                if (result.success) {
                    cargarContenido('ver_roles.php');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    }
    
    // Inicializar eventos al cargar la página
    document.addEventListener('DOMContentLoaded', asignarEventos);
    </script>
</body>
</html>