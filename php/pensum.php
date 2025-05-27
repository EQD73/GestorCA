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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.5.2/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <!-- DataTables CDN -->
    <!-- <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"> -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <!-- jQuery CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
</head>

<style>
    #tablaPensum {
        font-size: 13px;
    }

    div.dataTables_filter {
        margin-bottom: 5px;
        /* o la cantidad de espacio que desees */
    }

    .select2-container .select2-dropdown .select2-results {
        max-height: 250px;
        /* Ajusta esta altura a tu gusto */
        overflow-y: auto;
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
                <h3 class="text-center">Gestión - CRUD Tabla Pensum Académico</h3>
                <div class="d-flex justify-content-end mb-3">
                    <!-- <button id="btnNuevo" class="btn btn-success"> -->
                    <button type="button" id="btnNuevo" class="btn btn-success mb-1 btn-sm">
                        <i class="bi bi-plus-circle"></i> Nuevo Registro
                    </button>
                </div>
                <table id="tablaPensum" class="table table-bordered table-striped table-sm" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Programa</th>
                            <th>N. Programa</th>
                            <th>Facultad</th>
                            <th>N. Facultad</th>
                            <th>Asignatura</th>
                            <th>Nombre</th>
                            <th>Semestre</th>
                            <th>Comentarios</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modalPensum" tabindex="-1" aria-labelledby="modalPensumLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <form id="formPensum" class="modal-content">
                        <div class="modal-header" id="modalPensumHeader">
                            <h5 class="modal-title" id="modalPensumLabel">Nuevo Registro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id" name="id">
                            <input type="hidden" name="accion" id="accion">
                            <!-- Programa -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="codigo_programa">Programa</label>
                                    <select id="codigo_programa" name="codigo_programa" class="form-select"></select>
                                </div>
                                <div class="col-md-8">
                                    <label for="nombre_programa">Nombre Programa</label>
                                    <input type="text" id="nombre_programa" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="codigo_facultad">Facultad</label>
                                    <select id="codigo_facultad" name="codigo_facultad" class="form-select"></select>
                                </div>
                                <div class="col-md-8">
                                    <label for="nombre_facultad">Nombre Facultad</label>
                                    <input type="text" id="nombre_facultad" class="form-control" readonly>
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
                                    <!-- <input type="text" id="nombre_asignatura" class="form-control" readonly> -->
                                    <input type="text" id="nombre_asignatura" name="nom_asignatura" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="semestre" class="form-label">Semestre</label>
                                <input type="number" class="form-control" id="semestre" name="semestre" required min="1">
                            </div>

                            <div class="col-12">
                                <label for="comentarios" class="form-label">Comentarios</label>
                                <textarea class="form-control" id="comentarios" name="comentarios" rows="3" maxlength="100"
                                    placeholder="Ingrese hasta 100 caracteres..." oninput="actualizarContador()"></textarea>
                                <div class="form-text text-end">
                                    <span id="contadorComentarios">0</span>/100 caracteres
                                </div>
                            </div>


                            <div class="col-md-6">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="">Seleccione...</option>
                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="INACTIVO">INACTIVO</option>
                                </select>
                            </div>
                        </div>
                        <!-- <input type="hidden" name="accion" id="accion">
                        <input type="hidden" name="id" id="id">  Solo se usa para editar -->

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btnGuardar">
                                <i class="bi bi-save"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Script de lógica -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="pensum.js"></script>

    <script type="text/javascript">
        function cerrarsession() {
            window.sessionStorage.removeItem("mostrarModal");
        }
    </script>






</body>

</html>