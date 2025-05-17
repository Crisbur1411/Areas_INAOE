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
    listTypeUsers();
            
});

function listTypeUsers() {
  $.ajax({
        url: "../../controllers/tipo_usuarios/controller_tipo_usuarios.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 1 },
        success: function(result) {            
            let i1 = +$('#pf').text();
            var table = "";
            $.each(result, function(index, val) {
                //console.log(val);
                if (val.status == 1)
                {
                $('#pf').text(++i1);
                table += "<tr>"       
                + "<th style='text-align:center'>"+val.id_type_users+"</th>"
                + "<th style='text-align:center'>"+val.key+"</th>"
                + "<th style='text-align:center'>"+val.name+"</a></th>"                 
                + "<th style='text-align:center'>"+val.details+"</th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='editTypeUser("+val.id_type_users+")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' id='btn-details' id-type-user='"+val.id_type_users+"' title='Click para eliminar' onclick='deleteTypeUser("+val.id_type_users+")'>"+'<i class="fas fa-trash"></i>'+"</button></th>"
                + "</tr>";
                }
            });
            if(i1 != 0){
                $('#table-type-users').html(table);
                $('#alert1').hide();
            }
        }, error: function (result){
            console.log(result); 
        }
    }); 
}



function saveTypeUser() {
    var name = $("#name").val().trim();
    var key = $("#key").val().trim();
    var details = $("#details").val().trim();

    // Validación individual con mensajes específicos
    if (name.length == 0) {
        alert("El campo nombre no puede estar vacío");
        $("#name").focus();
        return 0;
    }

    if (key.length == 0) {
        alert("El campo clave no puede estar vacío");
        $("#key").focus();
        return 0;
    }

    if (details.length == 0) {
        alert("El campo detalles no puede estar vacío");
        $("#details").focus();
        return 0;
    }

    // Si todos están llenos, puedes hacer una validación final así:
    if (name.length > 0 && key.length > 0 && details.length > 0) {
       
        $.ajax({
            url: "../../controllers/tipo_usuarios/controller_tipo_usuarios.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 2, name: name, key: key, details: details},
            success: function (result) {
            location.href = "../tipo_usuarios/tipo_usuarios.php";         
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
    }else
        bootbox.confirm({
            title: "<h4>Error al registrar el tipo de usuario</h4>",
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
            callback: function(result) {
                if (result == false) {
                    history.go(-1);
                }
            }
        });
}









function deleteTypeUser(id_type_users) {
    console.log(id_type_users)
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el tipo de usuario. ¿Estás seguro de continuar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../../controllers/tipo_usuarios/controller_tipo_usuarios.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 5, id_type_users: id_type_users },
                success: function(result) {
                    console.log(result)
                    if (result.status == "success") {

                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Tipo de usuario eliminado correctamente',
                            timer: 1000,
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
                            text: 'Ocurrió un error al eliminar el tipo de usuario'
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

// Redirigir a otra página

function editTypeUser(id_type_users){
    sessionStorage.setItem("id_type_users", id_type_users)
    location.href = "../tipo_usuarios/actualizar_tipo_usuario.php?dc="+id_type_users;  
}

function newTypeUser() {
    location.href = "../tipo_usuarios/registro_tipo_usuario.php";  
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


// cargar los datos de la tabla
$(document).ready(function(){
    listTypeUsers(); // o como se llame tu función
});


$("#exit").click(function() {
    //loader.fadeIn();
    $(".loader").fadeOut("slow");

    setTimeout(function() {
        location.href = "../../index.php";
    }, 1000);
});

