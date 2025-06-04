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
        url: "../../controllers/areas/controller_areas.php",
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
                            "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='redirigirUpdateArea(\"" + val.key + "\", \"" + val.name + "\", \"" + val.details + "\")'><i class='fas fa-edit'></i></button></th>" +
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
            url: "../../controllers/areas/controller_areas.php",
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
                url: "../../controllers/areas/controller_areas.php",
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
                            text: 'Área eliminada correctamente'
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




function editArea() {    
    var formHtml = 'desea editar';
 
    bootbox.dialog({
        title: "<h4>Editar Área</h4>",
        message: formHtml,
        closeButton: true,
        buttons: {
            cancel: {
                label: "Cancelar",
                className: "btn-secondary",
                callback: function () {

                }
            },
            save: {
                label: "Guardar",
                className: "btn-primary",
                callback: function () {
                    var nombreArea = $('#nombreArea').val().trim();
                    var detallesArea = $('#detallesArea').val().trim();
                    var identificadorArea = $('#identificador').val().trim();
                    var imagen = $('#imagen')[0].files[0];

                    if (nombreArea === '' || detallesArea === '' ) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Todos los campos son obligatorios. Por favor, complete todos los campos y seleccione una imagen.'
                        });
                        return false;
                    }

                    var formData = new FormData();
                    formData.append('action', 4);
                    formData.append('nombre_area', nombreArea);
                    formData.append('detalles_area', detallesArea);
                    formData.append('identificador_area', identificadorArea);
                    formData.append('imagen', imagen);

                    $.ajax({
                        url: "../../controllers/areas/controller_areas.php",
                        cache: false,
                        dataType: 'JSON',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function (result) {
                            console.log(result);

                            if (result.status == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: 'Área editada correctamente'
                                });

                                location.href = "./areas.php";

                            } else {
                                console.log("Hubo error al editar el área");
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Ocurrió un error al editar el área'
                                });
                            }
                        },
                        error: function (result) {
                            console.log(result);
                            console.log("Hubo error al realizar la solicitud");
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


document.getElementById('imagen').addEventListener('change', function() {
    var file = this.files[0];
    var reader = new FileReader();

    reader.onload = function(e) {
        document.getElementById('previewImage').src = e.target.result;
        // Verificar si se ha cargado una imagen
        if (file && file.name.split('.').pop() !== 'null') {
            // Si hay una imagen y la extensión no es 'null', hacer visible la vista previa
            document.getElementById('previewImage').style.display = 'block';
        } else {
            // Si no hay imagen o la extensión es 'null', hacer invisible la vista previa
            document.getElementById('previewImage').style.display = 'none';
        }
    };

    if (file && file.name.split('.').pop() !== 'null') {
        reader.readAsDataURL(file);
    } else {
        document.getElementById('previewImage').src = "#";
    }
});





function previewImage(event) {
    var input = event.target;
    var preview = document.getElementById('previewImage');
    var file = input.files[0];

    var reader = new FileReader();
    reader.onload = function() {
        preview.src = reader.result;
        preview.style.display = 'block'; // Mostrar la imagen de vista previa
    };
    
    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "#";
        preview.style.display = 'none'; // Ocultar la imagen de vista previa si no se selecciona ningún archivo
    }
}


function redirigirUpdateArea(areaId, nameArea, areaDetails){
    sessionStorage.setItem('areaId', areaId);
    sessionStorage.setItem('nameArea', nameArea);
    sessionStorage.setItem('areaDetails', areaDetails);
    location.href = "../areas/update_area.php";
}

document.addEventListener('DOMContentLoaded', function() {
    var areaId = sessionStorage.getItem('areaId');
    var nameArea = sessionStorage.getItem('nameArea');
    var areaDetails = sessionStorage.getItem('areaDetails');
    document.getElementById('nombreArea').value = nameArea;
    document.getElementById('detallesArea').value = areaDetails;
    document.getElementById('identificador').value = areaId;

    var extensiones = ['.jpg', '.jpeg', '.png', '.gif'];
    var rutaBase = "../../res/imgs/" + areaId;
    var imagenEncontrada = false;

    function probarExtension(index) {
        if (index >= extensiones.length) {
            document.getElementById('imagenArea').style.display = 'none';
            return;
        }
        var rutaImagen = rutaBase + extensiones[index];
        var img = new Image();
        img.onload = function() {
            document.getElementById('enlaceImagen').setAttribute('href', rutaImagen);
            document.getElementById('imagenArea').setAttribute('src', rutaImagen);
            document.getElementById('imagenArea').style.display = 'block';
            imagenEncontrada = true;
        };
        img.onerror = function() {
            probarExtension(index + 1);
        };
        img.src = rutaImagen;
    }

    probarExtension(0);
});






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
