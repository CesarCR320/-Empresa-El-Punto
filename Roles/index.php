<?php
require_once 'conexion_r.php';
session_start();

// Procesar acciones POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once procesarAccion($_POST['action'] ?? '');
}

function procesarAccion($action) {
    switch ($action) {
        case 'agregar':
            require_once 'agregar_rol.php';
            return agregarRol();
        case 'editar':
            require_once 'editar_rol.php';
            return editarRol();
        case 'eliminar':
            require_once 'eliminar_rol.php';
            return eliminarRol();
        default:
            return ['error' => 'Acción no válida'];
    }
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
        
        <nav class="menu">
            <button onclick="cargarContenido('ver_roles.php')">Ver Roles</button>
            <button onclick="cargarContenido('agregar_rol.php')">Agregar Rol</button>
        </nav>
        
        <div id="contenido-dinamico">
            <!-- Aquí se carga el contenido -->
            <?php include 'ver_roles.php'; ?>
        </div>
    </div>

    <script>
    function cargarContenido(url) {
        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.getElementById('contenido-dinamico').innerHTML = html;
                // Reasignar eventos después de cargar nuevo contenido
                asignarEventos();
            });
    }
    
    function asignarEventos() {
        // Asignar eventos a los elementos dinámicos
        document.querySelectorAll('.editar-btn').forEach(btn => {
            btn.onclick = () => cargarContenido(`editar_rol.php?id=${btn.dataset.id}`);
        });
        
        document.querySelectorAll('.eliminar-btn').forEach(btn => {
            btn.onclick = () => confirmarEliminacion(btn.dataset.id);
        });
    }
    
    function confirmarEliminacion(id) {
        if (confirm('¿Estás seguro de eliminar este rol?')) {
            const formData = new FormData();
            formData.append('action', 'eliminar');
            formData.append('id', id);
            
            fetch('index.php', {
                method: 'POST',
                body: formData
            }).then(() => cargarContenido('ver_roles.php'));
        }
    }
    
    // Asignar eventos iniciales
    document.addEventListener('DOMContentLoaded', asignarEventos);
    </script>
</body>
</html>