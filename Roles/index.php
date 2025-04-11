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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Gestor de Roles</h1>
        
        <?php if (!empty($message)): ?>
            <div class="alert <?= isset($message['error']) ? 'error' : 'success' ?>">
                <?= $message['error'] ?? $message['success'] ?>
            </div>
        <?php endif; ?>
        
        <nav class="menu">
            <button onclick="cargarContenido('ver_roles.php')">Ver Roles</button>
            <button onclick="cargarContenido('agregar_rol.php')">Agregar Rol</button>
        </nav>
        
        <div id="contenido-dinamico">
            <?php include 'ver_roles.php'; ?>
        </div>
    </div>

    <script>
    async function cargarContenido(url) {
        try {
            const response = await fetch(url);
            const html = await response.text();
            document.getElementById('contenido-dinamico').innerHTML = html;
            asignarEventos();
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    function asignarEventos() {
        // Asignar eventos a formularios dinámicos
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
                        cargarContenido('ver_roles.php');
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            };
        });
        
        // Asignar eventos a botones de editar
        document.querySelectorAll('.editar-btn').forEach(btn => {
            btn.onclick = () => cargarContenido(`editar_rol.php?id=${btn.dataset.id}`);
        });
        
        // Asignar eventos a botones de eliminar
        document.querySelectorAll('.eliminar-btn').forEach(btn => {
            btn.onclick = () => confirmarEliminacion(btn.dataset.id);
        });
    }
    
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