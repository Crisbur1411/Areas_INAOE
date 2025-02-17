
/*
Desarrollado por Julian 
El 29/03/2024
Funcionalidad Eliminar Area de forma Logica
*/

function deleteArea(element) {
    var id_area = $(element).data('id-area');
    var key = $(element).data('key');


    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el área. ¿Estás seguro de continuar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../../controllers/areas/controller_areas.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 3, identificador_area: key },
                success: function(result) {
                    if (result.status == 200) {
                        listAreas();
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Área eliminada correctamente'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al eliminar el área'
                        });
                    }

                },
                error: function (result) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al realizar la solicitud'
                    });
                }
            });
        }
    });
}