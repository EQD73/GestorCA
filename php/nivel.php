<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];


include('conexion.php');

//select de tabla roles

$query_nivel = "SELECT * FROM sistema.nivel ORDER BY id ASC ";
$resultado_qnivel = pg_query($conexion, $query_nivel);
$num1 = pg_num_rows($resultado_qnivel);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/vendors/chartjs/Chart.min.css">
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/cargando.css">
    <link rel="stylesheet" type="text/css" href="../css/maquinawrite.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.css" integrity="sha512-us/9of/cEp3FrrmLUpCcWUAzm2gE7EOPnfEAWBMwdWR1Lpxw0orMoVvLyyoGSD9iMGAUlEd8XHzt5+SDwmdGLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.js" integrity="sha512-vgklhe3vcXaOdX0on3diSDRNRFlqWR9sLH6mMT4gm8ZzSMG0OxE8S1Tm8LHUOfEdZICn45OO2eluLLt81oHvtQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"> 
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
    <div class="cargando">
        <div class="loader-outter"></div>
        <div class="loader-inner"></div>
    </div>




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
                                <li>
                                    <a href="Microcurriculo.php">Microcurriculo</a>
                                </li>
                                <li>
                                    <a href="Consignador.php">Consignador Acádemico</a>
                                </li>
                                <li>
                                    <a href="Registro.php">Registro de Actividades</a>
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
                                    <a href="#">Otro...</a>
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
                                    <a href="#"></a>
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
                                                No hay notificaciones
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
                <div class="container mt-5 p-5">

                    <h4 class="text-center">CRUD Tabla Nivel</h4>
                    <hr>

                </div>

                <div class="row text-center" style="background-color: #cecece">
                    <div class="col-md-6">
                        <strong>Registrar Nivel</strong>
                    </div>
                    <div class="col-md-6">
                        <strong>Lista de Niveles<span style="color: crimson"> ( <?php echo $num1; ?> )</span> </strong>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="body">
                            <div class="row clearfix">

                                <div class="col-sm-5">
                                    <!--- Formulario para registrar Periodo --->
                                    <?php include('GuardarNivel.php');  ?>
                                </div>


                                <div class="col-sm-7">
                                    <div class="row">
                                        <div class="col-md-12 p-2">


                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="color:black" style="width:10px" scope="col">id</th>
                                                            <th style="color:black" style="width:20px" scope="col">Nivel1</th>
                                                            <th style="color:black" style="width:20px" scope="col">Nivel2</th>
                                                            <th style="color:black" style="width:20px" scope="col">Nivel3</th>
                                                            <th style="color:black" style="width:20px" scope="col">Nivel4</th> 
                                                            <th style="color:black" style="width:400px" scope="col">Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        while ($dataNivel = pg_fetch_array($resultado_qnivel)) { ?>
                                                            <tr>
                                                                <td><?php echo $dataNivel['id']; ?></td>
                                                                <td><?php echo $dataNivel['nivel1']; ?></td>
                                                                <td><?php echo $dataNivel['nivel2']; ?></td>
                                                                <td><?php echo $dataNivel['nivel3']; ?></td>
                                                                <td><?php echo $dataNivel['nivel4']; ?></td> 

                                                                <td>
                                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteChildresn<?php echo $dataNivel['id']; ?>" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                                        <i data-feather="trash-2" width="20"></i>
                                                                    </button>

                                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editChildresn<?php echo $dataNivel['id']; ?>" data-toggle="tooltip" data-placement="top" title="Modificar">
                                                                        <i data-feather="edit" width="20"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>


                                                            <!--Ventana Modal para Actualizar--->
                                                            <?php include('ModalEditarNivel.php'); ?>

                                                            <!--Ventana Modal para la Alerta de Eliminar--->
                                                            <?php include('ModalEliminarNivel.php'); ?>


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
                            <p>2022 &copy; UniCorsalud </p>
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
                    url = "recib_DeleteNivel.php";
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: dataString,
                        success: function(data) {
                            window.location.href = "nivel.php";
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