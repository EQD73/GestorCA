<?php
session_start();
include('conexion2.php');
include('conexion.php');


// 1) Si no hay usuario logueado, redirigir a la pantalla de login
if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
    exit();
}

// 2) Recuperar datos del usuario para mostrar (opcional)
$codigo_rol = $_SESSION['codigo_rol'];
$nombre     = $_SESSION['nombres'];
$apellido   = $_SESSION['apellidos'];

$nombre = explode(" ", trim($nombre))[0];
$apellido = explode(" ", trim($apellido))[0];

$estadoper = $_SESSION['estado_periodo'];
$estado = $_SESSION['estado_periodo'] ?? null;
$query_roles = "SELECT nombre_rol FROM sistema.roles WHERE codigo_rol = :codigo_rol";
$stmt = $pdo->prepare($query_roles);
$stmt->execute(['codigo_rol' => $codigo_rol]);
$objroles = $stmt->fetch(PDO::FETCH_OBJ);

if ($objroles) {
    $_SESSION['nombre_rol'] = $objroles->nombre_rol;
    $nombre_rol = $objroles->nombre_rol;
} else {
    $_SESSION['nombre_rol'] = null; // o maneja el caso según necesites
}

//select de tabla usuarios
$query_facultad = "SELECT * FROM sistema.facultades ORDER BY codigo_facultad ASC ";
$resultado_qf = pg_query($conexion, $query_facultad);
$num1 = pg_num_rows($resultado_qf);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        <?php require('stylepanel.html'); ?>
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
                    window.location.href = "dashboard.php";

                }
            });
        });
    </script>
<?php
} else {
?>

    <body>
        <?php include("sidebar.html");
        //Define esto antes de incluir el topbar -->
        $iconColor = 'text-primary-emphasis';
        $iconClass = 'bi-people-fill';
        $pageTitle = "Gestión Control de Usuarios"; // Cambia esto según la lógica de tu aplicación style="font-size:0.8em" style="font-size:0.8em"
        include("topbar.html"); ?>
        <!-- <div class="container mt-5 pt-3" style="margin-left: var(--sidebar-width); max-width:87%;"> -->
        <main id="content">
            <h3 class="text-center">CRUD - Tabla de Usuarios</h3>
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

            <div class="table-responsive-sm">
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
            <footer>
                <p>© 2024 UniCorsalud. Todos los derechos reservados.</p>
            </footer>
        </main>

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


    <?php
} ?>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



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
                    dataTable.ajax.reload(null, false);
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const topbar = document.getElementById('topbar');
            const content = document.getElementById('content');
            const btnToggle = document.getElementById('btnToggleSidebar');
            const sidebarToggler = document.querySelector('.sidebar-toggler');

            // Función para alternar la clase 'collapsed'
            function toggleSidebar() {
                sidebar.classList.toggle('collapsed');
                topbar.classList.toggle('collapsed');
                content.classList.toggle('collapsed');

                // Cambiar el ícono del botón hamburguesa (bi-list ↔ bi-x)
                const icon = btnToggle.querySelector('i');
                icon.classList.toggle('bi-list');
                icon.classList.toggle('bi-x');
            }

            // Cuando se hace clic en el botón hamburguesa
            btnToggle.addEventListener('click', toggleSidebar);

            // Cuando se hace clic en el botón “X” del sidebar
            sidebarToggler.addEventListener('click', () => {
                sidebar.classList.add('collapsed');
                topbar.classList.add('collapsed');
                content.classList.add('collapsed');
            });
        });
    </script>

    <script type="text/javascript">
        function cerrarsession(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Vas a salir del sistema.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php';
                }
            });
        }
    </script>


    </body>

</html>