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
    listPrestamos();
    getStudent();
    getEmployee();
            
});




function listPrestamos() {
  $.ajax({
        url: "../../controllers/prestamo/controller_prestamo.php",
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

                    var fechaCompleta = val.date_register;
                    var partes = fechaCompleta.split(" ");
                    var fecha = partes[0];
                    var hora = partes[1].substring(0,8);
                    var fechaHoraFormateada = fecha + " " + hora;

                    table += "<tr>"       
                    + "<th style='text-align:center'>"+val.id_prestamo+"</th>"
                    + "<th style='text-align:center'>"+val.student_name+"</th>"
                    + "<th style='text-align:center'>"+val.description+"</a></th>"                 
                    + "<th style='text-align:center'>"+fechaHoraFormateada+"</th>"
                    + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='editTypeUser("+val.id_prestamo+")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                    + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' id='btn-details' id-type-user='"+val.id_prestamo+"' title='Click para eliminar' onclick='deleteTypeUser("+val.id_prestamo+")'>"+'<i class="fas fa-trash"></i>'+"</button></th>"
                    + "</tr>";
                }
            });
            if(i1 != 0){
                $('#table-prestamo').html(table);
                $('#alert1').hide();
            }
        }, error: function (result){
            console.log(result); 
        }
    }); 
}




function getStudent(){    
    $(".loader").fadeOut("slow");
    $.ajax({
        url: "../../controllers/prestamo/controller_prestamo.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 2},
        success: function(result) {
            var addStudent = "<option value='null' selected disabled>Seleccione al Estudiante</option>";
            $.each(result, function(index, val){
                addStudent += "<option value='"+ val.id_student +"'>"+ val.full_name +"</option>";
            });            
            $("#student").html(addStudent);             
        }, error: function(result) {
            //console.log(result);
        }
    });
}


function getEmployee(){  
    var email_employee = sessionStorage.getItem("email_employee");
    console.log("Correo de empleado:", email_employee); 

    $(".loader").fadeOut("slow");
    $.ajax({
        url: "../../controllers/prestamo/controller_prestamo.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 3, email_employee: email_employee },
        success: function(result) {
            if(result.length > 0){
                // Aquí usa el id_employee como value
                var addEmployee = "<option value='" + result[0].id_employee + "' selected>" + result[0].full_name_employee + "</option>";
                $("#employee").html(addEmployee);
            } else {
                var addEmployee = "<option value='null' selected>No se encontró empleado</option>";
                $("#employee").html(addEmployee);
            }

            // Deshabilita el select para que no se pueda modificar
            $("#employee").prop("disabled", true);
        }, 
        error: function(result) {
            console.log("Error al obtener empleado");
        }
    });
}







function savePrestamo() {
var student = $("#student").val();
var description = $("#description").val().trim();
var employee = $("#employee").val().trim();

// Validación individual con mensajes específicos
if (student === null || student === "null") {
    alert("Debe seleccionar un estudiante");
    $("#student").focus();
    return 0;
}

if (description.length == 0) {
    alert("El campo descripción de préstamo no puede estar vacío");
    $("#description").focus();
    return 0;
}

if (employee.length == 0) {
    alert("El campo empleado no puede estar vacío");
    $("#employee").focus();
    return 0;
}


    // Si todos están llenos, ejecuta el AJAX
    $.ajax({
        url: "../../controllers/prestamo/controller_prestamo.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 4, student: student, description: description, employee: employee },
        success: function (result) {
            // Si todo va bien, redirige
            location.href = "../prestamo/prestamo.php";
        },
        error: function (xhr, status, error) {
            console.error("Error en la petición AJAX:");
            console.error("Estado: " + status);
            console.error("Error: " + error);
            console.error("Respuesta del servidor: " + xhr.responseText);

            var errorMsg = "<h5>Ocurrió un error al hacer el registro del préstamo.</h5>";

            // Si hay un mensaje en la respuesta, úsalo
            if (xhr.responseText) {
                errorMsg += "<br><strong>Detalle:</strong> " + xhr.responseText;
            }

            bootbox.confirm({
                title: "<h4>Error al registrar préstamo</h4>",
                message: errorMsg,
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







function newPrestamo() {
    location.href = "../prestamo/registro_prestamo.php";  
}




$("#exit").click(function() {
    //loader.fadeIn();
    $(".loader").fadeOut("slow");

    setTimeout(function() {
        location.href = "../../index.php";
    }, 1000);
});
