<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];


include('conexion.php');

///traer valor de id 
/* $query_temp = "SELECT * FROM sistema.temporal WHERE id='1'";
$resultado_temp = pg_query($conexion, $query_temp);
$obj_temp = pg_fetch_object($resultado_temp);
$codigoConsulta = $obj_temp->valor2; */


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
}
$codigoConsulta = $id;
$_SESSION['codigoConsulta'] = $codigoConsulta;

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


    <!--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@dashboardcode/bsmultiselect@1.1.18/dist/css/BsMultiSelect.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="../assets/vendors/chartjs/Chart.min.css"> -->
    <!-- <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css"> -->
    <link rel="stylesheet" href="../assets/css/app.css">
    <!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/@dashboardcode/bsmultiselect@1.1.18/dist/js/BsMultiSelect.min.js"></script> -->
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <!-- <link rel="stylesheet" type="text/css" href="dist/css/virtual-select.min.css"> -->
    <script type="text/javascript" src="../js/multiselect-dropdown.js"></script>
    <!-- <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"> -->

</head>


<style type="text/css">
    .inputClass {
        font-weight: bold;

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
                    <h4 class="text-center" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Módulo Registro de Actividades - Registro Novedad</h4>
                    <hr>
                </div>
                <div class="row">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <?php $url1 = "editar_novedadRegistro.php?id=" . urlencode($codigoConsulta); ?>
                        <?php $url2 = "modificar_novedadRegistro.php?id=" . urlencode($codigoConsulta); ?>
                        <a href="<?php echo $url1; ?>" class="btn btn-info btn-ms" id="BtnAgregar" type="button" data-toggle="tooltip" data-placement="top" title="Agregar Registro de Actividades"><i data-feather="file-plus" width="20"></i> Agregar</a>
                        <a href="<?php echo $url2; ?>" class="btn btn-warning btn-ms" id="BtnEditar" type="button" data-toggle="tooltip" data-placement="top" title="Editar Registro de Actividades"><i data-feather="edit" width="20"></i> Editar</a>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2"></div>
                </div>
                <hr class="hr hr-blurry" />
                <!-- //inicio de nav-tab  

                <ul class="nav nav-pills sm-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">Información General</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false" onclick="mostraropt3();">Registro de Actividades (Semanas)</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3" type="button" role="tab" aria-controls="pills-3" aria-selected="false">Validación</button>
                    </li> 
                </ul>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <?php /* include('FormRegularRegistro.php');  */ ?>
                    </div>
                </div> -->
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
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
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
                    const idrow = "<?php echo $codigoConsulta; ?>";
                    $('#pills-2cont').load('FormsRegularRegistro.php?id=' + idrow);
                });

        };
    </script>
    <script type="text/javascript">
        function cerrarsession() {
            window.sessionStorage.removeItem("mostrarModal");
        }
    </script>

</body>

</html>