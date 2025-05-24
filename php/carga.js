let tabla; // Definir como variable global

$(document).ready(function () {
    cargarSelects();
    cargarRegistros();
    inicializarSelect2('#codigo_docente', '#modalFormulario');
    inicializarSelect2('#codigo_asignatura', '#modalFormulario');
    inicializarSelect2('#codigo_programa', '#modalFormulario');
    inicializarSelect2('#codigo_periodo', '#modalFormulario');


   /*  tabla = $('#tabla').DataTable({  // Inicializar correctamente
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
        }
    });
 */
$('#tabla').DataTable({
  ajax: {
    url: 'carga_crud.php',
    type: 'POST',
    data: {
      accion: 'leer'
    },
    dataSrc: '' // o 'data' si tu respuesta es { data: [...] }
  },
  columns: [
    { data: 'id' },
    { data: 'codigo_docente' },
    { data: 'nombre_docente' },
    { data: 'codigo_asignatura' },
    { data: 'nom_asignatura' },
    { data: 'codigo_programa' },
    { data: 'nombre_programa' },
    { data: 'codigo_periodo' },
    { data: 'nombre_periodo' },
    { data: 'semestre' },
    { data: 'grupo' },
      {
          data: null,
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
                    orderable: false
        }
    ],
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
            const formData = new FormData(this);
            formData.append('accion', $('#accion').val());
            
            if ($('#accion').val() == 'editar') {
                formData.append('id', $('#id').val());
            }

            // Mostrar modal de progreso mejorado
            const progressSwal = Swal.fire({
                title: 'Procesando actualización...',
                html: `
                    <div class="progress-container">
                        <div class="progress mb-3">
                            <div id="globalProgress" class="progress-bar progress-bar-striped progress-bar-animated" 
                                 role="progressbar" style="width: 0%"></div>
                        </div>
                        <div id="globalStatus" class="status-text">Iniciando proceso...</div>
                        
                        <div class="mt-4">
                            <h6>Progreso detallado:</h6>
                            <div class="table-progress">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Tabla principal</td>
                                            <td><div class="progress"><div id="progressMain" class="progress-bar" style="width: 0%"></div></div></td>
                                            <td id="statusMain" class="status">Pendiente</td>
                                        </tr>
                                        <tr>
                                            <td>Tabla M1</td>
                                            <td><div class="progress"><div id="progressM1" class="progress-bar" style="width: 0%"></div></div></td>
                                            <td id="statusM1" class="status">Pendiente</td>
                                        </tr>
                                        <tr>
                                            <td>Tabla M2</td>
                                            <td><div class="progress"><div id="progressM2" class="progress-bar" style="width: 0%"></div></div></td>
                                            <td id="statusM2" class="status">Pendiente</td>
                                        </tr>
                                        <tr>
                                            <td>Tabla M3</td>
                                            <td><div class="progress"><div id="progressM3" class="progress-bar" style="width: 0%"></div></div></td>
                                            <td id="statusM3" class="status">Pendiente</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                `,
                allowOutsideClick: false,
                showConfirmButton: false,
                width: '700px',
                didOpen: () => {
                    Swal.showLoading();
                    
                    // Animación inicial
                    updateProgress('globalProgress', 'globalStatus', 10, 'Validando datos...');
                    
                    // Simular progreso mientras se espera la respuesta
                    const steps = [
                        {target: 'progressMain', status: 'statusMain', percent: 30, message: 'Actualizando tabla principal...'},
                        {target: 'progressM1', status: 'statusM1', percent: 50, message: 'Actualizando Microcurrículo (M1)...'},
                        {target: 'progressM2', status: 'statusM2', percent: 70, message: 'Actualizando Consignador Académico (M2)...'},
                        {target: 'progressM3', status: 'statusM3', percent: 90, message: 'Actualizando Registro de Actividades (M3)...'}
                    ];
                    
                    steps.forEach((step, i) => {
                        setTimeout(() => {
                            if (!progressSwal.isClosed) {
                                updateProgress(step.target, step.status, step.percent, step.message);
                                if (i === steps.length - 1) {
                                    updateProgress('globalProgress', 'globalStatus', 95, 'Finalizando proceso...');
                                }
                            }
                        }, (i + 1) * 6800);
                    });
                }
            });

            // Función para actualizar progreso
            function updateProgress(barId, statusId, percent, message) {
                $(`#${barId}`).css('width', percent + '%');
                if (statusId && message) {
                    $(`#${statusId}`).text(message);
                }
            }

            // Enviar la petición
            fetch('carga_crud.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Actualizar al 100% cuando se complete
                updateProgress('globalProgress', 'globalStatus', 100, 'Proceso completado');
                
                // Mostrar resultados reales
                if (data.estado === 'Éxito') {
                    // Actualizar estados con información real
                    $('#statusMain').html('Completado ✓');
                    if (data.docente_cambiado) {
                        $('#statusM1').html(`Completado (${data.filas_afectadas.m1} filas)`);
                        $('#statusM2').html(`Completado (${data.filas_afectadas.m2} filas)`);
                        $('#statusM3').html(`Completado (${data.filas_afectadas.m3} filas)`);
                        $('#progressM1, #progressM2, #progressM3').css('width', '100%');
                    } else {
                        $('#statusM1, #statusM2, #statusM3').html('No requerido');
                    }
                    
                    // Esperar 2 segundos para mostrar los resultados
                    setTimeout(() => {
                        progressSwal.close();
                        Swal.fire({
                            title: '¡Actualización exitosa!',
                            html: `
                                <div class="text-start">
                                    <p>${data.mensaje}</p>
                                    <div class="mt-3">
                                        <h6>Detalle de actualizaciones:</h6>
                                        <ul>
                                            <li>Tabla principal: Actualizada</li>
                                            ${data.docente_cambiado ? `
                                            <li>Microcurrículo (M1): ${data.filas_afectadas.m1} filas actualizadas</li>
                                            <li>Consignador (M2): ${data.filas_afectadas.m2} filas actualizadas</li>
                                            <li>Registros (M3): ${data.filas_afectadas.m3} filas actualizadas</li>
                                            ` : '<li>No se requirieron cambios en tablas relacionadas</li>'}
                                        </ul>
                                        <small class="text-muted">Tiempo de ejecución: ${data.detalle}</small>
                                    </div>
                                </div>
                            `,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            $('#modalFormulario').modal('hide');
                            cargarRegistros();
                        });
                    }, 6000);
                } else {
                    progressSwal.close();
                    Swal.fire({
                        title: 'Error',
                        html: `<p>${data.mensaje}</p>
                               ${data.error_sql ? `<small class="text-muted">Detalle SQL: ${JSON.stringify(data.error_sql)}</small>` : ''}`,
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                progressSwal.close();
                Swal.fire('Error', 'Error en la conexión: ' + error.message, 'error');
            });
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


    $('#tabla tbody').on('click', '.btnEditar', function () {
    //alert('aqui estoy');

    const tabla = $('#tabla').DataTable();
    const data = tabla.row($(this).closest('tr')).data();
        if (!data) {
        alert("No se encontraron datos para la fila seleccionada.");
        return;
    }

    document.getElementById('modalCargaHeader').className = 'modal-header bg-primary text-white';
    document.getElementById('modalCargaLabel').textContent = 'Editar Registro';

    const btnGuardar = document.getElementById('btnGuardar');
    btnGuardar.className = 'btn btn-primary';
    btnGuardar.innerHTML = '<i class="bi bi-pencil-square"></i> Actualizar';

    // Armar objeto de datos
    const d = {
       
        id: data.id,
        codigo_docente: data.codigo_docente,
        nombre_docente: data.nombre_docente,
        codigo_asignatura: data.codigo_asignatura,
        nom_asignatura: data.nom_asignatura,
        codigo_programa: data.codigo_programa,
        nombre_programa: data.nombre_programa,
        codigo_periodo: data.codigo_periodo,
        nombre_periodo: data.nombre_periodo,
        semestre: data.semestre,
        grupo: data.grupo,
        
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
            id: data.id,
            nom_asignatura: data.nom_asignatura
        };
        //console.log(d);
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

/* function cargarRegistros() {
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
} */

    /* function cargarRegistros() {
    $.post('carga_crud.php', { accion: 'leer' }, function (data) {
        const tabla = $('#tabla').DataTable();
        tabla.clear().destroy(); // Destruir la tabla existente completamente
        
        // Recrear la tabla con los nuevos datos
        tabla = $('#tabla').DataTable({
            data: data,
            columns: [
                { data: 'id' },
                { data: 'codigo_docente' },
                { data: 'nombre_docente' },
                { data: 'codigo_asignatura' },
                { data: 'nom_asignatura' },
                { data: 'codigo_programa' },
                { data: 'nombre_programa' },
                { data: 'codigo_periodo' },
                { data: 'nombre_periodo' },
                { data: 'semestre' },
                { data: 'grupo' },
                { 
                    data: null,
                    render: function(data, type, row) {
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
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            }
        });
    }, 'json').fail(function() {
        Swal.fire('Error', 'No se pudieron cargar los registros', 'error');
    });
} */
function cargarRegistros() {
    $.post('carga_crud.php', { accion: 'leer' }, function (data) {
        // Verificar si la tabla ya está inicializada
        if ($.fn.DataTable.isDataTable('#tabla')) {
            $('#tabla').DataTable().destroy();
        }
        
        $('#tabla').DataTable({
            data: data,
            columns: [
                { data: 'id' },
                { data: 'codigo_docente' },
                { data: 'nombre_docente' },
                { data: 'codigo_asignatura' },
                { data: 'nom_asignatura' },
                { data: 'codigo_programa' },
                { data: 'nombre_programa' },
                { data: 'codigo_periodo' },
                { data: 'nombre_periodo' },
                { data: 'semestre' },
                { data: 'grupo' },
                { 
                    data: null,
                    render: function(data, type, row) {
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
                    orderable: false
                }
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            }
        });
    }, 'json').fail(function(jqXHR) {
        Swal.fire({
            title: 'Error',
            text: 'Error al cargar datos: ' + (jqXHR.responseJSON?.mensaje || jqXHR.statusText),
            icon: 'error'
        });
    });
}

function inicializarSelect2(selector, modalSelector = null) {
    $(selector).select2({
        theme: 'bootstrap-5',
        width: '100%',
        dropdownParent: modalSelector ? $(modalSelector) : $(document.body)
    });
}


function editar(d) {
    //console.log('Datos recibidos para editar:', d); // Agrega esto para depuración
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
        $('#codigo_asignatura').append(new Option(d.codigo_asignatura + ' | ' + d.nom_asignatura, d.codigo_asignatura, true, true)).trigger('change');
    } else {
        $('#codigo_asignatura').val(d.codigo_asignatura).trigger('change');
    }
    $('#nombre_asignatura').val(d.nom_asignatura);

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
