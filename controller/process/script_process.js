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
    processCatalogFilter();
    listProcess();
    processManager();
    loadExecutionFlow();
});

let stepCount = 0;




function processCatalogFilter(selectedId = null) {
  $(".loader").fadeOut("slow");
  $.ajax({
    url: "../../controller/process/controller_process.php",
    cache: false,
    dataType: 'JSON',
    type: 'POST',
    data: { action: 3 },
    success: function (result) {
      let options = "";
      let selectedText = "";

      $.each(result, function (index, val) {
        let selected = "";

        // Si no hay selectedId y es el primer registro, seleccionarlo
        if (selectedId === null && index === 0) {
          selected = "selected";
          selectedId = val.id_process_catalog;
          selectedText = val.description; // Guardar texto
        } else if (val.id_process_catalog == selectedId) {
          selected = "selected";
          selectedText = val.description; // Guardar texto
        }

        options += `<option value='${val.id_process_catalog}' ${selected}>${val.description}</option>`;
      });

      $("#process_catalog_filter").html(options);

      // Poner texto en el segundo h5
      $("#processSelectedTitle").text(selectedText);

      // Ejecutar la lista de procesos inmediatamente después de llenar el select
      listProcess();
    },
    error: function (result) {
      console.log("Error al cargar procesos:", result);
    }
  });
}


$(document).on("change", "#process_catalog_filter", function() {
  let selectedText = $(this).find("option:selected").text();
  $("#processSelectedTitle").text(selectedText);
  listProcess();
});



function listProcess() {
  const id_process_catalog = $("#process_catalog_filter").val();
  console.log("ID del proceso seleccionado:", id_process_catalog);

  $.ajax({
    url: "../../controller/process/controller_process.php",
    cache: false,
    dataType: 'JSON',
    type: 'POST',
    data: { 
      action: 1,
      id_process_catalog: id_process_catalog // se envía al backend
    },
    success: function (result) {
      stepCount = 0;
      $('#steps-container').empty();

      const flujoCounts = {};
      const pasosActivos = result.filter(val => val.status == 1);

      if (pasosActivos.length === 0) {
        $('#steps-container').html(`
          <div class="alert alert-warning" role="alert">
            No existen pasos asignados aún para este proceso.
          </div>
        `);
        return;
      }

      // Contar ocurrencias de cada flujo
      pasosActivos.forEach(val => {
        flujoCounts[val.flujo_ejecucion] = (flujoCounts[val.flujo_ejecucion] || 0) + 1;
      });

      // Renderizar pasos
      pasosActivos.forEach(val => {
        stepCount++;
        const tipo = flujoCounts[val.flujo_ejecucion] > 1 ? 'Simultáneo' : 'Secuencial';

        const stepHTML = `
          <div class="border rounded p-3 mb-3" style="border-left: 6px solid #691C32; background-color: #f8f9fa;">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <strong>Paso ${stepCount}:</strong>
                <span>${val.description}</span>
                <div><small><strong>Responsable:</strong> ${val.name_user}</small></div>
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
                  <button class="btn btn-sm btn-outline-primary ml-1" title="Ver detalles" onclick="DetailsProcess(${val.id_process_stages}, '${tipo}')">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="btn btn-sm btn-secondary ml-1" title="Editar paso" onclick="editProcess(${val.id_process_stages})">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-sm btn-danger ml-1" title="Eliminar paso" onclick="deleteProcess(${val.id_process_stages})">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        `;

        $('#steps-container').append(stepHTML);
      });
    },
    error: function (result) {
      console.error("Error al cargar procesos:", result);
    }
  });
}


// Detectar cambio en el select y recargar la lista
$(document).on("change", "#process_catalog_filter", function () {
  listProcess();
});





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
      $('#process-execution-flow').text(general.flujo_ejecucion);
      $('#area-user').text(general.area_user);

      // Mostrar la modal
      $('#processDetailsModal').modal('show');
    },
    error: function (result) {
      console.error("Error al cargar procesos:", result);
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

      // Si ya hay un encargado seleccionado, mostrar su área
      if (selectedId) {
        getAreaByUser(selectedId);
      }
    },
    error: function (result) {
      console.log(result);
    }
  });
}

// Evento: cuando el usuario cambia el encargado
$(document).on("change", "#process_manager", function () {
  const id_user = $(this).val();
  getAreaByUser(id_user);
});

// Función que obtiene el área por ID de usuario
function getAreaByUser(id_user) {
  $.ajax({
    url: "../../controller/process/controller_process.php",
    type: "POST",
    data: { action: 9, id_user: id_user },
    dataType: "JSON",
    success: function (response) {
      if (response.length > 0) {
        $("#area_user").val(response[0].name_area);
      } else {
        $("#area_user").val("Sin área asignada"); // Limpia si no hay área
      }
    },
    error: function (error) {
      console.error("Error al obtener el área:", error);
    }
  });
}





function loadExecutionFlow(selectedId = null) {
  $(".loader").fadeOut("slow");
  $.ajax({
    url: "../../controller/process/controller_process.php",
    cache: false,
    dataType: 'JSON',
    type: 'POST',
    data: { action: 10 },
    success: function (result) {
      let options = `<option value="null" disabled ${selectedId === null ? "selected" : ""}>Seleccione un Paso</option>`;
      
      $.each(result, function(index, val) {
        const selected = (val.id_process_stages == selectedId) ? "selected" : "";
        options += `<option value='${val.id_process_stages}' data-execution='${val.execution_flow}' ${selected}>${val.description}</option>`;
      });

      // Opción secuencial
      const isSequentialSelected = selectedId === 'sequential';
      options += `<option value="sequential" ${isSequentialSelected ? "selected" : ""}>PASO SECUENCIAL</option>`;

      $("#execution_flow").html(options);

      // Si se desea ver en consola en precarga
      if (selectedId && selectedId !== "sequential") {
        const selectedOption = $("#execution_flow option:selected");
        const execFlow = selectedOption.data("execution");
        console.log("Execution flow preseleccionado:", execFlow);
      }
    },
    error: function (result) {
      console.log(result);
    }
  });
}



$("#execution_flow").on("change", function() {
  const selectedOption = $(this).find("option:selected");
  const execFlow = selectedOption.data("execution") || null;
  console.log("Execution flow seleccionado:", execFlow);
});







function saveProcess() {
  const process_catalog = $("#process_catalog").val();
  const description = $("#description").val().trim();
  const selectedOption = $("#execution_flow option:selected");
  const selectedValue = selectedOption.val();
  const process_manager = $("#process_manager").val();

  // Validaciones
  if (!process_catalog) {
    alert("Tiene que seleccionar un proceso");
    $("#process_catalog").focus();
    return;
  }

  if (description.length === 0) {
    alert("El campo descripción no puede estar vacío");
    $("#description").focus();
    return;
  }

  if (!selectedValue) {
    alert("Tiene que seleccionar un paso");
    $("#execution_flow").focus();
    return;
  }

  if (!process_manager) {
    alert("Tiene que seleccionar un encargado de liberar");
    $("#process_manager").focus();
    return;
  }

  const enviarRegistro = (execution_flow_real) => {
    $.ajax({
      url: "../../controller/process/controller_process.php",
      cache: false,
      dataType: 'JSON',
      type: 'POST',
      data: {
        action: 5,
        process_catalog: process_catalog,
        description: description,
        execution_flow: execution_flow_real,
        process_manager: process_manager
      },
      success: function () {
        location.href = "../process/process.php";
      },
      error: function () {
        bootbox.confirm({
          title: "<h4>Error al registrar paso para el proceso</h4>",
          message: "<h5>Ocurrió un error al hacer el registro.</h5>",
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
            if (!result) history.go(-1);
          }
        });
      }
    });
  };

  // Evaluar si se seleccionó PASO SECUENCIAL
  if (selectedValue === "sequential") {
    $.ajax({
      url: "../../controller/process/controller_process.php",
      type: "POST",
      dataType: "JSON",
      data: { action: 11 },
      success: function (resp) {
        const nextFlow = resp.next_execution_flow;
        enviarRegistro(nextFlow);
      },
      error: function () {
        alert("Error al obtener el siguiente flujo de ejecución.");
      }
    });
  } else {
    const execution_flow = selectedOption.data("execution");
    enviarRegistro(execution_flow);
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

        // Llenar los selectores y campos
        processCatalog(processData.fk_process_catalog);
        processManager(processData.fk_process_manager); // carga encargados
        loadExecutionFlow(processData.id_process_stages);
        $('#process_catalog').val(processData.fk_process_catalog);
        $('#process_manager').val(processData.fk_process_manager);
        $('#description').val(processData.description);

        
        getAreaByUser(processData.fk_process_manager);

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
    const selectedOption = $("#execution_flow option:selected");
    const selectedValue = selectedOption.val();
    const process_manager = $("#process_manager").val();

    // Validaciones
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

    if (!selectedValue || selectedValue === "null") {
        alert("Debe seleccionar un flujo de ejecución");
        $("#execution_flow").focus();
        return;
    }

    if (!process_manager || process_manager === "null") {
        alert("Debe seleccionar un encargado");
        $("#process_manager").focus();
        return;
    }

    const enviarEdicion = (execution_flow_real) => {
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
                execution_flow: execution_flow_real,
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
    };

    // Si es secuencial, obtener el máximo y sumarle 1
    if (selectedValue === "sequential") {
        $.ajax({
            url: "../../controller/process/controller_process.php",
            type: "POST",
            dataType: "JSON",
            data: { action: 11 },
            success: function (resp) {
                const nextFlow = resp.next_execution_flow;
                enviarEdicion(nextFlow);
            },
            error: function () {
                alert("Error al obtener el siguiente flujo de ejecución.");
            }
        });
    } else {
        const execution_flow_real = selectedOption.data("execution");
        enviarEdicion(execution_flow_real);
    }
}






function deleteProcess(id_process_stages) {
    console.log("ID del paso a eliminar:", id_process_stages);

    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el paso del proceso. ¿Deseas continuar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../../controller/process/controller_process.php",
                cache: false,
                dataType: 'JSON',
                type: 'POST',
                data: {
                    action: 8,
                    id_process_stages: id_process_stages
                },
                success: function (result) {
                    console.log(result);
                    if (result.status === "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Paso del proceso eliminado correctamente',
                            timer: 500,
                            timerProgressBar: true,
                        }).then((r) => {
                            if (r.dismiss === Swal.DismissReason.timer) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al eliminar el paso del proceso'
                        });
                    }
                },
                error: function (result) {
                    console.log(result);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al realizar la solicitud'
                    });
                }
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
        loadExecutionFlow();
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







