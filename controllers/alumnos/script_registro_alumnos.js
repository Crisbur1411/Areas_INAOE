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

function courses(){    
    $(".loader").fadeOut("slow");
    var program = $("#program").val();
    $.ajax({
        url: "../../controllers/alumnos/controller_registro_alumnos.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 1, program: program },
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

function cancel() {
    window.history.back();
}

function saveStudent(){
        
    var name = $("#name").val().trim(); 
    var surname = $("#surname").val().trim(); 
    var secondsurname = $("#second_surname").val().trim(); 

    var controlnumber = $("#control-number").val();
    var email = $("#email").val().trim(); 

    var course = $("#course").val();
    
   
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
    
    var expEmail = /^[A-Za-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
    var validEmail = expEmail.test(email);
   
    if(validEmail == true){
        $.ajax({
            url: "../../controllers/alumnos/controller_registro_alumnos.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 2, name: name, surname: surname, secondsurname: secondsurname, email: email, controlnumber: controlnumber, course: course },
            success: function(result) {
                history.go(-1);         
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
  
    
$("#exit").click(function() {
    //loader.fadeIn();
    $(".loader").fadeOut("slow");

    setTimeout(function() {
        location.href = "../../index.php";
    }, 1000);
});