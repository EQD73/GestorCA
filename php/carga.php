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
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.5.2/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
</head>
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
</style>

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
                                                No ha hay notificaciones
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
                <div class="row">
                    <h4 class="text-center" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Periodo Académico: <?php echo $_SESSION['descripcion']; ?></h4>

                </div>
                <h3 class="text-center mb-4">Gestión Docente - Asignaturas por Periodo (Carga Académica)</h3>
                <div class="d-flex justify-content-end mb-3">
                    <button id="btnNuevo" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Nuevo Registro
                    </button>
                </div>
                <table id="tabla" class="table table-bordered table-striped table-sm" style="width:100%">
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
            </div>

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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
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
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="carga.js"></script>

    <script type="text/javascript">
        function cerrarsession() {
            window.sessionStorage.removeItem("mostrarModal");
        }
    </script>

</body>

</html>