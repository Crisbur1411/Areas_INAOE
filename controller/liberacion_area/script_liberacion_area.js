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
                        + "<th style='text-align:center'>"+val.full_name+"</th>" 
                        + "<th style='text-align:center'><button type='button' class='btn btn-primary btn-sm' title='Click para finalizar el trámite' onClick='signStudent("+val.id_student+", \""+val.full_name.replace(/"/g, '&quot;')+"\");'><i class='fa-solid fa-file-import'></i></button></a></th>"
                        + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' title='Click para ver las notas' data-toggle='modal' onClick='notesStudent("+val.id_student+");'><i class='fa-solid fa-eye'></i></button></a></th>"
                        + "</tr>";
                    } else {
                        table += "<tr>"       
                        + "<th style='text-align:center'>"+val.id_student+"</th>"
                        + "<th style='text-align:center'>"+val.control_number+"</a></th>"
                        + "<th style='text-align:center'>"+val.full_name+"</th>" 
                        + "<th style='text-align:center'><button type='button' class='btn btn-primary btn-sm' title='Click para finalizar el trámite' onClick='signStudent("+val.id_student+", \""+val.full_name.replace(/"/g, '&quot;')+"\");'><i class='fa-solid fa-file-import'></i></button></a></th>"
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

function signStudent(id_student, full_name) {
    $u = document.getElementById("user");
    $user = $u.innerHTML;

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
            var password = $(".swal-content__input").val();
            $.ajax({
                url: "../../controller/liberacion_area/controller_liberacion_area.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 6, password: password },
                success: function (result) {
                    $.each(result, function (index, val) {
                        if (val.success === 't') {
                            $.ajax({
                                url: "../../controller/liberacion_area/controller_liberacion_area.php",
                                cache: false,
                                dataType: 'JSON',
                                type: 'POST',
                                data: { action: 2, id_student: id_student, user: $user, full_name: full_name },
                                success: function (result) {},
                                error: function (result) {
                                    console.log(result);
                                },
                                complete: function () {
                                    $(".loader").fadeOut("slow");
                                    $("#info").removeClass("d-none");
                                    listStudentInProgress();
                                    listStudentFree();
                                }
                            });

                            swal("Trámite finalizado!", {
                                icon: "success",
                            }).then(() => {
                                location.reload(); // Recarga la página después de la alerta
                            });

                        } else if (typeof val.message !== 'undefined') {
                            swal("Error", val.message, "error");
                        }
                    });
                },
                error: function (result) {
                    console.log(result);
                }
            });
        }
    });

    // Agregamos el controlador de eventos para la tecla "Enter" en el campo de contraseña
    $('#passwordInput').keypress(function (event) {
        if (event.which === 13) {
            event.preventDefault();
            return false;
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
                    + "<th style='text-align:center'>"+val.full_name+"</th>" 
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
                    + "<th style='text-align:center'>"+val.full_name+"</th>" 
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


$("#exit").click(function() {
    //loader.fadeIn();
    $(".loader").fadeOut("slow");

    setTimeout(function() {
        location.href = "../../index.php";
    }, 1000);
});

