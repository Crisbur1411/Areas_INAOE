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
    listStudentFree();

        
});


$(document).ready(function() {
    $('#validationForm').on('submit', function(e) {
        e.preventDefault();

        let folio = $('#folio').val();

        if (folio.trim() === '') {
            $('#alert_error').text("Ingrese un correo electrónico.").show();
            return;
        }

        $.ajax({
            url: '../../controller/consulta_folio/controller_consulta_folio.php',
            type: 'POST',
            data: { 
                action: 1,
                folio: folio
            },
            success: function(response) {
                console.log(response); // Para debug

                if (response !== '"error"') {
                    // Guardamos el id_student en sessionStorage
                    sessionStorage.setItem("id_student", response);
                    sessionStorage.setItem("folio", folio);


                    // Redirigimos al usuario con su folio y su id en la URL
                    window.location.href = 'consulta_folio.php?dc='+folio+'&id_student='+response;
                } else {
                    $('#alert_error').text("Error: Folio no encontrado.").show();
                }
            },
            error: function() {
                $('#alert_error').text("Error en la petición. Intente nuevamente.").show();
            }
        });
    });
});


function listStudentFree(){
    let folio = sessionStorage.getItem("folio");
    let i2 = 0;

    $.ajax({
        url: "../../controller/consulta_folio/controller_consulta_folio.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 2, folio: folio },
        success: function(result) {
            var table = "";

            $.each(result, function(index, val) {
                i2++;

                table += "<tr>"
                    + "<th style='text-align:center'>" + val.id_student + "</th>"
                    + "<th style='text-align:center'>" + val.full_name + "</th>"
                    + "<th style='text-align:center'>"
                    + "<button class='btn btn-info btn-sm' title='Ver detalles de Liberación' onClick='showDetails(" + val.id_student + ")'>Detalles</button>"
                    + "</th>"
                    + "</tr>";
            });

            $('#pf2').text(i2);

            if (i2 != 0) {
                $('#table-students-free').html(table);
                $('#alert2').hide();
            }
        },
        error: function(result) {
            console.log(result);
        }
    });
}



function showDetails(id_student){
    console.log("Mostrando detalles del alumno con ID:", id_student);
    $('#modalStudentDetails').modal();

    // Limpiar antes de cargar
    $('#student-fullname').text('');
    $('#student-control-number').text('');
    $('#student-email').text('');
    $('#student-institucion').text('');
    $('#student-fecha-conclusion').text('');
    $('#student-programa-academico').text('');

    $('#student-status').text('').removeClass('badge badge-success badge-warning badge-danger');

    $.ajax({
        url: "../../controller/consulta_folio/controller_consulta_folio.php",
        type: "POST",
        dataType: "JSON",
        data: { action: 3, id_student: id_student },
        success: function(result) {
            if (result.status == 200 && result.data) {
                const alumno = result.data;
                $('#student-fullname').text(alumno.full_name);
                $('#student-control-number').text(alumno.control_number);
                $('#student-email').text(alumno.email);
                $('#student-institucion').text(alumno.institucion);
                $('#student-fecha-conclusion').text(alumno.fecha_conclusion);
                $('#student-programa-academico').text(alumno.programa_academico);
                $('#student-folio').text(alumno.folio);

                
                if (alumno.status == 3) {
                    $('#student-status')
                    .html('<span class="badge badge-success">Liberado</span>');
                } else {
                    $('#student-status')
                    .html('<span class="badge badge-warning">En proceso</span>');
                }

            } else {
                console.warn("No se encontraron datos del alumno.");
            }
        },
        error: function(err) {
            console.error("Error al obtener los datos del alumno", err);
        }
    });
}


