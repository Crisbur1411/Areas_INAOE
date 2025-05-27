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



$(document).ready(function() {
    $('#validationForm').on('submit', function(e) {
        e.preventDefault();

        let email = $('#email').val();

        if (email.trim() === '') {
            $('#alert_error').text("Ingrese un correo electrónico.").show();
            return;
        }

        $.ajax({
            url: '../../controllers/validacion_proceso/controller_validacionProceso.php',
            type: 'POST',
            data: { 
                action: 3,
                email: email
            },
            success: function(response) {
                console.log(response); // Para debug

                if (response !== '"error"') {
                    // Guardamos el id_student en sessionStorage
                    sessionStorage.setItem("id_student", response);
                    sessionStorage.setItem("email", email);


                    // Redirigimos al usuario con su email y su id en la URL
                    window.location.href = 'validacion_proceso.php?dc='+email+'&id_student='+response;
                } else {
                    $('#alert_error').text("Error: Correo no encontrado.").show();
                }
            },
            error: function() {
                $('#alert_error').text("Error en la petición. Intente nuevamente.").show();
            }
        });
    });
});





function listStudentInProgress() {
    let i2 = 0; // Inicializamos contador
    let email = sessionStorage.getItem("email");


    $.ajax({
        url: "../../controllers/validacion_proceso/controller_validacionProceso.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 1, email: email }, // Enviamos el email
        success: function(result) {
            var table = "";
            $.each(result, function(index, val) {
                if (val.status == 2 && val.areas_count >= 0) {
                    i2++; // Incrementamos solo si cumple condición

                    table += "<tr>"
                        + "<th style='text-align:center'>" + val.id_student + "</th>"
                        + "<th style='text-align:center'>" + val.full_name + "</th>"
                        + "<th style='text-align:center'>" + val.email + "</th>"
                        + "<th style='text-align:center'>" + val.control_number + "</th>"
                        + "<th style='text-align:center'>" + val.areas_count + "</th>"
                        + "<th style='text-align:center'>"
                        + "<button class='btn btn-info btn-sm' onClick='showRegisterAreas(" + val.id_student + ")'>Detalles</button>"
                        + "</th>"
                        + "</tr>";
                } else {
                    table += "<tr>"
                        + "<th style='text-align:center'>" + val.id_student + "</th>"
                        + "<th style='text-align:center'>" + val.control_number + "</th>"
                        + "<th style='text-align:center'>" + val.full_name + "</th>"
                        + "<th style='text-align:center'>" + val.areas_count + "</th>"
                        + "<th style='text-align:center'>"
                        + "<button class='btn btn-info btn-sm' onClick='showRegisterAreas(" + val.id_student + ")'>Detalles</button>"
                        + "</th>"
                        + "</tr>";
                }
            });
            $('#pf2').text(i2);
            if (i2 != 0) {
                $('#table-students-in-progress').html(table);
                $('#alert2').hide();
            }
        },
        error: function(result) {
            console.log(result);
        }
    });
}



function showRegisterAreas(id_student) { 
    $('#exampleModalCenter').modal();
    var modal = $('#exampleModalCenter')
    modal.find('.modal-title').text('Detalles')
    $.ajax({
        url: "../../controllers/validacion_proceso/controller_validacionProceso.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 2, id_student: id_student }, 
        success: function(result) {
            var table = "";
            var name_student = "";
            $.each(result, function(index, val) {
                if (val.status == 2) {             
                    name_student = val.full_name;  
                }      
                table += "<tr>"       
                    + "<th style='text-align:center'>" + val.namearea + "</a></th>"
                    + "<th style='text-align:center'>" + val.formatted_date + "</th>"
                    + "<th style='text-align:center'>" + val.description + "</th>"
                    + "</tr>";
            });
            $('#table-modal-info-areas').html(table);
            $('#title-name-student').html(name_student);
        },
        error: function(result){
            console.log(result);
        }                   
    });     
}



function helper() { 
    $('#responsablesModal').modal();
    var modal = $('#responsablesModal')
    modal.find('.modal-title').text('Responsables de las áreas')
    $('#responsablesModalSubtitle').text('Responsables de la liberación de cada área en caso de requerir atención especial.')

    $.ajax({
        url: "../../controllers/validacion_proceso/controller_validacionProceso.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 4 }, 
        success: function(result) {
            var table = "";
            $.each(result, function(index, val) {
                table += "<tr>"       
                    + "<td style='text-align:center'>" + val.area_name + "</td>"
                    + "<td style='text-align:center'>" + val.full_name + "</td>"
                    + "</tr>";
            });
            $('#table-modal-responsables').html(table);
        },
        error: function(result){
            console.log(result);
        }                   
    });     
}



$(function(){
    $(".loader").fadeOut("slow");
    $("#info").removeClass("d-none");
    listStudentInProgress();

        
});