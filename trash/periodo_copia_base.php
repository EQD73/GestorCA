<?php

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
}

$nombre = $_SESSION['nombre'];
$tipo_usuario = $_SESSION['tipo_usuario'];

require "conexion.php";

$query_periodo = "SELECT codigo_periodo, nombre_periodo FROM sistema.periodos";
$resultado_qp = pg_query($conexion, $query_periodo);

/* $num1= pg_num_rows($resultado_qp);

if($num1>0){
    echo $num1;
}
 */

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendors/chartjs/Chart.min.css">
    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/cargando.css">
    <link rel="stylesheet" type="text/css" href="css/maquinawrite.css">
    <style>
        table tr th {
            background: rgba(0, 0, 0, .6);
            color: azure;
        }

        tbody tr {
            font-size: 12px !important;

        }

        h3 {
            color: crimson;
            margin-top: 100px;
        }

        a:hover {
            cursor: pointer;
            color: #333 !important;
        }
    </style>
</head>
<!-- <script>
    $(document).ready(function() {
        $('#ventana-modal').modal('toggle')
    });
</script> -->

<body>
        <div class="cargando">
        <div class="loader-outter"></div>
        <div class="loader-inner"></div>
        </div>
    <!-- <div class="modal fade" tabindex="-1" role="dialog" id="ventana-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seleccionar Periodo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select class="form-select form-select-sm" aria-label="Default select example">
                        <?php
                        while ($obj = pg_fetch_object($resultado_qp)) { ?>
                            <option value="<?php echo $obj->codigo_periodo ?>"><?php echo $obj->nombre_periodo; ?></option>
                       <?php
                        }
                        ?>
                        
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Aceptar</button>
                    <!-- <button type="button" class="btn btn-danger">Aceptar</button> -->
    </div>
    </div>
    </div>
    </div> -->




    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <img src="assets/images/logo.png" width="220" height="120">
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">


                        <li class='sidebar-title'>Menu Principal</li>



                        <li class="sidebar-item active ">

                            <a href="#" class='sidebar-link'>
                                <i data-feather="home" width="20"></i>
                                <span>Inicio</span>
                            </a>


                        </li>



                        <li class="sidebar-item  has-sub">

                            <a href="#" class='sidebar-link'>
                                <i data-feather="layers" width="20"></i>
                                <span>Módulos</span>
                            </a>


                            <ul class="submenu ">

                                <li>
                                    <a href="microcurriculo.php">Microcurriculo</a>
                                </li>

                                <li>
                                    <a href="consigndor.php">Consignador Acádemico</a>
                                </li>

                                <li>
                                    <a href="reg_actividades.php">Registro de Actividades</a>
                                </li>


                            </ul>

                        </li>






                        <li class='sidebar-title'>Formularios/Tablas</li>



                        <li class="sidebar-item  has-sub">

                            <a href="#" class='sidebar-link'>
                                <i data-feather="database" width="20"></i>
                                <span>Tablas Básicas</span>
                            </a>


                            <ul class="submenu ">


                                <li>
                                    <a href="periodos.php">Periodos Académicos</a>
                                </li>

                                <li>
                                    <a href="asignaturas.php">Asignaturas</a>
                                </li>


                                <li>
                                    <a href="programas.php">Programas</a>
                                </li>

                                <li>
                                    <a href="usuarios.php">Control de Usuarios</a>
                                </li>

                                <li>
                                    <a href="roles.php">Roles Usuarios</a>
                                </li>

                                <li>
                                    <a href="permisos.php">Permisos Roles</a>
                                </li>

                            </ul>

                        </li>



                        <!-- <li class="sidebar-item  ">

                    <a href="form-layout.html" class='sidebar-link'>
                        <i data-feather="layout" width="20"></i> 
                        <span>Form Layout</span>
                    </a>

                    
                </li>
                
            
                
                <li class="sidebar-item  ">

                    <a href="form-editor.html" class='sidebar-link'>
                        <i data-feather="layers" width="20"></i> 
                        <span>Form Editor</span>
                    </a>

                    
                </li>
                
            
                
                <li class="sidebar-item  ">

                    <a href="table.html" class='sidebar-link'>
                        <i data-feather="grid" width="20"></i> 
                        <span>Table</span>
                    </a>

                    
                </li> -->

                        <!-- 
                
                <li class="sidebar-item  ">

                    <a href="table-datatable.html" class='sidebar-link'>
                        <i data-feather="file-plus" width="20"></i> 
                        <span>Datatable</span>
                    </a>

                    
                </li> -->



                        <li class='sidebar-title'>Herramientas</li>



                        <li class="sidebar-item  has-sub">

                            <a href="#" class='sidebar-link'>
                                <i data-feather="tool" width="20"></i>
                                <span>Utilidades</span>
                            </a>


                            <ul class="submenu ">

                                <li>
                                    <a href="config.php">Configuraciones</a>
                                </li>

                                <li>
                                    <a href="cargamasiva.php">Cargue Masivo</a>
                                </li>

                                <li>
                                    <a href="copiasoporte">Copias de Soporte</a>
                                </li>

                                <li>
                                    <a href="restauradatos.php">Restaurar Datos</a>
                                </li>
                                <li>
                                    <a href="otro.php">Otro...</a>
                                </li>
                            </ul>

                        </li>



                        <li class="sidebar-item  has-sub">

                            <a href="#" class='sidebar-link'>
                                <i data-feather="pie-chart" width="20"></i>
                                <span>Graficas/Estadisticas</span>
                            </a>


                            <ul class="submenu ">

                                <li>
                                    <a href="est_asignaturas.php">Asignaturas</a>
                                </li>

                                <li>
                                    <a href="est_estudiantes.php">Estudiantes</a>
                                </li>

                                <li>
                                    <a href="est_docentes.php">Docentes</a>
                                </li>
                            </ul>

                        </li>



                        <li class='sidebar-title'>Reportes/Informes</li>



                        <li class="sidebar-item  has-sub">

                            <a href="#" class='sidebar-link'>
                                <i data-feather="file-text" width="20"></i>
                                <span>Informes</span>
                            </a>


                            <ul class="submenu ">

                                <li>
                                    <a href="Report_microcurriculo.php">Microcurriculo</a>
                                </li>

                                <li>
                                    <a href="Report_Consignador.php">Consignador</a>
                                </li>

                                <li>
                                    <a href="Report_Registro.php">Registro Actividades</a>
                                </li>

                            </ul>

                        </li>



                        <li class="sidebar-item  has-sub">

                            <a href="#" class='sidebar-link'>
                                <i data-feather="alert-circle" width="20"></i>
                                <span>-----</span>
                            </a>


                            <!-- <ul class="submenu ">
                        
                        <li>
                            <a href="error-403.html">403</a>
                        </li>
                        
                        <li>
                            <a href="error-404.html">404</a>
                        </li>
                        
                        <li>
                            <a href="error-500.html">500</a>
                        </li>
                        
                    </ul> -->

                        </li>


                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
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
                                    <img src="assets/images/avatar/avatar-s-1.png" alt="" srcset="">
                                </div>
                                <div class="d-none d-md-block d-lg-inline-block">Hola, <?php echo $nombre; ?></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#"><i data-feather="user"></i> Cuenta/Perfil</a>
                                <!-- <a class="dropdown-item active" href="#"><i data-feather="mail"></i> Messages</a> -->
                                <!-- <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="index.php"><i data-feather="log-out"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="main-content container-fluid">
                
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2022 &copy; UniCorsalud </p>
                    </div>
                    <!--  <div class="float-end">
                        <p>Crafted with <span class='text-danger'><i data-feather=""></i></span> by <a href="#">Eqd</a></p>
                    </div> -->
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="assets/js/feather-icons/feather.min.js"></script>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>

    <script src="assets/vendors/chartjs/Chart.min.js"></script>
    <script src="assets/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>

    <script src="assets/js/main.js"></script>
    <script src="modal.js"></script>

</body>

</html>