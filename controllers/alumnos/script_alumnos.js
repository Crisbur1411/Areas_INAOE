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
    listStudent();
    listStudentInProgress();
    listStudentFree();
    listStudentCancel();
            
});


function listStudent() {
    let i1 = 0; // Inicializamos i1 con 0
    $.ajax({
        url: "../../controllers/alumnos/controller_alumnos.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 1 },
        success: function(result) {      
            var table = "";
            $.each(result, function(index, val) {
                if (val.status == 1)
                {
                    i1++; // Incrementamos i1 solo si el estudiante cumple con la condición
                    table += "<tr>"       
                    + "<th style='text-align:center'>"+val.id_student+"</th>"
                    + "<th style='text-align:center'>"+val.control_number+"</a></th>"
                    + "<th style='text-align:center'>"+val.full_name+"</th>" 
                    + "<th style='text-align:center'>"+val.namecourse+"</th>"
                    + "<th style='text-align:center'>"+val.date+"</th>"
                    + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='editStudent("+val.id_student+")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                    + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' id='btn-details' id-student='"+val.id_student+"' title='Click para eliminar' onclick='deleteStudent("+val.id_student+")'>"+'<i class="fas fa-trash"></i>'+"</button></th>"
                    + "<th style='text-align:center'><button type='button' class='btn btn-success btn-sm' id='btn-details' id-student='"+val.id_student+"' title='Click para turnar a firma'  onclick='turnSingAreas("+val.id_student+")'>"+'<i class="fa-solid fa-file-signature"></i>'+"</button></th>"
                    + "</tr>";
                }
            });
            $('#pf1').text(i1); // Actualizamos el valor en el elemento con id 'pf'
            if(i1 != 0){
                $('#table-students').html(table);
                $('#alert1').hide();
            }
        }, error: function (result){
            console.log(result); 
        }
    }); 
}

function editStudent(id_student) {
        location.href = "../alumnos/actualizar_alumnos.php?dc="+id_student;
}

function deleteStudent(id_student) {
    swal({
        title: "ELIMINAR REGISTRO",
        text: "¿Estás seguro de que deseas eliminar el registro del alumno?",
        icon: "warning",
        buttons: {
            cancel: "Cancelar",
            Aceptar: true,
        },
    }).then((deleteDoc) => {
        if (deleteDoc) {
            $.ajax({
                url: "../../controllers/alumnos/controller_alumnos.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 2, id_student: id_student },
                success: function (result) {
                    swal("Registro Eliminado!", {
                        icon: "success",
                    }).then(() => {
                        location.reload(); // Recarga la página después de eliminar
                    });
                }
            });
        }
    });
}


function newStudent() {
    location.href = "../alumnos/registro_alumnos.php";
}

function turnSingAreas(id_student) {
    $u = document.getElementById("user");
    $user = $u.innerHTML;

    swal({
        title: "TURNAR A LIBERACIÓN DE ÁREAS",
        text: "¿Estás seguro de que deseas turnar a firma para liberación al alumno? ... Ya no podrás realizar ninguna modificación",
        icon: "info",
        buttons: {
            cancel: "Cancelar",
            Enviar: true,
        },
    }).then((sendDoc) => {
        if (sendDoc) {
            $.ajax({
                url: "../../controllers/alumnos/controller_alumnos.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 3, id_student: id_student, user: $user },
                success: function (result) {
                    console.log(result);
                    $.ajax({
                        url: "../../controllers/alumnos/controller_alumnos.php",
                        cache: false,
                        dataType: 'JSON',
                        type: 'POST',
                        data: { action: 9, id_student: result },
                        success: function (result) { },
                        error: function (result) {
                            console.log(result);
                        }
                    });
                },
                error: function (result) {
                    console.log(result);
                },
                complete: function () {
                    $(".loader").fadeOut("slow");
                    $("#info").removeClass("d-none");
                    listStudent();
                    listStudentInProgress();
                    listStudentFree();
                    listStudentCancel();
                }
            });

            swal("Turnado a firma!", {
                icon: "success",
            }).then(() => {
                location.reload(); // Recarga la página después de la alerta
            });
        }
    });
}


function listStudentInProgress() {
    let i2 = 0; // Inicializamos i1 con 0
    $.ajax({
        url: "../../controllers/alumnos/controller_alumnos.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 4 },
        success: function(result) {      
            var table = "";
            $.each(result, function(index, val) {
                i2++; // Incrementamos i1 solo si el estudiante cumple con la condición
                if (val.status == 2 && val.areas_count >=0 )
                {
                    table += "<tr>"       
                    + "<th style='text-align:center'>"+val.id_student+"</th>"
                    + "<th style='text-align:center'>"+val.control_number+"</a></th>"
                    + "<th style='text-align:center'>"+val.full_name+"</th>" 
                    + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showRegisterAreas("+val.id_student+");'>"+val.areas_count+"</a></th>"
                    + "<th style='text-align:center'><button type='button' class='btn btn-primary btn-sm' title='Click para finalizar el trámite' onClick='freeStudent("+val.id_student+");'><i class='fa-solid fa-file-import'></i></button></a></th>"
                    + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' title='Click para cancelar el trámite' onClick='cancelStudent("+val.id_student+");'><i class='fa-solid fa-file-excel'></i></button></a></th>"
                    + "</tr>";
                } else {
                    table += "<tr>"       
                    + "<th style='text-align:center'>"+val.id_student+"</th>"
                    + "<th style='text-align:center'>"+val.control_number+"</a></th>"
                    + "<th style='text-align:center'>"+val.full_name+"</th>" 
                    + "<th style='text-align:center'>"+val.areas_count+"</th>"
                    + "<th style='text-align:center'><button type='button' class='btn btn-primary btn-sm' title='Click para finalizar el trámite' onClick='freeStudent("+val.id_student+");'><i class='fa-solid fa-file-import'></i></button></a></th>"
                    + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' title='Click para cancelar el trámite' onClick='cancelStudent("+val.id_student+");'><i class='fa-solid fa-file-excel'></i></button></a></th>"
                    + "</tr>";
                }
            });
            $('#pf2').text(i2); // Actualizamos el valor en el elemento con id 'pf'
            if(i2 != 0){
                $('#table-students-in-progress').html(table);
                $('#alert2').hide();
            }
        }, error: function (result){
            console.log(result); 
        }
    }); 
}

function showRegisterAreas(id_student) { 
  
    $('#exampleModalCenter').modal();
    var modal = $('#exampleModalCenter')
    modal.find('.modal-title').text('Detalles')

    $.ajax({
           url: "../../controllers/alumnos/controller_alumnos.php",
           cache: false,
           dataType: 'JSON',
           type: 'POST',
           data: { action: 5, id_student: id_student},
           success: function(result) {
            //console.log(result);
            var table = "";
            var name_student="";
                $.each(result, function(index, val) {
                    if (val.status == 2)
                    {             
                        name_student = val.full_name;  
                    }      
                        table += "<tr>"       
                        + "<th style='text-align:center'>"+val.namearea+"</a></th>"
                        + "<th style='text-align:center'>"+val.formatted_date+"</th>"
                        + "<th style='text-align:center'>"+val.description+"</th>"
                         + "</tr>";
                    
                });
                $('#table-modal-info-areas').html(table);
                $('#title-name-student').html(name_student);
                 
           },error: function(result){
                console.log(result);
           }                   
       });     
}

function freeStudent(id_student) {
    $u = document.getElementById("user");
    $user = $u.innerHTML;
    
    swal({
        title: "FINALIZAR EL TRÁMITE DE FORMA SATISFACTORIA",
        text: "¿Estás seguro de que deseas finalizar el trámite correspondiente a la liberación de áreas?",
        icon: "info",
        buttons: {
            cancel: "Cancelar",
            Enviar: true,
        },
    }).then((sendDoc) => {
        if (sendDoc) {
            $.ajax({
                url: "../../controllers/alumnos/controller_alumnos.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 6, id_student: id_student, user: $user },
                success: function (result) {
                    $.ajax({
                        url: "../../controllers/alumnos/controller_alumnos.php",
                        cache: false,
                        dataType: 'JSON',
                        type: 'POST',
                        data: { action: 7, id_student: id_student },
                        success: function (result) { },
                        error: function (result) {
                            console.log(result);
                        }
                    });
                },
                error: function (result) {
                    console.log(result);
                },
                complete: function () {
                    $(".loader").fadeOut("slow");
                    $("#info").removeClass("d-none");
                    listStudent();
                    listStudentInProgress();
                    listStudentFree();
                    listStudentCancel();
                }
            });

            swal("Trámite finalizado!", {
                icon: "success",
            }).then(() => {
                location.reload(); // Recarga la página después de la alerta
            });
        }
    });
}


function listStudentFree() {
    let i3 = 0; // Inicializamos i1 con 0
    $.ajax({
        url: "../../controllers/alumnos/controller_alumnos.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 8 },
        success: function(result) {      
            var table = "";
            $.each(result, function(index, val) {
                if (val.status == 3)
                {
                    i3++; // Incrementamos i1 solo si el estudiante cumple con la condición
                    table += "<tr>"       
                    + "<th style='text-align:center'>"+val.id_student+"</th>"
                    + "<th style='text-align:center'>"+val.control_number+"</a></th>"
                    + "<th style='text-align:center'>"+val.full_name+"</th>" 
                    + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showRegisterAreas("+val.id_student+");'>"+val.date+"</a></th>"
                    + "<th style='text-align:center'><button type='button' class='btn btn-primary btn-sm' title='Click para imprimir la constancia' onClick='printPDF("+val.id_student+");'><i class='fa-solid fa-print'></i></button></a></th>"
                    + "</tr>";
                }
            });
            $('#pf3').text(i3); // Actualizamos el valor en el elemento con id 'pf'
            if(i3 != 0){
                $('#table-students-free').html(table);
                $('#alert3').hide();
            }
        }, error: function (result){
            console.log(result); 
        }
    }); 
}


//desarrollado por BRYAM el 03/04/2024 funcion para general el pdf de cada alumno

function printPDF(id_student) {
    $.ajax({
        url: "../../controllers/alumnos/controller_alumnos.php",
        cache: false,
        type: 'POST',
        data: { action: 13, id_student: id_student },
        success: function(result) {
            try {
                var data = JSON.parse(result);
                if (data.pdf_url) {
                    window.location.href = data.pdf_url; 
                } else {
                    console.error('Error: URL de PDF no proporcionada en la respuesta JSON.');
                }
            } catch (error) {
                console.error('Error al analizar la respuesta JSON:', error);
            }
        }        
    }); 
}

function cancelStudent(id_student) {
    $u = document.getElementById("user");
    $user = $u.innerHTML;

    swal({
        title: "CANCELAR EL TRÁMITE",
        text: "Escribe el motivo de cancelación:",
        content: {
            element: "input",
            attributes: {
                placeholder: "Motivo de cancelación",
                type: "text",
            },
        },
        icon: "info",
        buttons: {
            cancel: "Cancelar",
            confirm: "Enviar",
        },
    }).then((motivo) => {
        if (motivo) {
            $.ajax({
                url: "../../controllers/alumnos/controller_alumnos.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 10, id_student: id_student, user: $user, motivo: motivo },
                success: function (result) {
                    $.ajax({
                        url: "../../controllers/alumnos/controller_alumnos.php",
                        cache: false,
                        dataType: 'JSON',
                        type: 'POST',
                        data: { action: 11, id_student: id_student },
                        success: function (result) { },
                        error: function (result) {
                            console.log(result);
                        }
                    });
                },
                error: function (result) {
                    console.log(result);
                },
                complete: function () {
                    $(".loader").fadeOut("slow");
                    $("#info").removeClass("d-none");
                    listStudent();
                    listStudentInProgress();
                    listStudentFree();
                    listStudentCancel();
                }
            });

            swal("Trámite cancelado!", {
                icon: "warning",
            }).then(() => {
                location.reload(); // Recarga la página después de la alerta
            });
        }
    });
}



function listStudentCancel() {
    
    let i4 = 0; // Inicializamos i1 con 0
    $.ajax({
        url: "../../controllers/alumnos/controller_alumnos.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 12 },
        success: function(result) {   
            var table = "";
            $.each(result, function(index, val) {
                if (val.status == 4)
                {
                    i4++; // Incrementamos i1 solo si el estudiante cumple con la condición
                    table += "<tr>"       
                    + "<th style='text-align:center'>"+val.id_student+"</th>"
                    + "<th style='text-align:center'>"+val.control_number+"</a></th>"
                    + "<th style='text-align:center'>"+val.full_name+"</th>" 
                    + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showRegisterAreas("+val.id_student+");'>"+val.date+"</a></th>"
                    + "</tr>";
                }
            });
            $('#pf4').text(i4); // Actualizamos el valor en el elemento con id 'pf'
            if(i4 != 0){
                $('#table-students-cancel').html(table);
                $('#alert4').hide();
            }
        }, error: function (result){
            console.log(result); 
        }
    }); 
}

$("#exit").click(function() {
    //loader.fadeIn();
    $(".loader").fadeOut("slow");

    setTimeout(function() {
        location.href = "../../index.php";
    }, 1000);
});

