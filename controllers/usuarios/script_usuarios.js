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

function listUser() {
  $.ajax({
        url: "../../controllers/usuarios/controller_usuarios.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 1 },
        success: function(result) {            
            let i1 = +$('#pf').text();
            var table = "";
            $.each(result, function(index, val) {
                if (val.status == 1)
                {
                $('#pf').text(++i1);
                table += "<tr>"       
                + "<th style='text-align:center'>"+val.id_user+"</th>"
                + "<th style='text-align:center'>"+val.full_name+"</a></th>"
                + "<th style='text-align:center'>"+val.area_name+"</th>" 
                + "<th style='text-align:center'>"+val.type_name+"</th>"
                + "<th style='text-align:center'>"+val.date+"</th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='vistaUpdateUsuario("+val.id_user+")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' id='btn-details' id-user='"+val.id_user+"' title='Click para eliminar' onclick='deleteUser("+val.id_user+")'>"+'<i class="fas fa-trash"></i>'+"</button></th>"
                + "</tr>";
                }
            });
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
        url: "../../controllers/usuarios/controller_usuarios.php",
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
   
    if (newPassword !== confirmPassword) {
        alert('Las contraseñas nuevas no coinciden.');
        return;
    }
    $.ajax({
        url: '../../controllers/usuarios/controller_usuarios.php',
        method: 'POST',
        dataType: "JSON",
        data: { action: 3, id_user: id_user, currentPassword: currentPassword, newPassword: newPassword },
        success: function(response) {
            if (response.success) { 
                alert('actualizado con éxito');
                $('#modalEdit').modal('hide'); 
            } else {
                alert('Error al actualizar la contraseña.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al modificar la contraseña:', status, error);
        }
    });
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
    
