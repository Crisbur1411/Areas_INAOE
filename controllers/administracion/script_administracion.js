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
    //loader.fadeOut();
    $(".loader").fadeOut("slow");
    $("#info").removeClass("d-none");
    /*listUser();
    titleListToSign();
    titleListToSign2();
    titleListSign();
    titleListDGP();
    titleListIssue();
    titleListRefused();
    toCancelList();
    titleListToSignCancel();
    readyCancel();
    titleListCancel();*/
            
});

// Document status = 1
function titleListToSign() {
    // console.log("signDocument "+id_documentData);
  $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 1 },
        success: function(result) {
            
            let i1 = +$('#pf').text();
            var table = "";
            $.each(result, function(index, val) {
                //console.log(val);
                if (val.status == 1)
                {
                $('#pf').text(++i1);
                table += "<tr>"       
                + "<th style='text-align:center'>"+val.id_titledata+"</th>"
                + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showRegister("+val.id_titledata+");'>"+val.names+"</a></th>"
                // + "<th><button type='button' class='btn btn-primary btn-sm' id='btn-dw' title='Click para descargar' >"+'<i class="fas fa-download"></i>'+"</button></th>"

                + "<th style='text-align:center'>"+val.course_name+"</th>" 
                + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showHistory("+val.id_titledata+");'>"+val.date+"</a></th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='editRegister("+val.id_titledata+")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' id='btn-details' id-titledata='"+val.id_titledata+"' title='Click para eliminar' onclick='deleteRegister("+val.id_titledata+")'>"+'<i class="fas fa-trash"></i>'+"</button></th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-success btn-sm' id='btn-details' id-titledata='"+val.id_titledata+"' title='Click para turnar a firma'  onclick='turnDocument("+val.id_titledata+")'>"+'<i class="fa-solid fa-file-signature"></i>'+"</button></th>"

                /*+ "<th><button type='button' class='btn btn-secondary w-100' id='btn-details' id-titledata='"+val.id_titledata+"' onclick='details(this)'>EDITAR</button></th>"
                + "<th><button type='button' class='btn btn-danger w-100' id='btn-details' id-titledata='"+val.id_titledata+"' onclick='details(this)'>ELIMINAR</button></th>"
                + "<th><button type='button' class='btn btn-primary w-100' id='btn-details' id-titledata='"+val.id_titledata+"' onclick='details(this)'>DESCARGAR XML</button></th>"*/
                + "</tr>";
                }
            });
            if(i1 != 0){
                $('#table-titles').html(table);
                $('#alert1').hide();
            }
            //console.log(result); 
        }
    }); 
}

function titleListToSign2() {
    // console.log("signDocument "+id_documentData);
  $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 15 },
        success: function(result) {
            let i6 = +$('#pf2').text();
            var table2 = "";
            $.each(result, function(index, val) {
                //console.log(val);
                $('#pf2').text(++i6);
                    table2 += "<tr>"    
                        + "<th style='text-align:center'>"+val.id_titledata+"</th>"                            
                        + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showRegister("+val.id_titledata+");'>"+val.names+"</a></th>" 
                        + "<th style='text-align:center'>"+val.course_name+"</th>"
                        + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showHistory("+val.id_titledata+");'>"+val.date+"</a></th>"
                        + "</tr>";
            });
            if(i6 != 0){
                $('#table-titles2').html(table2);
                $('#alert6').hide();
            }
            //console.log(result);
        }
    }); 
}

// Document status = 3
function titleListSign() {
    
  $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 11 },
        success: function(result) {
            let i2 = +$('#le').text();
            var tabletitlesReadyToShip = "";
            $.each(result, function(index, val) {
                //console.log(val);
                $('#le').text(++i2);
                    tabletitlesReadyToShip += "<tr>"    
                        + "<th style='text-align:center'>"+val.id_titledata+"</th>"                            
                        + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showRegister2("+val.id_titledata+"); '>"+val.names+"</a></th>" 
                        + "<th style='text-align:center'>"+val.course_name+"</th>"
                        + "<th style='text-align:center'>"+val.datedocument+"</th>"
                        + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showHistory("+val.id_titledata+");'>"+val.datesign+"</a></th>"
                        + "<th style='text-align:center'><button type='button' class='btn btn-success btn-sm' title='Click para descargar XML' onClick='generateXMLB("+val.id_titledata+");'><i class='fa-solid fa-download'></i></button></a></th>"
                        + "<th style='text-align:center'><button type='button' class='btn btn-primary btn-sm' id='btn-details' title='Click para enviar documento' onclick='sendDocument("+val.id_titledata+")'><i class='fa-solid fa-paper-plane'></i></button></th>"
                        + "</tr>";
            });
            if(i2 != 0){
                $('#table-titlesReadyToShip').html(tabletitlesReadyToShip);
                $('#alert2').hide();
            }
            //console.log (result)             
        }
    }); 
}

// Document status = 4
function titleListDGP() {
    
  $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 12 },
        success: function(result) {
            let i3 = +$('#er').text();
            var tabletitlesReview = "";
            $.each(result, function(index, val) {
                //console.log(val);
                $('#er').text(++i3);
                tabletitlesReview += "<tr>"    
                    + "<th style='text-align:center'>"+val.id_titledata+"</th>"                            
                    + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showRegister2("+val.id_titledata+");'>"+val.names+"</a></th>" 
                    + "<th style='text-align:center'>"+val.course_name+"</th>"
                    + "<th style='text-align:center'>"+val.datedocument+"</th>"
                    + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showHistory("+val.id_titledata+");'>"+val.datedgp+"</a></th>"
                    + "<th style='text-align:center'><button type='button' class='btn btn-success btn-sm' title='Click para descargar ZIP' onClick='descargaTitulo("+val.id_titledata+");'><i class='fa-solid fa-download'></i></button></a></th>"
                    + "<th style='text-align:center'><button type='button' class='btn btn-primary btn-sm' data-toggle='modal' onClick='consult("+val.id_titledata+"); ' title='Click para ver estatus' ><i class='fa-solid fa-eye'></i></button></th>"
                    + "</tr>";
            });
            if(i3 != 0){
                $('#table-titlesReview').html(tabletitlesReview);
                $('#alert3').hide();
            }
           //console.log (result)             
        },error: function(result){
            //console.log(result);
        }
    }); 
}



// Document status = 5
function titleListIssue() {
    
  $.ajax({ 
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 13 },
        success: function(result) {
            let i5 = +$('#em').text();
            var tabletitlesCast = "";
            $.each(result, function(index, val) {
                //console.log(val);
                $('#em').text(++i5);
                    tabletitlesCast += "<tr>"    
                        + "<th style='text-align:center'>"+val.id_titledata+"</th>"                            
                        + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showRegister2("+val.id_titledata+");'>"+val.names+"</a></th>" 
                        // + "<th style='text-align:center'><button type='button' class='btn btn-primary btn-sm' title='Click para subir fotografia del egresado' onClick='photograph("+val.id_titledata+",\""+val.names+"\");'><i class='fa-solid fa-user'></i></button></a></th>"
                        + "<th style='text-align:center'>"+val.course_name+"</th>"
                        + "<th style='text-align:center'>"+val.datedocument+"</th>"
                        + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showHistory("+val.id_titledata+");'>"+val.dateissue+"</a></th>"
                        + "<th style='text-align:center'><button type='button' class='btn btn-success btn-sm' title='Click para descargar XML' onClick='generateXMLB("+val.id_titledata+");'><i class='fa-solid fa-download'></i></button></a></th>"
                        + "<th style='text-align:center'><button type='button' class='btn btn-primary btn-sm' title='Click para imprimir el título' onClick='print("+val.id_titledata+");'><i class='fa-solid fa-print'></i></button></a></th>"
                        + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm'  title='Click para iniciar proceso de cancelación' onClick='toCancel("+val.id_titledata+");'><i class='fa-solid fa-cancel'></i></button></a></th>"
                        + "</tr>";
            });
            if(i5 != 0){
                $('#table-titlesCast').html(tabletitlesCast);
                $('#alert5').hide();
            } 
           //console.log (result)           
        }
    });  
}



// Document status = 6
function titleListRefused() {
    
  $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 14 },
        success: function(result) {
            //console.log(result);
            let i4 = +$('#re').text();
            var tabletitlesRejected = "";
            $.each(result, function(index, val) { 
               // console.log(val);
                $('#re').text(++i4);
                    tabletitlesRejected += "<tr>"    
                        + "<th style='text-align:center'>"+val.id_titledata+"</th>"                            
                        + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showRegister2("+val.id_titledata+");'>"+val.names+"</a></th>" 
                        + "<th style='text-align:center'>"+val.course_name+"</th>"
                        + "<th style='text-align:center'>"+val.datedocument+"</th>"
                        + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showHistory("+val.id_titledata+");'>"+val.daterefused+"</a></th>"
                        + "<th style='text-align:center'><button type='button' class='btn btn-primary btn-sm' title='Click para ver motivos' data-toggle='modal' onClick='showDetailsDGP("+val.id_titledata+");' ><i class='fa-solid fa-eye'></i></button></th>"
                        + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' title='Click para volver a registrar' data-toggle='modal' onClick='restore("+val.id_titledata+");' ><i class='fa-solid fa-rotate-left'></i></button></th>"
                        + "<th style='text-align:center'><button type='button' class='btn btn-success btn-sm' title='Click para volver a enviar' data-toggle='modal' onClick='goTitleListSign("+val.id_titledata+");' ><i class='fa-solid fa-paper-plane'></i></button></th>"
                        + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' title='Click para eliminar el registro' onClick='deleteRegister("+val.id_titledata+");'><i class='fas fa-trash'></i></button></a></th>"
                        + "</tr>";
            });
            if(i4 != 0){
                $('#table-titlesRejected').html(tabletitlesRejected);
                $('#alert4').hide();
            }
           //console.log (result)          
        }
    }); 
} 


// Document status = 1
function titleListToSign() {
    // console.log("signDocument "+id_documentData);
  $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 1 },
        success: function(result) {
            
            let i1 = +$('#pf').text();
            var table = "";
            $.each(result, function(index, val) {
                //console.log(val);
                if (val.status == 1)
                {
                $('#pf').text(++i1);
                table += "<tr>"       
                + "<th style='text-align:center'>"+val.id_titledata+"</th>"
                + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showRegister("+val.id_titledata+");'>"+val.names+"</a></th>"
                // + "<th><button type='button' class='btn btn-primary btn-sm' id='btn-dw' title='Click para descargar' >"+'<i class="fas fa-download"></i>'+"</button></th>"

                + "<th style='text-align:center'>"+val.course_name+"</th>" 
                + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showHistory("+val.id_titledata+");'>"+val.date+"</a></th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='editRegister("+val.id_titledata+")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' id='btn-details' id-titledata='"+val.id_titledata+"' title='Click para eliminar' onclick='deleteRegister("+val.id_titledata+")'>"+'<i class="fas fa-trash"></i>'+"</button></th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-success btn-sm' id='btn-details' id-titledata='"+val.id_titledata+"' title='Click para turnar a firma'  onclick='turnDocument("+val.id_titledata+")'>"+'<i class="fa-solid fa-file-signature"></i>'+"</button></th>"

                /*+ "<th><button type='button' class='btn btn-secondary w-100' id='btn-details' id-titledata='"+val.id_titledata+"' onclick='details(this)'>EDITAR</button></th>"
                + "<th><button type='button' class='btn btn-danger w-100' id='btn-details' id-titledata='"+val.id_titledata+"' onclick='details(this)'>ELIMINAR</button></th>"
                + "<th><button type='button' class='btn btn-primary w-100' id='btn-details' id-titledata='"+val.id_titledata+"' onclick='details(this)'>DESCARGAR XML</button></th>"*/
                + "</tr>";
                }
            });
            if(i1 != 0){
                $('#table-titles').html(table);
                $('#alert1').hide();
            }
            //console.log(result); 
        }
    }); 
}
// ----------------------------------CANCELACION--------------------------------------------------

// -----------------------------------------------------------------------------------------------


// Document status = 10
function toCancelList() {

  $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 35 },
        success: function(result) {
            // console.log("toCancelList "+result);
            let i1 = +$('#a1').text();
            var table = "";
            $.each(result, function(index, val) {
                //console.log(val);
                if (val.status == 10)
                {
                $('#a1').text(++i1);
                table += "<tr>"       
                + "<th style='text-align:center'>"+val.id_titledata+"</th>"
                + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showRegister("+val.id_titledata+");'>"+val.names+"</a></th>"
                + "<th style='text-align:center'>"+val.course_name+"</th>" 
                + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showHistory("+val.id_titledata+");'>"+val.date+"</a></th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' data-toggle='modal' id='btn-m' title='Click para agregar motivo' onclick='confirmCancel("+val.id_titledata+")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                // + "<th style='text-align:center'><button type='button' class='btn btn-success btn-sm' id='btn-details' id-titledata='"+val.id_titledata+"' title='Click para turnar a firma para cancelar'  onclick='turnSingDocumentCancel("+val.id_titledata+")'>"+'<i class="fa-solid fa-file-signature"></i>'+"</button></th>"
                + "</tr>";
                }
                if (val.status == 15)
                {
                $('#a1').text(++i1);
                table += "<tr>"       
                + "<th style='text-align:center'>"+val.id_titledata+"</th>"
                + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showRegister("+val.id_titledata+");'>"+val.names+"</a></th>"
                + "<th style='text-align:center'>"+val.course_name+"</th>" 
                + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showHistory("+val.id_titledata+");'>"+val.date+"</a></th>"
                // + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' data-toggle='modal' id='btn-m' title='Click para agregar motivo' onclick='confirmCancel("+val.id_titledata+")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                + "<th style='text-align:center'><button type='button' class='btn btn-success btn-sm' id='btn-details' id-titledata='"+val.id_titledata+"' title='Click para turnar a firma para cancelar'  onclick='turnSingDocumentCancel("+val.id_titledata+")'>"+'<i class="fa-solid fa-file-signature"></i>'+"</button></th>"
                + "</tr>";
                }
            });
            if(i1 != 0){
                $('#table-to-cancel').html(table);
                $('#alert-cancel').hide();
            }
            //console.log(result); 
        }
    }); 
}

// Document status = 20
function titleListToSignCancel() {
  // console.log("titleListToSignCancel "+id_documentData);
  $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 38 },
        success: function(result) {
            
            let i1 = +$('#a2').text();
            var table = "";
            $.each(result, function(index, val) {
                // console.log(val);
                if (val.status == 20)
                {
                $('#a2').text(++i1);
                table += "<tr>"       
                + "<th style='text-align:center'>"+val.id_titledata+"</th>"
                + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showRegister("+val.id_titledata+");'>"+val.names+"</a></th>"
                // + "<th><button type='button' class='btn btn-primary btn-sm' id='btn-dw' title='Click para descargar' >"+'<i class="fas fa-download"></i>'+"</button></th>"

                + "<th style='text-align:center'>"+val.course_name+"</th>" 
                + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showHistory("+val.id_titledata+");'>"+val.date+"</a></th>"
                // + "<th style='text-align:center'><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='editRegister("+val.id_titledata+")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                // + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' id='btn-details' id-titledata='"+val.id_titledata+"' title='Click para eliminar' onclick='deleteRegister("+val.id_titledata+")'>"+'<i class="fas fa-trash"></i>'+"</button></th>"
                // + "<th style='text-align:center'><button type='button' class='btn btn-success btn-sm' id='btn-details' id-titledata='"+val.id_titledata+"' title='Click para turnar a firma'  onclick='turnDocument("+val.id_titledata+")'>"+'<i class="fa-solid fa-file-signature"></i>'+"</button></th>"

                /*+ "<th><button type='button' class='btn btn-secondary w-100' id='btn-details' id-titledata='"+val.id_titledata+"' onclick='details(this)'>EDITAR</button></th>"
                + "<th><button type='button' class='btn btn-danger w-100' id='btn-details' id-titledata='"+val.id_titledata+"' onclick='details(this)'>ELIMINAR</button></th>"
                + "<th><button type='button' class='btn btn-primary w-100' id='btn-details' id-titledata='"+val.id_titledata+"' onclick='details(this)'>DESCARGAR XML</button></th>"*/
                + "</tr>";
                }
            });
            if(i1 != 0){
                $('#table-cancelF').html(table);
                $('#alert-cancel2').hide();
            }
            // console.log(result); 
        }
    }); 
}


// Document status = 30
function readyCancel() {
    
  $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 41 },
        success: function(result) {
            let i3 = +$('#a3').text();
            var titlesReadyToShipCancel = "";
            $.each(result, function(index, val) {
                //console.log(val);
                $('#a3').text(++i3);
                titlesReadyToShipCancel += "<tr>"    
                    + "<th style='text-align:center'>"+val.id_titledata+"</th>"                            
                    + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showRegister2("+val.id_titledata+");'>"+val.names+"</a></th>" 
                    + "<th style='text-align:center'>"+val.course_name+"</th>"
                    + "<th style='text-align:center'>"+val.datedocument+"</th>"
                    + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showHistory("+val.id_titledata+");'>"+val.datesignc+"</a></th>"
                    + "<th style='text-align:center'><button type='button' class='btn btn-danger btn-sm' title='Click para realizar CANCELACIÓN' onClick='confirmCancelDGP("+val.id_titledata+");'><i class='fa-solid fa-cancel'></i></button></a></th>"
                    + "</tr>";
            });
            if(i3 != 0){
                $('#table-titlesReadyToShipCancel').html(titlesReadyToShipCancel);
                $('#alert-cancel3').hide();
            }
           //console.log (result)             
        },error: function(result){
            //console.log(result);
        }
    }); 
}


// Document status = 50
function titleListCancel() {
    
  $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 44 },
        success: function(result) {
            console.log("titleListCancel"+result);
            let c4 = +$('#a4').text();
            var titlesReviewCancel = "";
            $.each(result, function(index, val) {
                // console.log(val);
                $('#a4').text(++c4);
                titlesReviewCancel += "<tr>"    
                    + "<th style='text-align:center'>"+val.id_titledata+"</th>"                            
                    + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showRegister2("+val.id_titledata+");'>"+val.names+"</a></th>" 
                    + "<th style='text-align:center'>"+val.course_name+"</th>"
                    + "<th style='text-align:center'>"+val.details+"</th>"
                    + "<th style='text-align:center'><a href='#'  data-toggle='modal' onClick='showHistory("+val.id_titledata+");'>"+val.datesignc+"</a></th>"
                    + "<th style='text-align:center'><button type='button' class='btn btn-success btn-sm' title='Click para descargar archivos' onClick='printPDFCancel("+val.id_titledata+");'><i class='fa-solid fa-download'></i></button></a></th>"

                    + "</tr>";
            });
            if(c4 != 0){
                $('#table-titlesReviewCancel').html(titlesReviewCancel);
                $('#alert-cancel4').hide();
            }
           //console.log (result)             
        },error: function(result){
            //console.log(result);
        }
    }); 
}

// -----------------------------------------------------------------------------------------------









  


















































/*##########################################  REGISTRAR HISTORIAL ###################################################################################*/ 

//REGISTRO DE DESCARGA

function traceDownload($id_titledata, controlinvoice) {
    $u = document.getElementById("user");
    $user = $u.innerHTML;
    //console.log("turnargn: "+$id_titledata+"controlinvoice: "+controlinvoice);
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 22, id_titledata: $id_titledata, controlinvoice: controlinvoice, user: $user},
        success: function(result) {
            //console.log(result);             
        }, error: function(result){
            //console.log(result);
        }
    }); 
}

// REGISTRO ENVIAR DOCUMENTO A LA DGP
function traceSendDocument($id_titledata, controlinvoice, numeroLote) {
    $u = document.getElementById("user");
    $user = $u.innerHTML;
    //console.log("turnargn: "+$id_titledata+"controlinvoice: "+controlinvoice);
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 17, id_titledata: $id_titledata, controlinvoice: controlinvoice, numeroLote: numeroLote, user:$user},
        success: function(result) {
            location.reload();
            $(".loader").fadeOut("slow");
            //console.log(result);             
        }, error: function(result){
            //console.log(result);
        }
    }); 
}

//REGISTRO TURNAR A FIRMA
function turnSign($id_titledata, controlinvoice) {
    $u = document.getElementById("user");
    $user = $u.innerHTML;
    //console.log("turnargn: "+$id_titledata+"controlinvoice: "+controlinvoice);
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 7, id_titledata: $id_titledata, controlinvoice: controlinvoice, user:$user},
        success: function(result) {
            location.reload();
            $(".loader").fadeOut("slow"); 
            //console.log(result);             
        }
    }); 
}

//REGISTRO ELIMINAR REGISTRO
function deleteDocument ($id_titledata, controlinvoice) {
    $u = document.getElementById("user");
    $user = $u.innerHTML;
    // console.log("turnargn: "+$id_titledata+"controlinvoice: "+controlinvoice);
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 5, id_titledata: $id_titledata, controlinvoice: controlinvoice, user:$user},
        success: function(result) {
            // console.log(result);             
        },complete: function () {
        //loader.fadeOut();
        location.reload();
        $(".loader").fadeOut("slow");
        }
    }); 
}

//REGISTRAR CONSULTA  
function traceConsult (id_titledata, controlinvoice) {
    $u = document.getElementById("user");
    $user = $u.innerHTML;
    // console.log("turnargn: "+$id_titledata+"controlinvoice: "+controlinvoice);
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 25, id_titledata: id_titledata, controlinvoice: controlinvoice, user:$user},
        success: function(result) {
             //console.log(result);             
        },complete: function () {
        
        }
    }); 
}

//REGISTRAR CONSULTA  
function traceDownloadTitle (id_titledata, controlinvoice) {
    // console.log("turnargn: "+$id_titledata+"controlinvoice: "+controlinvoice);
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 28, id_titledata: id_titledata, controlinvoice: controlinvoice},
        success: function(result) {
             //console.log(result);             
        },complete: function () {
        
        }
    }); 
}

//EMITIR RECHAZAR
function traceUpdateRechazar($id_titledata, controlinvoice, msg) {
    //console.log("turnargn: "+$id_titledata+"controlinvoice: "+controlinvoice);
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 30, id_titledata: $id_titledata, controlinvoice: controlinvoice, msg: msg},
        success: function(result) {
            location.reload();
            $(".loader").fadeOut("slow"); 
            //console.log(result);             
        }
    }); 
}

function traceUpdateEmitir($id_titledata, controlinvoice, msg) {
    //console.log("turnargn: "+$id_titledata+"controlinvoice: "+controlinvoice);
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 28, id_titledata: $id_titledata, controlinvoice: controlinvoice, msg: msg},
        success: function(result) {
            location.reload();
            $(".loader").fadeOut("slow"); 
            //console.log(result);             
        }
    }); 
}

//REGISTRAR CONSULTA  
function traceToCancel (id_titledata, controlinvoice) {
    // console.log("traceToCancel");  
    $u = document.getElementById("user");
    $user = $u.innerHTML;
    // console.log("traceToCancel");
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 34, id_titledata: id_titledata, controlinvoice: controlinvoice, user:$user},
        success: function(result) {
                        
        },complete: function () {
        
        }
    }); 
}

//REGISTRO TURNAR A FIRMA CANCELAR
function traceTurnSignCancel ($id_titledata, controlinvoice) {
    $u = document.getElementById("user");
    $user = $u.innerHTML;
    //console.log("turnargn: "+$id_titledata+"controlinvoice: "+controlinvoice);
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 37, id_titledata: $id_titledata, controlinvoice: controlinvoice, user:$user},
        success: function(result) {
            location.reload();
            $(".loader").fadeOut("slow"); 
            //console.log(result);             
        }
    }); 
}

//REGISTRO TURNAR A FIRMA CANCELAR
function traceTitleListCancel ($id_titledata, controlinvoice) {
    $u = document.getElementById("user");
    $user = $u.innerHTML;
    //console.log("turnargn: "+$id_titledata+"controlinvoice: "+controlinvoice);
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 37, id_titledata: $id_titledata, controlinvoice: controlinvoice, user:$user},
        success: function(result) {
            location.reload();
            $(".loader").fadeOut("slow"); 
            //console.log(result);             
        }
    }); 
}


function traceCancelDGP ($id_titledata, controlinvoice) {
    $u = document.getElementById("user");
    $user = $u.innerHTML;
    //console.log("turnargn: "+$id_titledata+"controlinvoice: "+controlinvoice);
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 48, id_titledata: $id_titledata, controlinvoice: controlinvoice, user:$user},
        success: function(result) {
            location.reload();
            $(".loader").fadeOut("slow"); 
            //console.log(result);             
        }
    }); 
}

































/* ######################################################  CAMBIOS DE ESTATUS     ############################################################################### */


//ACTUALIZAR STATUS==0

function deleteRegister(id_titledata) {
    
    swal({
        title: "ELIMINAR REGISTRO",
        text: "¿Estás seguro de que deseas eliminar el registro?",
        icon: "warning",
        buttons: {
            cancel: "Cancelar",
            Aceptar: true,
          },
      })
      .then((deleteDoc) => {
        if (deleteDoc) {
            $.ajax({
                url: "../../controllers/administracion/controller_administracion.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 4, id_titledata: id_titledata},
                success: function(result) {
                    //console.log(result);
                    var $aux = result;
                    deleteDocument(id_titledata, $aux);
                }
            });
            
          swal("Registro Eliminado!", {
            icon: "success",
          });
        } else {
        }
      });
}

//ACTUALIZAR STATUS==2

function turnDocument(id_titledata) {
    // console.log("signDocument "+id_documentData);
    swal({
        title: "TURNAR A FIRMA",
        text: "¿Estás seguro de que deseas turnar a firma el documento? ... Ya no podrás realizar ninguna modificación",
        icon: "info",
        buttons: {
            cancel: "Cancelar",
            Enviar: true,
          },
      })
      .then((sendDoc) => {
        if (sendDoc) {
            $.ajax({
                url: "../../controllers/administracion/controller_administracion.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 6, id_titledata: id_titledata},
                success: function(result) {
                    //console.log(result);
                    var $aux = result;
                    turnSign(id_titledata, $aux);
                },complete: function () {
                //loader.fadeOut();
                $(".loader").fadeOut("slow");
                    $("#info").removeClass("d-none");
                    titleListToSign();
                    titleListSign();
                    titleListDGP();
                    titleListIssue();
                    titleListRefused(); 
                }
                
            });
            
          swal("Turnado a firma!", {
            icon: "success",
          });
        } else {
        }
      });
}

// ACTUALIZAR STATUS == 4

function updateSystem(id_titledata,$numeroLote){
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 16, id_titledata: id_titledata},
        success: function(result) {
            //console.log(result);
            var $aux = result;
            traceSendDocument(id_titledata, $aux, $numeroLote); 
        },complete: function () {
        loader.fadeOut();
        $(".loader").fadeOut("slow");
        $("#info").removeClass("d-none");
            titleListToSign();
            titleListSign();
            titleListDGP();
            titleListIssue();
            titleListRefused();
        }
        
    });

}

//ACTUALIZAR STATUS=5

function emitir(id_titledata, $msg) {
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 24, id_titledata: id_titledata},
        success: function(result) {
            //console.log(result);
            var $aux = result;
            traceUpdateEmitir(id_titledata, $aux, $msg);
        }
        
    });         
}

//ACTUALIZAR STATUS=6
function rechazar(id_titledata,$msg) {
    console.log($msg);
    
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 29, id_titledata: id_titledata},
        success: function(result) {
            console.log(result);
            var $aux = result;
            traceUpdateRechazar(id_titledata, $aux, $msg);
        }
        
    });      
}

function confirmCancel(id_titledata) {

    swal("Espere un momento!", {
        buttons: false,
        timer: 1000,
      });
    $.ajax({
           url: "../../controllers/administracion/controller_administracion.php",
           cache: false,
           dataType: 'JSON',
           type: 'POST',
           data: { action: 23, id_titledata: id_titledata},
           success: function(result) {
               console.log(result);
               var data=result[0];
               var controlinvoice=data.controlinvoice;      
               $('#mcancel').modal();
               var modal = $('#mcancel');
               modal.find('.mcancelTitle').text('Cancelación  ');
               $('#folioM').text(data.controlinvoice); 
               $('#folioM').val(data.controlinvoice); 
               $('#loteM').text(data.lote); 
               $('#id_titledata').val(id_titledata); 
           }                    
       });         
}

function confirmCancelOk() {
    var motivo = document.getElementById("motivoTxt").value;
    var motivoDGP = document.getElementById("motivoTxtDGP").value;
    var id_titledata = document.getElementById("id_titledata").value;
    var controlinvoice = document.getElementById("folioM").value;
    $u = document.getElementById("user");
    $user = $u.innerHTML;

    swal("Espere un momento!", {
        buttons: false,
        timer: 1000,
      });

    console.log(controlinvoice);
    $.ajax({
           url: "../../controllers/administracion/controller_administracion.php",
           cache: false,
           dataType: 'JSON',
           type: 'POST',
           data: { action: 42, id_titledata: id_titledata},
           success: function(result) {
               // console.log("confirmCancelOk1->"+result);
               $.ajax({
                   url: "../../controllers/administracion/controller_administracion.php",
                   cache: false,
                   dataType: 'JSON',
                   type: 'POST',
                   data: { action: 43, id_titledata: id_titledata, controlinvoice: controlinvoice,  motivo: motivo,  motivoDGP: motivoDGP, user:$user},
                   success: function(result) {
                       // console.log("confirmCancelOk2->"+result);
                       location.reload();
                   }                    
               });  
           }                    
       });    
}

function confirmCancelDGP(id_titledata) {

    swal("Espere un momento!", {
        buttons: false,
        timer: 1000,
      });
    $.ajax({
           url: "../../controllers/administracion/controller_administracion.php",
           cache: false,
           dataType: 'JSON',
           type: 'POST',
           data: { action: 23, id_titledata: id_titledata},
           success: function(result) {
               console.log(result);
               var data=result[0];
               var controlinvoice=data.controlinvoice;      
               $('#mcancelDGP').modal();
               var modal = $('#mcancelDGP');
               modal.find('.mcancelTitle').text('Cancelación  ');
               $('#folioCDGP').text(data.controlinvoice); 
               $('#folioCDGP').val(data.controlinvoice); 
               $('#loteCDGP').text(data.lote); 
               $('#id_titledata').val(id_titledata); 
           }                    
       });         
}

function confirmCancelDGPOk() {
    var dateDGP = document.getElementById("dateDGP").value;
    var dDGP = document.getElementById("dDGP").value;

    console.log(dateDGP);
    var id_titledata = document.getElementById("id_titledata").value;
    var controlinvoice = document.getElementById("folioCDGP").value;
    $u = document.getElementById("user");
    $user = $u.innerHTML;

    swal("Espere un momento!", {
        buttons: false,
        timer: 1000,
      });

    console.log(controlinvoice);
    $.ajax({
           url: "../../controllers/administracion/controller_administracion.php",
           cache: false,
           dataType: 'JSON',
           type: 'POST',
           data: { action: 45, id_titledata: id_titledata},
           success: function(result) {
               // console.log("confirmCancelOk1->"+result);
               $.ajax({
                   url: "../../controllers/administracion/controller_administracion.php",
                   cache: false,
                   dataType: 'JSON',
                   type: 'POST',
                   data: { action: 46, id_titledata: id_titledata, controlinvoice: controlinvoice,  dateDGP: dateDGP,  dDGP: dDGP, user:$user},
                   success: function(result) {
                       // console.log("confirmCancelOk2->"+result);
                       location.reload();
                   }                    
               });  
           }                    
       });    
}


//ACTUALIZAR STATUS=10
function toCancel(id_titledata) {

    swal({
        title: "INICIAR PROCESO DE CANCELACIÓN",
        text: "¿Estás seguro de que deseas iniciar el proceso?",
        icon: "info",
        buttons: {
            cancel: "Cancelar", 
            Enviar: true, 
          },
      })
      .then((sendDoc) => { 
        if (sendDoc) {    
            $.ajax({
                url: "../../controllers/administracion/controller_administracion.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 33, id_titledata: id_titledata},
                success: function(result) {
                    // console.log("OK->"+result);
                    var $aux = result;
                    traceToCancel(id_titledata, $aux);
                },complete: function () {
                    location.reload();
                    loader.fadeOut();
                    $(".loader").fadeOut("slow");
                    $("#info").removeClass("d-none");
                        titleListToSignCancel();
                    }
                
            }); 
            swal("Turnado a proceso de cancelación!", {
            icon: "success",
          });            
        } else {
        }
      });         
}

//ACTUALIZAR STATUS=20
function turnSingDocumentCancel(id_titledata) {
    console.log("turnSingDocumentCancel "+id_titledata);
    swal({
        title: "TURNAR A FIRMA",
        text: "¿Estás seguro de que deseas turnar a firma el documento? ... Ya no podrás realizar ninguna modificación",
        icon: "info",
        buttons: {
            cancel: "Cancelar",
            Enviar: true,
          },
      })
      .then((sendDoc) => {
        if (sendDoc) {
            $.ajax({
                url: "../../controllers/administracion/controller_administracion.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 36, id_titledata: id_titledata},
                success: function(result) {
                    console.log(result);
                    var $aux = result;
                    traceTurnSignCancel(id_titledata, $aux);
                },complete: function () {
                //loader.fadeOut();
                $(".loader").fadeOut("slow");
                    $("#info").removeClass("d-none");
                    titleListToSignCancel();
                }
                
            });
            
          swal("Turnado a firma!", {
            icon: "success",
          });
        } else {
        }
      });
}

//ACTUALIZAR STATUS=50
function cancelDGP(id_titledata) {
    console.log("cancelDGPOk "+id_titledata);
    swal({
        title: "CANCELAR TÍTULO",
        text: "¿Estás seguro de que deseas cancelar este documento? ... Una vez realizada la acción ya no se puede revertir",
        icon: "info",
        buttons: {
            cancel: "Cancelar",
            Enviar: true,
          },
      })
      .then((sendDoc) => {
        if (sendDoc) {
            $.ajax({
                url: "../../controllers/administracion/controller_administracion.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: { action: 45, id_titledata: id_titledata},
                success: function(result) {
                    console.log(result);
                    var $aux = result;
                    // traceTurnSignCancel(id_titledata, $aux);
                    traceCancelDGP(id_titledata, $aux);
                },complete: function () {
                //loader.fadeOut();
                $(".loader").fadeOut("slow");
                    $("#info").removeClass("d-none");
                    titleListToSignCancel();
                }
                
            });
            
          swal("Turnado a firma!", {
            icon: "success",
          });
        } else {
        }
      });
}

/* #######################################################   LLAMADOS A LA DGP              ###################################################################### */

//CARGAR DOCUMENTO

function sendDocument(id_titledata) {
    swal("Espere un momento!", {
        buttons: false,
        timer: 3000,
      });
    //console.log(id_titledata);
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 21, id_titledata: id_titledata},
        success: function(result) {
            //console.log(result);
            $control = result[0];
            $folio = $control.controlinvoice;
            $arr = result[0];
            $cad = $arr.date
            $cadenaSeparar = $cad.split(" ")
            $fecha = $cadenaSeparar[0];
            $hora = $cadenaSeparar[1];
            $cadHora  = $hora.split(":");
            $nameFile = $folio+"_"+$fecha+"_"+$cadHora[0]+"_"+$cadHora[1]+"_"+$cadHora[2]+".xml"
            //console.log($nameFile);
            var result = checkFileExist("http://titulo-electronico.org.mx/inaoe/res/xml/"+$nameFile);
            if (result == true) {
                //existe
                swal({
                    title: "ENVIAR DOCUMENTO",
                    text: "¿Estás seguro de que deseas enviar el documento?",
                    icon: "info",
                    buttons: {
                        cancel: "Cancelar", 
                        Enviar: true, 
                      },
                  })
                  .then((sendDoc) => { 
                    if (sendDoc) {
                        //Llamada a DGP
                        swal("Espere un momento!", {
                            buttons: false,
                            
                          });
                        var route=$nameFile;
                        var dataString = 'route='+route;
                        $.ajax({
                            type: "POST",
                            url: "../../controllers/administracion/cargar.php",
                            data: dataString,
                            success: function(result) {
                                //console.log(result);
                                if(result==false || result=='false' || result=="false" ){
                                    swal("A currido un error!", {
                                        icon: "warning",
                                      });
                                }else{
                                    $numeroLote=result.numeroLote;
                                    $msg=result.mensaje;
                                    updateSystem(id_titledata,$numeroLote);
                                }
                            },error: function (result)
                             { 
                                //console.log(result);
                            }
                        });
                    } else {
                    }
                  });
            } else {
                //no existe
                swal("El archivo no existe! Favor de descargar para generar", {
                    icon: "warning",
                  });
            }
            //console.log($nameFile);
            },complete: function () {
        
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







//CONSULTA LOTE


function consult(id_titledata) {
    //console.log("VER REGISTRO"+id_titledata);
    swal("Espere un momento!", {
        buttons: false,
        timer: 1000,
      });
    $.ajax({
           url: "../../controllers/administracion/controller_administracion.php",
           cache: false,
           dataType: 'JSON',
           type: 'POST',
           data: { action: 23, id_titledata: id_titledata},
           success: function(result) {
               //console.log(result);
               var data=result[0];
               var lote = data.lote;
               var controlinvoice=data.controlinvoice;
               var dataString = 'lote='+lote;
               $.ajax({
                url: "../../controllers/administracion/consult.php",
                type: 'POST',
                data: dataString,
                success: function(result) {
                    //console.log(result);
                    $('#exampleModal').modal();
                    var modal = $('#exampleModal')
                    modal.find('.modal-title').text('Consulta Proceso')
                    $('#loteR').text(result.numeroLote);
                    $('#statusR').text(result.estatusLote);
                    $('#msgR').text(result.mensaje);
                    traceConsult(id_titledata, controlinvoice);
                }                   
            });   
           }                    
       });     
   }







   function descargaTitulo(id_titledata) {
    //console.log("VER REGISTRO"+id_titledata);
    swal("Espere un momento!", {
        buttons: false,
        timer: 2000,
      });
    $.ajax({
           url: "../../controllers/administracion/controller_administracion.php",
           cache: false,
           dataType: 'JSON',
           type: 'POST',
           data: { action: 23, id_titledata: id_titledata},
           success: function(result) {
               //console.log(result);
               var data=result[0];
               var lote = data.lote;

               var dataString = 'lote='+lote;
               $.ajax({
                url: "../../controllers/administracion/download.php",
                type: 'POST',
                data: dataString,
                success: function(result) {
                    //console.log(result);
                    $msg=result[2];
                    if(result[1]==1 || result[1]=='1' ){
                        swal($msg, {
                            icon: "success",
                        });
                        emitir(id_titledata,$msg);
                    }if(result[1]==2 || result[1]=='2' ){
                        swal("Documento rechazado por la DGP", {
                            icon: "warning",
                        });
                        rechazar(id_titledata,$msg);
                        
                    }
                    
                },error: function (result)
                { 
                  // console.log(result);
               }                  
            });   
           }                    
       });     
   }


   /* #########################################################    SHOWS MODALES           ############################################################################## */







   function showRegister(id_titledata) {
    
    // console.log("VER REGISTRO"+id_titledata);
    $.ajax({
           url: "../../controllers/administracion/controller_administracion.php",
           cache: false,
           dataType: 'JSON',
           type: 'POST',
           data: { action: 9, id_titledata: id_titledata},
           success: function(result) {
               //console.log(result);  
               $('#exampleModalCenter').modal();
               var modal = $('#exampleModalCenter')
               modal.find('.modal-title').text('Detalles del Alumno')
               //datos personales
               $('#name1').val((result[0].professional_name)+' '+(result[0].professional_surname)+" "+(result[0].professional_secondsurname));
               $('#curp1').val(result[0].professional_curp);
               $('#email').val(result[0].professional_email);
               $('#controlinvoice').val(result[0].controlinvoice);
               
               //datos carrera
               $('#name_i').val(result[0].institution_nameinstitution);
               $('#course_name').val(result[0].course_name);
               $('#course_reconnaissanceauthorization').val(result[0].course_reconnaissanceauthorization);
               $('#course_startdate').val(result[0].course_startdate.split(" ")[0]);
               $('#course_finishdate').val(result[0].course_finishdate.split(" ")[0]);
               
               //Datos de expedición
               $('#expedition_date').val(result[0].expedition_date.split(" ")[0]);
               $('#expedition_degreemodality').val(result[0].expedition_degreemodality);

               /*########################################################## CAMBIO 12/09/22  ######################################################################################## */


               if(result[0].expedition_iddegreemodality==2){
                document.getElementById("exam").style.display = 'none';  
               document.getElementById("exencion").style.display = '';
               
               $('#exencion_date').val(result[0].expedition_dateprofessionalexam.split(" ")[0]);
               }
               if(result[0].expedition_iddegreemodality==1){
                document.getElementById("exencion").style.display = 'none';
                document.getElementById("exam").style.display = ''; 
                $('#expedition_dateprofessionalexam').val(result[0].expedition_dateprofessionalexam.split(" ")[0]);
                }

                /*################################################################################################################################################## */



               $('#expedition_state').val(result[0].expedition_state);      
               var ss = result[0].expedition_socialservice;
               if(ss == 0){
                $('#expedition_socialservice').val('NO APLICA');
               }
               $('#expedition_legalbasissocialservice').val(result[0].expedition_legalbasissocialservice);
               //Antecedentes    
               $('#antecedent_institutionorigin').val(result[0].antecedent_institutionorigin);
               $('#antecedent_typestudy').val(result[0].antecedent_typestudy);
               $('#antecedent_document').val(result[0].antecedent_document);
               $('#antecedent_finishdate').val(result[0].antecedent_finishdate.split(" ")[0]);
               $('#antecedent_state').val(result[0].antecedent_state);
               $('#titledata').text('Descargar XML de '+result[0].professional_name);
               $('#id_titledata').val(result[0].id_titledata);
              
           }                    
       });     
   }

   

   function showRegister2(id_titledata) {
    // console.log("VER REGISTRO"+id_titledata);
    $.ajax({
           url: "../../controllers/administracion/controller_administracion.php",
           cache: false,
           dataType: 'JSON',
           type: 'POST',
           data: { action: 9, id_titledata: id_titledata},
           success: function(result) {
               //console.log(result);  
               $('#exampleModalCenter2').modal();
               var modal = $('#exampleModalCenter2')
               modal.find('.modal-title').text('Detalles del Alumno')
               //datos personales
               $('#name2').val((result[0].professional_name)+' '+(result[0].professional_surname)+" "+(result[0].professional_secondsurname));
               $('#curp2').val(result[0].professional_curp);
               $('#email2').val(result[0].professional_email);
               $('#controlinvoice2').val(result[0].controlinvoice);
               
               //datos carrera
               $('#name_i2').val(result[0].institution_nameinstitution);
               $('#course_name2').val(result[0].course_name);
               $('#course_reconnaissanceauthorization2').val(result[0].course_reconnaissanceauthorization);
               $('#course_startdate2').val(result[0].course_startdate.split(" ")[0]);
               $('#course_finishdate2').val(result[0].course_finishdate.split(" ")[0]);
               
               //Datos de expedición
               $('#expedition_date2').val(result[0].expedition_date.split(" ")[0]);
               $('#expedition_degreemodality2').val(result[0].expedition_degreemodality);

                /*################################################################## CAMBIO 12/09/22 ####################################################### */

               if(result[0].expedition_iddegreemodality==2){
                document.getElementById("exam2").style.display = 'none';  
               document.getElementById("exencion2").style.display = '';
               
               $('#exencion_date2').val(result[0].expedition_dateprofessionalexam.split(" ")[0]);
               }
               if(result[0].expedition_iddegreemodality==1){
                document.getElementById("exencion2").style.display = 'none';
                document.getElementById("exam2").style.display = ''; 
                $('#expedition_dateprofessionalexam2').val(result[0].expedition_dateprofessionalexam.split(" ")[0]);
                }

                /*################################################################################################################################################## */
               

               $('#expedition_state2').val(result[0].expedition_state);      
               var ss = result[0].expedition_socialservice;
               if(ss == 0){
                $('#expedition_socialservice2').val('NO APLICA');
               }
               $('#expedition_legalbasissocialservice2').val(result[0].expedition_legalbasissocialservice);
               //Antecedentes    
               $('#antecedent_institutionorigin2').val(result[0].antecedent_institutionorigin);
               $('#antecedent_typestudy2').val(result[0].antecedent_typestudy);
               $('#antecedent_document2').val(result[0].antecedent_document);
               $('#antecedent_finishdate2').val(result[0].antecedent_finishdate.split(" ")[0]);
               $('#antecedent_state2').val(result[0].antecedent_state);
               $('#titledata').text('Descargar XML de '+result[0].professional_name);
               $('#id_titledata').val(result[0].id_titledata);
              
           }                    
       });     
   }


   function showHistory(id_titledata) {
    // console.log("VER REGISTRO"+id_titledata);
    $.ajax({
           url: "../../controllers/administracion/controller_administracion.php",
           cache: false,
           dataType: 'JSON',
           type: 'POST',
           data: { action: 26, id_titledata: id_titledata},
           success: function(result) {
               //console.log(result);  
                document.getElementById("cons").style.display = "none";
                var tableHistory = "";
                var loteS='Sin asignar';
                var consult="";
                $('#history').modal();
                $('#folio').text(result[0].controlinvoice);
                
                
                var modal = $('#history')
                modal.find('.modal-title').text('Histórico  ')
                
                $.each(result, function(index, val) { 
                   if (val.lote != null){
                       loteS=val.lote;
                   }
                   if (val.status == 700){
                       var hora=val.date.split(" ")[1];
                    consult="Consultado el "+val.date.split(" ")[0]+" a las "+hora.split(".")[0];
                    document.getElementById("cons").style.display = "block";
                    $('#mensaje').text(consult);
                   }
                   if (val.status == 600 || val.status == 500){
                    document.getElementById("cons").style.display = "none";
                   }

                //console.log(val);
                    tableHistory += "<tr>"    
                           
                        + "<th style='text-align:center'>"+val.status+"</th>"
                        + "<th style='text-align:center'>"+val.description+"</th>"
                        + "<th style='text-align:center'>"+val.date.split(".")[0]+"</th>"
                        + "</tr>";
                });
                $('#tableHistory').html(tableHistory);
                $('#loteS').text(loteS);
           //console.log (result)    
           },error: function (result)
           { 
              //console.log(result);
          }               
       });     
   }



 


/*

   function showDetailsDGP(id_titledata) {
    // console.log("VER REGISTRO"+id_titledata);
    
    $.ajax({
           url: "../../controllers/administracion/controller_administracion.php",
           cache: false,
           dataType: 'JSON',
           type: 'POST',
           data: { action: 31, id_titledata: id_titledata},
           success: function(result) {
               //console.log(result);  
               
                $('#exampleModal2').modal();
                $('#details').text(result[0].details);
                var modal = $('#exampleModal2')
                modal.find('.modal-title').text('Motivos de rechazo')
               
           //console.log (result)    
           },error: function (result)
           { 
              //console.log(result);
          }               
       });     
   }*/

//function print(id_titledata){
  //  window.open("representacionimpresa.php?id=" + id_titledata, "Documento", "width=1000, height = 1000");
    // console.log("ENTRA PRINT + "+id_titledata);
    // var url= "/inaoe/assets/images/persons/"+id_titledata+".jpg";
    //  $.ajax({
    //     url:url,
    //     type:'HEAD',
    //     error: function()
    //     {
    //     swal("No existe un archivo de fotografia para este documento!", {
    //         buttons: false,
    //         timer: 4000,
    //       });
    //     // window.location.href = "./foto.php?id="+ id_titledata;
    //     },
    //     success: function()
    //     {
    //      swal("Espere un momento!", {
    //         buttons: false,
    //         timer: 2000,
    //       });
    //      window.open("representacionimpresa.php?id=" + id_titledata, "Documento", "width=1000, height = 1000");
    //     }
    // });   

//}
/*
function printPDFCancel (id_titledata)
{
    window.open("acusedecancelacion.php?id=" + id_titledata, "Documento", "width=1000, height = 1000");

}

function photograph(id_titledata, name){
   
    
    console.log("ENTRA photograph + "+id_titledata);    
    console.log("ENTRA photograph + "+name); 
    window.location.href = "./foto.php?id="+ id_titledata+"&name="+name;      

}

*/


/* #################################################     CREAR REGISTRO       ############################################################################# */

//CREAR REGISTRO ESTUDIANTE


function resetForm() {
    document.getElementById("myForm").reset();
    elemento = document.getElementById("signer");
    elemento.style.display = "none";
    elemento = document.getElementById("nameu");
    elemento.style.display = "none";
    elemento = document.getElementById("typeu");
    elemento.style.display = "none";
    elemento = document.getElementById("psws");
    elemento.style.display = "none";
    elemento = document.getElementById("pswrs");
    elemento.style.display = "none";
    elemento = document.getElementById("pswrsV");
    elemento.style.display = "none";
    elemento = document.getElementById("names");
    elemento.style.display = "none";
    elemento = document.getElementById("surnames");
    elemento.style.display = "none";
    elemento = document.getElementById("second_surnames");
    elemento.style.display = "none";
    elemento = document.getElementById("curps");
    elemento.style.display = "none";
    elemento = document.getElementById("positions");
    elemento.style.display = "none";
    elemento = document.getElementById("certificates");
    elemento.style.display = "none";
    elemento = document.getElementById("id_certificates");
    elemento.style.display = "none";
  }

function editRegister(id_titledata) {
    location.href = "../actualizar/actualizar.php?dc="+id_titledata;

}

function restore(id_titledata) {
    location.href = "../restaurar/restaurar.php?dc="+id_titledata;

}



/*function goTitleListSign($id_documentdata) {
    console.log("goTitleListSign id titulo "+$id_documentdata);

     $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 47, id_documentdata: $id_documentdata},
        success: function(result) {
            var $controlinvoice = result; 
            console.log("-"+result);
            traceGoTitleListSign($id_documentdata, $controlinvoice);
            location.reload();
            $(".loader").fadeOut("slow"); 
                                 
        }
    }); 
}

function traceGoTitleListSign($id_titledata, $controlinvoice) {
    
    console.log("traceGoTitleListSign: "+$id_titledata+"controlinvoice: "+$controlinvoice);
    $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 48, id_titledata: $id_titledata, controlinvoice: $controlinvoice},
        success: function(result) {
            //location.reload();
            //$(".loader").fadeOut("slow");
            //console.log(result);             
        }, error: function(result){
            //console.log(result);
        }
    }); 
}

 

//---------------------------- USUARIOS


function listUser() {
    // console.log("signDocument "+id_documentData);
  $.ajax({
        url: "../../controllers/administracion/controller_administracion.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 18 },
        success: function(result) {
            var table = "";
            var tipo ='';
            var permiso ='';
            var status = '';
            $.each(result, function(index, val) {
                //console.log(val);
                
                if(val.type == 1){
                    tipo = 'Firmante Sin PEM'
                }
                if(val.type == 2){
                    tipo = 'Firmante'
                }
                if(val.type == 3){
                    tipo = 'Capturista'
                }
                if(val.type == 5){
                    tipo = 'Admin'
                }

                table += "<tr>"       
                    + "<th>"+val.id_user+"</th>"
                    + "<th>"+val.name+"</a></th>" //<a href='#'  data-toggle='modal' onClick='showRegister("+val.id_user+");'>
                    + "<th>"+tipo+"</th>" ;

                if(val.permission == null){
                    permiso = 'Sin permisos'                    
                    table +=  "<th>"+permiso+"</th>";
                }
                if(val.permission == 1){
                    permiso = 'Firmante'
                    table +=  "<th><button class='btn btn-success btn-sm'  onClick='deleteInfo();'>"+permiso+"</button></th>";
                }
                if(val.status == 1){
                    status = 'Activo'
                }
                if(val.status == 0){
                    status = 'Inactivo'
                }
                //console.log(val);
               

                if(val.status == 1){
                    table+="<th><span class='badge badge-success'>"+status+"</span></th>"
                    +"<th><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='editRegister("+val.id_user+")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                    +"<th><button type='button' class='btn btn-danger btn-sm' title='Click para DESACTIVAR el usuario'  onclick='optionUser("+val.status+","+val.id_user+")'>"+'<i class="fas fa-toggle-off"></i>'+"</button></th>"
                    + "</tr>";

                }
                if(val.status == 0){
                    table+="<th><span class='badge badge-danger'>"+status+"</span></th>"
                    +"<th><button type='button' class='btn btn-secondary btn-sm' id='btn-edit' title='Click para editar' onclick='editRegister("+val.id_user+")'>"+'<i class="fas fa-edit"></i>'+"</button></th>"
                    +"<th><button type='button' class='btn btn-success btn-sm' title='Click para ACTIVAR el usuario'  onclick='optionUser("+val.status+","+val.id_user+")'>"+'<i class="fas fa-toggle-on"></i>'+"</button></th>"
                    + "</tr>";

                }
                //+ "</tr>";
                /*if(val.status == 1){
                    table+=
                    "<th><button type='button' class='btn btn-danger btn-sm' title='Click para DESACTIVAR el usuario'  onclick='optionUser("+val.status+","+val.id_user+")'>"+'<i class="fas fa-toggle-off"></i>'+"</button></th>"
                    + "</tr>";
                }
                if(val.status == 0){
                    table+=
                    "<th><button type='button' class='btn btn-success btn-sm' title='Click para ACTIVAR el usuario'  onclick='optionUser("+val.status+","+val.id_user+")'>"+'<i class="fas fa-toggle-on"></i>'+"</button></th>"
                    + "</tr>";
                }
            });
            
                $('#table-users').html(table);
                $('#alertU').hide();
            
        }
    }); 
}

function deleteInfo() {

    swal({
        title: "ELIMINAR ARCHIVOS",
        text: "¿Estás seguro de que deseas eliminar los archivos?",
        icon: "warning",
        buttons: {
            cancel: "Cancelar",
            Aceptar: true,
          },
      })
      .then((deletePEM) => {
        if (deletePEM) {
             $.ajax({
                url: "../../controllers/administracion/controller_administracion.php",
                cache: false,
                type: 'POST',
                data: { action: 32 },
                success: function(result) {
                    console.log("OK delete");  
                }
            });

             listUser();
            
          swal("¡Archivos eliminados!", {
            icon: "success",
          });
        } else {
        }
      });    
}


//CREAR NUEVO USUARIO 


function createUser() {
    var type = $("#type").val();
    var name_user = $("#name_user").val();
    var psw =  $("#psw").val();
    var pswr = $("#pswr").val();
    if (type == 1){
        var name = $("#name").val();
        var surname = $("#surname").val();
        var second_surname = $("#second_surname").val();
        var curp = $("#curp").val();
        var id_position = $("#position").val();
        var position_name = $("#position").find('option:selected').text();
        var certificate = $("#certificate").val();
        var id_certificate = $("#id_certificate").val();
        if (name.length==0){
            elemento = document.getElementById("names");
            elemento.style.display = "inline";
            $("#name").focus();
            return 0;
        }
        if (surname.length==0){
            elemento = document.getElementById("surnames");
            elemento.style.display = "inline";
            $("#surname").focus();
            return 0;
        }
        if (second_surname.length==0){
            elemento = document.getElementById("second_surnames");
            elemento.style.display = "inline";
            $("#second_surname").focus();
            return 0;
        }
        if (curp.length==0){
            elemento = document.getElementById("curps");
            elemento.style.display = "inline";
            $("#curp").focus();
            return 0;
        }
        if (id_position==null){
            elemento = document.getElementById("positions");
            elemento.style.display = "inline";
            $("#position").focus();
            return 0;
        }
        if (certificate.length==0){
            elemento = document.getElementById("certificates");
            elemento.style.display = "inline";
            $("#certificate").focus();
            return 0;
        }
        if (id_certificate.length==0){
            elemento = document.getElementById("id_certificates");
            elemento.style.display = "inline";
            $("#id_certificate").focus();
            return 0;
        }
        var expCurp = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/
        var validCurp = expCurp.test(curp);
        if (validCurp == false){

        }
    }
    if (type==null){
        elemento = document.getElementById("typeu");
        elemento.style.display = "inline";
        $("#type").focus();
        return 0;
    }
    if (name_user.length==0){
        elemento = document.getElementById("nameu");
        elemento.style.display = "inline";
        $("#name_user").focus();
        return 0;
    }
    if (psw.length==0){
        elemento = document.getElementById("psws");
        elemento.style.display = "inline";
        $("#psw").focus();
        return 0;
    }
    if (pswr.length==0){
        elemento = document.getElementById("pswrs");
        elemento.style.display = "inline";
        $("#pswr").focus();
        return 0;
    }
    if (pswr != psw){
        elemento = document.getElementById("pswrsV");
        elemento.style.display = "inline";
        $("#pswr").focus();
        return 0;
    }
    
}


//mostrar contenido en el modal de firmante 
function cargaUser() {
    var type = $("#type").val();
    if (type == 1){
        elemento = document.getElementById("signer");
        //elemento.style.visibility='visible';
        elemento.style.display = "inline";
    }
    if (type == 3 || type == 5){
        elemento = document.getElementById("signer");
        //elemento.style.visibility='visible';
        elemento.style.display = "none";
    }
   
}

//ACTIVAR / DESACTIVAR USUARIOS

// Activar / Desactivar
function optionUser(status, id_user) {
    console.log(status+" "+id_user);
    if(status == 1){
        swal({
            title: "Desactivar usuario",
            text: "¿Estás seguro de que deseas desactivar el usuario",
            icon: "info",
            buttons: {
                cancel: "Cancelar",
                Aceptar: true,
              },
          })
          .then((optionU) => {
            if (optionU) {
                $.ajax({
                    url: "../../controllers/administracion/controller_administracion.php",
                    cache: false,
                    dataType: 'JSON',
                    type: 'POST',
                    data: { action: 19, status:status, id_user: id_user},
                    success: function(result) {
                        //console.log(result);
                    },complete: function () {
                    //loader.fadeOut();
                    $(".loader").fadeOut("slow");
                        $("#info").removeClass("d-none");
                        listUser();
                        location.reload();
                    }
                    
                });
            } else {
            }
          });
        
    }
    if(status == 0){
        swal({
            title: "Activar usuario",
            text: "¿Estás seguro de que deseas activar el usuario",
            icon: "info",
            buttons: {
                cancel: "Cancelar",
                Aceptar: true,
              },
          })
          .then((optionU) => {
            if (optionU) {
                $.ajax({
                    url: "../../controllers/administracion/controller_administracion.php",
                    cache: false,
                    dataType: 'JSON',
                    type: 'POST',
                    data: { action: 19, status:status, id_user: id_user},
                    success: function(result) {
                        //console.log(result);
                    },complete: function () {
                    //loader.fadeOut();
                    $(".loader").fadeOut("slow");
                        $("#info").removeClass("d-none");
                        listUser();
                        location.reload();
                    }
                    
                });
            } else {
            }
          });
        
    }

}*/




$("#exit").click(function() {
    //loader.fadeIn();
    $(".loader").fadeOut("slow");

    setTimeout(function() {
        location.href = "../../index.php";
    }, 1000);
});

