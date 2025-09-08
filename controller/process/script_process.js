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
  getAreas();
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
      // Guardar selección en sessionStorage para acceder desde otra página
      sessionStorage.setItem('selectedProcessCatalogId', selectedId);
    },
    error: function (result) {
      console.log("Error al cargar procesos:", result);
    }
  });
}

$(document).on("change", "#process_catalog_filter", function () {
  const selectedId = $(this).val();
  const selectedText = $("#process_catalog_filter option:selected").text();

  // Actualizar el h5 con el texto de la opción seleccionada
  $("#processSelectedTitle").text(selectedText);

  sessionStorage.setItem('selectedProcessCatalogId', selectedId);
  listProcess();
});



function listProcess() {
  if ($("#process_catalog_filter").length === 0) return; // No existe, no hacer nada
  const id_process_catalog = $("#process_catalog_filter").val();

  $.ajax({
    url: "../../controller/process/controller_process.php",
    cache: false,
    dataType: 'JSON',
    type: 'POST',
    data: {
      action: 1,
      id_process_catalog: id_process_catalog
    },
    success: function (result) {
      stepCount = 0;
      $('#steps-body').empty(); // limpiar solo las filas

      const flujoCounts = {};
      const pasosActivos = result.filter(val => val.status == 1);

      if (pasosActivos.length === 0) {
        $('#steps-body').html(`
          <tr>
            <td colspan="5" class="text-center text-muted">
              No existen pasos asignados aún para este proceso.
            </td>
          </tr>
        `);
        return;
      }

      // Contar ocurrencias de cada flujo
      pasosActivos.forEach(val => {
        flujoCounts[val.flujo_ejecucion] = (flujoCounts[val.flujo_ejecucion] || 0) + 1;
      });

      // Renderizar filas
      pasosActivos.forEach(val => {
        stepCount++;
        const tipo = flujoCounts[val.flujo_ejecucion] > 1 ? 'Simultáneo' : 'Secuencial';

        const rowHTML = `
          <tr>
            <td>${stepCount}</td>
            <td>${val.description}</td>
            <td>${val.name_user}</td>
            <td>${val.flujo_ejecucion}</td>
            <td>
              <button class="btn btn-sm btn-outline-primary ml-1" title="Ver detalles" onclick="DetailsProcess(${val.id_process_stages}, '${tipo}')">
                <i class="fas fa-eye"></i>
              </button>
              <button class="btn btn-sm btn-secondary ml-1" title="Editar paso" onclick="editProcess(${val.id_process_stages})">
                <i class="fas fa-edit"></i>
              </button>
              <button class="btn btn-sm btn-danger ml-1" title="Eliminar paso" onclick="deleteProcess(${val.id_process_stages})">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
        `;

        $('#steps-body').append(rowHTML);
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




function getAreas(selectedId = null) {
  $(".loader").fadeOut("slow");
  $.ajax({
    url: "../../controller/process/controller_process.php",
    cache: false,
    dataType: 'JSON',
    type: 'POST',
    data: { action: 4 }, // ya está enlazado con getAreas() en tu PHP
    success: function (result) {
      let options = `<option value="null" disabled ${selectedId === null ? "selected" : ""}>Seleccione un Área</option>`;
      
      $.each(result, function (index, val) {
        const selected = (val.id_area == selectedId) ? "selected" : "";
        options += `<option value='${val.id_area}' ${selected}>${val.name_area}</option>`;
      });
      
      $("#area_select").html(options); // 👈 ajusta el ID de tu <select>
    },
    error: function (result) {
      console.error("Error al obtener áreas:", result);
    }
  });
}


// Evento: cuando el usuario cambia el encargado
$(document).on("change", "#area_select", function () {
  const id_area = $(this).val();
  getAreaByUser(id_area);
});

// Función que obtiene el usuario asociado a un área por ID
function getAreaByUser(id_area) {
  $.ajax({
    url: "../../controller/process/controller_process.php",
    type: "POST",
    data: { action: 9, id_area: id_area },
    dataType: "JSON",
    success: function (response) {
      if (response.length > 0) {
        $("#area_user").val(response[0].full_name);  // nombre visible
        $("#area_user_id").val(response[0].id_user); // id oculto
      } else {
        $("#area_user").val("Sin área asignada");
        $("#area_user_id").val("");
      }
    },
    error: function (error) {
      console.error("Error al obtener el área:", error);
    }
  });
}







$(document).ready(function () {
    const params = new URLSearchParams(window.location.search);
    const idStep = params.get('dc'); // id del paso, solo existe si es editar
    const processCatalog = params.get('process_catalog');

    if (!idStep) {
        // Registro (nuevo): solo asegurarse que el formulario esté listo
        // Por ejemplo, podrías limpiar campos o establecer valores por defecto
        $("#description").val("");
        $("#execution_flow").val(""); // si es input tipo número
        $("#process_manager").val(null);
        $("#area_select").val(null);
        $("#area_user").val("");
        $("#area_user_id").val("");
    } else {
        // Edición: precargar datos del paso
        preCargarDatosProcess(idStep);
    }
});










function getQueryParam(param) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(param);
}

function saveProcess() {
    const process_catalog = getQueryParam('process_catalog');
    const description = $("#description").val().trim();
    const execution_flow = $("#execution_flow").val();
    const process_manager = $("#area_user_id").val();

    // Validaciones
    if (!process_catalog) {
        alert("El proceso no está definido en la URL");
        return 0;
    }

    if (description.length === 0) {
        alert("El campo descripción no puede estar vacío");
        $("#description").focus();
        return 0;
    }

    if (!execution_flow || isNaN(execution_flow) || execution_flow <= 0) {
    alert("Tiene que colocar un número de ejecución válido (mayor a 0).");
    $("#execution_flow").focus();
    return 0;
}

    if (!process_manager) {
        alert("Tiene que seleccionar un área de liberar");
        $("#process_manager").focus();
        return 0;
    }

    // Enviar registro
    $.ajax({
        url: "../../controller/process/controller_process.php",
        cache: false,
        dataType: 'JSON',
        type: 'POST',
        data: { 
            action: 5,
            process_catalog: process_catalog,
            description: description,
            execution_flow: execution_flow,
            process_manager: process_manager
        },
        success: function () {
            location.href = "../process/process.php";
        },
        error: function (result) {
            console.log(result);
            bootbox.confirm({
                title: "<h4>Error al registrar paso del proceso</h4>",
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
                    if (result == false) {
                        history.go(-1);
                    }
                }
            });
        }
    });
}





function preCargarDatosProcess(idStep) {
  const formData = new FormData();
  formData.append('action', 6);
  formData.append('id_process_stages', idStep);

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

        // llenar los campos primero
        $('#description').val(processData.description);
        $('#execution_flow').val(processData.execution_flow);

        // cargar áreas y después seleccionar la correcta
        getAreas(processData.id_area);

        // cargar encargado
        getAreaByUser(processData.id_area);

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
    const urlParams = new URLSearchParams(window.location.search);
    const process_catalog = urlParams.get('process_catalog');
    const description = $("#description").val().trim();
    const execution_flow = $("#execution_flow").val().trim();
    const process_manager = $("#area_user_id").val(); // el id del encargado oculto

    // Validaciones
    if (description.length === 0) {
        alert("Debe escribir una descripción");
        $("#description").focus();
        return 0;
    }

    if (!execution_flow || parseInt(execution_flow) <= 0) {
        alert("Debe ingresar un número de ejecución válido (mayor a 0)");
        $("#execution_flow").focus();
        return 0;
    }

    if (!process_manager || process_manager === "null") {
        alert("Debe seleccionar un encargado");
        $("#area_select").focus();
        return 0;
    }

    // Si todo está correcto
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
                timerProgressBar: true,
            }).then((res) => {
                if (res.dismiss === Swal.DismissReason.timer) {
                    location.href = "../process/process.php";
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
                title: 'Error al actualizar el paso del proceso',
                html: `<b>Estado:</b> ${textStatus}<br><b>Error:</b> ${errorThrown}`,
                footer: 'Revisa consola para más detalles',
                timer: 10000,
                timerProgressBar: true,
            });
        }
    });
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
  if (id) { // Solo si existe el id en la URL
    preCargarDatosProcess(id);
    getAreas();
  }
});

function editProcess(id_process_stages) {
  const selectedProcessId = $("#process_catalog_filter").val();
  if (!selectedProcessId) {
    alert("Por favor, selecciona un proceso en el filtro antes de editar un paso.");
    return;
  }
  sessionStorage.setItem("id_process_stages", id_process_stages);
  // Pasar ambos parámetros en la URL: id del paso y process_catalog
  location.href = `../process/actualizar_process.php?dc=${id_process_stages}&process_catalog=${selectedProcessId}`;
}

function NewProcess() {
  const selectedProcessId = $("#process_catalog_filter").val();
  if (!selectedProcessId) {
    alert("Por favor, selecciona un proceso en el filtro antes de añadir un nuevo paso.");
    return;
  }
  // Redirigir pasando el id del proceso seleccionado
  location.href = `../process/registro_process.php?process_catalog=${selectedProcessId}`;
}

// Al cargar el documento, verificar si hay un parámetro en la URL y asignarlo a la variable `processCatalogId`
$(document).ready(function () {
  const urlParams = new URLSearchParams(window.location.search);
  const processCatalogId = urlParams.get('process_catalog');

  if (processCatalogId) {
    $("#process_catalog").val(processCatalogId);
    console.log("processCatalogId:", processCatalogId);
  }
});



function cancel() {
  window.history.back();
}

$("#exit").click(function () {
  //loader.fadeIn();
  $(".loader").fadeOut("slow");

  setTimeout(function () {
    location.href = "../../index.php";
  }, 1000);
});







