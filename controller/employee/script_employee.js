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

$(function() {
    $(".loader").fadeOut("slow");
    $("#info").removeClass("d-none");
    listEmployee();
});



function listEmployee() {
  $.ajax({
        url: "../../controller/employee/controller_employee.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 1 },
        success: function(result) { 
            let i1 = 0; // <-- Reinicia el contador aquí           
            var table = "";
            $.each(result, function(index, val) {
                if (val.status == 1)
                {
                i1++; // Solo incrementa aquí
                table += "<tr>"       
                + "<th style='text-align:center'>"+val.id_employee+"</th>"
                + "<th style='text-align:center'>"+val.full_name+"</a></th>"
                + "<th style='text-align:center'>"+val.area+"</th>"
                + "<th style='text-align:center'>"+val.type_name+"</th>"
                + "<th style='text-align:center'>"+val.email+"</th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='vistaUpdateEmployee("+val.id_employee+")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' id='btn-details' id-user='"+val.id_employee+"' title='Click para eliminar' onclick='deleteEmployee("+val.id_employee+")'>"+'<i class="fas fa-trash"></i>'+"</button></th>"
                + "</tr>";
                }
            });
            $('#pf').text(i1); // <-- Actualiza el contador aquí
            if(i1 != 0){
                $('#table-employees').html(table);
                $('#alert1').hide();
            }
        }, error: function (result){
            //console.log(result); 
        }
    }); 
}




function saveEmployee() {



    var name = $("#name").val().trim();
    var surname = $("#surname").val().trim();
    var secondsurname = $("#second_surname").val().trim();
    var email = $("#email").val().trim();

    var password = $("#password").val().trim();

    var area = $("#areas").val().trim();


    if (name.length == 0) {
        alert("Tiene que escribir el nombre")
        $("#name").focus();
        return 0;
    }
    if (surname.length == 0) {
        alert("Tiene que escribir el apellido")
        $("#surname").focus();
        return 0;
    }
    if (secondsurname.length == 0) {
        alert("Tiene que escribir el segundo apellido")
        $("#second_surname").focus();
        return 0;
    }
  
    if (email.length == 0) {
        alert("Tiene que escribir el correo electrónico")
        $("#email").focus();
        return 0;
    }

    if (password.length == 0) {
        alert("Tiene que escribir la contraseña")
        $("#password").focus();
        return 0;
    }
    

    if (area.length == 0) {
        alert("Tiene que elegir el área")
        $("#areas").focus();
        return 0;
    }


 

    var expEmail = /^[A-Za-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
    var validEmail = expEmail.test(email);


    if (validEmail == true) {
        $.ajax({
            url: "../../controller/employee/controller_employee.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 2, name: name, surname: surname, secondsurname: secondsurname, email: email, password: password, area: area },
            success: function (result) {
                    window.location.href = "../employee/employee.php";
                }, error: function (result) {
                console.log(result);
                bootbox.confirm({
                    title: "<h4>Error al registrar empleado</h4>",
                    message: "<h5>Ocurrio un error al hacer el registro del empleado. Revisa que el correo electrónico no se encuentre registrado.</h5>",
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
                            window.location.href = "../employee/employee.php";
                        }
                    }
                });
            }
        });
    } else
        bootbox.confirm({
            title: "<h4>Error al registrar empleado</h4>",
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
            callback: function (result) {
                if (result == false) {
                    window.location.href = "../employee/employee.php";
                }
            }
        });
}














function newEmployee() {
    location.href = "../employee/registro_employee.php";
}


$("#exit").click(function() {
    //loader.fadeIn();
    $(".loader").fadeOut("slow");

    setTimeout(function() {
        location.href = "../../index.php";
    }, 1000);
});
    