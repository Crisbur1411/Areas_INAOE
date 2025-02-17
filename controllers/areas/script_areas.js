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
    $.ajax({
        url: "../../controllers/areas/controller_areas.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 1 },
        success: function(result) {
            let i1 = +$('#pf').text();
            var table = "";
            $.each(result, function(index, val) {
                if (val.status == 1) {
               
                    $('#pf').text(++i1);
                    table += "<tr>" +
                        "<th style='text-align:center'>" + val.id_area + "</th>" +
                        "<th style='text-align:center'>" + val.key + "</th>" +
                        "<th style='text-align:center'>" + val.name + "</th>" +
                            "<th style='text-align:center'>" + val.details + "</th>" +
                            "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='redirigirUpdateArea(\"" + val.key + "\", \"" + val.name + "\", \"" + val.details + "\")'><i class='fas fa-edit'></i></button></th>" +
                            "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' data-id-area='" + val.id_area + "' data-key='" + val.key + "' title='Click para eliminar' onclick='deleteArea(this)'><i class='fas fa-trash'></i></button></th>" +
                        "</tr>";
                }
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

function cancelNewArea(){
    location.href = "../areas/areas.php";
    
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
