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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
 --> <!-- <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css"> -->
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.css" integrity="sha512-us/9of/cEp3FrrmLUpCcWUAzm2gE7EOPnfEAWBMwdWR1Lpxw0orMoVvLyyoGSD9iMGAUlEd8XHzt5+SDwmdGLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.js" integrity="sha512-vgklhe3vcXaOdX0on3diSDRNRFlqWR9sLH6mMT4gm8ZzSMG0OxE8S1Tm8LHUOfEdZICn45OO2eluLLt81oHvtQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<!-- <script>
    $(document).ready(function() {
        $('#ventana-modal').modal('toggle')
    });
</script> -->
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
                                                    No hay notificaciones
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

                <div class="container">

                    <h3 class="text-center">CRUD Control de Usuarios</h3>


                    <div class="row">
                        <div class="col-4 offset-9">
                            <div class="text-center">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#modalUsuario" style="font-size:0.8em" id="botonCrear">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> Usuario Nuevo</button>
                            </div>
                        </div>
                    </div>
                    <br />
                    <br />

                    <div class="table-responsive-sm" style="font-size:0.8em">
                        <table id="datos_usuario" class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Código</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Celular</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Rol</th>
                                    <th>Nom. Rol</th>
                                    <th>Editar</th>
                                    <th>Borrar</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <input type="text" name="codigo" id="codigo" placeholder="numero de  doc. identidad" class="form-control">
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
                                                <label for="Celular">Ingrese Celular</label>
                                                <input type="text" name="Celular" id="Celular" pattern="\d{10}" maxlength="10" required placeholder="ej.: 3001234567" class="form-control">
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="email">Correo electrónico Institucional:</label>
                                                <input type="text" id="email" name="email" placeholder="usuario" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                                <div class="input-group-addon">
                                                    <span class="input-group-text" id="basic-addon2">@unicorsalud.edu.co</span>
                                                </div>
                                                <br>
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
                                        <!-- div class="row">
                                            <div class="col-sm-6">
                                                <label for="desc_rol">Nombre Rol</label>
                                                <input type="text" id="descripcion_rol" class="form-control form-control-sm mt-2" readonly>
                                            </div>
                                    </div> -->
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>



    <script type="text/javascript">
        $(document).ready(function() {
            $("#botonCrear").click(function() {
                $("#formulario")[0].reset();
                $(".modal-title").text("Crear Usuario");
                $("#action").val("Crear");
                $("#operacion").val("Crear");
            });

            var dataTable = $('#datos_usuario').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': 'obtener_registrosUsuario.php'
                },
                'columns': [{

                        data: 'id'
                    },
                    {
                        data: 'codigo_usuario'
                    },
                    {
                        data: 'nombres'
                    },
                    {
                        data: 'apellidos'
                    },
                    {
                        data: 'Celular'
                    },
                    {
                        data: 'email_institucional'
                    },
                    {
                        data: 'estado'
                    },
                    {
                        data: 'codigo_rol'
                    },
                    {
                        data: 'nom_rol'
                    },
                    {
                        data: 'editar'
                    },
                    {
                        data: 'borrar'
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
            });

            //Aquí código inserción / crear
            $(document).on('submit', '#formulario', function(event) {
                event.preventDefault();
                var codigo_user = $('#codigo').val();
                var nombres = $('#nombres').val();
                var apellidos = $('#apellidos').val();
                var Celular = $('#Celular').val();
                var email = $('#email').val();
                var estado = $('#estado').val();
                var rol = $('#rol').val();
                // var nomrol = $('#descripcion_rol').val();


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
            });

            //Funcionalida de editar
            $(document).on('click', '.editar', function() {
                var id_usuario = $(this).attr("id");
                $.ajax({
                    url: "obtener_registroUsuario.php",
                    method: "POST",
                    data: {
                        id_usuario: id_usuario
                    },
                    dataType: "json",
                    success: function(data) {

                        $('#modalUsuario').modal('show');
                        $('#codigo').val(data.codigo_usuario);
                        $('#nombres').val(data.nombres);
                        $('#apellidos').val(data.apellidos);
                        $('#Celular').val(data.Celular);
                        let parteUsuario = data.email.split('@')[0];
                        $('#email').val(parteUsuario);
                        $('#estado').val(data.estado);
                        $('#rol').val(data.rol);
                        $('.modal-title').text("Editar Usuario");
                        $('#id_usuario').val(id_usuario);
                        $('#action').val("Guardar Cambios");
                        $('#operacion').val("Editar");

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                })
            });

            //Funcionalida de borrar
            $(document).on('click', '.borrar', function() {
                var id_usuario = $(this).attr("id");

                Swal.fire({
                    title: 'Estás seguro de borrar este registro del usuario: ' + id_usuario + ' ?',
                    text: "No podrás revertir los cambios!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borralo!'
                }).then((result) => {

                    if (result.isConfirmed) {
                        $.ajax({
                            url: "borrarUsuario.php",
                            method: "POST",
                            data: {
                                id_usuario: id_usuario
                            },
                            success: function(data) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Exito!",
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
    <script>
        document.getElementById('rol').addEventListener('change', function() {
            const selectedText = this.options[this.selectedIndex].text;
            document.getElementById('descripcion_rol').value = selectedText !== 'Escoger Opción' ? selectedText : '';
        });
    </script>

    <script type="text/javascript">
        function cerrarsession() {
            window.sessionStorage.removeItem("mostrarModal");
        }
    </script>


    </body>

</html>