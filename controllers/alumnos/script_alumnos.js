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



// Funcion para listar los alumnos en la tabla
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

                    // Aquí se envia la llamada para enviar el correo
                    $.ajax({
                        url: "../../services/send_email.php",
                        type: 'GET',
                        dataType: 'JSON',
                        data: { id_student: id_student },  // 👈 aquí enviamos el id_student
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });


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
                    + "<th style='text-align:center'><button type='button' class='btn btn-primary btn-sm' title='Click para imprimir la constancia' onClick='printPDF("+val.id_student+", \""+val.full_name.replace(/"/g, '&quot;')+"\");'><i class='fa-solid fa-print'></i></button></a></th>"
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

//Funcion para imprimir el PDF de cada alumno "Temporal"




//desarrollado por BRYAM el 03/04/2024 funcion para general el pdf de cada alumno
function showError(message) {
    $("#errorModalBody").text(message);
    var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
    errorModal.show();
}




function printPDF(id_student, full_name) {
    $.ajax({
        url: "../../controllers/alumnos/controller_alumnos.php",
        cache: false,
        type: 'POST',
        data: { action: 13, id_student: id_student, full_name: full_name },
        success: function(result) {
            console.log("Respuesta recibida:", result);

            try {
                var data = JSON.parse(result);

                if (data.pdf_url) {
                    window.location.href = data.pdf_url;
                } else {
                    let errorMessage = 'No se pudo generar el PDF.\nVerifica que el alumno tenga las liberaciones necesarias.';
                    showError(errorMessage);
                    console.error(errorMessage, data);
                }

            } catch (error) {
                let errorMessage = 'Error al procesar la respuesta del servidor. Intenta de nuevo.';
                showError(errorMessage);
                console.error(errorMessage, error);
                console.log('Respuesta sin procesar:', result);
            }
        },
        error: function(xhr, status, error) {
            let errorMessage = 'Error en la petición AJAX.\nEstado: ' + status + '\nError: ' + error;
            showError(errorMessage);
            console.error(errorMessage);
            console.error("Respuesta completa:", xhr.responseText);
        }
    });
}








//Obtener cursos para mostrar en el select de registro de alumnos
function courses(){    
    $(".loader").fadeOut("slow");
    var program = $("#program").val();
    $.ajax({
        url: "../../controllers/alumnos/controller_alumnos.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 14, program: program },
        success: function(result) {
            var addCourse = "<option value='null' selected disabled>Seleccione su área</option>";
            $.each(result, function(index, val){
                addCourse += "<option value='"+ val.id_academic_programs +"'>"+ val.name +"</option>";
            });            
            $("#course").html(addCourse);             
        }, error: function(result) {
            //console.log(result);
        }
    });
}

//Funciona para actualizar el campo institución en el registro de alumnos
function updateInstitucion() {
  var program = $("#program").val();
  var institucionInput = $("#institucion");

  if (program == "1" || program == "2") {
    institucionInput.val("INAOE");
    institucionInput.prop("readonly", true);
  } else if (program == "3" || program == "4") {
    institucionInput.val("");
    institucionInput.prop("readonly", false);
  } else {
    institucionInput.val("");
    institucionInput.prop("readonly", false);
  }
}




// Fucncion para registrar un nuevo alumno
function saveStudent(){
        
    var name = $("#name").val().trim(); 
    var surname = $("#surname").val().trim(); 
    var secondsurname = $("#second_surname").val().trim(); 

    var controlnumber = $("#control-number").val();
    var email = $("#email").val().trim(); 

    var course = $("#course").val();

    var institucion = $("#institucion").val().trim();

    var date_conclusion = $("#date_conclusion").val().trim();
    
   
    if (name.length==0){
        alert("Tiene que escribir el nombre")
        $("#name").focus();
        return 0;
    }
    if (surname.length==0){
        alert("Tiene que escribir el apellido")
        $("#surname").focus();
        return 0;
    }
    /*if (professional_secondsurname.length==0){
        
        alert("Tiene que escribir su segundo apellido")
        $("#second_surname").focus();
        professional_secondsurname = "";
        return 0;
        
    }*/
    if (email.length==0){
        alert("Tiene que escribir el correo electrónico")
        $("#email").focus();
        return 0;
    } 
    if (controlnumber.length==0){
        alert("Tiene que escribir la matrícula")
        $("#control-number").focus();
        return 0;
    } 
    if (course==null){
        alert("Tiene que elegir el área")
        $("#course").focus();
        return 0;
    }

    if (institucion==null){
        alert("Tiene que ingresar la institución")
        $("#institucion").focus();
        return 0;
    }

    if (date_conclusion==null){
        alert("Tiene que agregar la fecha de conclusión")
        $("#date_conclusion").focus();
        return 0;
    }
    
    var expEmail = /^[A-Za-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
    var validEmail = expEmail.test(email);
   
    if(validEmail == true){
        $.ajax({
            url: "../../controllers/alumnos/controller_alumnos.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 15, name: name, surname: surname, secondsurname: secondsurname, email: email, controlnumber: controlnumber, course: course, institucion: institucion, date_conclusion: date_conclusion },
            success: function(result) {
    window.location.href = "../alumnos/alumnos.php";
}, error: function(result) {
                console.log(result);
                bootbox.confirm({
                    title: "<h4>Error al registrar el alumno</h4>",
                    message: "<h5>Ocurrio un error al hacer el registro del alumno.</h5>",
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
                    callback: function(result) {
                        if (result == false) {
                            history.go(-1);
                        }
                    }
                });
            }
        });
    }else
        bootbox.confirm({
            title: "<h4>Error al registrar alumno</h4>",
            message: "<h5>Favor de verificar que el correo sea válido.</h5>",
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
            callback: function(result) {
                if (result == false) {
                    history.go(-1);
                }
            }
        });
    }




// Obtener cursos para mostrar en el select de editar alumnos
function getCourses(){
    var program = $("#program").val();
    
    $.ajax({
        url: "../../controllers/alumnos/controller_alumnos.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 14, program: program },
        success: function(result) {
            //console.log(result);
            var addArea = "<option value='null' selected disabled>Seleccione su área</option>";
            $.each(result, function(index, val){
                addArea += "<option value='"+ val.id_academic_programs +"'>"+ val.name +"</option>";
            });            
            $("#course").html(addArea);   
                   
        }
    });
    
}


//Agregar cursos al select de editar alumnos
function coursesAds(){
    let params = new URLSearchParams(location.search);
    id_student = parseInt(params.get('dc'));
    $.ajax({
        url: "../../controllers/alumnos/controller_alumnos.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 16, id_student: id_student },
        success: function(result) {
            var addArea = "";
            $.each(result, function(index, val){
                addArea += "<option value='"+ val.id_academic_programs +"'>"+ val.name +"</option>";
            });
            //console.log(result[0].name);
            var stringP = result[0].name.toString();
            var primerCaracter = stringP.charAt(0);
            if( primerCaracter == 'M'){
                $("#program").val(1);
                $("#course").html(addArea); 
            }else{
                $("#program").val(2); 
                $("#course").html(addArea);
            }
        }, error: function ( result) {
            console.log(result);
        } 
    });
}

// Obtener los datos del alumno a editar
function getStudent() {
    $(".loader").fadeOut("slow");
    let params = new URLSearchParams(location.search);
    id_student = parseInt(params.get('dc'));
   
    $.ajax({
        url: "../../controllers/alumnos/controller_alumnos.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 17, id_student:id_student },
        success: function(result) {
                console.log(result); // <-- aquí  
            
            $.each(result, function(index, val){                
                $('#name').val(val.name);
                $('#surname').val(val.surname); 
                $('#second-surname').val(val.second_surname);
                $('#email').val(val.email);
                $('#control-number').val(val.control_number);
                $('#institucion').val(val.institucion);
                $('#date_conclusion').val(val.date_conclusion);
            });   
        }, error: function ( result) {
            console.log(result);
        } 
    }); 
}



function checkInstitution() {
    let program = $("#program").val();

    if (program == "1" || program == "2") {
        $("#institucion").val("INAOE");
        $("#institucion").prop("disabled", true);
    } else if (program == "3" || program == "4") {
        $("#institucion").val("");
        $("#institucion").prop("disabled", false);
    } else {
        $("#institucion").val("");
        $("#institucion").prop("disabled", false);
    }
}


// Actualizar los datos del alumno
function updateStudent(){
    let params = new URLSearchParams(location.search);
    id_student = parseInt(params.get('dc'));

    var name = $("#name").val().trim(); 
    var surname = $("#surname").val().trim(); 
    var secondsurname = $("#second-surname").val().trim(); 

    var controlnumber = $("#control-number").val();
    var email = $("#email").val().trim(); 

    var course = $("#course").val();
    var institucion = $("#institucion").val().trim();
    var date_conclusion = $("#date_conclusion").val().trim();
    
   
    if (name.length==0){
        alert("Tiene que escribir el nombre")
        $("#name").focus();
        return 0;
    }
    if (surname.length==0){
        alert("Tiene que escribir el apellido")
        $("#surname").focus();
        return 0;
    }
    /*if (professional_secondsurname.length==0){
        
        alert("Tiene que escribir su segundo apellido")
        $("#second_surname").focus();
        professional_secondsurname = "";
        return 0;
        
    }*/
    if (email.length==0){
        alert("Tiene que escribir el correo electrónico")
        $("#email").focus();
        return 0;
    } 
    if (controlnumber.length==0){
        alert("Tiene que escribir la matrícula")
        $("#control-number").focus();
        return 0;
    } 
    if (course==null){
        alert("Tiene que elegir el área")
        $("#course").focus();
        return 0;
    }
    if (institucion==null){
        alert("Tiene que agregar la institución")
        $("#institucion").focus();
        return 0;
    }
    if (date_conclusion==null){
        alert("Tiene que agregar la fecha de conclusión")
        $("#date_conclusion").focus();
        return 0;
    } 
    
    var expEmail = /^[A-Za-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
    var validEmail = expEmail.test(email);
   
    if (validEmail == true) {
    $.ajax({
        url: "../../controllers/alumnos/controller_alumnos.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { 
            action: 18, 
            id_student: id_student, 
            name: name, 
            surname: surname, 
            secondsurname: secondsurname, 
            email: email, 
            controlnumber: controlnumber, 
            course: course,
            institucion: institucion,
            date_conclusion: date_conclusion 
        },
        success: function(result) {
    window.location.href = "../alumnos/alumnos.php";
},
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Estado de la petición:", textStatus);
            console.error("Error lanzado:", errorThrown);
            console.error("Código de estado HTTP:", jqXHR.status);
            console.error("Texto de estado HTTP:", jqXHR.statusText);
            console.error("Respuesta completa del servidor:", jqXHR.responseText);

            bootbox.confirm({
                title: "<h4>Error al actualizar el alumno</h4>",
                message: "<h5>Ocurrió un error al hacer la actualización del registro del alumno.<br><br><b>Error:</b> " 
                         + textStatus + " - " + errorThrown + "</h5>",
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
                callback: function(result) {
                    if (result == false) {
                        $(".loader").fadeOut("slow")
                        history.go(-1);
                    }
                }
            });
        }
    });
    }else
        bootbox.confirm({
            title: "<h4>Error al actualizar alumno</h4>",
            message: "<h5>Favor de verificar que el correo sea válido.</h5>",
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
            callback: function(result) {
                if (result == false) {
                    history.go(-1);
                }
            }
        });
    }




$(document).ready(function() {
    checkInstitution(); // para inicializar el campo si ya hay un valor seleccionado
});



function cancel() {
    window.history.back();
}

$("#exit").click(function() {
    //loader.fadeIn();
    $(".loader").fadeOut("slow");

    setTimeout(function() {
        location.href = "../../index.php";
    }, 1000);
});

