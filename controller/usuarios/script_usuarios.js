var answer_save = [];
var loader = $(".loader");
var document_id;


(function($) {
    $.fn.inputFilter = function(inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
        if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart; 
            this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
            this.value = ""; 
        }
        });
    };
}(jQuery));


$(function(){
    $(".loader").fadeOut("slow");
    $("#info").removeClass("d-none");
    listUser();        
});



function validatePasswordRules(password) {
    const minLength = /.{8,}/;
    const upper = /[A-Z]/;
    const lower = /[a-z]/;
    const number = /[0-9]/;

    return minLength.test(password) &&
           upper.test(password) &&
           lower.test(password) &&
           number.test(password);
}


function listUser() {
  $.ajax({
        url: "../../controller/usuarios/controller_usuarios.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 1 },
        success: function(result) { 
            let i1 = 0; // <-- Reinicia el contador aquí           
            var table = "";
            $.each(result, function(index, val) {
                if (val.status == 1)
                {
                i1++; // Solo incrementa aquí
                let category = (val.user_category === null || val.user_category === "" || val.user_category === undefined) ? "No Asignado" : val.user_category;
                table += "<tr>"       
                + "<th style='text-align:center'>"+val.id_user+"</th>"
                + "<th style='text-align:center'>"+val.full_name+"</a></th>"
                + "<th style='text-align:center'>"+val.area_name+"</th>" 
                + "<th style='text-align:center'>"+val.type_name+"</th>"
                + "<th style='text-align:center'>"+category+"</th>"
                + "<th style='text-align:center'>"+val.date+"</th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='vistaUpdateUsuario("+val.id_user+")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' id='btn-details' id-user='"+val.id_user+"' title='Click para eliminar' onclick='deleteUser("+val.id_user+")'>"+'<i class="fas fa-trash"></i>'+"</button></th>"
                + "</tr>";
                }
            });
            $('#pf').text(i1); // <-- Actualiza el contador aquí
            if(i1 != 0){
                $('#table-users').html(table);
                $('#alert1').hide();
            }
        }, error: function (result){
            //console.log(result); 
        }
    }); 
}

//  desarrollado por BRYAM el 29/03/2024 esta función hace una petición ajax al controlador para obtener los datos del usuario

$(function() {
    var id_user = $("#user_id").data("id");
    getUserInfo(id_user);

    $('#modalEdit').on('hidden.bs.modal', function (e) {
        $(this).find('input[type="password"]').val('');
    });
        
});

function getUserInfo(id_user) {
    $.ajax({
        url: "../../controller/usuarios/controller_usuarios.php",
        method: "POST",
        dataType: "JSON",
        data: { action: 2, id_user: id_user },
        success: function(result) {
            $("#full_name").text(result.full_name);
            $("#area").text(result.area_name);
            $("#userNme").text(result.type_name);
            $("#fechaRegistro").text(result.date);
            $("#correo").text(result.username);
        },
        error: function(xhr, status, error) {
            console.error("Error al obtener datos del usuario:", status, error);
            console.log("Respuesta del servidor:", xhr.responseText);
        }
        
    });
}


// desarrollado por BRYAM el 01/04/2024 esta función hace que el modal se muestre al precionar el botón de editar, también una función para que se agregue un correo valido

function showModal() {
    $('#modalEdit').modal('show');
}


// desarrollado por BRYAM el 02/04/2024 esta función hace 2 cosas primero validad que las contraseñas muevas coincidad y luego verifica la contraseña de la session actual para autorizar el cambio

function saveChanges(id_user) {
    var currentPassword = $('#currentPassword').val();
    var newPassword = $('#newPassword').val();
    var confirmPassword = $('#confirmPassword').val();

    // Validar coincidencia
    if (newPassword !== confirmPassword) {
        alert('Las contraseñas nuevas no coinciden.');
        return;
    }

    // Validar reglas de la contraseña
    if (!validatePasswordRules(newPassword)) {
        alert('La contraseña debe tener:\n\n' +
            '- Mínimo 8 caracteres\n' +
            '- Al menos una letra mayúscula\n' +
            '- Al menos una letra minúscula\n' +
            '- Al menos un número');
        return;
    }

    // Si pasa validación → enviar petición
    $.ajax({
        url: '../../controller/usuarios/controller_usuarios.php',
        method: 'POST',
        dataType: "JSON",
        data: { 
            action: 3, 
            id_user: id_user, 
            currentPassword: currentPassword, 
            newPassword: newPassword 
        },
        success: function(response) {
            if (response.success) { 
                alert('Actualizado con éxito');
                $('#modalEdit').modal('hide');
            } else {
                alert(response.msg ?? 'Error al actualizar la contraseña.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al modificar la contraseña:', status, error);
        }
    });
}



function deleteUser( key) {
    console.log(key)
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el usuario. ¿Estás seguro de continuar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../../controller/usuarios/controller_usuarios.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 5, identificador_usuario: key },
                success: function(result) {
                    console.log(result)
                    if (result.status == "success") {

                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Usuario eliminado correctamente',
                            timer: 500,
                            timerProgressBar: true,
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                location.reload();

                            }
                          });
                        

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al eliminar al Usuario'
                        });
                    }

                },
                error: function (result) {
                    console.log(result); 
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




function preCargarDatos() {
    var userID = sessionStorage.getItem('id_usuario');

    var formData = new FormData();
    formData.append('action', 6);
    formData.append('id_usuario', userID);
        console.log("ID de usuario obtenido:", userID);  // Se muestra el ID en la consola


    $.ajax({
        url: "../../controller/usuarios/controller_usuarios.php",
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
                $('#category').val(userData.user_category);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al editar el usuario'
                });
            }
        },
        error: function (xhr, status, error) {
    console.error("❌ Error al realizar la solicitud:");
    console.error("📄 Estado de la petición: " + status);
    console.error("⚠️ Error devuelto por el servidor: " + error);

    let mensajeError = "";

    if (xhr.status === 0) {
        mensajeError = "No se pudo conectar con el servidor. Verifica tu conexión de red.";
    } else if (xhr.status >= 400 && xhr.status < 500) {
        mensajeError = "Error en la solicitud (Código " + xhr.status + "). Verifica los datos enviados.";
    } else if (xhr.status >= 500) {
        mensajeError = "Error en el servidor (Código " + xhr.status + "). Intenta más tarde o contacta al administrador.";
    } else {
        mensajeError = "Error desconocido (Código " + xhr.status + ").";
    }

    // Mostrar respuesta devuelta por el servidor si existe
    if (xhr.responseText) {
        console.log("📨 Respuesta recibida del servidor:", xhr.responseText);
    }

    // Mostrar alerta bonita con SweetAlert
    Swal.fire({
        icon: 'error',
        title: 'Error',
        html: mensajeError,
        footer: (xhr.responseText) ? "<pre style='text-align:left; max-height:150px; overflow:auto;'>" + xhr.responseText + "</pre>" : null
    });
}
    });
}




function changePassword() {
    var userID = sessionStorage.getItem('id_usuario');

    var formHtml = `
        <form id="newAreaForm">
            <div class="form-group">
                <label>Nueva Contraseña:</label>
                <input type="password" class="form-control" id="newPassword" required>
            </div>
            <div class="form-group">
                <label>Confirmar Nueva Contraseña</label>
                <input type="password" class="form-control" id="confirmNewPassword" required>
            </div>
        </form>
    `;

    bootbox.dialog({
        title: "<h4>Cambiar Contraseña</h4>",
        message: formHtml,
        closeButton: true,
        buttons: {
            cancel: {
                label: 'Cancelar',
                className: 'btnCancel'
            },
            confirm: {
                label: 'Guardar',
                className: 'btnConfirm',
                callback: function () {

                    var newPassword = $('#newPassword').val().trim();
                    var confirmNewPassword = $('#confirmNewPassword').val().trim();

                    // Validar que coincidan
                    if (newPassword !== confirmNewPassword) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Las contraseñas no coinciden.'
                        });
                        return false;
                    }

                    // Validar reglas de contraseña
                    if (!validatePasswordRules(newPassword)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Contraseña inválida',
                            html: `
                                La contraseña debe cumplir con:
                                <br><br>
                                • Mínimo <b>8 caracteres</b><br>
                                • Al menos <b>una letra mayúscula</b><br>
                                • Al menos <b>una letra minúscula</b><br>
                                • Al menos <b>un número</b>
                            `
                        });
                        return false;
                    }

                    // Si pasa todo, enviamos la solicitud
                    var formData = new FormData();
                    formData.append('action', 7);
                    formData.append('id_usuario', userID);
                    formData.append('new_passsword', newPassword);

                    $.ajax({
                        url: "../../controller/usuarios/controller_usuarios.php",
                        cache: false,
                        dataType: 'JSON',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function (result) {
                            if (result.status === 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: 'Contraseña actualizada correctamente'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Ocurrió un error al actualizar la contraseña'
                                });
                            }
                        },
                        error: function () {
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




function areas() {


    $(".loader").fadeOut("slow");
    $.ajax({
        url: "../../controller/usuarios/controller_usuarios.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 8 },
        success: function (result) {

            var addArea = "<option value='null' selected disabled>Seleccione una área</option>";
            $.each(result, function (index, val) {
                addArea += "<option value='" + val.id_area + "'>" + val.name + "</option>";
            });
            $("#areas").html(addArea);
        }, error: function (result) {
            console.log(result);
        }
    });
}




function typeUsers(fk_type) {

    $(".loader").fadeOut("slow");
    $.ajax({
        url: "../../controller/usuarios/controller_usuarios.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 9 },
        success: function (result) {
            var addType = "<option value='null' selected disabled>Seleccione un tipo</option>";
            $.each(result, function (index, val) {
               
                addType += "<option value='" + val.id_type_users + "'>" + val.name + "</option>";
            });
            $("#type-users").html(addType);

            if(fk_type){
                $('#type-users').val(fk_type);
            }

          
        },
        error: function (result) {
            console.log(result);
        }
    });
}




function saveUser() {

    var program = $("#program").val();


    var name = $("#name").val().trim();
    var surname = $("#surname").val().trim();
    var secondsurname = $("#second_surname").val().trim();
    var email = $("#email").val().trim();

    var password = $("#password").val().trim();

    var area = $("#areas").val()
    var type_user = $("#type-users").val();
    var category = $("#category").val();


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
    if (secondsurname.length == 0) {
        alert("Tiene que escribir el segundo apellido")
        $("#second_surname").focus();
        return 0;
    }
  
    if (email.length == 0) {
        alert("Tiene que escribir el correo electrónico")
        $("#email").focus();
        return 0;
    }

    if (password.length == 0) {
        alert("Tiene que escribir la contraseña")
        $("#password").focus();
        return 0;
    }

    if (!validatePasswordRules(password)) {
        alert("La contraseña debe tener:\n\n• Al menos 8 caracteres\n• Una letra mayúscula\n• Una letra minúscula\n• Un número");
        $("#password").focus();
        return;
    }
    
    if (type_user == null) {
        alert("Tiene que elegir el tipo de usuario")
        $("#type-users").focus();
        return 0;
    }

    if (category == null) {
        alert("Tiene que elegir la categoría")
        $("#category").focus();
        return 0;
    }

    if (area == null) {
        alert("Tiene que elegir el área")
        $("#areas").focus();
        return 0;
    }


 

    var expEmail = /^[A-Za-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
    var validEmail = expEmail.test(email);


    if (validEmail == true) {
        $.ajax({
            url: "../../controller/usuarios/controller_usuarios.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 10, name: name, surname: surname, secondsurname: secondsurname, email: email, type_user: type_user, password: password, category: category },
            success: function (result) {
                console.log("el resultado es" + result);
                var $id_user = result;
                userArea($id_user, area);
                window.location.href = "../usuarios/usuarios.php";
            }, error: function (result) {
                console.log(result);
                bootbox.confirm({
                    title: "<h4>Error al registrar usuario</h4>",
                    message: "<h5>Ocurrio un error al hacer el registro del usuario, verifique que el correo no este registrado.</h5>",
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
                            window.location.href = "../usuarios/usuarios.php";
                        }
                    }
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
                    window.location.href = "../usuarios/usuarios.php";
                }
            }
        });
}




function userArea(id_user, $area) {
    $.ajax({
        url: "../../controller/usuarios/controller_usuarios.php",
        cache: false,
        dataType: 'JSON', 
        type: 'POST',
        data: { action: 11, id_user: id_user, area: $area },
        success: function (result) {
            history.go(-1);
        }, error: function (result) {
            console.log(result);
            bootbox.confirm({
                title: "<h4>Error al registrar el área</h4>",
                message: "<h5>Ocurrio un error al hacer el registro del usuario con el área.</h5>",
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
    });
}






function saveUserEdit() {

    var program = $("#program").val();
    var userID = sessionStorage.getItem('id_usuario');
    var name = $("#name").val().trim();
    var surname = $("#surname").val().trim();
    var secondsurname = $("#second_surname").val().trim();
    var email = $("#email").val().trim();
    var category = $("#category").val();


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
    if (category.length == 0) {
        alert("Tiene que elegir la categoría")
        $("#category").focus();
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
            url: "../../controller/usuarios/controller_usuarios.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 12, user_id: userID, area: area, name: name, surname: surname, secondsurname: secondsurname, email: email, type_user: type_user, category: category },
            success: function (result) {

                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Usuario Actualizado correctamente',
                    timer: 500,
                    timerProgressBar: true,
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.href = "../usuarios/usuarios.php";

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
        html: `<b>Verifique que el correo sea válido o que no exista el mismo correo registrado con otro usuario</b>`,
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






document.addEventListener('DOMContentLoaded', function () {
    let id = new URLSearchParams(window.location.search).get('dc');
    if(id){ // Solo si existe el id en la URL
areas();
    typeUsers();
    preCargarDatos();    }
});





function cancel() {
    window.history.back();
}


function newUser() {
    location.href = "../usuarios/registro_usuarios.php";
}

function checkFileExist(urlToFile) {
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD', urlToFile, false);
    xhr.send();
     
    if (xhr.status == "404") {
        return false;
    } else {
        return true; 
    }
}


function vistaUpdateUsuario(id_usuario) {
    sessionStorage.setItem("id_usuario", id_usuario)
    location.href = "../usuarios/editar_usuario.php?dc=" + id_usuario;
}



// cargar los datos de la tabla
$(document).ready(function(){
    listUser();
});


$("#exit").click(function() {
    //loader.fadeIn();
    $(".loader").fadeOut("slow");

    setTimeout(function() {
        location.href = "../../index.php";
    }, 1000);
});
    
