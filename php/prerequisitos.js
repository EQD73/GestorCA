$(document).ready(function () {
  // Cargar datos iniciales
  function cargarDatos() {
    $.ajax({
      url: "backend_prerequisitos.php",
      type: "GET",
      dataType: "json",
      success: function (data) {
        inicializarDataTable(data);
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Error al cargar los datos",
        });
      },
    });
  }

  // Inicializar DataTable con datos
  function inicializarDataTable(data) {
    var table = $("#tablaPrerequisitos").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json",
      },
      responsive: true,
      data: data,
      columns: [
        { data: "id" },
        { data: "codigo_prerequisito" },
        { data: "nombre_prerequisito" },
        { data: "codigo_asignatura" },
        { data: "nombre_asignatura" },
        { data: "codigo_programa" },
        { data: "nombre_programa" },
        {
          data: null,
          render: function (data, type, row) {
            return `
                        <div class="btn-group" role="group">
                            <button class='btn btn-sm btn-primary editar' title="Editar" data-id='${row.id}'><i class="bi bi-pencil-square"></i></button>
                            <button class='btn btn-sm btn-danger eliminar' title="Eliminar" data-id='${row.id}'><i class="bi bi-trash"></i></button>
                        </div>
                        `;
          },
          orderable: false,
        },
      ],
    });
  }

  // Cargar datos al iniciar
  cargarDatos();

  $("#modalCrear").on("show.bs.modal", function () {
    cargarSelectsCrear();
  });

  /* // Cargar selects cuando se abre el modal de editar
  $("#modalEditar").on("show.bs.modal", function () {
    cargarSelectsEditar();
  }); */

  // Manejar el envío del formulario de creación
  $("#formCrear").on("submit", function (e) {
    e.preventDefault();
    // Obtener los valores de código (supongo que es el value del select)
    const codigoPrerequisito = $(this)
      .find("#codigo_prerequisito, #codigo_prerequisito_editar")
      .val();
    const codigoAsignatura = $(this)
      .find("#codigo_asignatura, #codigo_asignatura_editar")
      .val();

    // Extraer los dos primeros caracteres
    const programaPrerequisito = codigoPrerequisito.substring(0, 2);
    const programaAsignatura = codigoAsignatura.substring(0, 2);

    // Comparar los códigos de programa
    if (programaPrerequisito !== programaAsignatura) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "El prerrequisito y la asignatura deben pertenecer al mismo programa.",
      });
      return; // cancelar el envío
    }

    if (Number(codigoPrerequisito) > Number(codigoAsignatura)) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "El prerrequisito no pueder ser de un semestre superior a el de la asignatura.",
      });
      return; // cancelar el envío
    }

    $.ajax({
      url: "backend_prerequisitos.php",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.success) {
          Swal.fire({
            icon: "success",
            title: "Éxito",
            text: response.message,
            //timer: 1500,
            showConfirmButton: true,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
          });
        }
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Error en la comunicación con el servidor",
        });
      },
    });
  });

  // Manejar el envío del formulario de edición
  $("#formEditar").on("submit", function (e) {
    e.preventDefault();

    // Obtener los valores de código (supongo que es el value del select)
    const codigoPrerequisito = $(this)
      .find("#codigo_prerequisito, #codigo_prerequisito_editar")
      .val();
    const codigoAsignatura = $(this)
      .find("#codigo_asignatura, #codigo_asignatura_editar")
      .val();

    // Extraer los dos primeros caracteres
    const programaPrerequisito = codigoPrerequisito.substring(0, 2);
    const programaAsignatura = codigoAsignatura.substring(0, 2);

    // Comparar los códigos de programa
    if (programaPrerequisito !== programaAsignatura) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "El prerrequisito y la asignatura deben pertenecer al mismo programa.",
      });
      return; // cancelar el envío
    }
    if (Number(codigoPrerequisito) > Number(codigoAsignatura)) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "El prerrequisito no pueder ser de un semestre superior a el de la asignatura.",
      });
      return; // cancelar el envío
    }

    $.ajax({
      url: "backend_prerequisitos.php",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.success) {
          Swal.fire({
            icon: "success",
            title: "Éxito",
            text: response.message,
            //timer: 1500,
            showConfirmButton: true,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
          });
        }
      },
    });
  });

  // Manejar clic en botón editar
  $(document).on("click", ".editar", function () {
    const id = $(this).data("id");
    const data = $("#tablaPrerequisitos")
      .DataTable()
      .row($(this).parents("tr"))
      .data();

    cargarSelectsEditar().then(() => {
      establecerValoresEdicion(data);
      $("#modalEditar").modal("show");
    });
  });

  function establecerValoresEdicion(data) {
    $("#id_editar").val(data.id);
    $("#codigo_prerequisito_editar")
      .val(data.codigo_prerequisito)
      .trigger("change");
    $("#nombre_prerequisito_editar").val(data.nombre_prerequisito);
    $("#codigo_asignatura_editar")
      .val(data.codigo_asignatura)
      .trigger("change");
    $("#nombre_asignatura_editar").val(data.nombre_asignatura);
    $("#codigo_programa_editar").val(data.codigo_programa).trigger("change");
    $("#nombre_programa_editar").val(data.nombre_programa);
  }

  // Manejar clic en botón eliminar
  $(document).on("click", ".eliminar", function () {
    const id = $(this).data("id");

    Swal.fire({
      title: "¿Estás seguro?",
      text: "No podrás revertir esta acción",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "backend_prerequisitos.php",
          type: "POST",
          data: { action: "eliminar", id: id },
          dataType: "json",
          success: function (response) {
            if (response.success) {
              Swal.fire({
                icon: "success",
                title: "Éxito",
                text: response.message,
                timer: 1500,
                showConfirmButton: false,
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Error",
                text: response.message,
              });
            }
          },
        });
      }
    });
  });
});

$("#codigo_prerequisito, #codigo_asignatura, #codigo_programa").on(
  "change",
  function () {
    const id = $(this).attr("id");
    const tipo = id.split("_")[1];
    const nombre = "nombre_" + tipo;
    const text = $(this).find("option:selected").text();
    const valor = $(this).val();
    const soloNombre = text.split(" | ")[1] || "";
    $("#" + nombre).val(soloNombre);

    // Si es asignatura, extraer los 2 primeros caracteres y setear el programa
    if (id === "codigo_asignatura" && valor) {
      const codPrograma = valor.substring(0, 2); // 🟡 suponiendo que el código de programa son los 2 primeros caracteres

      // Buscar la opción que empiece con ese código en el select de programa
      const $selectPrograma = $("#codigo_programa");
      const $option = $selectPrograma.find(`option[value^="${codPrograma}"]`);

      if ($option.length) {
        $selectPrograma.val($option.val()).trigger("change");
      } else {
        $selectPrograma.val("").trigger("change");
        $("#nombre_programa").val("No encontrado");
      }
    }
  }
);

$(
  "#codigo_prerequisito_editar, #codigo_asignatura_editar, #codigo_programa_editar"
).on("change", function () {
  const id = $(this).attr("id");
  const tipo = id.split("_")[1];
  const nombre = "nombre_" + tipo + "_editar";
  const text = $(this).find("option:selected").text();
  const valor = $(this).val();
  const soloNombre = text.split(" | ")[1] || "";
  $("#" + nombre).val(soloNombre);

  // Lógica para programa si es asignatura
  if (id === "codigo_asignatura_editar" && valor) {
    const codPrograma = valor.substring(0, 2);
    const $selectPrograma = $("#codigo_programa_editar");
    const $option = $selectPrograma.find(`option[value^="${codPrograma}"]`);

    if ($option.length) {
      $selectPrograma.val($option.val()).trigger("change");
    } else {
      $selectPrograma.val("").trigger("change");
      $("#nombre_programa_editar").val("No encontrado");
    }
  }
});

function cargarSelectsCrear() {
  const tipos = ["prerequisitos", "asignaturas", "programas"];

  tipos.forEach((tipo) => {
    $.get(
      "prerequisitos_select2.php",
      { tipo },
      function (data) {
        let select = $("#codigo_" + tipo.slice(0, -1));
        select.empty().append('<option value="">Seleccione</option>');

        data.forEach((opt) => {
          let extraData =
            tipo === "asignaturas" ? ` data-semestre="${opt.semestre}"` : "";
          select.append(
            `<option value="${opt.id}"${extraData}>${opt.id} | ${opt.text}</option>`
          );
        });

        // Inicializar Select2 después de cargar los options
        select.select2({
          theme: "bootstrap-5",
          width: "100%",
          dropdownParent: $("#modalCrear"),
        });
      },
      "json"
    );
  });
}
function cargarSelectsEditar() {
  const tipos = ["prerequisitos", "asignaturas", "programas"];
  const promesas = tipos.map((tipo) => {
    return new Promise((resolve) => {
      $.get(
        "prerequisitos_select2.php",
        { tipo },
        function (data) {
          let select = $("#codigo_" + tipo.slice(0, -1) + "_editar");
          select.empty().append('<option value="">Seleccione</option>');

          data.forEach((opt) => {
            let extraData =
              tipo === "asignaturas" ? ` data-semestre="${opt.semestre}"` : "";
            select.append(
              `<option value="${opt.id}"${extraData}>${opt.id} | ${opt.text}</option>`
            );
          });

          select.select2({
            theme: "bootstrap-5",
            width: "100%",
            dropdownParent: $("#modalEditar"),
          });

          resolve(); // ✅ IMPORTANTE: resolver la promesa después de inicializar select2
        },
        "json"
      );
    });
  });

  return Promise.all(promesas); // ✅ Espera a que todos los selects terminen
}
