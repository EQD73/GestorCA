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
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CDN -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS CDN -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
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
                <h3 class="text-center">CRUD Tabla Pensum Académico</h3>
                <div class="d-flex justify-content-end mb-3">
                    <button id="btnNuevo" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Nuevo Registro
                    </button>
                </div>

                <table id="tablaPensum" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Programa</th>
                            <th>Facultad</th>
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
                    <div class="modal-content">
                        <form id="formPensum">
                            <div class="modal-header" id="modalPensumHeader">
                                <h5 class="modal-title" id="modalPensumLabel">Nuevo Registro</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>

                            <div class="modal-body row g-3">
                                <!-- <input type="hidden" id="id" name="id"> -->

                                <div class="col-md-6">
                                    <label for="codigo_programa" class="form-label">Código Programa</label>
                                    <input type="text" class="form-control" id="codigo_programa" name="codigo_programa" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="codigo_facultad" class="form-label">Código Facultad</label>
                                    <input type="text" class="form-control" id="codigo_facultad" name="codigo_facultad" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="codigo_asignatura" class="form-label">Código Asignatura</label>
                                    <input type="text" class="form-control" id="codigo_asignatura" name="codigo_asignatura" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="nom_asignatura" class="form-label">Nombre Asignatura</label>
                                    <!-- <input type="text" class="form-control" id="nom_asignatura" name="nom_asignatura" required> -->
                                    <input type="text" class="form-control" id="nom_asignatura" name="nom_asignatura" requiredstyle="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();">

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
                            <input type="hidden" name="accion" id="accion">
                            <input type="hidden" name="id" id="id"> <!-- Solo se usa para editar -->

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
    </div>
    <!-- Script de lógica -->
    <script src="pensum.js"></script>

    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <!-- <script src="../assets/js/app.js"></script> -->
    <script src="../assets/js/main.js"></script>

    <script type="text/javascript">
        function cerrarsession() {
            window.sessionStorage.removeItem("mostrarModal");
        }
    </script>






</body>

</html>