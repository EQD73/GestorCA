<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}


$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];

require "conexion.php";


$query_periodo = "SELECT codigo_periodo, nombre_periodo, estado, descripcion FROM sistema.periodos WHERE estado='ACTIVO'";
$resultado_qp = pg_query($conexion, $query_periodo);

$query_roles = "SELECT * FROM sistema.roles WHERE codigo_rol='$codigo_rol'";
$resultado_qr = pg_query($conexion, $query_roles);
$objroles = pg_fetch_object($resultado_qr);
$nombre_rol = $objroles->nombre_rol;
$_SESSION['nombre_rol'] = $nombre_rol;

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

    <div class="modal fade" tabindex="-1" role="dialog" id="ventana-modal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seleccionar Periodo</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <form method="POST" action="#datos-periodo">
                    <div class="modal-body">
                        <select class="form-select form-select-sm" id="CodigoPeriodo">
                            <option value="" data-codigo="" data-nombre="" selected>Escoger Opción</option>
                            <?php
                            while ($obj = pg_fetch_object($resultado_qp)) { ?>
                                <option value="" data-codigo="<?php echo $obj->codigo_periodo; ?>" data-nombre="<?php echo $obj->nombre_periodo; ?>" data-estado="<?php echo $obj->estado; ?>" data-desc="<?php echo $obj->descripcion; ?>"><?php echo $obj->codigo_periodo;
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
                    <input type="hidden" class="form-control form-control sm" id="DescPer" name="DescPer">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Aceptar</button>
                        <!-- <button type="button" class="btn btn-danger">Aceptar</button> -->
                    </div>
                    <div class="row" id="datos-periodo" style="display:none">
                        <div class="col-md-12 mt-2">
                            <?php
                            $_SESSION['codigo_periodo'] = $_REQUEST['CodPer'];
                            $_SESSION['anio'] = substr($_REQUEST['CodPer'], 0, 4);
                            $_SESSION['nombre_periodo'] = $_REQUEST['NomPer'];
                            $_SESSION['estado_periodo'] = $_REQUEST['EstadoPer'];
                            $_SESSION['descripcion'] = $_REQUEST['DescPer'];
                            ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <?php
    // elegir las tablas a trabajar por periodo//
    $anio = $_SESSION['anio'];
    //echo $anio;
    $m1 = ".m1";
    $m2 = ".m2";
    $m3 = ".m3";
    $Codperiod = strval($_SESSION['codigo_periodo']);
    //$tabla1 = $Codperiod . $m1;
    //$tabla1="periodo2023_1_m1";
    //$tabla2 = $Codperiod . $m2;
    //$tabla3 = $Codperiod . $m3;
    $tabla1 = $m1;
    $tabla2 = $m2;
    $tabla3 = $m3;
    $schema = "sistema";
    $_SESSION['tablam1'] = $schema . $tabla1;
    $_SESSION['tablam2'] = $schema . $tabla2;
    $_SESSION['tablam3'] = $schema . $tabla3;

    //si existe tabla1
    /* $consulta_t1 = "SELECT * FROM pg_tables WHERE tablename='$tabla1' AND schemaname='$schema'";
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
    } */
    //si existe tabla2
    /*  $consulta_t2 = "SELECT * FROM pg_tables WHERE tablename='$tabla2' AND schemaname='$schema'";
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
    } */
    //si existe tabla3
    /* $consulta_t3 = "SELECT * FROM pg_tables WHERE tablename='$tabla2' AND schemaname='$schema'";
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
    } */
    ?>

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

            <div class="main-content container-fluid">
                <div class="container">
                    <h4 class="text-center" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Periodo Académico: <?php echo $_SESSION['descripcion']; ?></h4>
                    <hr>
                </div>

                <div class="page-title">
                    <h3>Inicio</h3>
                    <!-- <p class="text-subtitle text-muted">Algunas estadisticas importantes</p> -->
                </div>
                <section class="section">

                </section>

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
            var elDesc = document.getElementById('DescPer');

            /* Asignamos cada dato a su input*/
            elCode.value = mData.codigo;
            elName.value = mData.nombre;
            elEst.value = mData.estado;
            elDesc.value = mData.desc;
        };
    </script>

    <script type="text/javascript">
        function cerrarsession() {
            window.sessionStorage.removeItem("mostrarModal");
        }
    </script>

</body>

</html>