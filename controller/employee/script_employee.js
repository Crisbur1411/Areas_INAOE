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

$(function() {
    $(".loader").fadeOut("slow");
    $("#info").removeClass("d-none");
    listEmployee();
});

function listEmployee() {
  $.ajax({
        url: "../../controller/employee/controller_employee.php",
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
                table += "<tr>"       
                + "<th style='text-align:center'>"+val.id_employee+"</th>"
                + "<th style='text-align:center'>"+val.full_name+"</a></th>"
                + "<th style='text-align:center'>"+val.area+"</th>"
                + "<th style='text-align:center'>"+val.type_name+"</th>"
                + "<th style='text-align:center'>"+val.email+"</th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='vistaUpdateEmployee("+val.id_employee+")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' id='btn-details' id-employee='"+val.id_employee+"' title='Click para eliminar' onclick='deleteEmployee("+val.id_employee+")'>"+'<i class="fas fa-trash"></i>'+"</button></th>"
                + "</tr>";
                }
            });
            $('#pf').text(i1); // <-- Actualiza el contador aquí
            if(i1 != 0){
                $('#table-employees').html(table);
                $('#alert1').hide();
            }
        }, error: function (result){
            //console.log(result); 
        }
    }); 
}




function saveEmployee() {



    var name = $("#name").val().trim();
    var surname = $("#surname").val().trim();
    var secondsurname = $("#second_surname").val().trim();
    var email = $("#email").val().trim();

    var password = $("#password").val().trim();

    var area = $("#areas").val().trim();


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
    

    if (area.length == 0) {
        alert("Tiene que elegir el área")
        $("#areas").focus();
        return 0;
    }


 

    var expEmail = /^[A-Za-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
    var validEmail = expEmail.test(email);


    if (validEmail == true) {
        $.ajax({
            url: "../../controller/employee/controller_employee.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 2, name: name, surname: surname, secondsurname: secondsurname, email: email, password: password, area: area },
            success: function (result) {
                    window.location.href = "../employee/employee.php";
                }, error: function (result) {
                console.log(result);
                bootbox.confirm({
                    title: "<h4>Error al registrar empleado</h4>",
                    message: "<h5>Ocurrio un error al hacer el registro del empleado. Revisa que el correo electrónico no se encuentre registrado.</h5>",
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
                            window.location.href = "../employee/employee.php";
                        }
                    }
                });
            }
        });
    } else
        bootbox.confirm({
            title: "<h4>Error al registrar empleado</h4>",
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
                    window.location.href = "../employee/employee.php";
                }
            }
        });
}




function preCargarDatos() {
    var employeeID = sessionStorage.getItem('id_employee');

    var formData = new FormData();
    formData.append('action', 3);
    formData.append('id_employee', employeeID);
    $.ajax({
        url: "../../controller/employee/controller_employee.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        success: function (result) {
            if (result.status == 200) {
                var employeeData = result.data;
                $('#name').val(employeeData.name);
                $('#surname').val(employeeData.surname);
                $('#second_surname').val(employeeData.second_surname);
                $('#email').val(employeeData.email);
                $('#areas').val(employeeData.area);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al editar el área'
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





function saveEmployeeEdit() {

    var employeeID = sessionStorage.getItem('id_employee');
    var name = $("#name").val().trim();
    var surname = $("#surname").val().trim();
    var secondsurname = $("#second_surname").val().trim();
    var email = $("#email").val().trim();
    var area = $("#areas").val().trim();

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


    if (area.length == 0) {
        alert("Tiene que elegir el área")
        $("#areas").focus();
        return 0;
    }




    var expEmail = /^[A-Za-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
    var validEmail = expEmail.test(email);


    if (validEmail == true) {
        $.ajax({
            url: "../../controller/employee/controller_employee.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 4, employee_id: employeeID, area: area, name: name, surname: surname, secondsurname: secondsurname, email: email},
            success: function (result) {

                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Empleado Actualizado correctamente',
                    timer: 500,
                    timerProgressBar: true,
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.href = "../employee/employee.php";

                    }
                });

            }, error: function (jqXHR, textStatus, errorThrown) {
    console.log("Error en Ajax:");
    console.log("Estado: " + textStatus);
    console.log("Error: " + errorThrown);
    console.log("Respuesta completa: ", jqXHR);

    Swal.fire({
        icon: 'error',
        title: 'Error al actualizar empleado',
        text: 'No se pudo actualizar el empleado. Verifica que el correo ingresado no esté ya registrado y vuelve a intentarlo.',
        footer: 'Si el error persiste, contacta al administrador.',
        timer: 10000,
        timerProgressBar: true,
    });
}
        });
    } else
        bootbox.confirm({
            title: "<h4>Error al editar empleado</h4>",
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




function deleteEmployee(id_employee) {
    console.log(id_employee)
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el empleado. ¿Estás seguro de continuar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../../controller/employee/controller_employee.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 5, id_employee: id_employee},
                success: function(result) {
                    console.log(result)
                    if (result.status == "success") {

                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Empleado eliminado correctamente',
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
                            text: 'Ocurrió un error al eliminar el Empleado'
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






function changePassword() {
    var employeeID = sessionStorage.getItem('id_employee');

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
                    var formData = new FormData();
                    formData.append('action', 6);
                    formData.append('id_employee', employeeID);
                    formData.append('new_passsword', newPassword);

                    if (newPassword.length === 0 || confirmNewPassword.length === 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ambos campos de contraseña son obligatorios'
                        });
                        return false;
                    }

                    if (!(newPassword == confirmNewPassword)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Las contraseñas no coinciden, favor de verificar'
                        });
                        return false;
                    }

                    $.ajax({
                        url: "../../controller/employee/controller_employee.php",
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




document.addEventListener('DOMContentLoaded', function () {
    let id = new URLSearchParams(window.location.search).get('dc');
    if(id){ // Solo si existe el id en la URL
    preCargarDatos();    }
});



function vistaUpdateEmployee(id_employee) {
    sessionStorage.setItem("id_employee", id_employee)
    location.href = "../employee/editar_employee.php?dc=" + id_employee;
}




function newEmployee() {
    location.href = "../employee/registro_employee.php";
}


$("#exit").click(function() {
    //loader.fadeIn();
    $(".loader").fadeOut("slow");

    setTimeout(function() {
        location.href = "../../index.php";
    }, 1000);
});
    