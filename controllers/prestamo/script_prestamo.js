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
