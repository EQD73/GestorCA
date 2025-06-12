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

//select de tabla evaluacion
$query_eval = "SELECT * FROM sistema.evaluacion ORDER BY id ASC ";
$resultado_qeval = pg_query($conexion, $query_eval);
$num1 = pg_num_rows($resultado_qeval);


// select de tabla sedes //
$query_sedes = "SELECT * FROM sistema.sedes ORDER BY codigo_sede ASC ";
$resultado_qs = pg_query($conexion, $query_sedes);
$num2 = pg_num_rows($resultado_qs);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        table tr th {
            background: rgba(0, 0, 0, .6);
            color: azure;
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
        $iconColor = 'text-primary';
        $iconClass = 'bi-database-fill-add';
        $pageTitle = "Gestión de Tablas Complementarias"; // Cambia esto según la lógica de tu aplicación style="font-size:0.8em"
        include("topbar.html"); ?>
        <!-- <div class="container mt-5 pt-3" style="margin-left: var(--sidebar-width); max-width:87%;"> -->
        <main id="content">
            <h4 class="text-center mt-2">CRUD Tabla Evaluación</h4>
            <div class="row text-center" style="background-color: #cecece">
                <div class="col-md-6">
                    <strong>Registrar Nueva Evaluación</strong>
                </div>
                <div class="col-md-6">
                    <strong>Lista de Evaluación<span style="color: crimson"> ( <?php echo $num1; ?> )</span> </strong>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-5">

                                <?php include('GuardarEval.php');  ?>
                            </div>

                            <div class="col-sm-7">
                                <div class="row">
                                    <div class="col-md-12 p-2">


                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">

                                                <thead>
                                                    <tr>
                                                        <th style="color:black" style="width:30px" scope="col">Id</th>
                                                        <th style="color:black" style="width:50px" scope="col">Momento</th>
                                                        <th style="color:black" style="width:50px" scope="col">% Actividades</th>
                                                        <th style="color:black" style="width:50px" scope="col">% Act. Final</th>
                                                        <th style="color:black" style="width:50px" scope="col">% Corte</th>
                                                        <th style="color:black" style="width:80px" scope="col">Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($dataEval = pg_fetch_array($resultado_qeval)) { ?>
                                                        <tr>
                                                            <td><?php echo $dataEval['id']; ?></td>
                                                            <td><?php echo $dataEval['momento']; ?></td>
                                                            <td><?php echo $dataEval['por_actividades']; ?></td>
                                                            <td><?php echo $dataEval['por_actfinal']; ?></td>
                                                            <td><?php echo $dataEval['por_corte']; ?></td>


                                                            <td>
                                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteChildresn<?php echo $dataEval['id']; ?>" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                                    <i data-feather="trash-2" width="20"></i>
                                                                </button>

                                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editChildresn<?php echo $dataEval['id']; ?>" data-toggle="tooltip" data-placement="top" title="Modificar">
                                                                    <i data-feather="edit" width="20"></i>
                                                                </button>
                                                            </td>
                                                        </tr>

                                                        <!--Ventana Modal para Actualizar-->
                                                        <?php include('ModalEditarEval.php'); ?>

                                                        <!--Ventana Modal para la Alerta de Eliminar-->
                                                        <?php include('ModalEliminarEval.php'); ?>

                                                    <?php } ?>
                                                </tbody>
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
                <p>© 2024 UniCorsalud. Todos los derechos reservados.</p>
            </footer>
        </main>
    <?php
} ?>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.btnBorrar').click(function(e) {
                e.preventDefault();
                var id = $(this).attr("id");

                var dataString = 'id=' + id;
                url = "recib_DeleteEval.php";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: dataString,
                    success: function(data) {
                        window.location.href = "evaluacion.php";
                        $('#respuesta').html(data);
                    }
                });
                return false;
            });
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