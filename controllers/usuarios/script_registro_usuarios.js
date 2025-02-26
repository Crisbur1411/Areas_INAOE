var answer_save = [];
var loader = $(".loader");
var document_id;

(function ($) {
    $.fn.inputFilter = function (inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
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


function areas() {


    $(".loader").fadeOut("slow");
    $.ajax({
        url: "../../controllers/usuarios/controller_registro_usuarios.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 1 },
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
        url: "../../controllers/usuarios/controller_registro_usuarios.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 2 },
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


function cancel() {
    window.history.back();
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
    
    if (type_user == null) {
        alert("Tiene que elegir el tipo de usuario")
        $("#type-users").focus();
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
            url: "../../controllers/usuarios/controller_registro_usuarios.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 3, name: name, surname: surname, secondsurname: secondsurname, email: email, type_user: type_user, password: password },
            success: function (result) {
                console.log("el resultado es" + result);
                var $id_user = result;
                userArea($id_user, area);
            }, error: function (result) {
                console.log(result);
                bootbox.confirm({
                    title: "<h4>Error al registrar usuario</h4>",
                    message: "<h5>Ocurrio un error al hacer el registro del usuario.</h5>",
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

function userArea(id_user, $area) {
    $.ajax({
        url: "../../controllers/usuarios/controller_registro_usuarios.php",
        cache: false,
        dataType: 'JSON', 
        type: 'POST',
        data: { action: 4, id_user: id_user, area: $area },
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

$("#exit").click(function () {
    //loader.fadeIn();
    $(".loader").fadeOut("slow");

    setTimeout(function () {
        location.href = "../../index.php";
    }, 1000);
});