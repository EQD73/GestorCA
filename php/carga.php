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
$periodo = $_SESSION['codigo_periodo'];


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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.5.2/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <style>
        #tabla {
            font-size: 13px;
        }

        .progress-container {
            max-height: 70vh;
            overflow-y: auto;
        }

        .table-progress {
            max-height: 300px;
            overflow-y: auto;
        }

        .status {
            min-width: 150px;
            font-size: 0.85rem;
        }

        .progress {
            height: 10px;
        }

        .progress-bar-animated {
            animation: progress-bar-stripes 1s linear infinite;
        }

        .select2-container .select2-dropdown .select2-results {
            max-height: 250px;
            /* Ajusta esta altura a tu gusto */
            overflow-y: auto;
        }
    </style>
    <style>
        /*  #tabla {
            font-size: 13px;
        } */

        .progress-container {
            max-height: 70vh;
            overflow-y: auto;
        }

        .table-progress {
            max-height: 300px;
            overflow-y: auto;
        }

        .status {
            min-width: 150px;
            font-size: 0.85rem;
        }

        .progress {
            height: 10px;
        }

        .progress-bar-animated {
            animation: progress-bar-stripes 1s linear infinite;
        }

        .select2-container .select2-dropdown .select2-results {
            max-height: 250px;
            /* Ajusta esta altura a tu gusto */
            overflow-y: auto;
        }
    </style>
    <style>
        <?php require('stylepanel.html'); ?>
    </style>
</head>

<body>
    <?php include("sidebar.html");
    //Define esto antes de incluir el topbar -->
    $iconColor = 'text-warning';
    $iconClass = 'bi-database-fill';
    $pageTitle = "Gestión de Tablas Básicas"; // Cambia esto según la lógica de tu aplicación style="font-size:0.8em"
    include("topbar.html"); ?>
    <!-- <div class="container mt-5 pt-3" style="margin-left: var(--sidebar-width); max-width:87%;"> -->
    <main id="content">
        <h3 class="text-center mb-4 mt-2">Gestión Docente - Asignaturas por Periodo (Carga Académica)</h3>
        <div class="d-flex justify-content-end mb-3">
            <button id="btnNuevo" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle"></i> Nuevo Registro
            </button>
        </div>
        <table id="tabla" class="table table-bordered table-striped table-sm table-responsive mt-2" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Código Docente</th>
                    <th>Nombre Docente</th>
                    <th>Código Asignatura</th>
                    <th>Nombre Asignatura</th>
                    <th>Código Programa</th>
                    <th>Nombre Programa</th>
                    <th>Código Periodo</th>
                    <th>Nombre Periodo</th>
                    <th>Semestre</th>
                    <th>Grupo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
        <footer>
            <p>© 2024 UniCorsalud. Todos los derechos reservados.</p>
        </footer>
    </main>
    <!-- Modal -->
    <div class="modal fade" id="modalFormulario" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <form id="formCarga" class="modal-content">
                <div class="modal-header" id="modalCargaHeader">
                    <h5 class="modal-title" id="modalCargaLabel">Nuevo Registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" name="accion" id="accion">
                    <!-- Docente -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="codigo_docente">Docente</label>
                            <select id="codigo_docente" name="codigo_docente" class="form-select"></select>
                        </div>
                        <div class="col-md-9">
                            <label for="nombre_docente">Nombre Docente</label>
                            <input type="text" id="nombre_docente" class="form-control" readonly>
                        </div>
                    </div>
                    <!-- Asignatura -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="codigo_asignatura">Asignatura</label>
                            <select id="codigo_asignatura" name="codigo_asignatura" class="form-select"></select>
                        </div>
                        <div class="col-md-9">
                            <label for="nombre_asignatura">Nombre Asignatura</label>
                            <input type="text" id="nombre_asignatura" class="form-control" readonly>
                        </div>
                    </div>
                    <!-- Semestre y Grupo -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="semestre">Semestre</label>
                            <input type="number" id="semestre" name="semestre" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="grupo">Grupo</label>
                            <input type="number" id="grupo" name="grupo" class="form-control" required max=3>
                        </div>
                    </div>
                    <!-- Programa -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="codigo_programa">Programa</label>
                            <select id="codigo_programa" name="codigo_programa" class="form-select"></select>
                        </div>
                        <div class="col-md-9">
                            <label for="nombre_programa">Nombre Programa</label>
                            <input type="text" id="nombre_programa" class="form-control" readonly>
                        </div>
                    </div>
                    <!-- Periodo -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="codigo_periodo">Periodo</label>
                            <select id="codigo_periodo" name="codigo_periodo" class="form-select"></select>
                        </div>
                        <div class="col-md-9">
                            <label for="nombre_periodo">Nombre Periodo</label>
                            <input type="text" id="nombre_periodo" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btnGuardar">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>



    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="carga.js"></script>

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