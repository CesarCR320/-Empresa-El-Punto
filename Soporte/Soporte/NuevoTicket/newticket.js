function init() {
    // Inicializa el formulario
    $('#ticket-form').on('submit', function(e) {
        guardaryeditar(e); // Llama a la función para guardar o editar el ticket
    });

}

$(document).ready(function() { // Llama a la función cuando el DOM está listo
    $('#ticket-description').summernote({
        height: 200, // Establece el tamaño del editor
    });

    $('#ticket-description').summernote('code', ''); // Limpia el contenido del editor

    $.post('../../controller/area.php?op=combo', function(data, status) {
        // Cargar las areas en el select
        $('#area-id').html(data);
        // console.log(data);
    });

    $.post('../../controller/categoria.php?op=combo', function(data, status) {
        // Cargar las categorías en el select
        $('#ticket-category').html(data);
        // console.log(data);
    });

    $('#ticket-category').change(function() {
        // Obtener el valor seleccionado
        cat_id = $(this).val();

        // Llamar a la función para cargar los subcategorías
        $.post('../../controller/subcategoria.php?op=combo', {cat_id : cat_id}, function(data, status) {
            // console.log(data);
            
            // Cargar los subcategorías en el select
            $('#subcategory').html(data);
        });
    });

});

function guardaryeditar(e) {
    e.preventDefault(); // Evita el envío del formulario por defecto

    var formData = new FormData($("#ticket-form")[0]);

    $.ajax({
        url: "../../controller/ticket.php?op=insert",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response); // Verifica la respuesta del servidor
        /*     if (response == 'ok') {
                alert('Ticket creado exitosamente.');
                window.location.href = '../Tickets/tickets.php'; // Redirigir a la página de tickets
            } else {
                alert('Error al crear el ticket: ' + response);
            }
        },
        error: function(xhr, status, error) {
            alert('Error en la solicitud: ' + error);*/
        }
    });
}

init();