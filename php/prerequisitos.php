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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.5.2/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">

    <style>
        .modal-content {
            border-radius: 10px;
        }

        .btn {
            margin-right: 5px;
        }

        #tablaPrerequisitos_wrapper {
            padding: 10px;
            font-size: 13px;
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
                <h3 class="text-center mb-4">Gestión de Prerequisitos</h3>
                <div class="d-flex justify-content-end mb-2">
                    <button type="button" class="btn btn-success mb-1 btn-sm" data-bs-toggle="modal" data-bs-target="#modalCrear">
                        <i class="bi bi-plus-circle"></i> Agregar Prerequisito
                    </button>
                </div>

                <table id="tablaPrerequisitos" class="table table-striped table-bordered mt-1" style="width:100%">
                    <thead class="table-success">
                        <tr>
                            <th>ID</th>
                            <th>Código Prerequisito</th>
                            <th>Nombre Prerequisito</th>
                            <th>Código Asignatura</th>
                            <th>Nombre Asignatura</th>
                            <th>Código Programa</th>
                            <th>Nombre Programa</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>


            </div>

            <!-- Modal para crear -->
            <div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="modalCrearLabel">Nuevo Prerequisito</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formCrear" method="POST">
                            <input type="hidden" name="action" value="crear">
                            <div class="modal-body">

                                <!-- Prerequisito -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="codigo_prerequisito">Código Prerequisito</label>
                                        <select id="codigo_prerequisito" name="codigo_prerequisito" class="form-select"></select>
                                    </div>
                                    <div class="col-md-9">
                                        <label for="nombre_prerequisito">Nombre Prerequisito</label>
                                        <input type="text" id="nombre_prerequisito" name="nombre_prerequisito" class="form-control" readonly>
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
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Guardar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancelar</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal para editar -->
            <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="modalEditarLabel">Editar Prerequisito</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formEditar" method="POST">
                            <input type="hidden" name="action" value="editar">
                            <input type="hidden" id="id_editar" name="id">
                            <div class="modal-body">
                                <!-- Prerequisito -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="codigo_prerequisito_editar">Código Prerequisito</label>
                                        <select id="codigo_prerequisito_editar" name="codigo_prerequisito_editar" class="form-select"></select>
                                    </div>
                                    <div class="col-md-9">
                                        <label for="nombre_prerequisito_editar">Nombre Prerequisito</label>
                                        <input type="text" id="nombre_prerequisito_editar" name="nombre_prerequisito_editar" class="form-control" readonly>
                                    </div>
                                </div>

                                <!-- Asignatura -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="codigo_asignatura_editar">Asignatura</label>
                                        <select id="codigo_asignatura_editar" name="codigo_asignatura_editar" class="form-select"></select>
                                    </div>
                                    <div class="col-md-9">
                                        <label for="nombre_asignatura_editar">Nombre Asignatura</label>
                                        <input type="text" id="nombre_asignatura_editar" class="form-control" readonly>
                                    </div>
                                </div>
                                <!-- Programa -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="codigo_programa_editar">Programa</label>
                                        <select id="codigo_programa_editar" name="codigo_programa_editar" class="form-select"></select>
                                    </div>
                                    <div class="col-md-9">
                                        <label for="nombre_programa_editar">Nombre Programa</label>
                                        <input type="text" id="nombre_programa_editar" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Actualizar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Custom JS -->
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="prerequisitos.js"></script>

    <script type="text/javascript">
        function cerrarsession() {
            window.sessionStorage.removeItem("mostrarModal");
        }
    </script>
</body>

</html>