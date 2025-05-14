
function preCargarDatos() {
    var userID = sessionStorage.getItem('id_usuario');

    var formData = new FormData();
    formData.append('action', 6);
    formData.append('id_usuario', userID);
        console.log("ID de usuario obtenido:", userID);  // Se muestra el ID en la consola


    $.ajax({
        url: "../../controllers/usuarios/controller_usuarios.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        success: function (result) {
            if (result.status == 200) {
                var userData = result.data;
                typeUsers(userData.fk_type);
                $('#name').val(userData.name);
                $('#surname').val(userData.surname);
                $('#second_surname').val(userData.second_surname);
                $('#email').val(userData.email);
                $('#type-users').val(userData.fk_type);
                $('#areas').val(userData.fk_area);
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
    areas();
    typeUsers();
    preCargarDatos();

});





function saveUserEdit() {

    var program = $("#program").val();
    var userID = sessionStorage.getItem('id_usuario');
    var name = $("#name").val().trim();
    var surname = $("#surname").val().trim();
    var secondsurname = $("#second_surname").val().trim();
    var email = $("#email").val().trim();


    var area = $("#areas").val()
    var type_user = $("#type-users").val();

    if (name.length == 0) {
        alert("Tiene que escribir el nombre")
        $("#name").focus();
        return 0;
    }
    if (surname.length == 0) {
        alert("Tiene que escribir el apellido")
        $("#surname").focus();
        return 0;
    }

    if (email.length == 0) {
        alert("Tiene que escribir el correo electrónico")
        $("#email").focus();
        return 0;
    }


    if (area == null) {
        alert("Tiene que elegir el área")
        $("#areas").focus();
        return 0;
    }
    if (type_user == null) {
        alert("Tiene que elegir el tipo de usuario")
        $("#type-users").focus();
        return 0;
    }




    var expEmail = /^[A-Za-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
    var validEmail = expEmail.test(email);


    if (validEmail == true) {
        $.ajax({
            url: "../../controllers/usuarios/controller_registro_usuarios.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 5, user_id: userID, area: area, name: name, surname: surname, secondsurname: secondsurname, email: email, type_user: type_user },
            success: function (result) {

                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Usuario Actualziado correctamente',
                    timer: 1000,
                    timerProgressBar: true,
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        history.go(-1);

                    }
                });

            }, error: function (jqXHR, textStatus, errorThrown) {
    console.log("Error en Ajax:");
    console.log("Estado: " + textStatus);
    console.log("Error: " + errorThrown);
    console.log("Respuesta completa: ", jqXHR);

    Swal.fire({
        icon: 'error',
        title: 'Error al actualizar usuario',
        html: `<b>Estado:</b> ${textStatus}<br><b>Error:</b> ${errorThrown}`,
        footer: 'Revisa consola para más detalles',
        timer: 10000,
        timerProgressBar: true,
    });
            }
        });
    } else
        bootbox.confirm({
            title: "<h4>Error al registrar usuario</h4>",
            message: "<h5>Favor de verificar que el correo sea válido.</h5>",
            buttons: {
                cancel: {
                    label: 'Cancelar',
                    className: 'btn-secondary'
                },
                confirm: {
                    label: 'Aceptar',
                    className: 'btn-success'
                }
            },
            closeButton: false,
            callback: function (result) {
                if (result == false) {
                    history.go(-1);
                }
            }
        });
}


function changePassword() {
    var userID = sessionStorage.getItem('id_usuario');

    var formHtml = `
        <form id="newAreaForm">
            <div class="form-group">
                <label for="nombreArea">Nueva Contraseña:</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
            </div>
            <div class="form-group">
                <label for="detalles">Confirmar Nueva Contraseña</label>
                <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" required>
            </div>
            <div class="form-group">
      
        </form>
    `;

    bootbox.dialog({
        title: "<h4>Nueva Área</h4>",
        message: formHtml,
        closeButton: true,
        buttons: {
            cancel: {
                label: 'Cancelar',
                className: 'btn-secondary'
            },
            confirm: {
                label: 'Guardar',
                className: 'btn-primary',
                callback: function () {
                    var newPassword = $('#newPassword').val().trim();
                    var confirmNewPassword = $('#confirmNewPassword').val().trim();
                    var formData = new FormData();
                    formData.append('action', 7);
                    formData.append('id_usuario', userID);
                    formData.append('new_passsword', newPassword);

                    if (!(newPassword == confirmNewPassword)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Todos los campos son obligatorios. Por favor, complete todos los campos.'
                        });
                        return false;
                    }

                    $.ajax({
                        url: "../../controllers/usuarios/controller_usuarios.php",
                        cache: false,
                        dataType: 'JSON',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function (result) {
                            console.log(result);
                            if (result.status === 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: 'La solicitud se ha completado correctamente'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Ocurrió un error al realizar la solicitud'
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
            }
        }
    });


}


