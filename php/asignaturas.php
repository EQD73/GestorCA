<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];
$periodo = $_SESSION['codigo_periodo'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.5.2/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        #asignaturasTable {
            font-size: 13px;
            padding: 10px;
        }


        body {
            padding-top: 20px;
        }

        .modal-lg {
            max-width: 800px;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        #asignaturasTable td.acciones-cell {
            padding-top: 4px;
            padding-bottom: 4px;
        }

        .btn-group-sm>.btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .btn-accion:hover {
            transform: scale(1.05);
            transition: transform 0.2s;
        }

        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__rendered {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice {
            display: flex;
            align-items: center;
            background: #e9ecef;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
        }

        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice__remove {
            order: 2;
            margin-left: 0.5rem;
            color: #6c757d;
        }

        .prerequisitos-disabled .select2-selection {
            background-color: #e9ecef;
            opacity: 0.7;
            pointer-events: none;
        }

        .select2-container--disabled .select2-selection--multiple {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }

        .select2-container--disabled .select2-selection--multiple .select2-selection__choice {
            background-color: #e9ecef;
            opacity: 0.9;
            border: 1px solid #dee2e6;
        }

        .select2-container--disabled .select2-selection--multiple .select2-selection__choice__remove {
            display: none;
        }

        /* Agrega esto a tu sección <style> */
        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice {
            display: inline-flex;
            align-items: center;
            border: none !important;
            padding: 0.25rem 0.5rem !important;
            margin-right: 4px !important;
            margin-bottom: 4px !important;
            border-radius: 10px !important;
            color: white !important;
        }

        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice__remove {
            color: white !important;
            margin-left: 6px !important;
            order: 2;
        }

        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #f8f9fa !important;
        }

        .swal2-popup {
            font-family: inherit;
            border-radius: 0.5rem;
        }

        .swal2-title {
            font-size: 1.25rem;
        }

        .swal2-confirm {
            background-color: #0d6efd !important;
        }

        .select2-container .select2-dropdown .select2-results {
            max-height: 250px;
            /* Ajusta esta altura a tu gusto */
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div id="app">
        <?php include("cargue_menul.html"); ?>
        <div id="main">
            <nav class="navbar navbar-header navbar-expand navbar-light">
                <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex align-items-center navbar-light ms-auto">
                        <li class="dropdown nav-icon">
                            <a href="#" data-bs-toggle="dropdown" class="nav-link  dropdown-toggle nav-link-lg nav-link-user">
                                <div class="d-lg-inline-block">
                                    <i data-feather="bell"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-large">
                                <h6 class='py-2 px-4'>Notificaciones</h6>
                                <ul class="list-group rounded-none">
                                    <li class="list-group-item border-0 align-items-start">
                                        <div class="avatar bg-success me-3">
                                            <span class="avatar-content"><i data-feather="alert-circle"></i></span>
                                        </div>
                                        <div>
                                            <h6 class='text-bold'>Aviso</h6>
                                            <p class='text-xs'>
                                                No ha ingresado informacion en las ultimas dos semanas
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="avatar me-1">
                                    <img src="../assets/images/avatar/avatarX.png" alt="" srcset="">
                                </div>
                                <div class="d-none d-md-block d-lg-inline-block">Hola, <?php echo $nombre; ?></div><br>
                                <div class="d-none d-md-block d-lg-inline-block"><?php echo $_SESSION['nombre_rol']; ?></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#"><i data-feather="user"></i> Cuenta/Perfil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php" onclick="cerrarsession()"><i data-feather="log-out"></i>Salir</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container mt-4">
                <h3 class="text-center mb-4">Gestión CRUD de Asignaturas</h3>
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#asignaturaModal" onclick="resetForm()">
                        <i class="bi bi-plus-circle"></i> Nueva Asignatura
                    </button>
                </div>


                <table id="asignaturasTable" class="table table-striped table-bordered mt-1" style="width:100%">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Programa</th>
                            <th>Nombre Programa</th>
                            <th>IHS</th>
                            <th>Créditos</th>
                            <!-- <th>Prerrequisitos</th> -->
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <!-- Modal para agregar/editar asignatura -->
                <div class="modal fade" id="asignaturaModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" id="modalAsignaturasHeader">
                                <h5 class="modal-title" id="modalAsignaturasTitle">Nueva Asignatura</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="asignaturaForm">
                                <input type="hidden" id="id" name="id">
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="codigo_asignatura" class="form-label">Código Asignatura*</label>
                                            <input type="text" class="form-control" id="codigo_asignatura" name="codigo_asignatura" required>
                                        </div>
                                        <div class="col-md-9">
                                            <label for="nom_asignatura" class="form-label">Nombre Asignatura*</label>
                                            <input type="text" class="form-control" id="nom_asignatura" name="nom_asignatura" style="text-transform: uppercase;" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="codigo_programa">Programa*</label>
                                            <select id="codigo_programa" name="codigo_programa" class="form-select" required></select>
                                        </div>
                                        <div class="col-md-9">
                                            <label for="nombre_programa">Nombre Programa</label>
                                            <input type="text" id="nombre_programa" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="ihs" class="form-label">IHS</label>
                                            <input type="number" class="form-control" id="ihs" name="ihs">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="creditos" class="form-label">Créditos</label>
                                            <input type="number" class="form-control" id="creditos" name="creditos">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="prerequisito" class="form-label">Prerrequisitos</label>
                                        <select class="form-select" id="prerequisito" name="prerequisito[]" multiple="multiple" disabled>
                                            <!-- Las opciones se cargarán dinámicamente -->
                                        </select>
                                        <small class="text-muted">Los prerrequisitos se gestionan desde el módulo correspondiente</small>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" id="btnGuardar" class="btn btn-primary">Guardar</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/main.js"></script>

    <script>
        function mostrarAlerta(icono, titulo, mensaje) {
            Swal.fire({
                icon: icono,
                title: titulo,
                text: mensaje,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
        }
        //**// */
        let dataTable;
        let asignaturaActual = null;

        $(document).ready(function() {
            cargarSelects();
            inicializarSelect2("#codigo_programa", "#asignaturaForm");
            //cargarAsignaturasParaPrerequisitos();

            // Inicializar DataTable
            dataTable = $('#asignaturasTable').DataTable({
                ajax: {
                    url: 'backend_asignaturas3.php',
                    type: 'GET',
                    data: {
                        action: 'list'
                    },
                    dataSrc: ''
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'codigo_asignatura'
                    },
                    {
                        data: 'nom_asignatura'
                    },
                    {
                        data: 'codigo_programa'
                    },
                    {
                        data: 'nombre_programa'
                    },
                    {
                        data: 'ihs'
                    },
                    {
                        data: 'creditos'
                    },
                    /* {
                        data: 'prerequisitos',
                        render: function(data, type, row) {
                            if (data && data.length > 0) {
                                return data.map(p => p.codigo_prerequisito).join(', ');
                            }
                            return 'Ninguno';
                        }
                    }, */
                    {
                        data: null,
                        className: "acciones-cell",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-info btn-accion" onclick="viewDetails(${row.id})" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-accion" onclick="editAsignatura(${row.id})" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-accion" onclick="deleteAsignatura(${row.id})" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });


            $('#asignaturaForm').submit(function(e) {
                e.preventDefault();

                const formData = {
                    id: $('#id').val(),
                    codigo_asignatura: $('#codigo_asignatura').val(),
                    nom_asignatura: $('#nom_asignatura').val(),
                    codigo_programa: $('#codigo_programa').val(),
                    ihs: $('#ihs').val(),
                    creditos: $('#creditos').val(),
                    action: $('#id').val() ? 'update' : 'create'
                };

                // Validación básica
                if (!formData.codigo_asignatura || !formData.nom_asignatura || !formData.codigo_programa) {
                    mostrarAlerta('error', 'Error', 'Por favor complete los campos requeridos');
                    return;
                }

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: $('#id').val() ? '¿Deseas actualizar esta asignatura?' : '¿Deseas crear esta nueva asignatura?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mostrar loader durante la operación
                        Swal.fire({
                            title: 'Procesando',
                            html: 'Por favor espere...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: 'backend_asignaturas3.php',
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            success: function(response) {
                                Swal.close();
                                if (response.success) {
                                    $('#asignaturaModal').modal('hide');
                                    dataTable.ajax.reload();
                                    mostrarAlerta('success', 'Éxito', response.message);
                                } else {
                                    mostrarAlerta('error', 'Error', response.message);
                                }
                            },
                            error: function(xhr) {
                                Swal.close();
                                mostrarAlerta('error', 'Error', 'Error en la solicitud: ' + xhr.responseText);
                            }
                        });
                    }
                });
            });
        });

        // Modificar la función resetForm
        function resetForm() {
            document.getElementById("modalAsignaturasHeader").className = "modal-header bg-primary text-white";
            document.getElementById("modalAsignaturasTitle").textContent = "Nueva Asignatura";
            const btnGuardar = document.getElementById("btnGuardar");
            btnGuardar.className = "btn btn-primary";
            btnGuardar.innerHTML = '<i class="bi bi-save"></i> Guardar';

            $('#asignaturaForm')[0].reset();
            $('#id').val('');
            $('#asignaturaForm input, #asignaturaForm select, #asignaturaForm textarea').prop('disabled', false);
            $('#asignaturaModal .modal-footer').show();
            $("#codigo_programa").val(null).trigger("change");

            // Configurar Select2 para prerrequisitos
            const $prerequisitoSelect = $('#prerequisito');
            $prerequisitoSelect.empty();

            // Habilitar temporalmente para inicializar Select2
            $prerequisitoSelect.prop('disabled', false);


            $prerequisitoSelect.select2({
                theme: 'bootstrap-5',
                placeholder: 'No hay prerrequisitos definidos',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#asignaturaModal'),
                closeOnSelect: false,
                disabled: true, // Deshabilitar después de inicializar
                templateSelection: function(data) {
                    // Determinar el color basado en el código de la asignatura
                    var color = obtenerColorPorCodigo(data.id);
                    return $('<span>')
                        .text(data.text)
                        .css('background-color', color)
                        .css('color', 'black')
                        .css('padding', '2px 8px')
                        .css('border-radius', '10px')
                        .css('margin-right', '4px');
                }

            });

            // Deshabilitar la interacción
            $prerequisitoSelect.prop('disabled', true);
            $prerequisitoSelect.next('.select2-container').css('pointer-events', 'none');
            $prerequisitoSelect.next('.select2-container').css('opacity', '0.7');

            $('#asignaturaForm input, #asignaturaForm textarea').prop('disabled', false);
            $('#btnGuardar').show();
            $('#asignaturaModal .modal-footer').show();
        }


        // Modificar la función editAsignatura
        function editAsignatura(id) {
            $.ajax({
                url: 'backend_asignaturas3.php',
                type: 'GET',
                data: {
                    action: 'get',
                    id: id
                },
                success: function(response) {
                    if (response.success) {

                        console.log("Respuesta del backend:", response);
                        const prerequisitos = response?.data?.prerequisitos;
                        const asignatura = response.data;

                        // Llenar campos básicos
                        $('#id').val(asignatura.id);
                        $('#codigo_asignatura').val(asignatura.codigo_asignatura);
                        $('#nom_asignatura').val(asignatura.nom_asignatura);
                        $('#codigo_programa').val(asignatura.codigo_programa).trigger('change');
                        $('#nombre_programa').val(asignatura.nombre_programa);
                        $('#ihs').val(asignatura.ihs);
                        $('#creditos').val(asignatura.creditos);

                        // Configurar Select2 para prerrequisitos
                        const $prerequisitoSelect = $('#prerequisito');

                        // Destruir Select2 si ya estaba inicializado
                        if ($prerequisitoSelect.hasClass('select2-hidden-accessible')) {
                            $prerequisitoSelect.select2('destroy');
                        }

                        // Limpiar y habilitar temporalmente
                        $prerequisitoSelect.empty().prop('disabled', false);

                        $prerequisitoSelect.select2({
                            theme: 'bootstrap-5',
                            placeholder: 'No hay prerrequisitos definidos',
                            allowClear: false,
                            width: '100%',
                            dropdownParent: $('#asignaturaModal'),
                            closeOnSelect: false,
                            templateSelection: function(data) {
                                var color = obtenerColorPorCodigo(data.id);
                                return $('<span>')
                                    .text(data.text)
                                    .css('background-color', color)
                                    .css('color', 'black')
                                    .css('padding', '2px 8px')
                                    .css('border-radius', '10px')
                                    .css('margin-right', '4px');
                            }

                        });

                        // Procesar los prerrequisitos del JSON
                        if (Array.isArray(prerequisitos) && prerequisitos.length > 0) {
                            const prereqCodes = [];

                            prerequisitos.forEach(item => {
                                const codigo = item.codigo_prerequisito;
                                const nombre = item.nombre_prerequisito;

                                if (codigo && nombre) {
                                    const option = new Option(`${codigo} - ${nombre}`, codigo, false, false);
                                    $prerequisitoSelect.append(option);
                                    prereqCodes.push(codigo);
                                }
                            });

                            $prerequisitoSelect.val(prereqCodes).trigger('change');
                        } else {
                            console.warn("No se recibieron prerrequisitos válidos.");
                        }

                        // Deshabilitar el select después de cargar
                        $prerequisitoSelect.prop('disabled', true);
                        $prerequisitoSelect.next('.select2-container').css('pointer-events', 'none');
                        $prerequisitoSelect.next('.select2-container').css('opacity', '0.7');

                        // Configurar modal
                        $('#modalAsignaturasHeader').removeClass('bg-primary bg-info').addClass('bg-warning text-black');
                        $('#modalAsignaturasTitle').text('Editar Asignatura');
                        $('#btnGuardar').removeClass('btn-primary').addClass('btn-warning text-black')
                            .html('<i class="bi bi-pencil-square"></i> Actualizar');
                        $('#asignaturaForm input, #asignaturaForm textarea').prop('disabled', false);
                        $('#asignaturaModal .modal-footer').show();
                        $('#btnGuardar').show();
                        $('#asignaturaModal').modal('show');
                    } else {
                        mostrarAlerta('Error: ' + response.message);
                    }
                }
            });
        }

        function viewDetails(id) {
            $.ajax({
                url: 'backend_asignaturas3.php',
                type: 'GET',
                data: {
                    action: 'get',
                    id: id
                },
                success: function(response) {
                    if (response.success) {
                        console.log("Respuesta del backend:", response);
                        const prerequisitos = response?.data?.prerequisitos;
                        const a = response.data;

                        // Configurar el formulario como solo lectura
                        $('#asignaturaForm input, #asignaturaForm select, #asignaturaForm textarea').prop('disabled', true);
                        $('#asignaturaModal .modal-footer').hide();

                        // Llenar campos básicos
                        $('#id').val(a.id);
                        $('#codigo_asignatura').val(a.codigo_asignatura);
                        $('#nom_asignatura').val(a.nom_asignatura);
                        $('#codigo_programa').val(a.codigo_programa);
                        $('#nombre_programa').val(a.nombre_programa);
                        $('#ihs').val(a.ihs);
                        $('#creditos').val(a.creditos);

                        // Configurar Select2 para prerrequisitos
                        const $prerequisitoSelect = $('#prerequisito');

                        // Destruir Select2 si ya estaba inicializado
                        if ($prerequisitoSelect.hasClass('select2-hidden-accessible')) {
                            $prerequisitoSelect.select2('destroy');
                        }

                        // Limpiar y habilitar temporalmente
                        $prerequisitoSelect.empty().prop('disabled', false);

                        // Inicializar Select2
                        $prerequisitoSelect.select2({
                            theme: 'bootstrap-5',
                            placeholder: 'No hay prerrequisitos definidos',
                            allowClear: false,
                            width: '100%',
                            dropdownParent: $('#asignaturaModal'),
                            closeOnSelect: false,
                            templateSelection: function(data) {
                                var color = obtenerColorPorCodigo(data.id);
                                return $('<span>')
                                    .text(data.text)
                                    .css('background-color', color)
                                    .css('color', 'black')
                                    .css('padding', '2px 8px')
                                    .css('border-radius', '10px')
                                    .css('margin-right', '4px');
                            }
                        });

                        if (Array.isArray(prerequisitos) && prerequisitos.length > 0) {
                            const prereqCodes = [];

                            prerequisitos.forEach(item => {
                                const codigo = item.codigo_prerequisito;
                                const nombre = item.nombre_prerequisito;

                                if (codigo && nombre) {
                                    const option = new Option(`${codigo} - ${nombre}`, codigo, false, false);
                                    $prerequisitoSelect.append(option);
                                    prereqCodes.push(codigo);
                                }
                            });

                            $prerequisitoSelect.val(prereqCodes).trigger('change');
                        } else {
                            console.warn("No se recibieron prerrequisitos válidos.");
                        }

                        // Deshabilitar el select después de cargar
                        $prerequisitoSelect.prop('disabled', true);
                        $prerequisitoSelect.next('.select2-container').css('pointer-events', 'none');
                        $prerequisitoSelect.next('.select2-container').css('opacity', '0.7');

                        // Configurar modal
                        $('#modalAsignaturasHeader').removeClass('bg-primary bg-warning').addClass('bg-info');
                        $('#modalAsignaturasTitle').text('Detalles de Asignatura');
                        $('#btnGuardar').hide();

                        $('#asignaturaModal').modal('show');
                    } else {
                        mostrarAlerta('Error: ' + response.message);
                    }
                }
            });
        }


        function deleteAsignatura(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Eliminando',
                        html: 'Por favor espere...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: 'backend_asignaturas3.php',
                        type: 'POST',
                        data: {
                            action: 'delete',
                            id: id
                        },
                        success: function(response) {
                            Swal.close();
                            if (response.success) {
                                dataTable.ajax.reload();
                                mostrarAlerta('success', 'Éxito', response.message);
                            } else {
                                mostrarAlerta('error', 'Error', response.message);
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            mostrarAlerta('error', 'Error', 'Error en la solicitud: ' + xhr.responseText);
                        }
                    });
                }
            });
        }

        function cargarSelects() {
            ["programas"].forEach((tipo) => {
                $.get(
                    "asignaturas_select2.php", {
                        tipo
                    },
                    function(data) {
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
                            dropdownParent: $("#asignaturaForm"),
                        });
                    },
                    "json"
                );
            });
        }

        $(
            "#codigo_programa"
        ).on("change", function() {
            const id = $(this).attr("id");
            const tipo = id.split("_")[1];
            const nombre = "nombre_" + tipo;
            const text = $(this).find("option:selected").text();
            const valor = $(this).val();
            const soloNombre = text.split(" | ")[1] || "";
            $("#" + nombre).val(soloNombre);
        });

        function inicializarSelect2(selector, modalSelector = null) {
            $(selector).select2({
                theme: "bootstrap-5",
                width: "100%",
                dropdownParent: modalSelector ? $(modalSelector) : $(document.body),
            });
        }
        // Agrega esta función al final de tu script para determinar colores
        function obtenerColorPorCodigo(codigo) {
            if (!codigo) return '#6c757d'; // Color por defecto

            // Extraer números del código (ej: "MAT101" -> 101)
            const numeros = codigo.match(/\d+/);
            const num = numeros ? parseInt(numeros[0]) : 0;

            // Paleta de colores Bootstrap
            const colores = [
                '#dc3545', // rojo
                '#fd7e14', // naranja
                '#ffc107', // amarillo
                '#28a745', // verde
                '#20c997', // verde agua
                '#17a2b8', // cyan
                '#007bff', // azul
                '#6f42c1', // morado
                '#e83e8c' // rosa
            ];

            // Asignar color basado en el código
            return colores[num % colores.length];
        }
    </script>

    <script type="text/javascript">
        function cerrarsession() {
            window.sessionStorage.removeItem("mostrarModal");
        }
    </script>
</body>