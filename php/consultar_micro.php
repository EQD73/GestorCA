<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];
$codperiodo = $_SESSION['codigo_periodo'];

include('conexion.php');

$dbconn2 = pg_connection_reset($conexion);

///traer valor de id 
/* echo $id;
$query_temp = "SELECT * FROM sistema.temporal WHERE id='1'";
$resultado_temp = pg_query($conexion, $query_temp);
$obj_temp = pg_fetch_object($resultado_temp); */


////**************************/////
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
}
$codigoConsulta = $id;

//select de tabla facultades

$query_facultad = "SELECT * FROM sistema.facultades ORDER BY codigo_facultad ASC ";
$resultado_qf = pg_query($conexion, $query_facultad);
$num1 = pg_num_rows($resultado_qf);

// select de tabla asignaturas

$query_asignaturas2 = "SELECT * FROM sistema.asignaturas WHERE periodo='$codperiodo' ORDER BY codigo_asignatura ASC, grupo ASC ";
$resultado_qas2 = pg_query($conexion, $query_asignaturas2);
$num2 = pg_num_rows($resultado_qas2);


// select de tabla programas

$query_programas = "SELECT * FROM sistema.programas ORDER BY codigo_programa ASC ";
$resultado_qp = pg_query($conexion, $query_programas);
$num3 = pg_num_rows($resultado_qp);

// select de tabla evaluacion

$query_evaluacion = "SELECT * FROM sistema.evaluacion ORDER BY id ASC ";
$resultado_qe = pg_query($conexion, $query_evaluacion);
$num4 = pg_num_rows($resultado_qe);

// select de tabla nivel
$query_nivel = "SELECT * FROM sistema.nivel ORDER BY id ASC ";
$resultado_qn = pg_query($conexion, $query_nivel);
$num5 = pg_num_rows($resultado_qn);

///*****querys usuarios */
$query_usuarios = "SELECT * FROM sistema.usuarios WHERE codigo_rol='2' ORDER BY codigo_usuario ASC ";
$resultado_qu = pg_query($conexion, $query_usuarios);

//select de tabla de usuarios 

$query_usuarios = "SELECT * FROM sistema.usuarios WHERE codigo_rol='4' ORDER BY codigo_usuario ASC ";
$resultado_qu2 = pg_query($conexion, $query_usuarios);

//select de tabla de usuarios 

$query_usuarios = "SELECT * FROM sistema.usuarios WHERE codigo_rol='5' ORDER BY codigo_usuario ASC ";
$resultado_qu3 = pg_query($conexion, $query_usuarios);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>



    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="../assets/vendors/chartjs/Chart.min.css"> -->
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script> -->
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <!-- <link rel="stylesheet" type="text/css" href="../css/cargando.css"> -->
    <!-- Styles -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
    <!-- <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"> -->

</head>

<<!-- style type="text/css">
    #requisitos2{
    width: 50em;
    }

    </style> -->
    <style type="text/css">
        /* .inputClass {
            font-weight: bold;
        } */

        .disabled {
            pointer-events: none;
            opacity: 0.7;
            border-color: rgba(118, 118, 118, 0.3);
            color: -internal-light-dark(graytext, rgb(170, 170, 170));
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
                                                    No hay información
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- <li class="dropdown nav-icon me-2">
                            <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="d-lg-inline-block">
                                    <i data-feather="mail"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" >
                                <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
                                <a class="dropdown-item active" href="#"><i data-feather="mail"></i> Messages</a>
                                <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i data-feather="log-out"></i> Logout</a>
                            </div>
                        </li> -->
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
                                    <!-- <a class="dropdown-item active" href="#"><i data-feather="mail"></i> Messages</a> -->
                                    <!-- <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a> -->
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="logout.php" onclick="cerrarsession()"><i data-feather="log-out"></i>Salir</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="main-content container-fluid">
                    <div class="row">
                        <h4 class="text-center" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Periodo Académico: <?php echo $_SESSION['descripcion']; ?></h4>
                    </div>
                    <div class="container p-3">
                        <div class="row">
                            <h4 class="text-center" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Módulo MicroCurriculo - Editar registro</h4>
                            <hr>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-4">
                                // Button trigger modal 
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-consulta">
                                    Consultar Registro
                                </button>
                                <?php /* include("Modal_ConsultarMicro.php"); */ ?>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#" onclick="mostrar();">
                                    Editar Registro
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-eliminar">
                                    Eliminar Registro
                                </button>
                                <?php /* include("Modal_EliminarMicro.php");  */ ?>
                            </div>
                        </div> -->

                    </div>

                    <!-- //inicio de nav-tab  -->

                    <ul class="nav nav-pills sm-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">Identificación</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false">Metodología</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3" type="button" role="tab" aria-controls="pills-3" aria-selected="false">Unidad 1</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-4-tab" data-bs-toggle="pill" data-bs-target="#pills-4" type="button" role="tab" aria-controls="pills-4" aria-selected="false">Unidad 2</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-5-tab" data-bs-toggle="pill" data-bs-target="#pills-5" type="button" role="tab" aria-controls="pills-5" aria-selected="false">Unidad 3</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-6-tab" data-bs-toggle="pill" data-bs-target="#pills-6" type="button" role="tab" aria-controls="pills-6" aria-selected="false">Unidad 4</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-7-tab" data-bs-toggle="pill" data-bs-target="#pills-7" type="button" role="tab" aria-controls="pills-7" aria-selected="false">Unidad 5</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-8-tab" data-bs-toggle="pill" data-bs-target="#pills-8" type="button" role="tab" aria-controls="pills-8" aria-selected="false">Proy. Integrador</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-9-tab" data-bs-toggle="pill" data-bs-target="#pills-9" type="button" role="tab" aria-controls="pills-9" aria-selected="false">Validación</button>
                        </li>
                    </ul>
                    <div class="row" id="form-visible">
                        <div class="col-md-12 mt-2">
                            <?php
                            //$codigoConsultacurso     = $_REQUEST['CodigoConsultaCurso'];
                            include('FormMicroConsulta.php'); ?>
                        </div>
                    </div>


                </div>

            </div>
        </div>
        </div>
        </div>




        <footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-start">
                    <p>2024 &copy; UniCorsalud </p>
                </div>
                <!--  <div class="float-end">
                        <p>Crafted with <span class='text-danger'><i data-feather=""></i></span> by <a href="#">Eqd</a></p>
                    </div> -->
            </div>
        </footer>
        </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script src="../assets/js/feather-icons/feather.min.js"></script>
        <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <!-- <script src="../assets/js/app.js"></script> -->
        <script src="../assets/js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

        <!-- Scripts -->
        <!--  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script type="text/javascript">
            function mostrar() {
                element = document.getElementById('form-visible');
                estado = element.style.display;
                if (estado == 'none') {
                    element.style.display = 'block'
                }
            }
        </script>

        <script type="text/javascript">
            /* document.getElementById('CodigoCurso').onchange = function() {
            /* Referencia a los atributos data de la opción seleccionada 
            var mData = this.options[this.selectedIndex].dataset;

            /* Referencia a los in
            var elCode = document.getElementById('CodigoCur');
            var elName = document.getElementById('NombreCurso');
            var elGroup = document.getElementById('grupo');

            /* Asignamos cada dato a su input*
            elCode.value = mData.codigo;
            elName.value = mData.nombre;
            elGroup.value = mData.grupo;
        };
 */
            document.getElementById('CodigoFacultad').onchange = function() {
                /* Referencia a los atributos data de la opción seleccionada */
                var mData = this.options[this.selectedIndex].dataset;

                /* Referencia a los input */
                var elCode = document.getElementById('CodFacul');
                var elName = document.getElementById('NombreFacul');

                /* Asignamos cada dato a su input*/
                elCode.value = mData.codigo;
                elName.value = mData.nombre;

            };

            document.getElementById('CodigoPrograma').onchange = function() {
                /* Referencia a los atributos data de la opción seleccionada */
                var mData = this.options[this.selectedIndex].dataset;

                /* Referencia a los input */
                var elCode = document.getElementById('CodProg');
                var elName = document.getElementById('NombreProg');

                /* Asignamos cada dato a su input*/
                elCode.value = mData.codigo;
                elName.value = mData.nombre;

            };
        </script>

        <script type="text/javascript">
            $('#requisitos2').select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $(this).data('placeholder'),
                closeOnSelect: false,
            });

            /* $('#multiple-select-field').select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $(this).data('placeholder'),
                closeOnSelect: false,
            }); */
        </script>
        <script type="text/javascript">
            function cerrarsession() {
                window.sessionStorage.removeItem("mostrarModal");
            }
        </script>

    </body>

</html>