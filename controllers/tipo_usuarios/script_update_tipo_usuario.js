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




function saveTypeUserEdit() {

    var userID = sessionStorage.getItem('id_type_users');
    var name = $("#name").val().trim();
    var key = $("#key").val().trim();
    var details = $("#details").val().trim();

    if (name.length == 0) {
        alert("Tiene que escribir el nombre")
        $("#name").focus();
        return 0;
    }
    if (key.length == 0) {
        alert("Tiene que escribir la clave")
        $("#key").focus();
        return 0;
    }

    if (details.length == 0) {
        alert("Tiene que escribir los detalles")
        $("#details").focus();
        return 0;
    }



    if (name.length > 0 && key.length > 0 && details.length > 0) {
        $.ajax({
            url: "../../controllers/tipo_usuarios/controller_tipo_usuarios.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 4, id_type_users: userID, name: name, key: key, details: details},
            success: function (result) {

                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Tipo de Usuario Actualizado correctamente',
                    timer: 1000,
                    timerProgressBar: true,
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                    location.href = "../tipo_usuarios/tipo_usuarios.php";         

                    }
                });

            }, error: function (jqXHR, textStatus, errorThrown) {
    console.log("Error en Ajax:");
    console.log("Estado: " + textStatus);
    console.log("Error: " + errorThrown);
    console.log("Respuesta completa: ", jqXHR);

    Swal.fire({
        icon: 'error',
        title: 'Error al actualizar el tipo de usuario',
        html: `<b>Estado:</b> ${textStatus}<br><b>Error:</b> ${errorThrown}`,
        footer: 'Revisa consola para más detalles',
        timer: 10000,
        timerProgressBar: true,
    });
            }
        });
    } 
}