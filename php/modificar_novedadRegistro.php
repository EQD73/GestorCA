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
                    <h4 class="text-center" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Módulo Registro de Actividades - Modificar registro Novedad</h4>
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
                        <?php include('FormMNovedadRegistro.php'); ?>
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
                    $('#pills-2cont').load('FormsMNovedadRegistro.php?id=' + idrow);
                });

            /* if (document.getElementById('TipoNovedad3p').value != " "){
                $( "#TipoNovedad3p" ).focus();
            }    */

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
                document.getElementById("s1divopt7").style.display = "none";
                document.getElementById("s1divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s1divopt5").style.display = "inline-block";
                document.getElementById("s1divopt6").style.display = "inline-block";
                document.getElementById("s1divopt7").style.display = "inline-block";
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
                document.getElementById("s2divopt7").style.display = "none";
                document.getElementById("s2divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s2divopt5").style.display = "inline-block";
                document.getElementById("s2divopt6").style.display = "inline-block";
                document.getElementById("s2divopt7").style.display = "inline-block";
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
                document.getElementById("s3divopt7").style.display = "none";
                document.getElementById("s3divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s3divopt5").style.display = "inline-block";
                document.getElementById("s3divopt6").style.display = "inline-block";
                document.getElementById("s3divopt7").style.display = "inline-block";
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
                document.getElementById("s4divopt7").style.display = "none";
                document.getElementById("s4divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s4divopt5").style.display = "inline-block";
                document.getElementById("s4divopt6").style.display = "inline-block";
                document.getElementById("s4divopt7").style.display = "inline-block";
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
                document.getElementById("s5divopt7").style.display = "none";
                document.getElementById("s5divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s5divopt5").style.display = "inline-block";
                document.getElementById("s5divopt6").style.display = "inline-block";
                document.getElementById("s5divopt7").style.display = "inline-block";
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
                document.getElementById("s6divopt7").style.display = "none";
                document.getElementById("s6divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s6divopt5").style.display = "inline-block";
                document.getElementById("s6divopt6").style.display = "inline-block";
                document.getElementById("s6divopt7").style.display = "inline-block";
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
                document.getElementById("s7divopt7").style.display = "none";
                document.getElementById("s7divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s7divopt5").style.display = "inline-block";
                document.getElementById("s7divopt6").style.display = "inline-block";
                document.getElementById("s7divopt7").style.display = "inline-block";
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
                document.getElementById("s8divopt7").style.display = "none";
                document.getElementById("s8divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s8divopt5").style.display = "inline-block";
                document.getElementById("s8divopt6").style.display = "inline-block";
                document.getElementById("s8divopt7").style.display = "inline-block";
                document.getElementById("s8divopt3").style.display = "none";
                document.getElementById("s8divopt4").style.display = "none";
                document.getElementById("s8divopt1").style.display = "block";
            }
        }
        //semana 9
        function showopt1s9() {
            getSelectValue = document.getElementById("TipoActividad9").value;
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
                document.getElementById("s9divopt7").style.display = "none";
                document.getElementById("s9divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s9divopt5").style.display = "inline-block";
                document.getElementById("s9divopt6").style.display = "inline-block";
                document.getElementById("s9divopt7").style.display = "inline-block";
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
                document.getElementById("s10divopt7").style.display = "none";
                document.getElementById("s10divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s10divopt5").style.display = "inline-block";
                document.getElementById("s10divopt6").style.display = "inline-block";
                document.getElementById("s10divopt7").style.display = "inline-block";
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
                document.getElementById("s11divopt7").style.display = "none";
                document.getElementById("s11divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s11divopt5").style.display = "inline-block";
                document.getElementById("s11divopt6").style.display = "inline-block";
                document.getElementById("s11divopt7").style.display = "inline-block";
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
                document.getElementById("s12divopt7").style.display = "none";
                document.getElementById("s12divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s12divopt5").style.display = "inline-block";
                document.getElementById("s12divopt6").style.display = "inline-block";
                document.getElementById("s12divopt7").style.display = "inline-block";
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
                document.getElementById("s13divopt7").style.display = "none";
                document.getElementById("s13divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s13divopt5").style.display = "inline-block";
                document.getElementById("s13divopt6").style.display = "inline-block";
                document.getElementById("s13divopt7").style.display = "inline-block";
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
                document.getElementById("s14divopt7").style.display = "none";
                document.getElementById("s14divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s14divopt5").style.display = "inline-block";
                document.getElementById("s14divopt6").style.display = "inline-block";
                document.getElementById("s14divopt7").style.display = "inline-block";
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
                document.getElementById("s15divopt7").style.display = "none";
                document.getElementById("s15divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s15divopt5").style.display = "inline-block";
                document.getElementById("s15divopt6").style.display = "inline-block";
                document.getElementById("s15divopt7").style.display = "inline-block";
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
                document.getElementById("s16divopt7").style.display = "none";
                document.getElementById("s16divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s16divopt5").style.display = "inline-block";
                document.getElementById("s16divopt6").style.display = "inline-block";
                document.getElementById("s16divopt7").style.display = "inline-block";
                document.getElementById("s16divopt3").style.display = "none";
                document.getElementById("s16divopt4").style.display = "none";
                document.getElementById("s16divopt1").style.display = "block";
            }
        }
        //semana 17
        function showopt1s17() {
            getSelectValue = document.getElementById("TipoActividad17").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s17divopt1").style.display = "block";
                document.getElementById("s17divopt2").style.display = "none";
                document.getElementById("s17divopt3").style.display = "none";
                document.getElementById("s17divopt4").style.display = "none";
                document.getElementById("s17divopt5").style.display = "none";
                document.getElementById("s17divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s17divopt1").style.display = "block";
                document.getElementById("s17divopt2").style.display = "block";
                document.getElementById("DescripcionActSem17").focus();
                document.getElementById("s17divopt3").style.display = "none";
                document.getElementById("s17divopt4").style.display = "none";
                document.getElementById("s17divopt5").style.display = "none";
                document.getElementById("s17divopt6").style.display = "none";
            }
        }

        function showopt2s17() {
            getSelectValue = document.getElementById("TipoNovedad17").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s17divopt3").style.display = "inline-block";
                document.getElementById("s17divopt4").style.display = "inline-block";
                document.getElementById("s17divopt5").style.display = "none";
                document.getElementById("s17divopt6").style.display = "none";
                document.getElementById("s17divopt7").style.display = "none";
                document.getElementById("s17divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s17divopt5").style.display = "inline-block";
                document.getElementById("s17divopt6").style.display = "inline-block";
                document.getElementById("s17divopt7").style.display = "inline-block";
                document.getElementById("s17divopt3").style.display = "none";
                document.getElementById("s17divopt4").style.display = "none";
                document.getElementById("s17divopt1").style.display = "block";
            }
        }
        //semana 18
        function showopt1s18() {
            getSelectValue = document.getElementById("TipoActividad18").value;
            if (getSelectValue == "Regular") {
                document.getElementById("s18divopt1").style.display = "block";
                document.getElementById("s18divopt2").style.display = "none";
                document.getElementById("s18divopt3").style.display = "none";
                document.getElementById("s18divopt4").style.display = "none";
                document.getElementById("s18divopt5").style.display = "none";
                document.getElementById("s18divopt6").style.display = "none";

            } else if (getSelectValue == "Novedad") {
                document.getElementById("s18divopt1").style.display = "block";
                document.getElementById("s18divopt2").style.display = "block";
                document.getElementById("DescripcionActSem18").focus();
                document.getElementById("s18divopt3").style.display = "none";
                document.getElementById("s18divopt4").style.display = "none";
                document.getElementById("s18divopt5").style.display = "none";
                document.getElementById("s18divopt6").style.display = "none";
            }
        }

        function showopt2s18() {
            getSelectValue = document.getElementById("TipoNovedad18").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s18divopt3").style.display = "inline-block";
                document.getElementById("s18divopt4").style.display = "inline-block";
                document.getElementById("s18divopt5").style.display = "none";
                document.getElementById("s18divopt6").style.display = "none";
                document.getElementById("s18divopt7").style.display = "none";
                document.getElementById("s18divopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s18divopt5").style.display = "inline-block";
                document.getElementById("s18divopt6").style.display = "inline-block";
                document.getElementById("s18divopt7").style.display = "inline-block";
                document.getElementById("s18divopt3").style.display = "none";
                document.getElementById("s18divopt4").style.display = "none";
                document.getElementById("s18divopt1").style.display = "block";
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
                document.getElementById("s1pdivopt7").style.display = "none";
                document.getElementById("s1pdivopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s1pdivopt5").style.display = "inline-block";
                document.getElementById("s1pdivopt6").style.display = "inline-block";
                document.getElementById("s1pdivopt7").style.display = "inline-block";
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
            getSelectValue = document.getElementById("TipoNovedad2p").value;
            if (getSelectValue == "Fueradefecha") {
                document.getElementById("s2pdivopt3").style.display = "inline-block";
                document.getElementById("s2pdivopt4").style.display = "inline-block";
                document.getElementById("s2pdivopt5").style.display = "none";
                document.getElementById("s2pdivopt6").style.display = "none";
                document.getElementById("s2pdivopt7").style.display = "none";
                document.getElementById("s2pdivopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s2pdivopt5").style.display = "inline-block";
                document.getElementById("s2pdivopt6").style.display = "inline-block";
                document.getElementById("s2pdivopt7").style.display = "inline-block";
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
                document.getElementById("s3pdivopt7").style.display = "none";
                document.getElementById("s3pdivopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s3pdivopt5").style.display = "inline-block";
                document.getElementById("s3pdivopt6").style.display = "inline-block";
                document.getElementById("s3pdivopt7").style.display = "inline-block";
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
                document.getElementById("s4pdivopt7").style.display = "none";
                document.getElementById("s4pdivopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s4pdivopt5").style.display = "inline-block";
                document.getElementById("s4pdivopt6").style.display = "inline-block";
                document.getElementById("s4pdivopt7").style.display = "inline-block";
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
                document.getElementById("s5pdivopt7").style.display = "none";
                document.getElementById("s5pdivopt1").style.display = "block";
            } else if (getSelectValue == "Reprogramacion") {
                document.getElementById("s5pdivopt5").style.display = "inline-block";
                document.getElementById("s5pdivopt6").style.display = "inline-block";
                document.getElementById("s5pdivopt7").style.display = "inline-block";
                document.getElementById("s5pdivopt3").style.display = "none";
                document.getElementById("s5pdivopt4").style.display = "none";
                document.getElementById("s5pdivopt1").style.display = "block";
            }
        }
    </script>
    <script type="text/javascript">
        function cerrarsession() {
            window.sessionStorage.removeItem("mostrarModal");
        }
    </script>
    <script type="text/javascript">
        function borrardatos() {
            //semana 1
            if (document.getElementById("DescripcionActSem1")) {
                if (document.getElementById("DescripcionActSem1").value != " ") {
                    document.getElementById("DescripcionActSem1").value = " ";
                    document.getElementById("TipoNovedad1").selectedIndex = 0;
                    document.getElementById("justificasem1").value = " ";
                    document.getElementById("fechanov1").value = " ";
                    document.getElementById("fecharepinicio1").value = " ";
                    document.getElementById("fecharepfinal1").value = " ";
                    document.getElementById("DescripcionActSem1").focus();
                }
            }
            //semana 2
            if (document.getElementById("DescripcionActSem2")) {
                if (document.getElementById("DescripcionActSem2").value != " ") {
                    document.getElementById("DescripcionActSem2").value = " ";
                    document.getElementById("TipoNovedad2").selectedIndex = 0;
                    document.getElementById("justificasem2").value = " ";
                    document.getElementById("fechanov2").value = " ";
                    document.getElementById("fecharepinicio2").value = " ";
                    document.getElementById("fecharepfinal2").value = " ";
                    document.getElementById("DescripcionActSem2").focus();
                }
            }
            //semana 3
            if (document.getElementById("DescripcionActSem3")) {
                if (document.getElementById("DescripcionActSem3").value != " ") {
                    document.getElementById("DescripcionActSem3").value = " ";
                    document.getElementById("TipoNovedad3").selectedIndex = 0;
                    document.getElementById("justificasem3").value = " ";
                    document.getElementById("fechanov3").value = " ";
                    document.getElementById("fecharepinicio3").value = " ";
                    document.getElementById("fecharepfinal3").value = " ";
                    document.getElementById("DescripcionActSem3").focus();
                }
            }
            //semana 4
            if (document.getElementById("DescripcionActSem4")) {
                if (document.getElementById("DescripcionActSem4").value != " ") {
                    document.getElementById("DescripcionActSem4").value = " ";
                    document.getElementById("TipoNovedad4").selectedIndex = 0;
                    document.getElementById("justificasem4").value = " ";
                    document.getElementById("fechanov4").value = " ";
                    document.getElementById("fecharepinicio4").value = " ";
                    document.getElementById("fecharepfinal4").value = " ";
                    document.getElementById("DescripcionActSem4").focus();
                }
            }
            //semana 5
            if (document.getElementById("DescripcionActSem5")) {
                if (document.getElementById("DescripcionActSem5").value != " ") {
                    document.getElementById("DescripcionActSem5").value = " ";
                    document.getElementById("TipoNovedad5").selectedIndex = 0;
                    document.getElementById("justificasem5").value = " ";
                    document.getElementById("fechanov5").value = " ";
                    document.getElementById("fecharepinicio5").value = " ";
                    document.getElementById("fecharepfinal5").value = " ";
                    document.getElementById("DescripcionActSem5").focus();
                }
            }
            //semana 6
            if (document.getElementById("DescripcionActSem6")) {
                if (document.getElementById("DescripcionActSem6").value != " ") {
                    document.getElementById("DescripcionActSem6").value = " ";
                    document.getElementById("TipoNovedad6").selectedIndex = 0;
                    document.getElementById("justificasem6").value = " ";
                    document.getElementById("fechanov6").value = " ";
                    document.getElementById("fecharepinicio6").value = " ";
                    document.getElementById("fecharepfinal6").value = " ";
                    document.getElementById("DescripcionActSem6").focus();
                }
            }
            //semana 7
            if (document.getElementById("DescripcionActSem7")) {
                if (document.getElementById("DescripcionActSem7").value != " ") {
                    document.getElementById("DescripcionActSem7").value = " ";
                    document.getElementById("TipoNovedad7").selectedIndex = 0;
                    document.getElementById("justificasem7").value = " ";
                    document.getElementById("fechanov7").value = " ";
                    document.getElementById("fecharepinicio7").value = " ";
                    document.getElementById("fecharepfinal7").value = " ";
                    document.getElementById("DescripcionActSem7").focus();
                }
            }
            //semana 8
            if (document.getElementById("DescripcionActSem8")) {
                if (document.getElementById("DescripcionActSem8").value != " ") {
                    document.getElementById("DescripcionActSem8").value = " ";
                    document.getElementById("TipoNovedad8").selectedIndex = 0;
                    document.getElementById("justificasem8").value = " ";
                    document.getElementById("fechanov8").value = " ";
                    document.getElementById("fecharepinicio8").value = " ";
                    document.getElementById("fecharepfinal8").value = " ";
                    document.getElementById("DescripcionActSem8").focus();
                }
            }
            //semana 9
            if (document.getElementById("DescripcionActSem9")) {
                if (document.getElementById("DescripcionActSem9").value != " ") {
                    document.getElementById("DescripcionActSem9").value = " ";
                    document.getElementById("TipoNovedad9").selectedIndex = 0;
                    document.getElementById("justificasem9").value = " ";
                    document.getElementById("fechanov9").value = " ";
                    document.getElementById("fecharepinicio9").value = " ";
                    document.getElementById("fecharepfinal9").value = " ";
                    document.getElementById("DescripcionActSem9").focus();
                }
            }
            //semana 10
            if (document.getElementById("DescripcionActSem10")) {
                if (document.getElementById("DescripcionActSem10").value != " ") {
                    document.getElementById("DescripcionActSem10").value = " ";
                    document.getElementById("TipoNovedad10").selectedIndex = 0;
                    document.getElementById("justificasem10").value = " ";
                    document.getElementById("fechanov10").value = " ";
                    document.getElementById("fecharepinicio10").value = " ";
                    document.getElementById("fecharepfinal10").value = " ";
                    document.getElementById("DescripcionActSem10").focus();
                }
            }
            //semana 11
            if (document.getElementById("DescripcionActSem11")) {
                if (document.getElementById("DescripcionActSem11").value != " ") {
                    document.getElementById("DescripcionActSem11").value = " ";
                    document.getElementById("TipoNovedad11").selectedIndex = 0;
                    document.getElementById("justificasem11").value = " ";
                    document.getElementById("fechanov11").value = " ";
                    document.getElementById("fecharepinicio11").value = " ";
                    document.getElementById("fecharepfinal11").value = " ";
                    document.getElementById("DescripcionActSem11").focus();
                }
            }
            //semana 12
            if (document.getElementById("DescripcionActSem12")) {
                if (document.getElementById("DescripcionActSem12").value != " ") {
                    document.getElementById("DescripcionActSem12").value = " ";
                    document.getElementById("TipoNovedad12").selectedIndex = 0;
                    document.getElementById("justificasem12").value = " ";
                    document.getElementById("fechanov12").value = " ";
                    document.getElementById("fecharepinicio12").value = " ";
                    document.getElementById("fecharepfinal12").value = " ";
                    document.getElementById("DescripcionActSem12").focus();
                }
            }
            //semana 13
            if (document.getElementById("DescripcionActSem13")) {
                if (document.getElementById("DescripcionActSem13").value != " ") {
                    document.getElementById("DescripcionActSem13").value = " ";
                    document.getElementById("TipoNovedad13").selectedIndex = 0;
                    document.getElementById("justificasem13").value = " ";
                    document.getElementById("fechanov13").value = " ";
                    document.getElementById("fecharepinicio13").value = " ";
                    document.getElementById("fecharepfinal13").value = " ";
                    document.getElementById("DescripcionActSem13").focus();
                }
            }
            //semana 14
            if (document.getElementById("DescripcionActSem14")) {
                if (document.getElementById("DescripcionActSem14").value != " ") {
                    document.getElementById("DescripcionActSem14").value = " ";
                    document.getElementById("TipoNovedad14").selectedIndex = 0;
                    document.getElementById("justificasem14").value = " ";
                    document.getElementById("fechanov14").value = " ";
                    document.getElementById("fecharepinicio14").value = " ";
                    document.getElementById("fecharepfinal14").value = " ";
                    document.getElementById("DescripcionActSem14").focus();
                }
            }
            //semana 15
            if (document.getElementById("DescripcionActSem15")) {
                if (document.getElementById("DescripcionActSem15").value != " ") {
                    document.getElementById("DescripcionActSem15").value = " ";
                    document.getElementById("TipoNovedad15").selectedIndex = 0;
                    document.getElementById("justificasem15").value = " ";
                    document.getElementById("fechanov15").value = " ";
                    document.getElementById("fecharepinicio15").value = " ";
                    document.getElementById("fecharepfinal15").value = " ";
                    document.getElementById("DescripcionActSem15").focus();
                }
            }
            //semana 16
            if (document.getElementById("DescripcionActSem16")) {
                if (document.getElementById("DescripcionActSem16").value != " ") {
                    document.getElementById("DescripcionActSem16").value = " ";
                    document.getElementById("TipoNovedad16").selectedIndex = 0;
                    document.getElementById("justificasem16").value = " ";
                    document.getElementById("fechanov16").value = " ";
                    document.getElementById("fecharepinicio16").value = " ";
                    document.getElementById("fecharepfinal16").value = " ";
                    document.getElementById("DescripcionActSem16").focus();
                }
            }
            //semana 1 postgrados
            if (document.getElementById("DescripcionActSem1p")) {
                if (document.getElementById("DescripcionActSem1p").value != " ") {
                    document.getElementById("DescripcionActSem1p").value = " ";
                    document.getElementById("TipoNovedad1p").selectedIndex = 0;
                    document.getElementById("justificasem1p").value = " ";
                    document.getElementById("fechanov1p").value = " ";
                    document.getElementById("fecharepinicio1p").value = " ";
                    document.getElementById("fecharepfinal1p").value = " ";
                    document.getElementById("DescripcionActSem1p").focus();
                }
            }
            //semana 2 postgrados
            if (document.getElementById("DescripcionActSem2p")) {
                if (document.getElementById("DescripcionActSem2p").value != " ") {
                    document.getElementById("DescripcionActSem2p").value = " ";
                    document.getElementById("TipoNovedad2p").selectedIndex = 0;
                    document.getElementById("justificasem2p").value = " ";
                    document.getElementById("fechanov2p").value = " ";
                    document.getElementById("fecharepinicio2p").value = " ";
                    document.getElementById("fecharepfinal2p").value = " ";
                    document.getElementById("DescripcionActSem2p").focus();
                }
            }
            //semana 3 postgrados
            if (document.getElementById("DescripcionActSem3p")) {
                if (document.getElementById("DescripcionActSem3p").value != " ") {
                    document.getElementById("DescripcionActSem3p").value = " ";
                    document.getElementById("TipoNovedad3p").selectedIndex = 0;
                    document.getElementById("justificasem3p").value = " ";
                    document.getElementById("fechanov3p").value = " ";
                    document.getElementById("fecharepinicio3p").value = " ";
                    document.getElementById("fecharepfinal3p").value = " ";
                    document.getElementById("DescripcionActSem3p").focus();
                }
            }
            //semana 4 postgrados
            if (document.getElementById("DescripcionActSem4p")) {
                if (document.getElementById("DescripcionActSem4p").value != " ") {
                    document.getElementById("DescripcionActSem4p").value = " ";
                    document.getElementById("TipoNovedad4p").selectedIndex = 0;
                    document.getElementById("justificasem4p").value = " ";
                    document.getElementById("fechanov4p").value = " ";
                    document.getElementById("fecharepinicio4p").value = " ";
                    document.getElementById("fecharepfinal4p").value = " ";
                    document.getElementById("DescripcionActSem4p").focus();
                }
            }
            //semana 5 postgrados
            if (document.getElementById("DescripcionActSem5p")) {
                if (document.getElementById("DescripcionActSem5p").value != " ") {
                    document.getElementById("DescripcionActSem5p").value = " ";
                    document.getElementById("TipoNovedad5p").selectedIndex = 0;
                    document.getElementById("justificasem5p").value = " ";
                    document.getElementById("fechanov5p").value = " ";
                    document.getElementById("fecharepinicio5p").value = " ";
                    document.getElementById("fecharepfinal5p").value = " ";
                    document.getElementById("DescripcionActSem5p").focus();
                }
            }
        }
    </script>
</body>

</html>