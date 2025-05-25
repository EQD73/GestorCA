$(document).ready(function () {
  cargarSelects();

  inicializarSelect2("#codigo_programa", "#modalPensum");
  inicializarSelect2("#codigo_facultad", "#modalPensum");
  inicializarSelect2("#codigo_asignatura", "#modalPensum");

  //actualizar contador
  function actualizarContador() {
    const textarea = $("#comentarios")[0]; // Selecciona el textarea con jQuery
    const contador = $("#contadorComentarios");
    if (contador && textarea) {
      contador.text(textarea.value.length); // Actualiza el contador
    }
  }

  $("#comentarios").on("input", actualizarContador);

  const tabla = $("#tablaPensum").DataTable({
    ajax: {
      url: "pensum_crud.php",
      type: "POST",
      data: { accion: "listar" },
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "codigo_programa" },
      { data: "nombre_programa" },
      { data: "codigo_facultad" },
      { data: "nombre_facultad" },
      { data: "codigo_asignatura" },
      { data: "nom_asignatura" },
      { data: "semestre" },
      { data: "comentarios" },
      { data: "estado" },
      {
        data: null,
        className: "text-center",
        render: function (data, type, row) {
          return `
                    <div class="btn-group" role="group">
                      <button class="btn btn-sm btn-secondary btnEditar me-1" title="Editar">
                        <i class="bi bi-pencil-square"></i>
                      </button>
                      <button class="btn btn-sm btn-danger btnEliminar" title="Eliminar">
                        <i class="bi bi-trash"></i>
                      </button>
                    </div>
                  `;
        },
      },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
    },
  });

  $("#btnNuevo").click(function () {
    document.getElementById("modalPensumHeader").className =
      "modal-header bg-success text-white";
    document.getElementById("modalPensumLabel").textContent = "Nuevo Registro";
    const btnGuardar = document.getElementById("btnGuardar");
    btnGuardar.className = "btn btn-success";
    btnGuardar.innerHTML = '<i class="bi bi-save"></i> Guardar';

    $("#formPensum")[0].reset();
    $("#codigo_programa").val(null).trigger("change");
    $("#codigo_facultad").val(null).trigger("change");
    $("#codigo_asignatura").val(null).trigger("change");
    $("#estado").val(null).trigger("change");
    // Limpia los campos de nombre que se llenan automáticamente
    $("#nombre_programa").val("");
    $("#nombre_asignatura").val("");
    $("#nombre_facultad").val("");
    $("#semestre").val("");
    $("#accion").val("insertar");
    $("#id").val(""); // Asegura que no haya un ID (modo creación)
    cargarSelects();
    $("#modalPensum").modal("show");
  });

  $("#tablaPensum tbody").on("click", ".btnEditar", function () {
    const data = tabla.row($(this).parents("tr")).data();
    document.getElementById("modalPensumHeader").className =
      "modal-header bg-primary text-white";
    document.getElementById("modalPensumLabel").textContent = "Editar Registro";
    const btnGuardar = document.getElementById("btnGuardar");
    btnGuardar.className = "btn btn-primary";
    btnGuardar.innerHTML = '<i class="bi bi-pencil-square"></i> Actualizar';

    $("#id").val(data.id);
    $("#accion").val("editar");
    $("#formPensum [name=codigo_programa]")
      .val(data.codigo_programa)
      .trigger("change");
    $("#formPensum [name=codigo_facultad]")
      .val(data.codigo_facultad)
      .trigger("change");
    $("#formPensum [name=codigo_asignatura]")
      .val(data.codigo_asignatura)
      .trigger("change");
    $("#formPensum [name=nombre_asignatura]").val(data.nom_asignatura);
    $("#formPensum [name=semestre]").val(data.semestre);
    $("#formPensum [name=comentarios]").val(data.comentarios);
    $("#formPensum [name=estado]").val(data.estado);
    $("#modalPensumLabel").text("Editar Registro");
    /*  $('#comentarios').trigger('input'); // Para actualizar el contador */
    $("#modalPensum").modal("show");
  });

  $("#tablaPensum tbody").on("click", ".btnEliminar", function () {
    const data = tabla.row($(this).parents("tr")).data();
    Swal.fire({
      title: "¿Estás seguro?",
      text: `Se eliminará el registro de la asignatura "${data.nom_asignatura}"`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.post(
          "pensum_crud.php",
          { accion: "eliminar", id: data.id },
          function (res) {
            // const r = JSON.parse(res);
            Swal.fire(
              res.estado,
              res.mensaje,
              res.estado === "Éxito" ? "success" : "error"
            );
            tabla.ajax.reload();
          }
        );
      }
    });
  });

  $("#formPensum").submit(function (e) {
    e.preventDefault();

    const campos = [
      "codigo_programa",
      "codigo_facultad",
      "codigo_asignatura",
      "estado",
      "semestre",
    ];
    for (let campo of campos) {
      if (!$(`[name=${campo}]`).val()) {
        Swal.fire(
          "Error",
          `El campo "${campo.replace("_", " ")}" es obligatorio.`,
          "warning"
        );
        return;
      }
    }

    const semestre = parseInt($("[name=semestre]").val());
    if (isNaN(semestre) || semestre < 1 || semestre > 10) {
      Swal.fire(
        "Error",
        "El semestre debe ser un número entre 1 y 10.",
        "warning"
      );
      return;
    }

    const estado = $("[name=estado]").val().trim();
    if (estado !== "ACTIVO" && estado !== "INACTIVO") {
      Swal.fire(
        "Error",
        'El estado debe ser "ACTIVO" o "INACTIVO".',
        "warning"
      );
      return;
    }

    Swal.fire({
      title: "¿Deseas guardar los cambios?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Guardar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        let datos = $("#formPensum").serializeArray();
        datos.push({ name: "accion", value: $("#accion").val() });

        if ($("#accion").val() == "editar") {
          datos.push({ name: "id", value: $("#id").val() });
        }

        $.post(
          "pensum_crud.php",
          $.param(datos),
          function (res) {
            Swal.fire(
              res.estado,
              res.mensaje,
              res.estado === "Éxito" ? "success" : "error"
            );
            if (res.estado === "Éxito") {
              $("#modalPensum").modal("hide");
              tabla.ajax.reload();
            }
          },
          "json"
        );
      }
    });
  });
  $("#codigo_facultad, #codigo_asignatura, #codigo_programa").on(
    "change",
    function () {
      const id = $(this).attr("id");
      const tipo = id.split("_")[1];
      const nombre = "nombre_" + tipo;
      const text = $(this).find("option:selected").text();
      const valor = $(this).val();
      const soloNombre = text.split(" | ")[1] || "";
      $("#" + nombre).val(soloNombre);

      /*  // $('#' + nombre).val(text);
        if (id === 'codigo_asignatura') {
            const semestre = $(this).find('option:selected').data('semestre') || '';
            $('#semestre').val(semestre);
        }
 */

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
});

function inicializarSelect2(selector, modalSelector = null) {
  $(selector).select2({
    theme: "bootstrap-5",
    width: "100%",
    dropdownParent: modalSelector ? $(modalSelector) : $(document.body),
  });
}
function cargarSelects() {
  ["programas", "facultads", "asignaturas"].forEach((tipo) => {
    $.get(
      "pensum_select2.php",
      { tipo },
      function (data) {
        let select = $("#codigo_" + tipo.slice(0, -1));
        select.html('<option value="">Seleccione</option>');
        data.forEach((opt) => {
          let extraData =
            tipo === "asignaturas" ? ` data-semestre="${opt.semestre}"` : "";
          select.append(
            `<option value="${opt.id}"${extraData}>${opt.id} | ${opt.text}</option>`
          );
        });
        select.select2({
          width: "100%",
          theme: "bootstrap-5",
          dropdownParent: $("#modalPensum"),
        });
      },
      "json"
    );
  });
}
