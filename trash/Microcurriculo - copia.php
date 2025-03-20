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
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.dataTables.min.css">
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

                                <!-- <li>
                                    <a href="est_estudiantes.php">Estudiantes</a>
                                </li> -->

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

                <h3 class="text-center" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Módulo MicroCurriculo</h3>


                <div class="row">
                    <div class="col-4 offset-9">
                        <div class="text-center">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#modalUsuario" style="font-size:0.8em" id="botonCrear">
                                <i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo MicroCurriculo</button>
                        </div>
                    </div>
                </div>
                <br />
                <br />

                <div class="table-responsive-sm" style="font-size:0.8em">
                    <table id="datos_micro" class="table table-sm table-bordered">
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
                                <th>Editar</th>
                                <th>Borrar</th>
                                <th>Imprimir</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modalMicro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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


    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script> -->


    <script type="text/javascript">
        $(document).ready(function() {
            $("#botonCrear").click(function() {
                window.location.href = 'agregar_micro.php';
                /* $("#formulario")[0].reset();
                $(".modal-title").text("Crear Usuario");
                $("#action").val("Crear");
                $("#operacion").val("Crear"); */
            });

            var dataTable = $('#datos_micro').DataTable({
                /* 'processing': true,
                'serverSide': true,
                'serverMethod': 'post', */
                orderCellsTop: true,
                fixedHeader: true,
                'ajax': {
                    'url': 'obtener_registrosMicro.php'
                    /* 'url': 'datos_micro.php',
                    /* "data": function (d) {}, */
                },



                'columns': [{

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
                        data: 'editar'
                    },
                    {
                        data: 'borrar'
                    },
                    {
                        data: 'imprimir'
                    },
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
                ////prueba
               /*  initComplete: function() {
                this.api().columns([7, 8]).every(function() {
                    var column = this;
                    var select = $('<select class="form-control"><option value = ""></option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });
                    column.data().unique().sort().each(function(d, j) {
                        if (column.search() === '^' + d + '$') {
                            select.append(
                                '<option value="' + d + '" selected="selected">' +
                                d +
                                '</option>'
                            )
                        } else {
                            select.append('<option value="' + d + '">' + d + '</option>')
                        }
                    });
                });
            }
 */

                ////fin prueba




            });
            //Creamos una fila en el head de la tabla y lo clonamos para cada columna
            /* $('#datos_micro thead tr').clone(true).appendTo( '#datos_micro thead' );

            $('#datos_micro thead tr:eq(1) th').each( function (i) {
                var title = $(this).text(); //es el nombre de la columna
                $(this).html( '<input type="text" placeholder="Filtrar...'+title+'" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );     */

            //var table = $('#datos_micro').DataTable({
            
            //});


            //Aquí código inserción
            /* $(document).on('submit', '#formulario', function(event) {
                event.preventDefault();
                var codigo_user = $('#codigo').val();
                var nombres = $('#nombres').val();
                var apellidos = $('#apellidos').val();
                var celular = $('#celular').val();
                var email = $('#email').val();
                var estado = $('#estado').val();
                var rol = $('#rol').val();


                if (codigo_user != '' && nombres != '' && apellidos != '' && email != '') {
                    $.ajax({
                        url: "crearUsuario.php",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            Swal.fire({
                                icon: "success",
                                title: "Exito!",
                                text: data,
                                showConfirmButton: true,
                                confirmButtonText: "Ok"
                            })
                        }
                    });
                    $('#formulario')[0].reset();
                    $('#modalUsuario').modal('hide');
                    dataTable.ajax.reload();
                } else {
                    Swal.fire({
                        icon: "info",
                        title: "Atención!",
                        text: "Algunos campos son obligatorios",
                        showConfirmButton: true,
                        confirmButtonText: "Ok"
                    })

                }
            }); */

            //Funcionalida de editar
            $(document).on('click', '.editar', function() {


                var id_micro = $(this).attr("id");
                // alert(id_micro);

                $.ajax({
                    url: "obtener_registroMicro.php",
                    method: "POST",
                    data: {
                        id_micro: id_micro
                    },
                    //dataType: "json",
                    success: function(data) {

                        /*  $('#modalUsuario').modal('show');
                        $('#codigo').val(data.codigo_usuario);
                        $('#nombres').val(data.nombres);
                        $('#apellidos').val(data.apellidos);
                        $('#celular').val(data.celular);
                        $('#email').val(data.email);
                        $('#estado').val(data.estado);
                        $('#rol').val(data.rol);
                        $('.modal-title').text("Editar Usuario");
                        $('#id_usuario').val(id_usuario);
                        $('#action').val("Editar");
                        $('#operacion').val("Editar");
 */
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                })
                window.location.href = "consultar_micro.php";
            });


            //Funcionalida de imprimir
            $(document).on('click', '.imprimir', function() {

                var id_micro = $(this).attr("id");
                // alert(id_micro);

                $.ajax({
                    url: "Envioimprpdf.php",
                    method: "POST",
                    data: {
                        id_micro: id_micro
                    },
                    //dataType: "json",
                    success: function(data) {},

                })
                window.open("imprimirMicro.php");
            });

            //Funcionalida de borrar
            $(document).on('click', '.borrar', function() {
                var id_micro = $(this).attr("id");

                Swal.fire({
                    title: 'Estás seguro de borrar este registro: ' + id_micro + ' ?',
                    text: "No podrás revertir los cambios!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borralo!'
                }).then((result) => {

                    if (result.isConfirmed) {
                        $.ajax({
                            url: "borrarMicro.php",
                            method: "POST",
                            data: {
                                id_micro: id_micro
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


</body>

</html>