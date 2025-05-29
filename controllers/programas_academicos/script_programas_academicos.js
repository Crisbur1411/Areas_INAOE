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
    var cve = $("#cve").val().trim();
    var select = document.getElementById("type_program");
    var selectedOption = select.options[select.selectedIndex];

    if (selectedOption.value == "") {
        alert("Selecciona un tipo de programa");
        return;
    }

    var type = selectedOption.value;
    var type_program = selectedOption.getAttribute("data-name");


    
    // Validación individual con mensajes específicos
    if (name.length == 0) {
        alert("El campo nombre no puede estar vacío");
        $("#name").focus();
        return 0;
    }

    if (cve.length == 0) {
        alert("El campo clave no puede estar vacío");
        $("#cve").focus();
        return 0;
    }

    // Si todos están llenos, puedes hacer una validación final así:
    if (name.length > 0 && cve.length) {
       
        $.ajax({
            url: "../../controllers/programas_academicos/controller_programas_academicos.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 2, name: name, cve: cve, type: type, type_program: type_program },
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



function preCargarDatosProgram() {
    var programID = sessionStorage.getItem('id_academic_programs');
if(!programID){
  Swal.fire({
    icon: 'error',
    title: 'Sin selección',
    text: 'No se ha seleccionado un programa academico para editar'
  });
  return;
}
    var formData = new FormData();
    formData.append('action', 3);
    formData.append('id_academic_programs', programID);

    $.ajax({
        url: "../../controllers/programas_academicos/controller_programas_academicos.php",
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
                $('#cve').val(userData.cve);
                $('#type_program').val(userData.type);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al editar el programa academico'
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
    let id = new URLSearchParams(window.location.search).get('dc');
    if(id){ // Solo si existe el id en la URL
        preCargarDatosProgram(id);
    }
});




function saveProgramEdit() {

    var programID = sessionStorage.getItem('id_academic_programs');
    var name = $("#name").val().trim();
    var cve = $("#cve").val().trim();
    var select = document.getElementById("type_program");
    var selectedOption = select.options[select.selectedIndex];

    if (selectedOption.value == "") {
        alert("Selecciona un tipo de programa");
        return;
    }

    var type = selectedOption.value;
    var type_program = selectedOption.getAttribute("data-name");

    if (name.length == 0) {
        alert("Tiene que escribir el nombre")
        $("#name").focus();
        return 0;
    }
    if (cve.length == 0) {
        alert("Tiene que escribir la clave")
        $("#cve").focus();
        return 0;
    }


    if (name.length > 0 && cve.length > 0) {
        $.ajax({
            url: "../../controllers/programas_academicos/controller_programas_academicos.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 4, id_academic_programs: programID, name: name, cve: cve, type: type, type_program: type_program },
            success: function (result) {

                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Programa académico Actualizado correctamente',
                    timer: 1000,
                    timerProgressBar: true,
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                    location.href = "../programas_academicos/programas_academicos.php";         

                    }
                });

            }, error: function (jqXHR, textStatus, errorThrown) {
    console.log("Error en Ajax:");
    console.log("Estado: " + textStatus);
    console.log("Error: " + errorThrown);
    console.log("Respuesta completa: ", jqXHR);

    Swal.fire({
        icon: 'error',
        title: 'Error al actualizar el programa académico',
        html: `<b>Estado:</b> ${textStatus}<br><b>Error:</b> ${errorThrown}`,
        footer: 'Revisa consola para más detalles',
        timer: 10000,
        timerProgressBar: true,
    });
            }
        });
    } 
}






function deleteProgram(id_academic_programs) {
    console.log(id_academic_programs)
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el programa académico seleccionado. ¿Estás seguro de continuar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../../controllers/programas_academicos/controller_programas_academicos.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 5, id_academic_programs: id_academic_programs },
                success: function(result) {
                    console.log(result)
                    if (result.status == "success") {

                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Programa académico eliminado correctamente',
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
                            text: 'Ocurrió un error al eliminar el programa académico',
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






//Redireccionar a pagina de actualizar programa academico

function editProgram(id_academic_programs){
    sessionStorage.setItem("id_academic_programs", id_academic_programs)
    location.href = "../programas_academicos/actualizar_programas_academicos.php?dc="+id_academic_programs;  
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