/*
Desarrollado por Julian 
El 29/03/2024
Funcionalidad Crear area con firma Integrada
*/

// Esperar a que el DOM esté completamente cargado antes de ejecutar el código
document.addEventListener('DOMContentLoaded', function() {
    var inputImagen = document.getElementById('imagen');

    if (inputImagen) {
        // Si el elemento existe, asignar dinámicamente el evento de cambio al input de tipo archivo
        inputImagen.addEventListener('change', function(event) {
            previewImage(event);
        });
      

    }
});


function redirigirNewArea(){
        location.href = "../areas/crear_area.php";

}

function newArea() {
    var formHtml = `
    
   <p>¿Desea crear la nueva area?</p>
`;    bootbox.dialog({
        title: "<h4>Confirmar Nueva Área</h4>",
        message: formHtml,
        closeButton: true,
        buttons: {
            cancel: {
                label: 'Cancelar',
                className: 'btn-secondary',
                callback: function () {
                    console.log('Se canceló la creación del área');
                }
            },
            confirm: {
                label: 'Guardar',
                className: 'btn-primary',
                callback: function () {

                    var nombreArea = $('#nombreArea').val().trim();
                    var detallesArea = $('#descripcionArea').val().trim();
                    var identificadorArea = $('#identificador').val().trim();
                    var imagen = $('#imagen')[0].files[0];


                    var formData = new FormData();
                    formData.append('action', 2);
                    formData.append('nombre_area', nombreArea);
                    formData.append('detalles_area', detallesArea);
                    formData.append('identificador_area', identificadorArea);
                    formData.append('imagen', imagen);

                    if (nombreArea === '' || detallesArea === '' || identificadorArea === '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Todos los campos son obligatorios. Por favor, complete todos los campos.'
                        });
                        return false;
                    }

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
                                console.log("Se creó el área");
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: 'Área creada correctamente'
                                });

                                location.href = "./areas.php";


                            } else {
                                console.log("Hubo error al crear el área");
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Ocurrió un error al crear el área'
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