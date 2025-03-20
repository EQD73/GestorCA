<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];


include('conexion.php');

///traer valor de id 
$query_temp = "SELECT * FROM sistema.temporal WHERE id='1'";
$resultado_temp = pg_query($conexion, $query_temp);
$obj_temp = pg_fetch_object($resultado_temp);
$codigoConsulta = $obj_temp->valor2;

//select de tabla de usuarios 

$query_usuarios = "SELECT * FROM sistema.usuarios WHERE codigo_rol='2' ORDER BY codigo_usuario ASC ";
$resultado_qu = pg_query($conexion, $query_usuarios);

//select de tabla de usuarios 

$query_usuarios = "SELECT * FROM sistema.usuarios WHERE codigo_rol='5' ORDER BY codigo_usuario ASC ";
$resultado_qu2 = pg_query($conexion, $query_usuarios);

//select de tabla de usuarios 

$query_usuarios = "SELECT * FROM sistema.usuarios WHERE codigo_rol='5' ORDER BY codigo_usuario ASC ";
$resultado_qu3 = pg_query($conexion, $query_usuarios);

//select de tabla facultades
$query_facultad = "SELECT * FROM sistema.facultades ORDER BY codigo_facultad ASC ";
$resultado_qf = pg_query($conexion, $query_facultad);
$num1 = pg_num_rows($resultado_qf);

// select de tabla asignaturas

$query_asignaturas = "SELECT * FROM sistema.asignaturas ORDER BY codigo_asignatura ASC, grupo ASC ";
$resultado_qa = pg_query($conexion, $query_asignaturas);
$num2 = pg_num_rows($resultado_qa);

// select de tabla asignaturas

$query_asignaturas2 = "SELECT * FROM sistema.asignaturas ORDER BY codigo_asignatura ASC, grupo ASC ";
$resultado_qa2 = pg_query($conexion, $query_asignaturas2);
$num2 = pg_num_rows($resultado_qa2);

// select de tabla programas

$query_programas = "SELECT * FROM sistema.programas ORDER BY codigo_programa ASC ";
$resultado_qp = pg_query($conexion, $query_programas);
$num3 = pg_num_rows($resultado_qp);

// select de tabla periodo

$query_periodo = "SELECT * FROM sistema.periodos WHERE estado='ACTIVO' ORDER BY codigo_periodo ASC ";
$resultado_qper = pg_query($conexion, $query_periodo);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>


    <!--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@dashboardcode/bsmultiselect@1.1.18/dist/css/BsMultiSelect.min.css">
   --> <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> -->
    <!-- <link rel="stylesheet" href="../assets/vendors/chartjs/Chart.min.css"> -->
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/@dashboardcode/bsmultiselect@1.1.18/dist/js/BsMultiSelect.min.js"></script> -->
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <!-- <link rel="stylesheet" type="text/css" href="dist/css/virtual-select.min.css"> -->
    <script type="text/javascript" src="../js/multiselect-dropdown.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">

</head>


<style type="text/css">
    .inputClass {
        font-weight: bold;

    }
</style>



<body>

    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <img src="../assets/images/logo.png" width="220" height="300">
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

                                <li class="sidebar-item  has-sub">

                                    <a href="#" class='sidebar-link'>
                                        <i data-feather="file-plus" width="20"></i>
                                        <span>Microcurriculo</span>
                                    </a>


                                    <ul class="submenu ">

                                        <li>
                                            <a href="agregar_micro.php">Agregar Registros</a>
                                        </li>

                                        <li>
                                            <a href="consultar_micro.php">Consultar Registros</a>
                                        </li>

                                        <li>
                                            <a href="microcurriculo.php">Eliminar</a>
                                        </li>

                                    </ul>

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
                                    <a href="#">Microcurriculo</a>
                                </li>

                                <li>
                                    <a href="#">Consignador</a>
                                </li>

                                <li>
                                    <a href="#">Registro Actividades</a>
                                </li>

                                <li>
                                    <a href="ImprimirUsuarios.php" target="_blank">Usuarios</a>
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
                                                No ha ingresado informacion
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
                                    <img src="../assets/images/avatar/avatar-s-1.png" alt="" srcset="">
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
                <div class="row">
                    <h4 class="text-center">Periodo Académico: <?php echo $_SESSION['codigo_periodo'];
                                                                echo " ";
                                                                echo $_SESSION['nombre_periodo']; ?></h4>

                </div>
                <div class="container p-3">
                    <h4 class="text-center">Módulo Registro de Actividades - Agregar registro</h4>
                    <hr>
                </div>

                <!-- //inicio de nav-tab  -->

                <ul class="nav nav-pills sm-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">Información General</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false" onclick="mostraropt3();">Registro de Actividades (Semanas)</button>
                    </li>
                    <!--  <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3" type="button" role="tab" aria-controls="pills-3" aria-selected="false">Validación</button>
                    </li> -->
                </ul>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <?php include('FormRegistro.php'); ?>
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
    <!-- <script src="../assets/js/app.js"></script> -->
    <script src="../assets/js/main.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@dashboardcode/bsmultiselect@1.1.18/dist/js/BsMultiSelect.min.js"></script> -->
    <!-- <script type="text/javascript" src="dist/js/virtual-select.min.js"></script>
    <script type="text/javascript">
        VirtualSelect.init({ 
        ele: '#requisitos',
        multiple: true 
        });
    </script> -->
    <script type="text/javascript">
        function mostraropt3() {
            var dato = document.getElementById('CodigoPrograma').value;
            $.ajax({
                    url: "EnviarDato.php",
                    type: "post",
                    data: {
                        variable: dato
                    }
                })
                .done(function(data) {
                    //alert(data);
                    $('#pills-2cont').load('FormsRegistro.php');
                });

        };
    </script>
    <script type="text/javascript">
        //semana 1
        function showopt1s1() {
            getSelectValue = document.getElementById("TipoActividad1").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s1divopt1").style.display = "block";
                document.getElementById("s1divopt2").style.display = "none";
                document.getElementById("s1divopt3").style.display = "none";
                document.getElementById("s1divopt4").style.display = "none";
                document.getElementById("s1divopt5").style.display = "none";
                document.getElementById("s1divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s1divopt1").style.display = "block";
                document.getElementById("s1divopt2").style.display = "block";
                document.getElementById("DescripcionActSem1").focus();
                document.getElementById("s1divopt3").style.display = "none";
                document.getElementById("s1divopt4").style.display = "none";
                document.getElementById("s1divopt5").style.display = "none";
                document.getElementById("s1divopt6").style.display = "none";
            }
        }

        function showopt2s1() {
            getSelectValue = document.getElementById("TipoNovedad1").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s1divopt3").style.display = "inline-block";
                document.getElementById("s1divopt4").style.display = "inline-block";
                document.getElementById("s1divopt5").style.display = "none";
                document.getElementById("s1divopt6").style.display = "none";
                document.getElementById("s1divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s1divopt5").style.display = "inline-block";
                document.getElementById("s1divopt6").style.display = "inline-block";
                document.getElementById("s1divopt3").style.display = "none";
                document.getElementById("s1divopt4").style.display = "none";
                document.getElementById("s1divopt1").style.display = "block";
            }
        }
        //semana 2
        function showopt1s2() {
            getSelectValue = document.getElementById("TipoActividad2").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s2divopt1").style.display = "block";
                document.getElementById("s2divopt2").style.display = "none";
                document.getElementById("s2divopt3").style.display = "none";
                document.getElementById("s2divopt4").style.display = "none";
                document.getElementById("s2divopt5").style.display = "none";
                document.getElementById("s2divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s2divopt1").style.display = "block";
                document.getElementById("s2divopt2").style.display = "block";
                document.getElementById("DescripcionActSem2").focus();
                document.getElementById("s2divopt3").style.display = "none";
                document.getElementById("s2divopt4").style.display = "none";
                document.getElementById("s2divopt5").style.display = "none";
                document.getElementById("s2divopt6").style.display = "none";
            }
        }

        function showopt2s2() {
            getSelectValue = document.getElementById("TipoNovedad2").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s2divopt3").style.display = "inline-block";
                document.getElementById("s2divopt4").style.display = "inline-block";
                document.getElementById("s2divopt5").style.display = "none";
                document.getElementById("s2divopt6").style.display = "none";
                document.getElementById("s2divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s2divopt5").style.display = "inline-block";
                document.getElementById("s2divopt6").style.display = "inline-block";
                document.getElementById("s2divopt3").style.display = "none";
                document.getElementById("s2divopt4").style.display = "none";
                document.getElementById("s2divopt1").style.display = "block";
            }
        }
        
        //semana 3
        function showopt1s3() {
            getSelectValue = document.getElementById("TipoActividad3").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s3divopt1").style.display = "block";
                document.getElementById("s3divopt2").style.display = "none";
                document.getElementById("s3divopt3").style.display = "none";
                document.getElementById("s3divopt4").style.display = "none";
                document.getElementById("s3divopt5").style.display = "none";
                document.getElementById("s3divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s3divopt1").style.display = "block";
                document.getElementById("s3divopt2").style.display = "block";
                document.getElementById("DescripcionActSem3").focus();
                document.getElementById("s3divopt3").style.display = "none";
                document.getElementById("s3divopt4").style.display = "none";
                document.getElementById("s3divopt5").style.display = "none";
                document.getElementById("s3divopt6").style.display = "none";
            }
        }

        function showopt2s3() {
            getSelectValue = document.getElementById("TipoNovedad3").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s3divopt3").style.display = "inline-block";
                document.getElementById("s3divopt4").style.display = "inline-block";
                document.getElementById("s3divopt5").style.display = "none";
                document.getElementById("s3divopt6").style.display = "none";
                document.getElementById("s3divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s3divopt5").style.display = "inline-block";
                document.getElementById("s3divopt6").style.display = "inline-block";
                document.getElementById("s3divopt3").style.display = "none";
                document.getElementById("s3divopt4").style.display = "none";
                document.getElementById("s3divopt1").style.display = "block";
            }
        }
        //semana 4
        function showopt1s4() {
            getSelectValue = document.getElementById("TipoActividad4").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s4divopt1").style.display = "block";
                document.getElementById("s4divopt2").style.display = "none";
                document.getElementById("s4divopt3").style.display = "none";
                document.getElementById("s4divopt4").style.display = "none";
                document.getElementById("s4divopt5").style.display = "none";
                document.getElementById("s4divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s4divopt1").style.display = "block";
                document.getElementById("s4divopt2").style.display = "block";
                document.getElementById("DescripcionActSem4").focus();
                document.getElementById("s4divopt3").style.display = "none";
                document.getElementById("s4divopt4").style.display = "none";
                document.getElementById("s4divopt5").style.display = "none";
                document.getElementById("s4divopt6").style.display = "none";
            }
        }

        function showopt2s4() {
            getSelectValue = document.getElementById("TipoNovedad4").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s4divopt3").style.display = "inline-block";
                document.getElementById("s4divopt4").style.display = "inline-block";
                document.getElementById("s4divopt5").style.display = "none";
                document.getElementById("s4divopt6").style.display = "none";
                document.getElementById("s4divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s4divopt5").style.display = "inline-block";
                document.getElementById("s4divopt6").style.display = "inline-block";
                document.getElementById("s4divopt3").style.display = "none";
                document.getElementById("s4divopt4").style.display = "none";
                document.getElementById("s4divopt1").style.display = "block";
            }
        }

        //semana 5
        function showopt1s5() {
            getSelectValue = document.getElementById("TipoActividad5").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s5divopt1").style.display = "block";
                document.getElementById("s5divopt2").style.display = "none";
                document.getElementById("s5divopt3").style.display = "none";
                document.getElementById("s5divopt4").style.display = "none";
                document.getElementById("s5divopt5").style.display = "none";
                document.getElementById("s5divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s5divopt1").style.display = "block";
                document.getElementById("s5divopt2").style.display = "block";
                document.getElementById("DescripcionActSem5").focus();
                document.getElementById("s5divopt3").style.display = "none";
                document.getElementById("s5divopt4").style.display = "none";
                document.getElementById("s5divopt5").style.display = "none";
                document.getElementById("s5divopt6").style.display = "none";
            }
        }

        function showopt2s5() {
            getSelectValue = document.getElementById("TipoNovedad5").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s5divopt3").style.display = "inline-block";
                document.getElementById("s5divopt4").style.display = "inline-block";
                document.getElementById("s5divopt5").style.display = "none";
                document.getElementById("s5divopt6").style.display = "none";
                document.getElementById("s5divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s5divopt5").style.display = "inline-block";
                document.getElementById("s5divopt6").style.display = "inline-block";
                document.getElementById("s5divopt3").style.display = "none";
                document.getElementById("s5divopt4").style.display = "none";
                document.getElementById("s5divopt1").style.display = "block";
            }
        }
        //semana 6
        function showopt1s6() {
            getSelectValue = document.getElementById("TipoActividad6").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s6divopt1").style.display = "block";
                document.getElementById("s6divopt2").style.display = "none";
                document.getElementById("s6divopt3").style.display = "none";
                document.getElementById("s6divopt4").style.display = "none";
                document.getElementById("s6divopt5").style.display = "none";
                document.getElementById("s6divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s6divopt1").style.display = "block";
                document.getElementById("s6divopt2").style.display = "block";
                document.getElementById("DescripcionActSem6").focus();
                document.getElementById("s6divopt3").style.display = "none";
                document.getElementById("s6divopt4").style.display = "none";
                document.getElementById("s6divopt5").style.display = "none";
                document.getElementById("s6divopt6").style.display = "none";
            }
        }

        function showopt2s6() {
            getSelectValue = document.getElementById("TipoNovedad6").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s6divopt3").style.display = "inline-block";
                document.getElementById("s6divopt4").style.display = "inline-block";
                document.getElementById("s6divopt5").style.display = "none";
                document.getElementById("s6divopt6").style.display = "none";
                document.getElementById("s6divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s6divopt5").style.display = "inline-block";
                document.getElementById("s6divopt6").style.display = "inline-block";
                document.getElementById("s6divopt3").style.display = "none";
                document.getElementById("s6divopt4").style.display = "none";
                document.getElementById("s6divopt1").style.display = "block";
            }
        }
        //semana 7
        function showopt1s7() {
            getSelectValue = document.getElementById("TipoActividad7").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s7divopt1").style.display = "block";
                document.getElementById("s7divopt2").style.display = "none";
                document.getElementById("s7divopt3").style.display = "none";
                document.getElementById("s7divopt4").style.display = "none";
                document.getElementById("s7divopt5").style.display = "none";
                document.getElementById("s7divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s7divopt1").style.display = "block";
                document.getElementById("s7divopt2").style.display = "block";
                document.getElementById("DescripcionActSem7").focus();
                document.getElementById("s7divopt3").style.display = "none";
                document.getElementById("s7divopt4").style.display = "none";
                document.getElementById("s7divopt5").style.display = "none";
                document.getElementById("s7divopt6").style.display = "none";
            }
        }

        function showopt2s7() {
            getSelectValue = document.getElementById("TipoNovedad7").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s7divopt3").style.display = "inline-block";
                document.getElementById("s7divopt4").style.display = "inline-block";
                document.getElementById("s7divopt5").style.display = "none";
                document.getElementById("s7divopt6").style.display = "none";
                document.getElementById("s7divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s7divopt5").style.display = "inline-block";
                document.getElementById("s7divopt6").style.display = "inline-block";
                document.getElementById("s7divopt3").style.display = "none";
                document.getElementById("s7divopt4").style.display = "none";
                document.getElementById("s7divopt1").style.display = "block";
            }
        }
        //semana 8
        function showopt1s8() {
            getSelectValue = document.getElementById("TipoActividad8").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s8divopt1").style.display = "block";
                document.getElementById("s8divopt2").style.display = "none";
                document.getElementById("s8divopt3").style.display = "none";
                document.getElementById("s8divopt4").style.display = "none";
                document.getElementById("s8divopt5").style.display = "none";
                document.getElementById("s8divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s8divopt1").style.display = "block";
                document.getElementById("s8divopt2").style.display = "block";
                document.getElementById("DescripcionActSem8").focus();
                document.getElementById("s8divopt3").style.display = "none";
                document.getElementById("s8divopt4").style.display = "none";
                document.getElementById("s8divopt5").style.display = "none";
                document.getElementById("s8divopt6").style.display = "none";
            }
        }

        function showopt2s8() {
            getSelectValue = document.getElementById("TipoNovedad8").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s8divopt3").style.display = "inline-block";
                document.getElementById("s8divopt4").style.display = "inline-block";
                document.getElementById("s8divopt5").style.display = "none";
                document.getElementById("s8divopt6").style.display = "none";
                document.getElementById("s8divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s8divopt5").style.display = "inline-block";
                document.getElementById("s8divopt6").style.display = "inline-block";
                document.getElementById("s8divopt3").style.display = "none";
                document.getElementById("s8divopt4").style.display = "none";
                document.getElementById("s8divopt1").style.display = "block";
            }
        }
        //semana 9
        function showopt1s9() {
            getSelectValue = document.getElementById("TipoActividad8").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s9divopt1").style.display = "block";
                document.getElementById("s9divopt2").style.display = "none";
                document.getElementById("s9divopt3").style.display = "none";
                document.getElementById("s9divopt4").style.display = "none";
                document.getElementById("s9divopt5").style.display = "none";
                document.getElementById("s9divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s9divopt1").style.display = "block";
                document.getElementById("s9divopt2").style.display = "block";
                document.getElementById("DescripcionActSem9").focus();
                document.getElementById("s9divopt3").style.display = "none";
                document.getElementById("s9divopt4").style.display = "none";
                document.getElementById("s9divopt5").style.display = "none";
                document.getElementById("s9divopt6").style.display = "none";
            }
        }

        function showopt2s9() {
            getSelectValue = document.getElementById("TipoNovedad9").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s9divopt3").style.display = "inline-block";
                document.getElementById("s9divopt4").style.display = "inline-block";
                document.getElementById("s9divopt5").style.display = "none";
                document.getElementById("s9divopt6").style.display = "none";
                document.getElementById("s9divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s9divopt5").style.display = "inline-block";
                document.getElementById("s9divopt6").style.display = "inline-block";
                document.getElementById("s9divopt3").style.display = "none";
                document.getElementById("s9divopt4").style.display = "none";
                document.getElementById("s9divopt1").style.display = "block";
            }
        }
        //semana 10
        function showopt1s10() {
            getSelectValue = document.getElementById("TipoActividad10").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s10divopt1").style.display = "block";
                document.getElementById("s10divopt2").style.display = "none";
                document.getElementById("s10divopt3").style.display = "none";
                document.getElementById("s10divopt4").style.display = "none";
                document.getElementById("s10divopt5").style.display = "none";
                document.getElementById("s10divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s10divopt1").style.display = "block";
                document.getElementById("s10divopt2").style.display = "block";
                document.getElementById("DescripcionActSem10").focus();
                document.getElementById("s10divopt3").style.display = "none";
                document.getElementById("s10divopt4").style.display = "none";
                document.getElementById("s10divopt5").style.display = "none";
                document.getElementById("s10divopt6").style.display = "none";
            }
        }

        function showopt2s10() {
            getSelectValue = document.getElementById("TipoNovedad10").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s10divopt3").style.display = "inline-block";
                document.getElementById("s10divopt4").style.display = "inline-block";
                document.getElementById("s10divopt5").style.display = "none";
                document.getElementById("s10divopt6").style.display = "none";
                document.getElementById("s10divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s10divopt5").style.display = "inline-block";
                document.getElementById("s10divopt6").style.display = "inline-block";
                document.getElementById("s10divopt3").style.display = "none";
                document.getElementById("s10divopt4").style.display = "none";
                document.getElementById("s10divopt1").style.display = "block";
            }
        }
        //semana 11
        function showopt1s11() {
            getSelectValue = document.getElementById("TipoActividad11").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s11divopt1").style.display = "block";
                document.getElementById("s11divopt2").style.display = "none";
                document.getElementById("s11divopt3").style.display = "none";
                document.getElementById("s11divopt4").style.display = "none";
                document.getElementById("s11divopt5").style.display = "none";
                document.getElementById("s11divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s11divopt1").style.display = "block";
                document.getElementById("s11divopt2").style.display = "block";
                document.getElementById("DescripcionActSem11").focus();
                document.getElementById("s11divopt3").style.display = "none";
                document.getElementById("s11divopt4").style.display = "none";
                document.getElementById("s11divopt5").style.display = "none";
                document.getElementById("s11divopt6").style.display = "none";
            }
        }

        function showopt2s11() {
            getSelectValue = document.getElementById("TipoNovedad11").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s11divopt3").style.display = "inline-block";
                document.getElementById("s11divopt4").style.display = "inline-block";
                document.getElementById("s11divopt5").style.display = "none";
                document.getElementById("s11divopt6").style.display = "none";
                document.getElementById("s11divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s11divopt5").style.display = "inline-block";
                document.getElementById("s11divopt6").style.display = "inline-block";
                document.getElementById("s11divopt3").style.display = "none";
                document.getElementById("s11divopt4").style.display = "none";
                document.getElementById("s11divopt1").style.display = "block";
            }
        }
        //semana 12
        function showopt1s12() {
            getSelectValue = document.getElementById("TipoActividad12").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s12divopt1").style.display = "block";
                document.getElementById("s12divopt2").style.display = "none";
                document.getElementById("s12divopt3").style.display = "none";
                document.getElementById("s12divopt4").style.display = "none";
                document.getElementById("s12divopt5").style.display = "none";
                document.getElementById("s12divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s12divopt1").style.display = "block";
                document.getElementById("s12divopt2").style.display = "block";
                document.getElementById("DescripcionActSem12").focus();
                document.getElementById("s12divopt3").style.display = "none";
                document.getElementById("s12divopt4").style.display = "none";
                document.getElementById("s12divopt5").style.display = "none";
                document.getElementById("s12divopt6").style.display = "none";
            }
        }

        function showopt2s12() {
            getSelectValue = document.getElementById("TipoNovedad12").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s12divopt3").style.display = "inline-block";
                document.getElementById("s12divopt4").style.display = "inline-block";
                document.getElementById("s12divopt5").style.display = "none";
                document.getElementById("s12divopt6").style.display = "none";
                document.getElementById("s12divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s12divopt5").style.display = "inline-block";
                document.getElementById("s12divopt6").style.display = "inline-block";
                document.getElementById("s12divopt3").style.display = "none";
                document.getElementById("s12divopt4").style.display = "none";
                document.getElementById("s12divopt1").style.display = "block";
            }
        }
        //semana 13
        function showopt1s13() {
            getSelectValue = document.getElementById("TipoActividad13").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s13divopt1").style.display = "block";
                document.getElementById("s13divopt2").style.display = "none";
                document.getElementById("s13divopt3").style.display = "none";
                document.getElementById("s13divopt4").style.display = "none";
                document.getElementById("s13divopt5").style.display = "none";
                document.getElementById("s13divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s13divopt1").style.display = "block";
                document.getElementById("s13divopt2").style.display = "block";
                document.getElementById("DescripcionActSem13").focus();
                document.getElementById("s13divopt3").style.display = "none";
                document.getElementById("s13divopt4").style.display = "none";
                document.getElementById("s13divopt5").style.display = "none";
                document.getElementById("s13divopt6").style.display = "none";
            }
        }
        function showopt2s13() {
            getSelectValue = document.getElementById("TipoNovedad13").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s13divopt3").style.display = "inline-block";
                document.getElementById("s13divopt4").style.display = "inline-block";
                document.getElementById("s13divopt5").style.display = "none";
                document.getElementById("s13divopt6").style.display = "none";
                document.getElementById("s13divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s13divopt5").style.display = "inline-block";
                document.getElementById("s13divopt6").style.display = "inline-block";
                document.getElementById("s13divopt3").style.display = "none";
                document.getElementById("s13divopt4").style.display = "none";
                document.getElementById("s13divopt1").style.display = "block";
            }
        }
        //semana 14
        function showopt1s14() {
            getSelectValue = document.getElementById("TipoActividad14").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s14divopt1").style.display = "block";
                document.getElementById("s14divopt2").style.display = "none";
                document.getElementById("s14divopt3").style.display = "none";
                document.getElementById("s14divopt4").style.display = "none";
                document.getElementById("s14divopt5").style.display = "none";
                document.getElementById("s14divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s14divopt1").style.display = "block";
                document.getElementById("s14divopt2").style.display = "block";
                document.getElementById("DescripcionActSem14").focus();
                document.getElementById("s14divopt3").style.display = "none";
                document.getElementById("s14divopt4").style.display = "none";
                document.getElementById("s14divopt5").style.display = "none";
                document.getElementById("s14divopt6").style.display = "none";
            }
        }
        function showopt2s14() {
            getSelectValue = document.getElementById("TipoNovedad14").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s14divopt3").style.display = "inline-block";
                document.getElementById("s14divopt4").style.display = "inline-block";
                document.getElementById("s14divopt5").style.display = "none";
                document.getElementById("s14divopt6").style.display = "none";
                document.getElementById("s14divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s14divopt5").style.display = "inline-block";
                document.getElementById("s14divopt6").style.display = "inline-block";
                document.getElementById("s14divopt3").style.display = "none";
                document.getElementById("s14divopt4").style.display = "none";
                document.getElementById("s14divopt1").style.display = "block";
            }
        }
        //semana 15
        function showopt1s15() {
            getSelectValue = document.getElementById("TipoActividad15").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s15divopt1").style.display = "block";
                document.getElementById("s15divopt2").style.display = "none";
                document.getElementById("s15divopt3").style.display = "none";
                document.getElementById("s15divopt4").style.display = "none";
                document.getElementById("s15divopt5").style.display = "none";
                document.getElementById("s15divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s15divopt1").style.display = "block";
                document.getElementById("s15divopt2").style.display = "block";
                document.getElementById("DescripcionActSem15").focus();
                document.getElementById("s15divopt3").style.display = "none";
                document.getElementById("s15divopt4").style.display = "none";
                document.getElementById("s15divopt5").style.display = "none";
                document.getElementById("s15divopt6").style.display = "none";
            }
        }
        function showopt2s15() {
            getSelectValue = document.getElementById("TipoNovedad15").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s15divopt3").style.display = "inline-block";
                document.getElementById("s15divopt4").style.display = "inline-block";
                document.getElementById("s15divopt5").style.display = "none";
                document.getElementById("s15divopt6").style.display = "none";
                document.getElementById("s15divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s15divopt5").style.display = "inline-block";
                document.getElementById("s15divopt6").style.display = "inline-block";
                document.getElementById("s15divopt3").style.display = "none";
                document.getElementById("s15divopt4").style.display = "none";
                document.getElementById("s15divopt1").style.display = "block";
            }
        }
        //semana 16
        function showopt1s16() {
            getSelectValue = document.getElementById("TipoActividad16").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s16divopt1").style.display = "block";
                document.getElementById("s16divopt2").style.display = "none";
                document.getElementById("s16divopt3").style.display = "none";
                document.getElementById("s16divopt4").style.display = "none";
                document.getElementById("s16divopt5").style.display = "none";
                document.getElementById("s16divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s16divopt1").style.display = "block";
                document.getElementById("s16divopt2").style.display = "block";
                document.getElementById("DescripcionActSem16").focus();
                document.getElementById("s16divopt3").style.display = "none";
                document.getElementById("s16divopt4").style.display = "none";
                document.getElementById("s16divopt5").style.display = "none";
                document.getElementById("s16divopt6").style.display = "none";
            }
        }
        function showopt2s16() {
            getSelectValue = document.getElementById("TipoNovedad16").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s16divopt3").style.display = "inline-block";
                document.getElementById("s16divopt4").style.display = "inline-block";
                document.getElementById("s16divopt5").style.display = "none";
                document.getElementById("s16divopt6").style.display = "none";
                document.getElementById("s16divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s16divopt5").style.display = "inline-block";
                document.getElementById("s16divopt6").style.display = "inline-block";
                document.getElementById("s16divopt3").style.display = "none";
                document.getElementById("s16divopt4").style.display = "none";
                document.getElementById("s16divopt1").style.display = "block";
            }
        }
        //semana 1 postgrado
        function showopt1s1p() {
            getSelectValue = document.getElementById("TipoActividad1p").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s1pdivopt1").style.display = "block";
                document.getElementById("s1pdivopt2").style.display = "none";
                document.getElementById("s1pdivopt3").style.display = "none";
                document.getElementById("s1pdivopt4").style.display = "none";
                document.getElementById("s1pdivopt5").style.display = "none";
                document.getElementById("s1pdivopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s1pdivopt1").style.display = "block";
                document.getElementById("s1pdivopt2").style.display = "block";
                document.getElementById("DescripcionActSem1p").focus();
                document.getElementById("s1pdivopt3").style.display = "none";
                document.getElementById("s1pdivopt4").style.display = "none";
                document.getElementById("s1pdivopt5").style.display = "none";
                document.getElementById("s1pdivopt6").style.display = "none";
            }
        }
        function showopt2s1p() {
            getSelectValue = document.getElementById("TipoNovedad1p").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s1pdivopt3").style.display = "inline-block";
                document.getElementById("s1pdivopt4").style.display = "inline-block";
                document.getElementById("s1pdivopt5").style.display = "none";
                document.getElementById("s1pdivopt6").style.display = "none";
                document.getElementById("s1pdivopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s1pdivopt5").style.display = "inline-block";
                document.getElementById("s1pdivopt6").style.display = "inline-block";
                document.getElementById("s1pdivopt3").style.display = "none";
                document.getElementById("s1pdivopt4").style.display = "none";
                document.getElementById("s1pdivopt1").style.display = "block";
            }
        }
        //semana 2 postgrado
        function showopt1s2p() {
            getSelectValue = document.getElementById("TipoActividad2p").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s2pdivopt1").style.display = "block";
                document.getElementById("s2pdivopt2").style.display = "none";
                document.getElementById("s2pdivopt3").style.display = "none";
                document.getElementById("s2pdivopt4").style.display = "none";
                document.getElementById("s2pdivopt5").style.display = "none";
                document.getElementById("s2pdivopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s2pdivopt1").style.display = "block";
                document.getElementById("s2pdivopt2").style.display = "block";
                document.getElementById("DescripcionActSem2p").focus();
                document.getElementById("s2pdivopt3").style.display = "none";
                document.getElementById("s2pdivopt4").style.display = "none";
                document.getElementById("s2pdivopt5").style.display = "none";
                document.getElementById("s2pdivopt6").style.display = "none";
            }
        }
        function showopt2s2p() {
            getSelectValue = document.getElementById("TipoNovedad1p").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s2pdivopt3").style.display = "inline-block";
                document.getElementById("s2pdivopt4").style.display = "inline-block";
                document.getElementById("s2pdivopt5").style.display = "none";
                document.getElementById("s2pdivopt6").style.display = "none";
                document.getElementById("s2pdivopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s2pdivopt5").style.display = "inline-block";
                document.getElementById("s2pdivopt6").style.display = "inline-block";
                document.getElementById("s2pdivopt3").style.display = "none";
                document.getElementById("s2pdivopt4").style.display = "none";
                document.getElementById("s2pdivopt1").style.display = "block";
            }
        }
        //semana 3 postgrado
        function showopt1s3p() {
            getSelectValue = document.getElementById("TipoActividad3p").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s3pdivopt1").style.display = "block";
                document.getElementById("s3pdivopt2").style.display = "none";
                document.getElementById("s3pdivopt3").style.display = "none";
                document.getElementById("s3pdivopt4").style.display = "none";
                document.getElementById("s3pdivopt5").style.display = "none";
                document.getElementById("s3pdivopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s3pdivopt1").style.display = "block";
                document.getElementById("s3pdivopt2").style.display = "block";
                document.getElementById("DescripcionActSem3p").focus();
                document.getElementById("s3pdivopt3").style.display = "none";
                document.getElementById("s3pdivopt4").style.display = "none";
                document.getElementById("s3pdivopt5").style.display = "none";
                document.getElementById("s3pdivopt6").style.display = "none";
            }
        }
        function showopt2s3p() {
            getSelectValue = document.getElementById("TipoNovedad3p").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s3pdivopt3").style.display = "inline-block";
                document.getElementById("s3pdivopt4").style.display = "inline-block";
                document.getElementById("s3pdivopt5").style.display = "none";
                document.getElementById("s3pdivopt6").style.display = "none";
                document.getElementById("s3pdivopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s3pdivopt5").style.display = "inline-block";
                document.getElementById("s3pdivopt6").style.display = "inline-block";
                document.getElementById("s3pdivopt3").style.display = "none";
                document.getElementById("s3pdivopt4").style.display = "none";
                document.getElementById("s3pdivopt1").style.display = "block";
            }
        }
        //semana 4 postgrado
        function showopt1s4p() {
            getSelectValue = document.getElementById("TipoActividad4p").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s4pdivopt1").style.display = "block";
                document.getElementById("s4pdivopt2").style.display = "none";
                document.getElementById("s4pdivopt3").style.display = "none";
                document.getElementById("s4pdivopt4").style.display = "none";
                document.getElementById("s4pdivopt5").style.display = "none";
                document.getElementById("s4pdivopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s4pdivopt1").style.display = "block";
                document.getElementById("s4pdivopt2").style.display = "block";
                document.getElementById("DescripcionActSem4p").focus();
                document.getElementById("s4pdivopt3").style.display = "none";
                document.getElementById("s4divopt4").style.display = "none";
                document.getElementById("s4pdivopt5").style.display = "none";
                document.getElementById("s4pdivopt6").style.display = "none";
            }
        }
        function showopt2s4p() {
            getSelectValue = document.getElementById("TipoNovedad4p").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s4pdivopt3").style.display = "inline-block";
                document.getElementById("s4pdivopt4").style.display = "inline-block";
                document.getElementById("s4pdivopt5").style.display = "none";
                document.getElementById("s4pdivopt6").style.display = "none";
                document.getElementById("s4pdivopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s4pdivopt5").style.display = "inline-block";
                document.getElementById("s4pdivopt6").style.display = "inline-block";
                document.getElementById("s4pdivopt3").style.display = "none";
                document.getElementById("s4pdivopt4").style.display = "none";
                document.getElementById("s4pdivopt1").style.display = "block";
            }
        }
        //semana 5 postgrado
        function showopt1s5p() {
            getSelectValue = document.getElementById("TipoActividad5p").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s5pdivopt1").style.display = "block";
                document.getElementById("s5pdivopt2").style.display = "none";
                document.getElementById("s5pdivopt3").style.display = "none";
                document.getElementById("s5pdivopt4").style.display = "none";
                document.getElementById("s5pdivopt5").style.display = "none";
                document.getElementById("s5pdivopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s5pdivopt1").style.display = "block";
                document.getElementById("s5pdivopt2").style.display = "block";
                document.getElementById("DescripcionActSem5p").focus();
                document.getElementById("s5pdivopt3").style.display = "none";
                document.getElementById("s5pdivopt4").style.display = "none";
                document.getElementById("s5pdivopt5").style.display = "none";
                document.getElementById("s5pdivopt6").style.display = "none";
            }
        }
        function showopt2s5p() {
            getSelectValue = document.getElementById("TipoNovedad5p").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s5pdivopt3").style.display = "inline-block";
                document.getElementById("s5pdivopt4").style.display = "inline-block";
                document.getElementById("s5pdivopt5").style.display = "none";
                document.getElementById("s5pdivopt6").style.display = "none";
                document.getElementById("s5pdivopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s5pdivopt5").style.display = "inline-block";
                document.getElementById("s5pdivopt6").style.display = "inline-block";
                document.getElementById("s5pdivopt3").style.display = "none";
                document.getElementById("s5pdivopt4").style.display = "none";
                document.getElementById("s5pdivopt1").style.display = "block";
            }
        }
    </script>    
</body>
</html>