<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];



include('conexion.php');
/* include('scriptsweet.php');  */


$query_periodo = "SELECT * FROM sistema.periodos ORDER BY codigo_periodo DESC ";
$resultado_qp = pg_query($conexion, $query_periodo);
$num1 = pg_num_rows($resultado_qp);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!--   <link rel="stylesheet" href="../assets/vendors/chartjs/Chart.min.css"> -->
    <!--  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">

    <!--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.css" integrity="sha512-us/9of/cEp3FrrmLUpCcWUAzm2gE7EOPnfEAWBMwdWR1Lpxw0orMoVvLyyoGSD9iMGAUlEd8XHzt5+SDwmdGLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.css" integrity="sha512-us/9of/cEp3FrrmLUpCcWUAzm2gE7EOPnfEAWBMwdWR1Lpxw0orMoVvLyyoGSD9iMGAUlEd8XHzt5+SDwmdGLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.js" integrity="sha512-vgklhe3vcXaOdX0on3diSDRNRFlqWR9sLH6mMT4gm8ZzSMG0OxE8S1Tm8LHUOfEdZICn45OO2eluLLt81oHvtQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"> -->

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

<?php
if ($codigo_rol == '3' || $codigo_rol == '4' || $codigo_rol == '5' || $codigo_rol == '2') { ?>
    <script type="text/javascript">
        $(document).ready(function() {
            Swal.fire({
                icon: "info",
                title: "Cuidado!",
                text: "Usted no tiene los permisos para ingresar a esta opción",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            }).then(function(result) {
                if (result.value) {
                    window.location.href = "home.php";

                }
            });
        });
    </script>
<?php
} else {
?>

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
                                    <a class="dropdown-item" href="logout.php" onclick="cerrarsession()"></i> Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="main-content container-fluid">
                    <div class="container">
                        <h4 class="text-center">CRUD Tabla de Periodos Académicos</h4>
                        <hr>
                    </div>
                    <div class="row text-center" style="background-color: #cecece">
                        <div class="col-md-6">
                            <strong>Registrar Nuevo Periodo</strong>
                        </div>
                        <div class="col-md-6">
                            <strong>Lista de Periodos <span style="color: crimson"> ( <?php echo $num1; ?> )</span> </strong>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-5">
                                        <!--- Formulario para registrar Periodo --->
                                        <?php include('GuardarPeriodo.php');  ?>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="row">
                                            <div class="col-md-12 p-2">


                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th style="color:black" scope="col">Código</th>
                                                                <th style="color:black" scope="col">Nombre </th>
                                                                <th style="color:black" scope="col">Estado </th>
                                                                <th style="color:black" scope="col">Acción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            while ($dataPeriodo = pg_fetch_array($resultado_qp)) { ?>
                                                                <tr>
                                                                    <td><?php echo $dataPeriodo['codigo_periodo']; ?></td>
                                                                    <td><?php echo $dataPeriodo['nombre_periodo']; ?></td>
                                                                    <td><?php echo $dataPeriodo['estado']; ?></td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteChildresn<?php echo $dataPeriodo['codigo_periodo']; ?>" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                                            <i data-feather="trash-2" width="20"></i>
                                                                        </button>

                                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editChildresn<?php echo $dataPeriodo['codigo_periodo']; ?>" data-toggle="tooltip" data-placement="top" title="Modificar">
                                                                            <i data-feather="edit" width="20"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>


                                                                <!--Ventana Modal para Actualizar--->
                                                                <?php include('ModalEditarPeriodo.php'); ?>

                                                                <!--Ventana Modal para la Alerta de Eliminar--->
                                                                <?php include('ModalEliminarPeriodo.php'); ?>


                                                            <?php } ?>

                                                    </table>
                                                </div>


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
        <?php
    } ?>
        <!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <script src="../assets/js/feather-icons/feather.min.js"></script>
        <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="../assets/js/app.js"></script>

        <script src="../assets/vendors/chartjs/Chart.min.js"></script>
    <script src="../assets/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/js/pages/dashboard.js"></script> -->

        <!-- <script src="../assets/js/main.js"></script>
        <script src="modal.js"></script>
        <script src="../js/jquery.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
        <script src="plugins/sweetAlert2/sweetalert2.all.min.js"></script>  -->

        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <script src="../assets/js/feather-icons/feather.min.js"></script>
        <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="../assets/js/app.js"></script>

        <script src="../assets/vendors/chartjs/Chart.min.js"></script>
        <script src="../assets/vendors/apexcharts/apexcharts.min.js"></script>
        <script src="../assets/js/pages/dashboard.js"></script>

        <script src="../assets/js/main.js"></script>
        <script src="modal.js"></script>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>



        <script type="text/javascript">
            $(document).ready(function() {

                $(window).load(function() {
                    $(".cargando").fadeOut(1000);
                });

                //Ocultar mensaje
                setTimeout(function() {
                    $("#contenMsjs").fadeOut(1000);
                }, 3000);



                $('.btnBorrar').click(function(e) {
                    e.preventDefault();
                    var id = $(this).attr("id");

                    var dataString = 'id=' + id;
                    url = "recib_DeletePeriodo.php";
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: dataString,
                        success: function(data) {
                            window.location.href = "periodo.php";
                            $('#respuesta').html(data);
                        }
                    });
                    return false;

                });


            });
        </script>
        <script type="text/javascript">
            function cerrarsession() {
                window.sessionStorage.removeItem("mostrarModal");
            }
        </script>



    </body>

</html>