/*
Desarrollado por Julian 
El 29/03/2024
Funcionalidad Crear editar con firma Integrada
*/



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
    var extension 
    document.getElementById('nombreArea').value = nameArea;
    document.getElementById('detallesArea').value = areaDetails;
    document.getElementById('identificador').value = areaId;

    

     
     $.ajax({
        url: "../../controllers/areas/controller_areas.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 5 ,area_id:areaId },
        success: function(result) {
             extension = result.extension[0].extension_imagen;

             var rutaImagen = "../../res/imgs/" + areaId + extension;   
            if(extension){
                document.getElementById('enlaceImagen').setAttribute('href', rutaImagen);
                document.getElementById('imagenArea').setAttribute('src', rutaImagen);
            }else{
                document.getElementById('imagenArea').style.display = 'none';

            }
           
              
        },
        error: function(result) {
            console.log(result);
         

        }
    });


  


});

function cancelEditArea(){
    location.href = "../areas/areas.php";
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