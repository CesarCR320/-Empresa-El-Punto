$(document).ready(function() { // Llama a la función cuando el DOM está listo
    $('#ticket-description').summernote({
        height: 200, // Establece el tamaño del editor
    });

    $('#ticket-description').summernote('code', ''); // Limpia el contenido del editor

    //$.post('../../controller/usuario.php?op=combo', function(data, status) {
        // Cargar las areas en el select
        //$('#usuario-select').html(data);
        // console.log(data);
    //});

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
