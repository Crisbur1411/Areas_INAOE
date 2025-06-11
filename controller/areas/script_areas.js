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
    listAreas();
});

function listAreas() {
    $.ajax({
        url: "../../controller/areas/controller_areas.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 1 },
        success: function(result) {
            let i1 = +$('#pf').text();
            var table = "";
            $.each(result, function(index, val) {
                if (val.status == 1) {
               
                    $('#pf').text(++i1);
                    table += "<tr>" +
                        "<th style='text-align:center'>" + val.id_area + "</th>" +
                        "<th style='text-align:center'>" + val.key + "</th>" +
                        "<th style='text-align:center'>" + val.name + "</th>" +
                            "<th style='text-align:center'>" + val.details + "</th>" +
                            "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='redirigirUpdateArea(" + val.id_area + ")'><i class='fas fa-edit'></i></button></th>" +
                            "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' data-id-area='" + val.id_area + "' data-key='" + val.key + "' title='Click para eliminar' onclick='deleteArea(this)'><i class='fas fa-trash'></i></button></th>" +
                        "</tr>";
                }
            });
            if (i1 != 0) {
                $('#table-areas').html(table);
                $('#alert1').hide();
            }
        },
        error: function(result) {
            console.log(result);
        }
    });
}




function newArea() {
    var name = $("#nombreNuevaArea").val().trim();
    var key = $("#identificador").val().trim();
    var details = $("#descripcionArea").val().trim();

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
        alert("El campo descripción no puede estar vacío");
        $("#details").focus();
        return 0;
    }

    // Si todos están llenos, puedes hacer una validación final así:
    if (name.length > 0 && key.length > 0 && details.length > 0) {
       
        $.ajax({
            url: "../../controller/areas/controller_areas.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 2, name: name, key: key, details: details},
            success: function (result) {
            location.href = "../areas/areas.php";         
            }, error: function (result) {
                console.log(result);
                bootbox.confirm({
                    title: "<h4>Error al registrar el área</h4>",
                    message: "<h5>Ocurrio un error al hacer el registro del área.</h5>",
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



function deleteArea(element) {
    var id_area = $(element).data('id-area');
    var key = $(element).data('key');


    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el área. ¿Estás seguro de continuar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../../controller/areas/controller_areas.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 3, identificador_area: key },
                success: function(result) {
                    if (result.status == 200) {
                        listAreas();
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Área eliminada correctamente',
                            window: location.reload()
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al eliminar el área'
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
    });
}

//Función para cargar los datos del area a editar

function preCargarDatosArea() {
    var areaID = sessionStorage.getItem('id_area');
if(!areaID){
  Swal.fire({
    icon: 'error',
    title: 'Sin selección',
    text: 'No se ha seleccionado un área para editar'
  });
  return;
}
    var formData = new FormData();
    formData.append('action', 5);
    formData.append('id_area', areaID);

    $.ajax({
        url: "../../controller/areas/controller_areas.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        success: function (result) {
            if (result.status == 200) {
                var areaData = result.data;
                $('#name').val(areaData.name);
                $('#key').val(areaData.key);
                $('#details').val(areaData.details);
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
    let id = new URLSearchParams(window.location.search).get('dc');
    if(id){ // Solo si existe el id en la URL
        preCargarDatosArea(id);
    }
});


function editArea() {    
 var areaID = sessionStorage.getItem('id_area');
    var name = $("#name").val().trim();
    var key = $("#key").val().trim();
    var details = $("#details").val().trim();

    if (name.length == 0) {
        alert("Tiene que escribir el nombre")
        $("#name").focus();
        return 0;
    }
    if (key.length == 0) {
        alert("Tiene que escribir la clave")
        $("#key").focus();
        return 0;
    }

    if (details.length == 0) {
        alert("Tiene que escribir la descripción")
        $("#details").focus();
        return 0;
    }



    if (name.length > 0 && key.length > 0 && details.length > 0) {
        $.ajax({
            url: "../../controller/areas/controller_areas.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 4, id_area: areaID, name: name, key: key, details: details},
            success: function (result) {

                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Área Actualizada correctamente',
                    timer: 1000,
                    timerProgressBar: true,
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                    location.href = "../areas/areas.php";         

                    }
                });

            }, error: function (jqXHR, textStatus, errorThrown) {
    console.log("Error en Ajax:");
    console.log("Estado: " + textStatus);
    console.log("Error: " + errorThrown);
    console.log("Respuesta completa: ", jqXHR);

    Swal.fire({
        icon: 'error',
        title: 'Error al actualizar el área',
        html: `<b>Estado:</b> ${textStatus}<br><b>Error:</b> ${errorThrown}`,
        footer: 'Revisa consola para más detalles',
        timer: 10000,
        timerProgressBar: true,
    });
            }
        });
    } 
}









function redirigirUpdateArea(id_area){
    sessionStorage.setItem("id_area", id_area)
    location.href = "../areas/update_area.php?dc="+id_area;  
}

function cancelEditArea(){
    location.href = "../areas/areas.php";
}



function cancelNewArea(){
    location.href = "../areas/areas.php";
    
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



//Redireccionar a nueva area
function redirigirNewArea(){
        location.href = "../areas/crear_area.php";

}




$("#exit").click(function() {
    $(".loader").fadeOut("slow");
    setTimeout(function() {
        location.href = "../../index.php";
    }, 1000);
});
