<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}


$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];

require "conexion.php";


$query_periodo = "SELECT codigo_periodo, nombre_periodo, estado FROM sistema.periodos";
$resultado_qp = pg_query($conexion, $query_periodo);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>

    <link rel="stylesheet" href="../assets/css/bootstrap.css">

    
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">




</head>
<!-- <script>
    $(document).ready(function() {
        $('#ventana-modal').modal('toggle')
    });
    
</script>  -->

<script type="text/javascript">
    $(document).ready(function() {
        if (!window.sessionStorage.getItem("mostrarModal")) {

            window.sessionStorage.setItem("mostrarModal", "no");

            $('#ventana-modal').modal("show");
        }

    })
</script>


<body>

    <div class="modal fade" tabindex="-1" role="dialog" id="ventana-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seleccionar Periodo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="#datos-periodo">
                    <div class="modal-body">
                        <select class="form-select form-select-sm" id="CodigoPeriodo">
                            <option value="" data-codigo="" data-nombre="" selected>Escoger Opción</option>
                            <?php
                            while ($obj = pg_fetch_object($resultado_qp)) { ?>
                                <option value="" data-codigo="<?php echo $obj->codigo_periodo; ?>" data-nombre="<?php echo $obj->nombre_periodo; ?>" data-estado="<?php echo $obj->estado; ?>"><?php echo $obj->codigo_periodo;
                                                                                                                                            echo "  |  ";
                                                                                                                                            echo $obj->nombre_periodo; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" class="form-control form-control sm" id="CodPer" name="CodPer">
                    <input type="hidden" class="form-control form-control sm" id="NomPer" name="NomPer">
                    <input type="hidden" class="form-control form-control sm" id="EstadoPer" name="EstadoPer">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Aceptar</button>
                        <!-- <button type="button" class="btn btn-danger">Aceptar</button> -->
                    </div>
                    <div class="row" id="datos-periodo" style="display:none">
                        <div class="col-md-12 mt-2">
                            <?php
                            $_SESSION['codigo_periodo'] = $_REQUEST['CodPer'];
                            $_SESSION['nombre_periodo'] = $_REQUEST['NomPer'];
                            $_SESSION['estado_periodo'] = $_REQUEST['EstadoPer'];
                            ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <?php
    // elegir las tablas a trabajar por periodo//
    $m1 = "_m1";
    $m2 = "_m2";
    $m3 = "_m3";
    $Codperiod = strval($_SESSION['codigo_periodo']);
    $tabla1 = $Codperiod . $m1;
    //$tabla1="periodo2023_1_m1";
    $tabla2 = $Codperiod . $m2;
    $tabla3 = $Codperiod . $m3;
    $schema = "sistema";

    //si existe tabla1
    $consulta_t1 = "SELECT * FROM pg_tables WHERE tablename='$tabla1' AND schemaname='$schema'";
    $resultado_ct1 = pg_query($conexion, $consulta_t1);
    $nt1 = pg_num_rows($resultado_ct1);
    if ($nt1 > 0) {
        $_SESSION['tablam1'] = "sistema." . $tabla1;
    } else { // sino existe tabla1
        $_SESSION['tablam1'] = $tabla1;
        $tm1 = $_SESSION['tablam1'];
        $torigen1 = "m1";
        $consulta1 = "CREATE TABLE " . $tm1 . " (LIKE $torigen1 INCLUDING DEFAULTS INCLUDING CONSTRAINTS INCLUDING INDEXES);";
        $resultado_c1 = pg_query($conexion, $consulta1);
    }
    //si existe tabla2
    $consulta_t2 = "SELECT * FROM pg_tables WHERE tablename='$tabla2' AND schemaname='$schema'";
    $resultado_ct2 = pg_query($conexion, $consulta_t2);
    $nt2 = pg_num_rows($resultado_ct2);
    if ($nt2 > 0) {
        $_SESSION['tablam2'] = "sistema." . $tabla2;
    } else { // sino existe tabla1
        $_SESSION['tablam2'] = $tabla2;
        $tm2 = $_SESSION['tablam2'];
        $torigen2 = "m2";
        $consulta2 = "CREATE TABLE " . $tm2 . " (LIKE $torigen2 INCLUDING DEFAULTS INCLUDING CONSTRAINTS INCLUDING INDEXES);";
        $resultado_c2 = pg_query($conexion, $consulta2);
    }

    //si existe tabla3
    $consulta_t3 = "SELECT * FROM pg_tables WHERE tablename='$tabla2' AND schemaname='$schema'";
    $resultado_ct3 = pg_query($conexion, $consulta_t3);
    $nt3 = pg_num_rows($resultado_ct3);
    if ($nt3 > 0) {
        $_SESSION['tablam3'] = "sistema." . $tabla3;
    } else { // sino existe tabla1
        $_SESSION['tablam3'] = $tabla3;
        $tm3 = $_SESSION['tablam3'];
        $torigen3 = "m3";
        $consulta3 = "CREATE TABLE " . $tm3 . " (LIKE $torigen3 INCLUDING DEFAULTS INCLUDING CONSTRAINTS INCLUDING INDEXES);";
        $resultado_c3 = pg_query($conexion, $consulta3);
    }


    ?>

    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <img src="../assets/images/logo.png" width="220" height="120">
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">


                        <li class='sidebar-title'>Menu Principal</li>



                        <li class="sidebar-item active ">

                            <a href="home.php" class='sidebar-link'>
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

                                <li class="sidebar-item  has-sub">

                                    <a href="#" class='sidebar-link'>
                                        <i data-feather="file-plus" width="20"></i>
                                        <span>Microcurriculo</span>
                                    </a>


                                    <ul class="submenu ">
                                        <li>
                                            <a href="Microcurriculo.php">Módulo</a>
                                        </li>
                                        <!--  <li>
                                            <a href="agregar_micro.php">Agregar Registros</a>
                                        </li>

                                        <li>
                                            <a href="consultar_micro.php">Consultar Registros</a>
                                        </li>  -->
                                    </ul> 

                                </li>
                                <li class="sidebar-item  has-sub">
                                    <a href="#" class='sidebar-link'>
                                        <i data-feather="file-plus" width="20"></i>
                                        <span>Consignador Acádemico</span>
                                    </a>
                                    <ul class="submenu ">
                                        <li>
                                            <a href="Consignador.php">Módulo</a>
                                        </li>
                                        <!--  <li>
                                            <a href="agregar_consignador.php">Agregar Registros</a>
                                        </li>

                                        <li>
                                            <a href="consultar_consignador.php">Consultar Registros</a>
                                        </li>  -->
                                    </ul> 
                                </li>
                                <li class="sidebar-item  has-sub">
                                    <a href="#" class='sidebar-link'>
                                        <i data-feather="file-plus" width="20"></i>
                                        <span>Registro de Actividades</span>
                                    </a>
                                    <ul class="submenu ">
                                        <li>
                                            <a href="Registro.php">Módulo</a>
                                        </li>
                                       <!-- <li>
                                            <a href="agregar_registro.php">Agregar Registros</a>
                                        </li>

                                        <li>
                                            <a href="#">Consultar Registros</a>
                                        </li>  -->
                                    </ul> 
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

                                    <a href="periodo.php">Periodos Académicos</a>
                                </li>

                                <li>
                                    <a href="asignaturas.php">Asignaturas</a>
                                </li>

                                <li>
                                    <a href="facultades.php">Facultades</a>
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
                                    <img src="../assets/images/avatar/avatarX.png" alt="" srcset="">
                                </div>
                                <div class="d-none d-md-block d-lg-inline-block">Hola, <?php echo $nombre; ?></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#"><i data-feather="user"></i> Cuenta/Perfil</a>
                                <!-- <a class="dropdown-item active" href="#"><i data-feather="mail"></i> Messages</a> -->
                                <!-- <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php" onclick="cerrarsession()"><i data-feather="log-out"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="main-content container-fluid">
                <div class="container">
                    <h4 class="text-center">Periodo Académico <?php echo " ";
                                                                echo $_SESSION['nombre_periodo'];
                                                                echo $_SESSION['codigo_periodo']; ?></h4>
                    <hr>
                </div>

                <div class="page-title">
                    <h3>Inicio</h3>
                    <!-- <p class="text-subtitle text-muted">Algunas estadisticas importantes</p> -->
                </div>
                <section class="section">
                    <!-- <div class="row mb-2">
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h3 class='card-title'>BALANCE</h3>
                                <div class="card-right d-flex align-items-center">
                                    <p>$50 </p>
                                </div>
                            </div>
                            <div class="chart-wrapper">
                                <canvas id="canvas1" style="height:100px !important"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h3 class='card-title'>Revenue</h3>
                                <div class="card-right d-flex align-items-center">
                                    <p>$532,2 </p>
                                </div>
                            </div>
                            <div class="chart-wrapper">
                                <canvas id="canvas2" style="height:100px !important"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h3 class='card-title'>ORDERS</h3>
                                <div class="card-right d-flex align-items-center">
                                    <p>1,544 </p>
                                </div>
                            </div>
                            <div class="chart-wrapper">
                                <canvas id="canvas3" style="height:100px !important"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <h3 class='card-title'>Sales Today</h3>
                                <div class="card-right d-flex align-items-center">
                                    <p>423 </p>
                                </div>
                            </div>
                            <div class="chart-wrapper">
                                <canvas id="canvas4" style="height:100px !important"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
                    <!-- <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class='card-heading p-1 pl-3'>Avances</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <div class="pl-3">
                                                <h1 class='mt-5'></h1>
                                                <p class='text-xs'><span class="text-green"><i data-feather="bar-chart" width="15"></i> +19%</span> último mes</p>
                                                <div class="legends">
                                                    <div class="legend d-flex flex-row align-items-center">
                                                        <div class='w-3 h-3 rounded-full bg-info me-2'></div><span class='text-xs'>Ultimo Mes</span>
                                                    </div>
                                                    <div class="legend d-flex flex-row align-items-center">
                                                        <div class='w-3 h-3 rounded-full bg-blue me-2'></div><span class='text-xs'>Mes Actual</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-12">
                                            <canvas id="bar"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                    <!-- <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Orders Today</h4>
                        <div class="d-flex ">
                            <i data-feather="download"></i>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-0">
                        <div class="table-responsive">
                            <table class='table mb-0' id="table1">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>City</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Graiden</td>
                                        <td>vehicula.aliquet@semconsequat.co.uk</td>
                                        <td>076 4820 8838</td>
                                        <td>Offenburg</td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dale</td>
                                        <td>fringilla.euismod.enim@quam.ca</td>
                                        <td>0500 527693</td>
                                        <td>New Quay</td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nathaniel</td>
                                        <td>mi.Duis@diam.edu</td>
                                        <td>(012165) 76278</td>
                                        <td>Grumo Appula</td>
                                        <td>
                                            <span class="badge bg-danger">Inactive</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Darius</td>
                                        <td>velit@nec.com</td>
                                        <td>0309 690 7871</td>
                                        <td>Ways</td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ganteng</td>
                                        <td>velit@nec.com</td>
                                        <td>0309 690 7871</td>
                                        <td>Ways</td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Oleg</td>
                                        <td>rhoncus.id@Aliquamauctorvelit.net</td>
                                        <td>0500 441046</td>
                                        <td>Rossignol</td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kermit</td>
                                        <td>diam.Sed.diam@anteVivamusnon.org</td>
                                        <td>(01653) 27844</td>
                                        <td>Patna</td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->
                    <!-- <div class="col-md-4">
                <div class="card ">
                    <div class="card-header">
                        <h4>Your Earnings</h4>
                    </div>
                    <div class="card-body">
                        <div id="radialBars"></div>
                        <div class="text-center mb-5">
                            <h6>From last month</h6>
                            <h1 class='text-green'>+$2,134</h1>
                        </div>
                    </div>
                </div>
                <div class="card widget-todo">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h4 class="card-title d-flex">
                            <i class='bx bx-check font-medium-5 pl-25 pr-75'></i>Progress
                        </h4>
                
                    </div>
                    <div class="card-body px-0 py-1">
                        <table class='table table-borderless'>
                            <tr>
                                <td class='col-3'>UI Design</td>
                                <td class='col-6'>
                                    <div class="progress progress-info">
                                        <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class='col-3 text-center'>60%</td>
                            </tr>
                            <tr>
                                <td class='col-3'>VueJS</td>
                                <td class='col-6'>
                                    <div class="progress progress-success">
                                        <div class="progress-bar" role="progressbar" style="width: 35%" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class='col-3 text-center'>30%</td>
                            </tr>
                            <tr>
                                <td class='col-3'>Laravel</td>
                                <td class='col-6'>
                                    <div class="progress progress-danger">
                                        <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class='col-3 text-center'>50%</td>
                            </tr>
                            <tr>
                                <td class='col-3'>ReactJS</td>
                                <td class='col-6'>
                                    <div class="progress progress-primary">
                                        <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class='col-3 text-center'>80%</td>
                            </tr>
                            <tr>
                                <td class='col-3'>Go</td>
                                <td class='col-6'>
                                    <div class="progress progress-secondary">
                                        <div class="progress-bar" role="progressbar" style="width: 65%" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class='col-3 text-center'>65%</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div> -->
                </section>

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
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/app.js"></script>

    <!-- <script src="../assets/vendors/chartjs/Chart.min.js"></script>
    <script src="../assets/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/js/pages/dashboard.js"></script> -->

    <script src="../assets/js/main.js"></script>
    <!-- <script src="../modal.js"></script> -->
    <script type="text/javascript">
        //asignacion de nombre de periodo para titulo
        document.getElementById('CodigoPeriodo').onchange = function() {
            /* Referencia a los atributos data de la opción seleccionada */
            var mData = this.options[this.selectedIndex].dataset;

            /* Referencia a los input */
            var elCode = document.getElementById('CodPer');
            var elName = document.getElementById('NomPer');
            var elEst = document.getElementById('EstadoPer');

            /* Asignamos cada dato a su input*/
            elCode.value = mData.codigo;
            elName.value = mData.nombre;
            elEst.value = mData.estado;

        };
    </script>

    <script type="text/javascript">
        function cerrarsession() {
            window.sessionStorage.removeItem("mostrarModal");
        }
    </script>

</body>

</html>