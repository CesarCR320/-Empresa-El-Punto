<?php // Funciones generales del sitio y header
    require 'includes/funciones.php';
    incluirTemplate('header');
?>
    
    <main class="contenedor seccion">
        <h1>Selecciona la opción que requieres</h1>

        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
                <h3>FAQ</h3>
                <p>Revisa la sección de preguntas frecuentes para verificar si tu duda o problema ya ha sido resuelto.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono Precio" loading="lazy">
                <h3>Nuevo Ticket</h3>
                <p>Crea un nuevo ticket de soporte en caso de no encontrar solución a tu problema en la seccion de preguntas frecuentes.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono Tiempo" loading="lazy">
                <h3>Seguimiento</h3>
                <p>Dale seguimiento a un ticket existente para estar al tanto de los cambios y actualizaciones.</p>
            </div>
        </div>
    </main>

<?php
    incluirTemplate('footer');
?>
