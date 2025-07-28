var answer_save = [];
var loader = $(".loader");
var document_id;


(function ($) {
    $.fn.inputFilter = function (inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
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


$(function () {
    $(".loader").fadeOut("slow");
    $("#info").removeClass("d-none");
    processCatalog();
    listProcess();
    processManager();
});

let stepCount = 0;


function listProcess() {
    $.ajax({
        url: "../../controller/process/controller_process.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { action: 1 },
        success: function (result) {
            stepCount = 0;
            $('#steps-container').empty();

            // Paso 1: contar ocurrencias de cada flujo
            const flujoCounts = {};
            result.forEach(val => {
                if (val.status == 1) {
                    flujoCounts[val.flujo_ejecucion] = (flujoCounts[val.flujo_ejecucion] || 0) + 1;
                }
            });

            // Paso 2: renderizar cada paso con su tipo determinado por ocurrencias
            result.forEach(val => {
                if (val.status == 1) {
                    stepCount++;

                    // Determinar tipo según cantidad de registros con ese flujo
                    const tipo = flujoCounts[val.flujo_ejecucion] > 1 ? 'Simultáneo' : 'Secuencial';

            const stepHTML = `
                <div class="border rounded p-3 mb-3" style="border-left: 6px solid #691C32; background-color: #f8f9fa;">
                    <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Paso ${stepCount}:</strong>
                        <span>${val.description}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="form-group mb-0 mr-3">
                        <label class="mb-0 mr-2">Tipo:</label>
                        <select class="form-control form-control-sm d-inline-block" style="width: auto;" disabled>
                            <option ${tipo === 'Secuencial' ? 'selected' : ''}>Secuencial</option>
                            <option ${tipo === 'Simultáneo' ? 'selected' : ''}>Simultáneo</option>
                        </select>
                        </div>
                        <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-primary ml-1" title="Ver detalles" onclick="DetailsProcess(${val.id_process_stages}, '${tipo}' )">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-secondary ml-1" title="Editar paso" onclick="editProcess(${val.id_process_stages})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger ml-1" title="Eliminar paso" onclick="deleteStep(${val.id_process_stages})">
                            <i class="fas fa-trash"></i>
                        </button>
                        </div>
                    </div>
                    </div>
                </div>
                `;



                    $('#steps-container').append(stepHTML);
                }
            });
        },
        error: function (result) {
            console.error("Error al cargar procesos:", result);
        }
    });
}




function DetailsProcess(id_process_stages, tipo) {
  $.ajax({
    url: "../../controller/process/controller_process.php",
    cache: false,
    dataType: 'JSON',
    type: 'POST',
    data: { action: 2, id_process_stages: id_process_stages },
    success: function (result) {
      if (result.length === 0) return;

      const general = result[0];

      // Formatear la fecha
      const rawDate = new Date(general.creation_date);
      const formattedDate = rawDate.toLocaleString('es-MX', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
      });

      $('#process-name').text(general.name_process);
      $('#process-responsible').text(general.name_user);
      $('#process-date').text(formattedDate);
      $('#process-description').text(general.description);
      $('#process-type').text(tipo);

      // Mostrar la modal
      $('#processDetailsModal').modal('show');
    },
    error: function (result) {
      console.error("Error al cargar procesos:", result);
    }
  });
}








function processCatalog(selectedId = null) {
  $(".loader").fadeOut("slow");
  $.ajax({
    url: "../../controller/process/controller_process.php",
    cache: false,
    dataType: 'JSON',
    type: 'POST',
    data: { action: 3 },
    success: function (result) {
      let options = `<option value="null" disabled ${selectedId === null ? "selected" : ""}>Seleccione un Proceso</option>`;
      $.each(result, function (index, val) {
        const selected = (val.id_process_catalog == selectedId) ? "selected" : "";
        options += `<option value='${val.id_process_catalog}' ${selected}>${val.name}</option>`;
      });
      $("#process_catalog").html(options);
    },
    error: function (result) {
      console.log(result);
    }
  });
}




function processManager(selectedId = null) {
  $(".loader").fadeOut("slow");
  $.ajax({
    url: "../../controller/process/controller_process.php",
    cache: false,
    dataType: 'JSON',
    type: 'POST',
    data: { action: 4 },
    success: function (result) {
      let options = `<option value="null" disabled ${selectedId === null ? "selected" : ""}>Seleccione un Encargado</option>`;
      $.each(result, function (index, val) {
        const selected = (val.id_user == selectedId) ? "selected" : "";
        options += `<option value='${val.id_user}' ${selected}>${val.name_user}</option>`;
      });
      $("#process_manager").html(options);
    },
    error: function (result) {
      console.log(result);
    }
  });
}









function saveProcess() {
    var process_catalog = $("#process_catalog").val();
    var description = $("#description").val().trim();
    var execution_flow = $("#execution_flow").val().trim();
    var process_manager = $("#process_manager").val();

    // Validación individual con mensajes específicos
    if (process_catalog == null) {
        alert("Tiene que seleccionar un proceso");
        $("#process_catalog").focus();
        return 0;
    }

    if (description.length == 0) {
        alert("El campo descripción no puede estar vacío");
        $("#description").focus();
        return 0;
    }

    if (execution_flow.length == 0) {
        alert("El campo de flujo de ejecución no puede estar vacío");
        $("#execution_flow").focus();
        return 0;
    }

    if (process_manager == null) {
        alert("Tiene que seleccionar un encargado de liberar");
        $("#process_manager").focus();
        return 0;
    }

    // Si todos están llenos, puedes hacer una validación final así:
    if (description.length > 0 && execution_flow.length > 0) {
       
        $.ajax({
            url: "../../controller/process/controller_process.php",
            cache: false,
            dataType: 'JSON',
            type: 'POST',
            data: { action: 5, process_catalog: process_catalog, description: description, execution_flow: execution_flow, process_manager: process_manager },
            success: function (result) {
            location.href = "../process/process.php";         
            }, error: function (result) {
                console.log(result);
                bootbox.confirm({
                    title: "<h4>Error al registrar paso para el proceso</h4>",
                    message: "<h5>Ocurrio un error al hacer el registro del paso para el proceso.</h5>",
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
                            history.go(-1);
                        }
                    }
                });
            }
        });
    }
}


function preCargarDatosProcess() {
  const processID = sessionStorage.getItem('id_process_stages');
  const formData = new FormData();
  formData.append('action', 6);
  formData.append('id_process_stages', processID);

  $.ajax({
    url: "../../controller/process/controller_process.php",
    cache: false,
    dataType: 'JSON',
    type: 'POST',
    processData: false,
    contentType: false,
    data: formData,
    success: function (result) {
      if (result.status == 200) {
        const processData = result.data;

        // Llenar los selectores y seleccionar el valor correspondiente
        processCatalog(processData.fk_process_catalog);
        processManager(processData.fk_process_manager);
        $('#process_catalog').val(processData.fk_process_catalog);
        $('#process_manager').val(processData.fk_process_manager);
        $('#description').val(processData.description);
        $('#execution_flow').val(processData.execution_flow);
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Ocurrió un error al editar el paso del proceso'
        });
      }
    },
    error: function (xhr, status, error) {
      console.error("Error al cargar los datos:", error);
    }
  });
}


function saveProcessEdit() {
    const id_process_stages = sessionStorage.getItem('id_process_stages');
    const process_catalog = $("#process_catalog").val();
    const description = $("#description").val().trim();
    const execution_flow = $("#execution_flow").val().trim();
    const process_manager = $("#process_manager").val();

    if (!process_catalog || process_catalog === "null") {
        alert("Debe seleccionar un proceso");
        $("#process_catalog").focus();
        return;
    }

    if (description.length === 0) {
        alert("Debe escribir una descripción");
        $("#description").focus();
        return;
    }

    if (execution_flow.length === 0) {
        alert("Debe escribir un flujo de ejecución");
        $("#execution_flow").focus();
        return;
    }

    if (!process_manager || process_manager === "null") {
        alert("Debe seleccionar un encargado");
        $("#process_manager").focus();
        return;
    }

    $.ajax({
        url: "../../controller/process/controller_process.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: {
            action: 7,
            id_process_stages: id_process_stages,
            process_catalog: process_catalog,
            description: description,
            execution_flow: execution_flow,
            process_manager: process_manager
        },
        success: function (result) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Paso del proceso actualizado correctamente',
                timer: 500,
                timerProgressBar: true
            }).then((r) => {
                if (r.dismiss === Swal.DismissReason.timer) {
                    window.location.href = "../process/process.php";
                }
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Error en Ajax:");
            console.log("Estado: " + textStatus);
            console.log("Error: " + errorThrown);
            console.log("Respuesta completa: ", jqXHR);

            Swal.fire({
                icon: 'error',
                title: 'Error al actualizar el paso',
                html: `<b>Estado:</b> ${textStatus}<br><b>Error:</b> ${errorThrown}`,
                footer: 'Revisa consola para más detalles',
                timer: 10000,
                timerProgressBar: true,
            });
        }
    });
}








document.addEventListener('DOMContentLoaded', function () {
    let id = new URLSearchParams(window.location.search).get('dc');
    if(id){ // Solo si existe el id en la URL
        preCargarDatosProcess(id);
        processCatalog();
        processManager();
    }
});

function editProcess(id_process_stages){
    sessionStorage.setItem("id_process_stages", id_process_stages)
    location.href = "../process/actualizar_process.php?dc="+id_process_stages;  
}

function NewProcess() {
    location.href = "../process/registro_process.php";  
}


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







