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
    listAreas();
});

    function listAreas() {

        var matricula=sessionStorage.getItem("matricula")
        $.ajax({
            url: "../../controllers/notificacion_avanze/controller_avanze.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 2 , matricula:matricula },
            success: function(result) {
                console.log(result)
                let i1 = +$('#pf').text();
                var table = "";
                $.each(result, function(index, val) {
                   
                        $('#pf').text(++i1);
                        table += "<tr>" +
                            "<th style='text-align:center'>" + val.name + "</th>" +
                            "<th style='text-align:center'>" + val.details + "</th>" +
                            "<th style='text-align:center'>" + val.estado_liberacion + "</th>" + 
                            "</tr>";
                    
                });
                if (i1 != 0) {
                    $('#table-areas').html(table);
                    $('#alert1').hide();
                }
            },
            error: function(result) {
                console.log(result);
            }
        });
    }




function checkFileExist(urlToFile) {
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD', urlToFile, false);
    xhr.send();
    if (xhr.status == "404") {
        return false;
    } else {
        return true;
    }
}

$("#exit").click(function() {
    $(".loader").fadeOut("slow");
    setTimeout(function() {
        location.href = "../../index.php";
    }, 1000);
});
