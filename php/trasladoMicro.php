<?php
session_start();
include('conexion2.php');
include('conexion.php');


// 1) Si no hay usuario logueado, redirigir a la pantalla de login
if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
    exit();
}

// 2) Recuperar datos del usuario para mostrar (opcional)
$codigo_rol = $_SESSION['codigo_rol'];
$nombre     = $_SESSION['nombres'];
$apellido   = $_SESSION['apellidos'];

$nombre = explode(" ", trim($nombre))[0];
$apellido = explode(" ", trim($apellido))[0];

$estadoper = $_SESSION['estado_periodo'];
$estado = $_SESSION['estado_periodo'] ?? null;
$query_roles = "SELECT nombre_rol FROM sistema.roles WHERE codigo_rol = :codigo_rol";
$stmt = $pdo->prepare($query_roles);
$stmt->execute(['codigo_rol' => $codigo_rol]);
$objroles = $stmt->fetch(PDO::FETCH_OBJ);

if ($objroles) {
    $_SESSION['nombre_rol'] = $objroles->nombre_rol;
    $nombre_rol = $objroles->nombre_rol;
} else {
    $_SESSION['nombre_rol'] = null; // o maneja el caso según necesites
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <style>
        <?php require('stylepanel.html'); ?>
    </style>
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

</head>



<body class="p-4 bg-light">
    <?php include("sidebar.html");
    //Define esto antes de incluir el topbar -->
    $iconColor = 'text-success';
    $iconClass = 'bi-tools';
    $pageTitle = "Gestión de Utilidades"; // Cambia esto según la lógica de tu aplicación style="font-size:0.8em"
    include("topbar.html"); ?>
    <!-- <div class="container mt-5 pt-3" style="margin-left: var(--sidebar-width); max-width:87%;"> -->
    <main id="content">
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
                    <button class="btn btn-danger" id="confirmar-traslado" disabled>Confirmar traslado</button>
                </div>
            </div>
            <div id="mensaje" class="mt-3"></div>
        </div>
        <footer>
            <p>© 2024 UniCorsalud. Todos los derechos reservados.</p>
        </footer>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                                $('#form-periodos')[0].reset();
                                $('#select_all_programas').prop('checked', false);
                                $('#periodo_origen').val(null).trigger('change');
                                $('#periodo_destino').val(null).trigger('change');
                            } else {
                                Swal.fire('Error', res.message, 'error');
                            }
                        }, 'json');
                    }
                });
            });

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const topbar = document.getElementById('topbar');
            const content = document.getElementById('content');
            const btnToggle = document.getElementById('btnToggleSidebar');
            const sidebarToggler = document.querySelector('.sidebar-toggler');

            // Función para alternar la clase 'collapsed'
            function toggleSidebar() {
                sidebar.classList.toggle('collapsed');
                topbar.classList.toggle('collapsed');
                content.classList.toggle('collapsed');

                // Cambiar el ícono del botón hamburguesa (bi-list ↔ bi-x)
                const icon = btnToggle.querySelector('i');
                icon.classList.toggle('bi-list');
                icon.classList.toggle('bi-x');
            }

            // Cuando se hace clic en el botón hamburguesa
            btnToggle.addEventListener('click', toggleSidebar);

            // Cuando se hace clic en el botón “X” del sidebar
            sidebarToggler.addEventListener('click', () => {
                sidebar.classList.add('collapsed');
                topbar.classList.add('collapsed');
                content.classList.add('collapsed');
            });
        });
    </script>
    <script type="text/javascript">
        function cerrarsession(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Vas a salir del sistema.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php';
                }
            });
        }
    </script>
</body>

</html>