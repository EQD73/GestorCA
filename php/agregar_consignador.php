<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];
$codperiodo = $_SESSION['codigo_periodo'];


include('conexion.php');

// select de tabla asignaturas
$codigousuario = $_SESSION['codigo_usuario'];
$query_asignaturas = "SELECT
	a.*,
	p.nombre_programa,
    p.codigo_coordinador, 
    p.nom_coordinador,
	u.nomcompleto,
	p.codigo_facultad,
	f.nombre_facultad
FROM
	asignaturas a 
INNER JOIN programas p  ON a.codigo_programa = p.codigo_programa
INNER JOIN usuarios u  ON a.codigo_docente = u.codigo_usuario::varchar
INNER JOIN facultades f  ON p.codigo_facultad = f.codigo_facultad
WHERE a.codigo_docente='$codigousuario' AND periodo='$codperiodo'";
$resultado_qasig = pg_query($conexion, $query_asignaturas);
$num2 = pg_num_rows($resultado_qasig);
//echo $num2;
//select de tabla de usuarios 

$query_usuarios = "SELECT * FROM sistema.usuarios WHERE codigo_rol='2' ORDER BY codigo_usuario ASC ";
$resultado_qu = pg_query($conexion, $query_usuarios);

//select de tabla de usuarios 

$query_usuarios = "SELECT * FROM sistema.usuarios WHERE codigo_rol='4' ORDER BY codigo_usuario ASC ";
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

$query_periodo = "SELECT * FROM sistema.periodos WHERE estado='ACTIVO' AND codigo_periodo='$codperiodo'";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.css" integrity="sha512-us/9of/cEp3FrrmLUpCcWUAzm2gE7EOPnfEAWBMwdWR1Lpxw0orMoVvLyyoGSD9iMGAUlEd8XHzt5+SDwmdGLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.js" integrity="sha512-vgklhe3vcXaOdX0on3diSDRNRFlqWR9sLH6mMT4gm8ZzSMG0OxE8S1Tm8LHUOfEdZICn45OO2eluLLt81oHvtQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <!-- <link rel="stylesheet" type="text/css" href="dist/css/virtual-select.min.css"> 
    <script type="text/javascript" src="../js/multiselect-dropdown.js"></script>-->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">

</head>

<?php
$estadoper = $_SESSION['estado_periodo'];
if ($estadoper == 'INACTIVO') { ?>
    <script type="text/javascript">
        $(document).ready(function() {
            Swal.fire({
                icon: "info",
                title: "Cuidado!",
                text: "Usted no puede ingresar Consignación en un periodo Cerrado o no Vigente. Solo puede Editar o Consultar",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            }).then(function(result) {
                if (result.value) {
                    window.location.href = "Consignador.php";

                }
            });
        });
    </script>
<?php
} else {
?>

    <style type="text/css">
        .inputClass {
            font-weight: bold;
        }

        .disabled {
            pointer-events: none;
            opacity: 0.7;
            border-color: rgba(118, 118, 118, 0.3);
            color: -internal-light-dark(graytext, rgb(170, 170, 170));
        }
    </style>



    <body>

    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <img src="../assets/images/logo.png" width="220" height="120">
                </div>
                 
                <?php if ($codigo_rol=='2') { ?>
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

                     </ul>
                    </div>   
                <?php } ?>

                <?php if ($codigo_rol<>'2') { ?>    

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
                                    <a href="sedes.php">Sedes</a>
                                </li>
                                <li>
                                    <a href="nivel.php">Nivel</a>
                                </li>
                                <li>
                                    <a href="revisionf.php">Version Formato</a>
                                </li>
                                <li>
                                    <a href="met_evaluacion.php">Metodologia Evaluación</a>
                                </li>
                                <li>
                                    <a href="evaluacion.php">Evaluación</a>
                                </li>

                            </ul>
                        </li>


                        <li class='sidebar-title'>Herramientas</li>
                        <li class="sidebar-item  has-sub">

                            <a href="#" class='sidebar-link'>
                                <i data-feather="tool" width="20"></i>
                                <span>Utilidades</span>
                            </a>
                            <ul class="submenu ">

                                <li>
                                    <a href="configuracion.php">Configuraciones</a>
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
                                    <a href="#">Asignaturas</a>
                                </li>

                                <li>
                                    <a href="#">Estudiantes</a>
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
                <?php } ?>
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
                        <h4 class="text-center" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Módulo Consignador Académico - Agregar registro</h4>
                        <hr>
                    </div>

                    <!-- //inicio de nav-tab  -->

                    <ul class="nav nav-pills sm-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1" aria-selected="true">Información General</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2" aria-selected="false">Desarrollo de la asignatura (Semanas)</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3" type="button" role="tab" aria-controls="pills-3" aria-selected="false">Validación</button>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <?php include('FormConsignador.php'); ?>
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
                    <p>V-2024 &copy; UniCorsalud </p>
                </div>
                <!--  <div class="float-end">
                        <p>Crafted with <span class='text-danger'><i data-feather=""></i></span> by <a href="#">Eqd</a></p>
                    </div> -->
            </div>
        </footer>
        </div>
        </div>
    <?php
}
    ?>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <!-- <script src="../assets/js/app.js"></script> -->
    <script src="../assets/js/main.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/sweetAlert2/sweetalert2.all.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@dashboardcode/bsmultiselect@1.1.18/dist/js/BsMultiSelect.min.js"></script> -->
    <!-- <script type="text/javascript" src="dist/js/virtual-select.min.js"></script>
    
    <script type="text/javascript">
        VirtualSelect.init({ 
        ele: '#requisitos',
        multiple: true 
        });
    </script> -->


    <script type="text/javascript">
        /*  document.getElementById('CodigoPrograma').onchange = function() {
            /* Referencia a los atributos data de la opción seleccionada 
            var mData = this.options[this.selectedIndex].dataset;

            /* Referencia a los input 
            var elCode = document.getElementById('CodProg');
            var elName = document.getElementById('NombreProg');


            /* Asignamos cada dato a su input
            elCode.value = mData.codigo;
            elName.value = mData.nombre;

            var dato = document.getElementById('CodProg').value;
            

           $.ajax({
                    url: "EnviarDato.php",
                    type: "post",
                    data: {
                        variable: dato
                    }
                })
                .done(function(data) {
                    //alert(data);
                    $('#pills-2').load('FormsConsigna.php');
                }); 
               
        }; 
 */

        document.getElementById('CodigoCurso').onchange = function() {
            var mData = this.options[this.selectedIndex].dataset;

            /* Referencia a los input */
            var elCode = document.getElementById('CodigoCur');
            var elName = document.getElementById('NombreCurso');
            var elGroup = document.getElementById('grupo');
            var elSem = document.getElementById('semestre');
            var elcodp = document.getElementById('CodigoPrograma');
            var elnomp = document.getElementById('NombreProg');
            var elcoddoc = document.getElementById('CodigoDocente');
            var elnomdoc = document.getElementById('NomDocente');

            /* Asignamos cada dato a su input*/
            elCode.value = mData.codigo;
            elName.value = mData.nombre;
            elGroup.value = mData.grupo;
            elSem.value = mData.semestre;
            elcodp.value = mData.codprog;
            elnomp.value = mData.nomprog;
            elcoddoc.value = mData.coddocente;
            elnomdoc.value = mData.nomdocente;

            //validar que exista microcurriculo antes de crear consignacion
            var codasig = document.getElementById('CodigoCur').value;
            var codgrup = document.getElementById('grupo').value;

            $.ajax({
                url: "confirmarMicro.php",
                method: "POST",
                data: {
                    codasig: codasig,
                    codgrup: codgrup
                },
                success: function(data) {
                    if (data.trim() == "null") {
                        //alert('aqui estoy');
                        return false;
                    } else {
                        //alert(data);
                        Swal.fire({
                            icon: "success",
                            title: "Atención!",
                            text: "Esta asignatura No tiene Microcurriculo generado. Por favor ingrese MicroCurriculo antes de diligenciar el consignador",
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        }).then(function(result) {
                            if (result.value) {
                                window.location = "Consignador.php";
                            }

                        })
                    }
                }
            });

            //validar formulario por codigo programa
            var dato = document.getElementById('CodigoPrograma').value;
            //alert(dato);
            $.ajax({
                    url: "EnviarDato.php",
                    type: "post",
                    data: {
                        variable: dato
                    }
                })
                .done(function(data) {
                    //alert(data);
                    $('#pills-2c').load('FormsConsigna.php');
                });


        };

        /* document.getElementById('CodigoDocente').onchange = function() {
            /* Referencia a los atributos data de la opción seleccionada 
            var mData = this.options[this.selectedIndex].dataset;

            /* Referencia a los input 
            var elCode3 = document.getElementById('CodDocente');
            var elName3 = document.getElementById('NomDocente');

            /* Asignamos cada dato a su input
            elCode3.value = mData.codigo;
            elName3.value = mData.nombre;

        }; */
    </script>
    <script type="text/javascript">
        function cerrarsession() {
            window.sessionStorage.removeItem("mostrarModal");
        }
    </script>

    </body>

</html>