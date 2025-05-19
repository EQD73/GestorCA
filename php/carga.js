let tabla; // Definir como variable global

$(document).ready(function () {
    cargarSelects();
    cargarRegistros();
    inicializarSelect2('#codigo_docente', '#modalFormulario');
    inicializarSelect2('#codigo_asignatura', '#modalFormulario');
    inicializarSelect2('#codigo_programa', '#modalFormulario');
    inicializarSelect2('#codigo_periodo', '#modalFormulario');


    tabla = $('#tabla').DataTable({  // Inicializar correctamente
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
        }
    });

    $('#btnNuevo').on('click', function () {
        document.getElementById('modalCargaHeader').className = 'modal-header bg-success text-white';
        document.getElementById('modalCargaLabel').textContent = 'Nuevo Registro';
        const btnGuardar = document.getElementById('btnGuardar');
        btnGuardar.className = 'btn btn-success';
        btnGuardar.innerHTML = '<i class="bi bi-save"></i> Guardar';


        $('#formCarga')[0].reset(); // Limpia el formulario
        // Limpia y reinicia los selects con Select2
        $('#codigo_docente').val(null).trigger('change');
        $('#codigo_asignatura').val(null).trigger('change');
        $('#codigo_programa').val(null).trigger('change');
        $('#codigo_periodo').val(null).trigger('change');
        // Limpia los campos de nombre que se llenan automáticamente
        $('#nombre_docente').val('');
        $('#nombre_asignatura').val('');
        $('#nombre_programa').val('');
        $('#nombre_periodo').val('');

        $('#id').val(''); // Asegura que no haya un ID (modo creación)
        $('#accion').val('crear');
        cargarSelects();
        $('#modalFormulario').modal('show'); // Muestra el modal
    });


    $('#formCarga').on('submit', function (e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Deseas guardar los cambios?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                let datos = $('#formCarga').serializeArray();
                datos.push({ name: 'accion', value: $('#accion').val() });

                if ($('#accion').val() == 'editar') {
                    datos.push({ name: 'id', value: $('#id').val() });
                }

                $.post('carga_crud.php', $.param(datos), function (res) {
                    Swal.fire(res.estado, res.mensaje, res.estado === 'Éxito' ? 'success' : 'error');
                    if (res.estado === 'Éxito') {
                        $('#modalFormulario').modal('hide');
                        cargarRegistros();
                    }
                }, 'json');
            }

        });
    });


    $('#codigo_docente, #codigo_asignatura, #codigo_programa, #codigo_periodo').on('change', function () {
        const id = $(this).attr('id');
        const tipo = id.split('_')[1];
        const nombre = 'nombre_' + tipo;
        const text = $(this).find('option:selected').text();
        const valor = $(this).val();
        const soloNombre = text.split(' | ')[1] || '';
        $('#' + nombre).val(soloNombre);

        // $('#' + nombre).val(text);
        if (id === 'codigo_asignatura') {
            const semestre = $(this).find('option:selected').data('semestre') || '';
            $('#semestre').val(semestre);
        }


        // Si es asignatura, extraer los 2 primeros caracteres y setear el programa
        if (id === 'codigo_asignatura' && valor) {
            const codPrograma = valor.substring(0, 2); // 🟡 suponiendo que el código de programa son los 2 primeros caracteres

            // Buscar la opción que empiece con ese código en el select de programa
            const $selectPrograma = $('#codigo_programa');
            const $option = $selectPrograma.find(`option[value^="${codPrograma}"]`);

            if ($option.length) {
                $selectPrograma.val($option.val()).trigger('change');
            } else {
                $selectPrograma.val('').trigger('change');
                $('#nombre_programa').val('No encontrado');
            }
        }
    });



    // Evento para botón Editar
    $('#tabla tbody').on('click', '.btnEditar', function () {
        const tabla = $('#tabla').DataTable();
        const data = tabla.row($(this).closest('tr')).data();
        document.getElementById('modalCargaHeader').className = 'modal-header bg-primary text-white';
        document.getElementById('modalCargaLabel').textContent = 'Editar Registro';
        const btnGuardar = document.getElementById('btnGuardar');
        btnGuardar.className = 'btn btn-primary';
        btnGuardar.innerHTML = '<i class="bi bi-pencil-square"></i> Actualizar';

        // Armar objeto con claves esperadas en la función editar(d)
        const d = {
            id: data[0],
            codigo_docente: data[1],
            nombre_docente: data[2],
            codigo_asignatura: data[3],
            nombre_asignatura: data[4],
            codigo_programa: data[5],
            nombre_programa: data[6],
            codigo_periodo: data[7],
            nombre_periodo: data[8],
            semestre: data[9],
            grupo: data[10],
        };

        editar(d);
    });
    $('#codigo_programa').on('select2:opening select2:unselecting', function (e) {
        e.preventDefault();
    });

    $('#tabla tbody').on('click', '.btnEliminar', function () {
        // const data = tabla.row($(this).parents('tr')).data();
        const data = tabla.row($(this).closest('tr')).data();
        const d = {
            id: data[0],
            nombre_asignatura: data[4]
        };
        console.log(d);
        Swal.fire({
            title: '¿Estás seguro?',
            text: `Se eliminará el registro de la asignatura "${d.nombre_asignatura}"`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('carga_crud.php', { accion: 'eliminar', id: d.id }, function (res) {
                    const r = JSON.parse(res);
                    Swal.fire(r.estado, r.mensaje, r.estado === 'Éxito' ? 'success' : 'error');
                    //tabla.clear();               // limpia la tabla
                    cargarRegistros();
                    //tabla.draw();

                });
            }
        });
    });

});

function cargarSelects() {
    ['docentes', 'asignaturas', 'programas', 'periodos'].forEach(tipo => {
        $.get('carga_select2.php', { tipo }, function (data) {
            let select = $('#codigo_' + tipo.slice(0, -1));
            select.html('<option value="">Seleccione</option>');
            data.forEach(opt => {
                let extraData = tipo === 'asignaturas' ? ` data-semestre="${opt.semestre}"` : '';
                select.append(`<option value="${opt.id}"${extraData}>${opt.id} | ${opt.text}</option>`);
            });
            select.select2({
                width: '100%',
                theme: 'bootstrap-5',
                dropdownParent: $('#modalFormulario')
            });
        }, 'json');
    });
}

function cargarRegistros() {
    $.post('carga_crud.php', { accion: 'leer' }, function (data) {
        const tabla = $('#tabla').DataTable();
        tabla.clear(); // Limpiar datos anteriores

        data.forEach(d => {
            tabla.row.add([
                d.id,
                d.codigo_docente, d.nombre_docente,
                d.codigo_asignatura, d.nom_asignatura,
                d.codigo_programa, d.nombre_programa,
                d.codigo_periodo, d.nombre_periodo,
                d.semestre, d.grupo,
                `<div class="btn-group" role="group">
                           <button class="btn btn-sm btn-secondary btnEditar me-1" title="Editar">
                             <i class="bi bi-pencil-square"></i>
                           </button>
                           <button class="btn btn-sm btn-danger btnEliminar" title="Eliminar">
                             <i class="bi bi-trash"></i>
                           </button>
                         </div>
                       `
            ]);
        });

        tabla.draw(); // Redibujar tabla con nuevos datos
    }, 'json');
}

function inicializarSelect2(selector, modalSelector = null) {
    $(selector).select2({
        theme: 'bootstrap-5',
        width: '100%',
        dropdownParent: modalSelector ? $(modalSelector) : $(document.body)
    });
}


function editar(d) {
    $('#id').val(d.id);
    $('#accion').val('editar');

    // Docente
    if (!$('#codigo_docente option[value="' + d.codigo_docente + '"]').length) {
        $('#codigo_docente').append(new Option(d.codigo_docente + ' | ' + d.nombre_docente, d.codigo_docente, true, true)).trigger('change');
    } else {
        $('#codigo_docente').val(d.codigo_docente).trigger('change');
    }
    $('#nombre_docente').val(d.nombre_docente);

    // Asignatura
    if (!$('#codigo_asignatura option[value="' + d.codigo_asignatura + '"]').length) {
        $('#codigo_asignatura').append(new Option(d.codigo_asignatura + ' | ' + d.nombre_asignatura, d.codigo_asignatura, true, true)).trigger('change');
    } else {
        $('#codigo_asignatura').val(d.codigo_asignatura).trigger('change');
    }
    $('#nombre_asignatura').val(d.nombre_asignatura);

    // Programa
    if (!$('#codigo_programa option[value="' + d.codigo_programa + '"]').length) {
        $('#codigo_programa').append(new Option(d.codigo_programa + ' | ' + d.nombre_programa, d.codigo_programa, true, true)).trigger('change');
    } else {
        $('#codigo_programa').val(d.codigo_programa).trigger('change');
    }
    $('#nombre_programa').val(d.nombre_programa);

    // Periodo
    if (!$('#codigo_periodo option[value="' + d.codigo_periodo + '"]').length) {
        $('#codigo_periodo').append(new Option(d.codigo_periodo + ' | ' + d.nombre_periodo, d.codigo_periodo, true, true)).trigger('change');
    } else {
        $('#codigo_periodo').val(d.codigo_periodo).trigger('change');
    }
    $('#nombre_periodo').val(d.nombre_periodo);

    $('#semestre').val(d.semestre);
    $('#grupo').val(d.grupo);

    $('#modalFormulario').modal('show');
}
