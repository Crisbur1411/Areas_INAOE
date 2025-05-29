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
    listPrograms();
});



function listPrograms() {
  $.ajax({
        url: "../../controllers/programas_academicos/controller_programas_academicos.php",
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
                + "<th style='text-align:center'>"+val.id_academic_programs+"</th>"
                + "<th style='text-align:center'>"+val.cve+"</th>"
                + "<th style='text-align:center'>"+val.name+"</a></th>"                 
                + "<th style='text-align:center'>"+val.type_program+"</th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='editProgram("+val.id_academic_programs+")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' id='btn-details' id-type-user='"+val.id_academic_programs+"' title='Click para eliminar' onclick='deleteProgram("+val.id_academic_programs+")'>"+'<i class="fas fa-trash"></i>'+"</button></th>"
                + "</tr>";
                }
            });
            if(i1 != 0){
                $('#table-programs').html(table);
                $('#alert1').hide();
            }
        }, error: function (result){
            console.log(result); 
        }
    }); 
}






function saveProgram() {
    var name = $("#name").val().trim();
    var key = $("#key").val().trim();
    var select = document.getElementById("type_program");
    var selectedOption = select.options[select.selectedIndex];

    if (selectedOption.value == "") {
        alert("Selecciona un tipo de programa");
        return;
    }

    var valor_tipo = selectedOption.value;
    var type_program = selectedOption.getAttribute("data-name");


    
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

    // Si todos están llenos, puedes hacer una validación final así:
    if (name.length > 0 && key.length) {
       
        $.ajax({
            url: "../../controllers/programas_academicos/controller_programas_academicos.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 2, name: name, cve: key, valor_tipo: valor_tipo, type_program: type_program },
            success: function (result) {
            location.href = "../programas_academicos/programas_academicos.php";         
            }, error: function (result) {
                console.log(result);
                bootbox.confirm({
                    title: "<h4>Error al registrar programa academico.</h4>",
                    message: "<h5>Ocurrio un error al hacer el registro del programa academico.</h5>",
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
}









//Redireccionar a pagina de agregar programa academico
function newProgram() {
    location.href = "../programas_academicos/registro_programas_academicos.php";  
}



$("#exit").click(function() {
    //loader.fadeIn();
    $(".loader").fadeOut("slow");

    setTimeout(function() {
        location.href = "../../index.php";
    }, 1000);
});