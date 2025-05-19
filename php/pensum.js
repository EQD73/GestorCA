
$(document).ready(function () {
    //actualizar contador 
    function actualizarContador() {
        const textarea = $('#comentarios')[0]; // Selecciona el textarea con jQuery
        const contador = $('#contadorComentarios');
        if (contador && textarea) {
            contador.text(textarea.value.length); // Actualiza el contador
        }
    }

    $('#comentarios').on('input', actualizarContador);
    const tabla = $('#tablaPensum').DataTable({
        ajax: {
            url: 'pensum_crud.php',
            type: 'POST',
            data: { accion: 'listar' },
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'codigo_programa' },
            { data: 'codigo_facultad' },
            { data: 'codigo_asignatura' },
            { data: 'nom_asignatura' },
            { data: 'semestre' },
            { data: 'comentarios' },
            { data: 'estado' },
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
                }
            }

        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });

    $('#btnNuevo').click(function () {
        document.getElementById('modalPensumHeader').className = 'modal-header bg-success text-white';
        document.getElementById('modalPensumLabel').textContent = 'Nuevo Registro';
        const btnGuardar = document.getElementById('btnGuardar');
        btnGuardar.className = 'btn btn-success';
        btnGuardar.innerHTML = '<i class="bi bi-save"></i> Guardar';

        $('#formPensum')[0].reset();
        $('#accion').val('insertar');
        $('#modalPensum').modal('show');

    });

    $('#tablaPensum tbody').on('click', '.btnEditar', function () {
        const data = tabla.row($(this).parents('tr')).data();
        document.getElementById('modalPensumHeader').className = 'modal-header bg-primary text-white';
        document.getElementById('modalPensumLabel').textContent = 'Editar Registro';
        const btnGuardar = document.getElementById('btnGuardar');
        btnGuardar.className = 'btn btn-primary';
        btnGuardar.innerHTML = '<i class="bi bi-pencil-square"></i> Actualizar';



        $('#id').val(data.id);
        $('#accion').val('editar');
        $('#formPensum [name=codigo_programa]').val(data.codigo_programa);
        $('#formPensum [name=codigo_facultad]').val(data.codigo_facultad);
        $('#formPensum [name=codigo_asignatura]').val(data.codigo_asignatura);
        $('#formPensum [name=nom_asignatura]').val(data.nom_asignatura);
        $('#formPensum [name=semestre]').val(data.semestre);
        $('#formPensum [name=comentarios]').val(data.comentarios);
        $('#formPensum [name=estado]').val(data.estado);
        $('#modalPensumLabel').text('Editar Registro');
        /*  $('#comentarios').trigger('input'); // Para actualizar el contador */
        $('#modalPensum').modal('show');
    });

    $('#tablaPensum tbody').on('click', '.btnEliminar', function () {
        const data = tabla.row($(this).parents('tr')).data();
        Swal.fire({
            title: '¿Estás seguro?',
            text: `Se eliminará el registro de la asignatura "${data.nom_asignatura}"`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('pensum_crud.php', { accion: 'eliminar', id: data.id }, function (res) {
                    // const r = JSON.parse(res);
                    Swal.fire(res.estado, res.mensaje, res.estado === 'Éxito' ? 'success' : 'error');
                    tabla.ajax.reload();
                });
            }
        });
    });

    $('#formPensum').submit(function (e) {
        e.preventDefault();

        const campos = ['codigo_programa', 'codigo_facultad', 'codigo_asignatura', 'nom_asignatura', 'semestre'];
        for (let campo of campos) {
            if (!$(`[name=${campo}]`).val()) {
                Swal.fire('Error', `El campo "${campo.replace('_', ' ')}" es obligatorio.`, 'warning');
                return;
            }
        }

        const semestre = parseInt($('[name=semestre]').val());
        if (isNaN(semestre) || semestre < 1 || semestre > 10) {
            Swal.fire('Error', 'El semestre debe ser un número entre 1 y 10.', 'warning');
            return;
        }

        const estado = $('[name=estado]').val().trim();
        if (estado !== 'ACTIVO' && estado !== 'INACTIVO') {
            Swal.fire('Error', 'El estado debe ser "ACTIVO" o "INACTIVO".', 'warning');
            return;
        }


        Swal.fire({
            title: '¿Deseas guardar los cambios?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                let datos = $('#formPensum').serializeArray();
                datos.push({ name: 'accion', value: $('#accion').val() });

                if ($('#accion').val() == 'editar') {
                    datos.push({ name: 'id', value: $('#id').val() });
                }

                $.post('pensum_crud.php', $.param(datos), function (res) {
                    Swal.fire(res.estado, res.mensaje, res.estado === 'Éxito' ? 'success' : 'error');
                    if (res.estado === 'Éxito') {
                        $('#modalPensum').modal('hide');
                        tabla.ajax.reload();
                    }
                }, 'json');
            }

        });
    });


});


