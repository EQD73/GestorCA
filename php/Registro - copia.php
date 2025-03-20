<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];


include('conexion.php');


//select de tabla usuarios

$query_facultad = "SELECT * FROM sistema.facultades ORDER BY codigo_facultad ASC ";
$resultado_qf = pg_query($conexion, $query_facultad);
$num1 = pg_num_rows($resultado_qf);


// select de tabla sedes //
//$query_sedes = "SELECT * FROM sistema.sedes ORDER BY codigo_sede ASC ";
//$resultado_qs = pg_query($conexion, $query_sedes);
//$num2= pg_num_rows($resultado_qs);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
 --> <!-- <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css"> -->
    <link rel="stylesheet" href="../assets/css/app.css">
    <!-- <link rel="stylesheet" href="../css/estilos.css"> -->
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.css" integrity="sha512-us/9of/cEp3FrrmLUpCcWUAzm2gE7EOPnfEAWBMwdWR1Lpxw0orMoVvLyyoGSD9iMGAUlEd8XHzt5+SDwmdGLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.js" integrity="sha512-vgklhe3vcXaOdX0on3diSDRNRFlqWR9sLH6mMT4gm8ZzSMG0OxE8S1Tm8LHUOfEdZICn45OO2eluLLt81oHvtQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<!-- <script>
    $(document).ready(function() {
        $('#ventana-modal').modal('toggle')
    });
</script> -->

<body>
    <!-- <div class="cargando">
        <div class="loader-outter"></div>
        <div class="loader-inner"></div>
    </div> -->


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
                                <div class="d-none d-md-block d-lg-inline-block">Hola, <?php echo $nombre; ?></div><br> 
                                <div class="d-none d-md-block d-lg-inline-block"><?php echo $_SESSION['nombre_rol']; ?></div>
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

            <div class="container">

                <div class="row">
                 <h4 class="text-center" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Periodo Académico: <?php echo $_SESSION['descripcion']; ?></h4>
                </div>

                <h3 class="text-center" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Módulo Registro de Actividades</h3>


                <div class="row">
                    <div class="col-4 offset-9">
                        <div class="text-center">
                            <!-- Button trigger modal -->
                            <!--<button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#modalUsuario" style="font-size:0.8em" id="botonCrear">
                                <i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo Registro</button>-->
                        </div>
                    </div>
                </div>
                <br />
                <br />

                <div class="table-responsive-sm" style="font-size:0.8em">
                    <table id="datos_registro" class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Grupo</th>
                                <th>Cod.Docente</th>
                                <th>Nom.Docente</th>
                                <th>Semestre</th>
                                <th>Nombre Programa</th>
                                <th>Acciones</th>
                                <!-- 
                                <th>Regular</th>
                                <th>Novedad</th>
                                <th>Borrar</th>
                                <th>Imprimir</th> -->
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="opcionesRegistro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Escoger Registro Actividades</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="#datos-registro">
                            <div class="modal-body">
                                <select class="form-select form-select-sm" id="optRegistro" name="optRegistro">
                                    <option value="" data-opcion="" selected>Escoger Opción</option>
                                    <option value="Regular" data-opcion="Regular">Registro Regular</option>
                                    <option value="Novedad" data-opcion="Novedad">Registro de Novedad</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Aceptar</button>
                                <!-- <button type="button" class="btn btn-danger">Aceptar</button> -->
                            </div>
                            <div class="row" id="datos-registro" style="display:none">
                                <div class="col-md-12 mt-2">
                                    <?php
                                    /* $optregistro = $_REQUEST['optRegistro'];
                                    //echo $optregistro;
                                    if ($optregistro=="Regular") {
                                         header("Location: menu_regularRegistro.php");
                                         die();
                                    }else if ($optregistro=="Novedad"){
                                         header("Location: menu_novedadRegistro.php");
                                         die();
                                    } */
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- <?php /* echo $optregistro;  */?> -->

        <!-- Modal -->
        <!-- <div class="modal fade" id="modalMicro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Crear Usuario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form method="POST" id="formulario" enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="col-sm-6">
                                        <label for="codigo">Ingrese Codigo Usuario</label>
                                        <input type="text" name="codigo" id="codigo" class="form-control">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="nombres">Ingrese Nombres</label>
                                            <input type="text" name="nombres" id="nombres" class="form-control" style="text-transform: uppercase">
                                        </div>

                                        <div class="col-sm-6">
                                            <label for="apellidos">Ingrese Apellidos</label>
                                            <input type="text" name="apellidos" id="apellidos" class="form-control" style="text-transform: uppercase">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="telefono">Ingrese Celular</label>
                                            <input type="text" name="celular" id="celular" class="form-control">
                                        </div>

                                        <div class="col-sm-6">
                                            <label for="email">Ingrese Email</label>
                                            <input type="email" name="email" id="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="estado">Estado</label>
                                            <select class="form-select form-select-sm" id="estado" name="estado">
                                                <option value="" selected>Escoger Opción</option>
                                                <option value="ACTIVO">ACTIVO</option>
                                                <option value="INACTIVO">INACTIVO</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="rol">Ingrese Rol</label>
                                            <select class="form-select form-select-sm" id="rol" name="rol">
                                                <option value="" selected>Escoger Opción</option>
                                                <option value="1">ADMINISTRADOR DEL SISTEMA</option>
                                                <option value="2">DOCENTE</option>
                                                <option value="4">DIRECTOR DE PROGRAMA</option>
                                                <option value="5">DIRECTIVO</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <input type="hidden" name="id_usuario" id="id_usuario">
                                    <input type="hidden" name="operacion" id="operacion">
                                    <input type="submit" name="action" id="action" class="btn btn-success" value="Crear">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->




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


    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script> -->


    <script type="text/javascript">
        $(document).ready(function() {
            $("#botonCrear").click(function() {
                //window.location.href ='agregar_registro.php';
                /* $("#formulario")[0].reset();
                $(".modal-title").text("Crear Usuario");
                $("#action").val("Crear");
                $("#operacion").val("Crear"); */
            });

            var dataTable = $('#datos_registro').DataTable({
                /* "searching": false,
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post', */
                'ajax': {
                    'url': 'obtener_registrosRegistro.php'
                    /* 'url': 'datos_micro.php',
                    /* "data": function (d) {}, */
                },



                'columns': [

                    {
                        data: 'id'
                    },
                    {
                        data: 'Codigo'
                    },
                    {
                        data: 'Nombre'
                    },
                    {
                        data: 'Grupo'
                    },
                    {
                        data: 'Codigodoc'
                    },
                    {
                        data: 'Docente'
                    },
                    {
                        data: 'semestre'
                    },
                    {
                        data: 'Programa'
                    },
                    {
                        data: 'acciones'
                    },
                    /* {
                        data: 'editarR'
                    },
                    {
                        data: 'editarN'
                    }, 
                    {
                        data: 'borrar'
                    },
                    {
                        data: 'imprimir'
                    }, */

                ],
                "language": {
                    "decimal": "",
                    "emptyTable": "No hay registros",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });

            //Funcionalida de editarR
            $(document).on('click', '.regular', function() {

                var id_registro = $(this).attr("id");

                $.ajax({
                    url: "obtener_registroRegistro.php",
                    method: "POST",
                    data: {
                        id_registro: id_registro
                    },
                    //dataType: "json",
                    success: function(data) {},
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                })
                window.location.href = "editar_regularRegistro.php";
            });

            //Funcionalida de modificarR
            $(document).on('click', '.mregular', function() {

                var id_registro = $(this).attr("id");

                $.ajax({
                    url: "obtener_registroRegistro.php",
                    method: "POST",
                    data: {
                        id_registro: id_registro
                    },
                    //dataType: "json",
                    success: function(data) {},
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                })
                window.location.href = "modificar_regularRegistro.php";
            });


            //Funcionalida de editarN
            $(document).on('click', '.novedad', function() {

                var id_registro = $(this).attr("id");
                // alert(id_micro);

                $.ajax({
                    url: "obtener_registroRegistro.php",
                    method: "POST",
                    data: {
                        id_registro: id_registro
                    },
                    //dataType: "json",
                    success: function(data) {



                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                })
                window.location.href = "editar_novedadRegistro.php";
            });


            //Funcionalida de modificarN
            $(document).on('click', '.mnovedad', function() {

                var id_registro = $(this).attr("id");
                // alert(id_micro);

                $.ajax({
                    url: "obtener_registroRegistro.php",
                    method: "POST",
                    data: {
                        id_registro: id_registro
                    },
                    //dataType: "json",
                    success: function(data) {



                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                })
                window.location.href = "modificar_novedadRegistro.php";
            });

            //Funcionalida de registrar
            $(document).on('click', '.registrar', function() {

                var id_registro = $(this).attr("id");
                // alert(id_micro);

                $.ajax({
                    url: "obtener_registroRegistro.php",
                    method: "POST",
                    data: {
                        id_registro: id_registro
                    },
                    //dataType: "json",
                    success: function(data) {



                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                })
               
                $('#opcionesRegistro').modal('show'); // abrir modal
                var res =   document.getElementById('optRegistro');
                res.selectedIndex=0;     
                
                //window.location.href = "opciones_Registro.php";
            });

            //Funcionalida de imprimir
            $(document).on('click', '.imprimir', function() {

                var id_registro = $(this).attr("id");
                // alert(id_micro);

                $.ajax({
                    url: "EnvioRimprpdf.php",
                    method: "POST",
                    data: {
                        id_registro: id_registro
                    },
                    //dataType: "json",
                    success: function(data) {},

                })
                window.open("imprimirRegistro.php");
            });

            //Funcionalida de borrar
            $(document).on('click', '.borrar', function() {
                var id_registro = $(this).attr("id");

                Swal.fire({
                    title: 'Estás seguro de borrar este registro: ' + id_registro + ' ?',
                    text: "No podrás revertir los cambios!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borralo!'
                }).then((result) => {

                    if (result.isConfirmed) {
                        $.ajax({
                            url: "borrarRegistro.php",
                            method: "POST",
                            data: {
                                id_registro: id_registro
                            },
                            success: function(data) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Atención!",
                                    text: data,
                                    showConfirmButton: true,
                                    confirmButtonText: "Ok"
                                })
                                dataTable.ajax.reload();
                            }
                        });
                    } else {
                        return false;
                    }
                })
            })
        });
    </script>
    <script type="text/javascript">
        function cerrarsession() {
            window.sessionStorage.removeItem("mostrarModal");
        }
    </script>
    <script type="text/javascript">
        //asignacion de nombre de periodo para titulo
        document.getElementById('optRegistro').onchange = function() {
        var opt=document.getElementById('optRegistro').value;
        if (opt=="Regular"){
            window.location.href= "menu_regularRegistro.php";
        } else if (opt=="Novedad")  {   
        window.location.href= "menu_novedadRegistro.php";
        } 
        }; 
    </script>    
</body>

</html>