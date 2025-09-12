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
    listStudentInProgress();
    listStudentFree();
    listStudentCancel();
});

function listStudentInProgress() {
    let i2 = 0; // Inicializamos i1 con 0
    $.ajax({
        url: "../../controller/liberacion_area/controller_liberacion_area.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 1 },
        success: function(result) {      
            var table = "";
            $.each(result, function(index, val) {
                if (val.status == 2 )
                { 
                    i2++; // Incrementamos i1 solo si el estudiante cumple con la condición
                    if (val.note_count > 0)
                    {
                        table += "<tr>"       
                        + "<th style='text-align:center'>"+val.id_student+"</th>"
                        + "<th style='text-align:center'>"+val.control_number+"</a></th>"
                        + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showStudentDetails("+val.id_student+");'>"+val.full_name+"</a></th>" 
                        + "<th style='text-align:center'><button type='button' class='btn btn-primary btn-sm' title='Click para finalizar el trámite' onClick='signStudent("+val.id_student+", \""+val.full_name.replace(/"/g, '&quot;')+"\", "+val.fk_process_catalog+");'><i class='fa-solid fa-file-import'></i></button></a></th>"
                        + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' title='Click para ver las notas' data-toggle='modal' onClick='notesStudent("+val.id_student+");'><i class='fa-solid fa-eye'></i></button></a></th>"
                        + "</tr>";
                    } else {
                        table += "<tr>"       
                        + "<th style='text-align:center'>"+val.id_student+"</th>"
                        + "<th style='text-align:center'>"+val.control_number+"</a></th>"
                        + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showStudentDetails("+val.id_student+");'>"+val.full_name+"</a></th>" 
                        + "<th style='text-align:center'><button type='button' class='btn btn-primary btn-sm' title='Click para finalizar el trámite' onClick='signStudent("+val.id_student+", \""+val.full_name.replace(/"/g, '&quot;')+"\", "+val.fk_process_catalog+");'><i class='fa-solid fa-file-import'></i></button></a></th>"
                        + "<th style='text-align:center'><button type='button' class='btn btn-info btn-sm' title='Click para agregar una nota en el trámite' onClick='noteStudent("+val.id_student+");'><i class='fa-solid fa-file-lines'></i></button></a></th>"
                        + "</tr>";
                    }
                    
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

function signStudent(id_student, full_name, fk_process_catalog) {
    const $u = document.getElementById("user");
    const $user = $u.innerHTML;
    const $id_user = ID_USER;

    console.log("ID del usuario:", $id_user);
    console.log("ID proceso catalog del estudiante:", fk_process_catalog);

    // Paso 1: Obtener el execution_flow del gestor
    $.ajax({
        url: "../../controller/alumnos/controller_alumnos.php",
        type: "POST",
        dataType: "JSON",
        data: { action: 21, id_user: $id_user, id_student: id_student, fk_process_catalog: fk_process_catalog },
        success: function (responseFlow) {
            if (responseFlow.status === 200 && responseFlow.data) {
                const user_execution_flow = parseInt(responseFlow.data.execution_flow);
                console.log("Execution flow del usuario:", user_execution_flow);

                // Paso 2: Obtener el avance del estudiante
                $.ajax({
                    url: "../../controller/alumnos/controller_alumnos.php",
                    type: "POST",
                    dataType: "JSON",
                    data: { action: 20, id_student: id_student, fk_process_catalog: fk_process_catalog },
                    success: function (flowResult) {
                        const flowData = flowResult.data;

                        let valid = true;
                        flowData.forEach(f => {
                            if (f.execution_flow < user_execution_flow && !f.completed) {
                                valid = false;
                            }
                        });

                        if (!valid) {
                            swal("Acción no permitida", "El estudiante no ha completado los pasos anteriores, por favor vuelva a intentarlo después.", "warning");
                            return;
                        }

                        // Paso 3: Mostrar el modal de contraseña
                        swal({
                            title: "LIBERAR DEL ÁREA AL ALUMNO",
                            text: "Por favor, ingresa tu contraseña para confirmar la liberación del área al alumno:",
                            icon: "info",
                            buttons: {
                                cancel: "Cancelar",
                                Liberar: true,
                            },
                            content: {
                                element: "input",
                                attributes: {
                                    placeholder: "Contraseña",
                                    type: "password",
                                    id: "passwordInput",
                                },
                            },
                            closeOnEsc: false,
                        }).then((value) => {
                            if (value === "Liberar") {
                                const password = $(".swal-content__input").val();

                                // Paso 4: Validar contraseña
                                $.ajax({
                                    url: "../../controller/liberacion_area/controller_liberacion_area.php",
                                    type: "POST",
                                    dataType: "JSON",
                                    data: { action: 6, password: password },
                                    success: function (result) {
                                        $.each(result, function (index, val) {
                                            if (val.success === 't') {
                                                // Paso 5: Liberar al estudiante
                                                $.ajax({
                                                    url: "../../controller/liberacion_area/controller_liberacion_area.php",
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    data: {
                                                        action: 2,
                                                        id_student: id_student,
                                                        user: $user,
                                                        full_name: full_name,
                                                        id_user: $id_user, 
                                                        fk_process_catalog: fk_process_catalog
                                                    },
                                                    complete: function () {
                                                        // ✅ Paso 6: Enviar correo al siguiente flujo
                                                        $.ajax({
                                                            url: "../../services/send_email.php",
                                                            type: 'GET',
                                                            dataType: 'JSON',
                                                            data: { 
                                                                id_student: id_student,
                                                                fk_process_catalog: fk_process_catalog,
                                                                proceso: "Proceso de Liberación"
                                                            },
                                                            success: function(responseEmail) {
                                                                console.log("Correo enviado al siguiente flujo:", responseEmail);
                                                            },
                                                            error: function(errorEmail) {
                                                                console.error("Error enviando correo al siguiente flujo:", errorEmail);
                                                            }
                                                        });

                                                        $(".loader").fadeOut("slow");
                                                        $("#info").removeClass("d-none");
                                                        listStudentInProgress();
                                                        listStudentFree();

                                                        swal("Trámite finalizado!", {
                                                            icon: "success",
                                                        }).then(() => {
                                                            location.reload();
                                                        });
                                                    },
                                                    error: function (result) {
                                                        console.log(result);
                                                    }
                                                });
                                            } else if (val.message) {
                                                swal("Error", val.message, "error");
                                            }
                                        });
                                    },
                                    error: function () {
                                        swal("Error", "Error al validar contraseña", "error");
                                    }
                                });
                            }
                        });

                        // Enter bloqueado
                        $(document).off('keypress', '#passwordInput').on('keypress', '#passwordInput', function (event) {
                            if (event.which === 13) {
                                event.preventDefault();
                                return false;
                            }
                        });
                    },
                    error: function () {
                        swal("Error", "No se pudo verificar el avance del estudiante.", "error");
                    }
                });

            } else {
                swal("Error", "No se pudo obtener el flujo del usuario.", "error");
            }
        },
        error: function () {
            swal("Error", "Fallo la consulta de flujo del usuario.", "error");
        }
    });
}








function listStudentFree() {
    let i3 = 0; // Inicializamos i1 con 0
    $.ajax({
        url: "../../controller/liberacion_area/controller_liberacion_area.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 3 },
        success: function(result) {      
            //console.log(result);
            var table = "";
            $.each(result, function(index, val) {
                if (val.status == 2)
                {
                    i3++; // Incrementamos i1 solo si el estudiante cumple con la condición
                    table += "<tr>"       
                    + "<th style='text-align:center'>"+val.id_student+"</th>"
                    + "<th style='text-align:center'>"+val.control_number+"</a></th>"
                    + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showStudentDetails("+val.id_student+");'>"+val.full_name+"</a></th>" 
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

function noteStudent(id_student) {
    $u = document.getElementById("user");
    $user = $u.innerHTML;
    
    swal({
        title: "NOTA EN EL TRÁMITE",
        text: "Escribe el motivo de la nota:",
        content: {
            element: "input",
            attributes: {
                placeholder: "Motivo de la nota",
                type: "text",
            },
        },
        icon: "info",
        buttons: {
            cancel: "Cancelar",
            confirm: "Enviar",
          },
      })
      .then((motivo) => {
        if (motivo) {
            $.ajax({
                url: "../../controller/liberacion_area/controller_liberacion_area.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 4, id_student: id_student, user: $user, motivo: motivo },
                success: function(result) {
                    //console.log(result); 
                }, error: function (result){
                    console.log(result);
                },complete: function () {
                    $(".loader").fadeOut("slow");
                    $("#info").removeClass("d-none");
                    listStudentInProgress();
                    listStudentFree();


                    // Aquí se envia la llamada para enviar el correo
                    $.ajax({
                        url: "../../services/send_email_notes.php",
                        type: 'GET',
                        dataType: 'JSON',
                        data: { id_student: id_student }, 
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                }
            });            
            swal("Nota agregada al tramite !", {
                icon: "success",
            });
        } else {
        }
      });
}

function notesStudent(id_student) { 
  
    $('#exampleModalCenter').modal();
    var modal = $('#exampleModalCenter')
    modal.find('.modal-title').text('Detalles')

    $.ajax({
           url: "../../controller/liberacion_area/controller_liberacion_area.php",
           cache: false,
           dataType: 'JSON',
           type: 'POST',
           data: { action: 5, id_student: id_student},
           success: function(result) {
            //console.log(result);
            var table = "";
            var name_student="";
                $.each(result, function(index, val) {
                    if (val.status == 1)
                    {
                        name_student = val.full_name;                         
                        table += "<tr>"    
                        + "<th style='text-align:center'>"+val.description+"</th>"
                        + "<th style='text-align:center'>"+val.formatted_date+"</th>"
                        + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar nota' onclick='noteStudentEdit(" + val.id_note +")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                        + "</tr>";
                    }
                });
                $('#title-name-student').html(name_student);
                $('#table-modal-info-notas').html(table);
                 
           },error: function(result){
                console.log(result);
           }                   
       });     
}



function listStudentCancel() {
    
    let i4 = 0; // Inicializamos i1 con 0
    $.ajax({
        url: "../../controller/liberacion_area/controller_liberacion_area.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 7 },
        success: function(result) {   
            var table = "";
            $.each(result, function(index, val) {
                if (val.status == 4)
                {
                    i4++; // Incrementamos i1 solo si el estudiante cumple con la condición
                    table += "<tr>"       
                    + "<th style='text-align:center'>"+val.id_student+"</th>"
                    + "<th style='text-align:center'>"+val.control_number+"</a></th>"
                    + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showStudentDetails("+val.id_student+");'>"+val.full_name+"</a></th>" 
                    + "<th style='text-align:center'><p>"+val.date+"</p></th>"
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




function noteStudentEdit(id_note) {
    $u = document.getElementById("user");
    $user = $u.innerHTML;

    $('#exampleModalCenter').modal('hide');

    swal({
        title: "EDITAR LA NOTA EN EL TRÁMITE",
        text: "Escribe el motivo de la nota:",
        content: {
            element: "input",
            attributes: {
                placeholder: "Motivo de la nota",
                type: "text",
            },
        },
        icon: "info",
        buttons: {
            cancel: "Cancelar",
            confirm: "Enviar",
        },
    })
    .then((motivo) => {
        if (motivo) {
            $.ajax({
                url: "../../controller/liberacion_area/controller_liberacion_area.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 9, user: $user, motivo: motivo, id_note: id_note },
                success: function(result) {
                    if (result.status === "success") {
                        swal(result.message, { icon: "success" });
                    } else {
                        swal(result.message, { icon: "error" });
                    }
                },
                error: function (result){
                    swal("Error al actualizar la nota", { icon: "error" });
                },
                complete: function () {
                    $(".loader").fadeOut("slow");
                    $("#info").removeClass("d-none");
                    listStudentInProgress();
                    listStudentFree();
                }
            });
        }
    });
}







function showStudentDetails(id_student) {
  $('#modalStudentDetails').modal();

  // Limpiar antes de cargar
  $('#student-fullname').text('');
  $('#student-control-number').text('');
  $('#student-email').text('');
  $('#student-institucion').text('');
  $('#student-fecha-conclusion').text('');
  $('#student-programa-academico').text('');

  $.ajax({
    url: "../../controller/liberacion_area/controller_liberacion_area.php",
    type: "POST",
    dataType: "JSON",
    data: { action: 8, id_student: id_student },
    success: function(result) {
      if (result.status == 200 && result.data) {
        const alumno = result.data;
        $('#student-fullname').text(alumno.full_name);
        $('#student-control-number').text(alumno.control_number);
        $('#student-email').text(alumno.email);
        $('#student-institucion').text(alumno.institucion);
        $('#student-fecha-conclusion').text(alumno.fecha_conclusion);
        $('#student-programa-academico').text(alumno.programa_academico);
      } else {
        console.warn("No se encontraron datos del alumno.");
      }
    },
    error: function(err) {
      console.error("Error al obtener los datos del alumno", err);
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

