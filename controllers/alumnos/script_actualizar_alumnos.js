
var answer_save = [];
var loader = $(".loader");
var id_titledata;

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

function getCourses(){
    var program = $("#program").val();
    
    $.ajax({
        url: "../../controllers/alumnos/controller_actualizar_alumnos.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 1, program: program },
        success: function(result) {
            //console.log(result);
            var addArea = "<option value='null' selected disabled>Seleccione su área</option>";
            $.each(result, function(index, val){
                addArea += "<option value='"+ val.id_course +"'>"+ val.name +"</option>";
            });            
            $("#course").html(addArea);   
                   
        }
    });
    
}

function coursesAds(){
    let params = new URLSearchParams(location.search);
    id_student = parseInt(params.get('dc'));
    $.ajax({
        url: "../../controllers/alumnos/controller_actualizar_alumnos.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 2, id_student: id_student },
        success: function(result) {
            var addArea = "";
            $.each(result, function(index, val){
                addArea += "<option value='"+ val.id_course +"'>"+ val.name +"</option>";
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

function getStudent() {
    $(".loader").fadeOut("slow");
    let params = new URLSearchParams(location.search);
    id_student = parseInt(params.get('dc'));
   
    $.ajax({
        url: "../../controllers/alumnos/controller_actualizar_alumnos.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 3, id_student:id_student },
        success: function(result) {            
            $.each(result, function(index, val){                
                $('#name').val(val.name);
                $('#surname').val(val.surname); 
                $('#second-surname').val(val.second_surname);
                $('#email').val(val.email);
                $('#control-number').val(val.control_number);
            });   
        }, error: function ( result) {
            console.log(result);
        } 
    }); 
}

function updateStudent(){
    let params = new URLSearchParams(location.search);
    id_student = parseInt(params.get('dc'));

    var name = $("#name").val().trim(); 
    var surname = $("#surname").val().trim(); 
    var secondsurname = $("#second-surname").val().trim(); 

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
            url: "../../controllers/alumnos/controller_actualizar_alumnos.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 4, id_student: id_student, name: name, surname: surname, secondsurname: secondsurname, email: email, controlnumber: controlnumber, course: course },
            success: function(result) {
                history.go(-1);         
            }, error: function(result) {
                console.log(result);
                bootbox.confirm({
                    title: "<h4>Error al actualizar el alumno</h4>",
                    message: "<h5>Ocurrio un error al hacer la actualización del registro del alumno.</h5>",
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

function cancel() {
    //location.href = "../xml/xml.php";
    history.go(-1);
}

$("#exit").click(function() {
    loader.fadeIn();

    setTimeout(function() {
        location.href = "../../index.php";
    }, 1000);
});