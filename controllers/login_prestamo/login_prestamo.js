$(document).ready(function() {
    $("#email").inputFilter(function(value) {
        return /^[a-zA-Z0-9@_.-]*$/.test(value); // Agrega '@' a la validación
    });
});


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

function logout() {
    $.ajax({
        url: "../../controllers/login_prestamo/controller_login_prestamo.php",
        cache: false,
        type: 'POST',
        data: { action: 2 },
        success: function(result) {
            location.href = "../../index.php";
        }
    });
}
// Funcion para finalizar la sesion
$("#btnLogout").click(function() {
    bootbox.confirm({
        title: "<h4>Cerrar sesión</h4>",
        message: "<h5>Está a apunto de cerrar la sesión. Para continuar presione el botón <b>Aceptar</b></h5>",
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
        callback: function(result) {
            if (result != false) {
                logout();
            }
        }
    });
});

// Funcion del boton que se usa para iniciar sesion 
$("#login-form").submit(function(event) {
    event.preventDefault();
    var email = $("#email").val();
    var password = $("#password").val();  
     
    if(email != '' || password != '' ) {
                $.ajax({
                    url: "../../controllers/login_prestamo/controller_login_prestamo.php",
                    cache: false,
                    type: 'POST',
                    data: { action:1 , email: email, password: password },
                    success: function(response){
                        console.log("login-form ->"+response);
                        if(response == "no exit")
                        {
                             bootbox.alert({
                                closeButton: false,
                                title: 'Error en la información de acceso. ',
                                message: 'Favor de verificar el usuario y contraseña.',
                                closeButton: false,
                                backdrop: true,
                                onEscape:true,
                                buttons: {
                                    ok: {
                                        label: 'ok',
                                        className: 'btn-success'
                                    }
                                }
                            });
                        }
                        if(response == 4)
                        {
                            /*bootbox.confirm({
                                title: "<h4>Información no registrada</h4>",
                                message: "<h5>No cuenta con sus archivos <b>.pem</b>, los cuales son necesarios para realizar el proceso de sellado en los títulos electronicos, favor de proporcionar la información necesaria para poder continuar. </h5>",
                                buttons: {
                                    cancel: {
                                        label: 'No',
                                        className: 'btn-secondary'
                                    },
                                    confirm: {
                                        label: 'Si',
                                        className: 'btn-success'
                                    }
                                },
                                closeButton: false,
                                callback: function(result) {
                                    if (result != false) {
                                         location.href = "v/efirma/efirma_cer.php";
                                    }
                                    else
                                    {
                                         location.href = "#";
                                    }
                                }
                            });*/
                            location.href = "../../v/prestamo/prestamo.php";
                        } 
                        
                        
                    }
                });
    } else {
        bootbox.alert({
            closeButton: false,
            message: 'Todos los campos son obligatorios.',
            closeButton: false,
            backdrop: true,
            onEscape:true,
            buttons: {
                ok: {
                    label: 'ok',
                    className: 'btn-success'
                }
            }
        });
    }
});


// Funcion para finalizar la sesion y PEM
$("#btnLogoutPem").click(function() {
    bootbox.confirm({
        title: "<h4>Cerrar sesión</h4>",
        message: "<h5>Está a apunto de cerrar la sesión y borrar el archivo <b>.PEM</b> Para continuar presione el botón <b>Aceptar</b></h5>",
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
        callback: function(result) {
            if (result != false) {
                logout();
                deleteInfo();
            }
        }
    });
});

function deleteInfo() {

     $.ajax({
        url: "../../controllers/firmar/controller_firmar.php",
        cache: false,
        type: 'POST',
        data: { action: 2 },
        success: function(result) {
            console.log("OK delete");  
        }
    });
}
