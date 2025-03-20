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
$nombre_rol=$objroles->nombre_rol;
$_SESSION['nombre_rol']=$nombre_rol;

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
                    <h3>Reporte de Microcurriculo</h3>
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
