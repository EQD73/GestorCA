<?php
session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}
$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
</head>

<style>
    .form-check-input.danger {
        border-color: #dc3545;
        /* rojo Bootstrap */
    }

    .form-check-input.danger:focus {
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        /* sombra al hacer foco */
    }

    .form-check-input.danger:checked {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .select2-container--default .select2-selection--single {
        /* background-color: #f8d7da; */
        /* Rojo atenuado (similar a Bootstrap danger-light) */
        border-color: #f5c6cb;
        /* Borde rojo claro */
        color: #721c24;
        /* Texto rojo oscuro */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #721c24;
        /* Texto del elemento seleccionado */
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #f8d7da;
        /* Color al hacer hover o seleccionar opción */
        color: #721c24;
    }
</style>


<body class="p-4 bg-light">
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
                                                No hay notificaciones
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
                                <a class="dropdown-item" href="logout.php" onclick="cerrarsession()"><i data-feather="log-out"></i> Salir</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container">
                <div class="card shadow-sm p-4">
                    <h3 class="mb-4 text-center">Traslado entre periodos - Microcurrículos</h3>

                    <form id="form-periodos" class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="periodo_origen" class="form-label">Periodo Origen</label>
                            <select id="periodo_origen" class="form-select select2" style="width: 100%;">
                                <option value="">Seleccione un periodo origen</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="periodo_destino" class="form-label">Periodo Destino</label>
                            <select id="periodo_destino" class="form-select select2" style="width: 100%;">
                                <option value="">Seleccione un periodo destino</option>
                            </select>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="card border-danger shadow-sm">
                                <div class="card-header bg-danger text-white">
                                    <strong>Seleccione los programas</strong>
                                </div>
                                <div class="card-body">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input danger" type="checkbox" id="select_all_programas">
                                        <label class="form-check-label" for="select_all_programas">
                                            Seleccionar / Deseleccionar todos los programas
                                        </label>
                                    </div>

                                    <div id="checkbox_programas" class="row"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-end">
                            <button id="vista_previa_btn" class="btn bg-danger-subtle mt-3">Mostrar Vista Previa</button>
                        </div>
                    </form>

                    <div id="vista_previa_resultado" class="d-none">
                        <h5>Microcurrículos que serán trasladados:</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Código</th>
                                        <th>Asignatura</th>
                                        <th>Docente</th>
                                        <th>Año Origen</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody id="preview-body"></tbody>
                            </table>
                        </div>
                        <div class="text-end">
                            <button class="btn btn-success" id="confirmar-traslado" disabled>Confirmar traslado</button>
                        </div>
                    </div>

                    <div id="mensaje" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/main.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // Cargar periodos
            $.getJSON('get_periodos.php', function(data) {
                data.forEach(p => {
                    $('#periodo_origen, #periodo_destino').append(
                        `<option value="${p.codigo}">${p.codigo} - ${p.nombre}</option>`
                    );
                });
            });

            // Cargar programas
            $.getJSON('get_programas_tm1.php', function(data) {
                let html = '';
                data.forEach((p, index) => {
                    html += `
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input danger" type="checkbox" name="programas[]" value="${p.codigo}" id="prog_${p.codigo}">
                                <label class="form-check-label" for="prog_${p.codigo}">${p.codigo} - ${p.nombre}</label>

                            </div>
                        </div>
                    `;
                });
                $('#checkbox_programas').html(html);
            });

            // Seleccionar / deseleccionar todos los checkboxes de programas
            $(document).on('change', '#select_all_programas', function() {
                const isChecked = $(this).is(':checked');
                $('input[name="programas[]"]').prop('checked', isChecked);
            });

            // desmarcar seleccionar todo si se desmarca uno individual
            $(document).on('change', 'input[name="programas[]"]', function() {
                const allChecked = $('input[name="programas[]"]').length === $('input[name="programas[]"]:checked').length;
                $('#select_all_programas').prop('checked', allChecked);
            });




            // Vista previa
            $('#vista_previa_btn').click(function(e) {
                e.preventDefault();

                const origen = $('#periodo_origen').val();
                const destino = $('#periodo_destino').val();
                const anio_origen = origen.substring(0, 4);
                const anio_destino = destino.substring(0, 4);
                const programas = $('input[name="programas[]"]:checked').map(function() {
                    return this.value;
                }).get();

                // Limpiar contenido anterior
                $('#preview-body').empty();

                if (!origen || !destino) {
                    Swal.fire('Faltan datos', 'Seleccione ambos periodos.', 'warning');
                    return;
                }

                if (anio_origen === anio_destino) {
                    Swal.fire('Error', 'No se puede mostrar vista previa dentro del mismo año.', 'error');
                    return;
                }

                $.post('vista_previa_traslado_m1.php', {
                    origen,
                    destino,
                    programas
                }, function(res) {
                    if (res.status === 'success') {
                        $('#vista_previa_resultado').removeClass('d-none');
                        $('#preview-body').html(res.html);
                        $('#confirmar-traslado').prop('disabled', false);
                    } else {
                        Swal.fire('Atención', res.message, 'info');
                    }
                }, 'json');
            });

            // Confirmar traslado
            $('#confirmar-traslado').click(function(e) {
                e.preventDefault();

                const origen = $('#periodo_origen').val();
                const destino = $('#periodo_destino').val();
                const anio_origen = origen.substring(0, 4);
                const anio_destino = destino.substring(0, 4);
                const programas = $('input[name="programas[]"]:checked').map(function() {
                    return this.value;
                }).get();
                const codigo_usuario = $('#codigo_usuario').val();

                if (!origen || !destino) {
                    Swal.fire('Faltan datos', 'Seleccione ambos periodos.', 'warning');
                    return;
                }

                if (anio_origen === anio_destino) {
                    Swal.fire('Error', 'No se puede trasladar información dentro del mismo año.', 'error');
                    return;
                }

                if (programas.length === 0) {
                    Swal.fire('Faltan datos', 'Seleccione al menos un programa.', 'warning');
                    return;
                }

                Swal.fire({
                    title: '¿Está seguro?',
                    text: 'Se trasladarán los microcurrículos seleccionados al nuevo periodo. Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, trasladar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Realizar traslado vía AJAX
                        $.post('traslado_m1.php', {
                            origen,
                            destino,
                            programas,
                            codigo_usuario
                        }, function(res) {
                            if (res.status === 'success') {
                                Swal.fire('Traslado completado', res.message, 'success');
                                $('#vista_previa_resultado').addClass('d-none');
                                $('#preview-body').empty();
                                $('#confirmar-traslado').prop('disabled', true);
                            } else {
                                Swal.fire('Error', res.message, 'error');
                            }
                        }, 'json');
                    }
                });
            });

        });
    </script>


    <script type="text/javascript">
        function cerrarsession() {
            window.sessionStorage.removeItem("mostrarModal");
        }
    </script>



</body>

</html>