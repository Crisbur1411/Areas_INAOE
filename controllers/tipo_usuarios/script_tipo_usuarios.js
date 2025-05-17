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
                + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='editTypeUser("+val.id_type_user+")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' id='btn-details' id-type-user='"+val.id_type_user+"' title='Click para eliminar' onclick='deleteTypeUser("+val.id_type_user+")'>"+'<i class="fas fa-trash"></i>'+"</button></th>"
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

function editTypeUser(id_user) {
    bootbox.alert({
        title: "<h4>Actualización</h4>",
        message: "<h5>Para realizar esta acción es necesario actualizar el sistema.</h5>",
        
        closeButton: true,
        callback: function(result) {            
        }
    });
}

function deleteTypeUser(id_user) {
    bootbox.alert({
        title: "<h4>Actualización</h4>",
        message: "<h5>Para realizar esta acción es necesario actualizar el sistema.</h5>",
        
        closeButton: true,
        callback: function(result) {            
        }
    });    
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

$("#exit").click(function() {
    //loader.fadeIn();
    $(".loader").fadeOut("slow");

    setTimeout(function() {
        location.href = "../../index.php";
    }, 1000);
});

