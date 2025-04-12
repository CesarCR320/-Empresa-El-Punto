<?php
require_once 'conexion_r.php';
session_start();

// Páginas válidas del sistema
$paginasValidas = ['ver_roles.php', 'agregar_rol.php', 'editar_rol.php', 'permisos_roles.php'];

// Determinar página a mostrar
$pagina = 'ver_roles.php';
if (isset($_GET['page']) && in_array(basename($_GET['page']), $paginasValidas)) {
    $pagina = basename($_GET['page']);
}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-users-cog"></i> Gestor de Roles</h1>
        
        <?php if (!empty($message)): ?>
            <div class="alert <?= isset($message['error']) ? 'error' : 'success' ?>">
                <i class="fas <?= isset($message['error']) ? 'fa-exclamation-circle' : 'fa-check-circle' ?>"></i>
                <?= $message['error'] ?? $message['success'] ?>
            </div>
        <?php endif; ?>
        
        <nav class="menu">
            <button class="btn primary" onclick="navegarA('ver_roles.php')">
                <i class="fas fa-list"></i> Ver Roles
            </button>
            <button class="btn success" onclick="navegarA('agregar_rol.php')">
                <i class="fas fa-plus"></i> Agregar Rol
            </button>
        </nav>
        
        <div id="contenido-dinamico">
            <?php include $pagina; ?>
        </div>
    </div>

    <script>
    // Función para navegar manteniendo la URL limpia
    function navegarA(pagina) {
        history.pushState(null, null, pagina);
        cargarContenido(pagina);
    }

    // Función para cargar contenido
    async function cargarContenido(url) {
        try {
            // Mostrar loader
            document.getElementById('contenido-dinamico').innerHTML = `
                <div class="loader">
                    <i class="fas fa-spinner fa-spin"></i> Cargando...
                </div>
            `;
            
            const response = await fetch(url);
            if (!response.ok) throw new Error('Error al cargar');
            const html = await response.text();
            
            document.getElementById('contenido-dinamico').innerHTML = html;
            asignarEventos();
        } catch (error) {
            console.error('Error:', error);
            window.location.href = 'index.php';
        }
    }

    // Manejar el botón de retroceso
    window.addEventListener('popstate', function(event) {
        const pagina = window.location.pathname.split('/').pop() || 'ver_roles.php';
        cargarContenido(pagina);
    });

    // Asignar eventos dinámicos
    function asignarEventos() {
        // Botones de formularios
        document.querySelectorAll('form').forEach(form => {
            form.onsubmit = async (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                
                try {
                    const response = await fetch('index.php', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const result = await response.json();
                    if (result.success) {
                        navegarA('ver_roles.php');
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            };
        });
        
        // Botones de acciones
        document.querySelectorAll('.editar-btn').forEach(btn => {
            btn.onclick = () => navegarA(`editar_rol.php?id=${btn.dataset.id}`);
        });
        
        document.querySelectorAll('.eliminar-btn').forEach(btn => {
            btn.onclick = () => confirmarEliminacion(btn.dataset.id);
        });
        
        document.querySelectorAll('.permisos-btn').forEach(btn => {
            btn.onclick = () => navegarA(`permisos_roles.php?id=${btn.dataset.id}`);
        });
    }

    // Función para eliminar roles
    async function confirmarEliminacion(id) {
        if (confirm('¿Estás seguro de eliminar este rol?')) {
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
                    navegarA('ver_roles.php');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    }

    // Inicializar eventos
    document.addEventListener('DOMContentLoaded', asignarEventos);
    </script>
</body>
</html>