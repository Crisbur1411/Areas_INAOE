function preCargarDatosTypeuser() {
    var userID = sessionStorage.getItem('id_type_users');
if(!userID){
  Swal.fire({
    icon: 'error',
    title: 'Sin selección',
    text: 'No se ha seleccionado un usuario para editar'
  });
  return;
}
    var formData = new FormData();
    formData.append('action', 3);
    formData.append('id_type_users', userID);

    $.ajax({
        url: "../../controllers/tipo_usuarios/controller_tipo_usuarios.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        success: function (result) {
            if (result.status == 200) {
                var userData = result.data;
                $('#name').val(userData.name);
                $('#key').val(userData.key);
                $('#details').val(userData.details);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al editar el área'
                });
            }
        },
        error: function (result) {
            console.log("Hubo un error al realizar la solicitud");

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al realizar la solicitud'
            });
        }
    });
}

document.addEventListener('DOMContentLoaded', function () { 

    preCargarDatosTypeuser();

});