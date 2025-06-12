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

//select de tabla facultades

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
    <script>
        const estadoPeriodo = "<?php echo $estadoper; ?>";
    </script>
    <style>
        <?php require('stylepanel.html'); ?>
    </style>
</head>

<body>
    <?php include("sidebar.html");
    //Define esto antes de incluir el topbar -->
    $iconColor = 'text-danger';
    $iconClass = 'bi-stack';
    $pageTitle = "Gestión de Microcuriculos"; // Cambia esto según la lógica de tu aplicación style="font-size:0.8em"
    include("topbar.html"); ?>
    <!-- <div class="container mt-5 pt-3" style="margin-left: var(--sidebar-width); max-width:87%;"> -->
    <main id="content">
        <h3 class="text-center mt-2" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Módulo MicroCurriculo</h3>
        <div class="row justify-content-end mb-4"> <!-- Botón alineado a la derecha -->
            <div class="col-auto">
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalUsuario" id="botonCrear">
                    <i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo MicroCurriculo
                </button>
            </div>
        </div>

        <div class="table-responsive-sm mt-1" style="width: 100%">
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
        <footer>
            <p>© 2024 UniCorsalud. Todos los derechos reservados.</p>
        </footer>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#botonCrear").click(function() {
                window.location.href = 'agregar_micro.php';
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

            });


            //Funcionalidad de editar
            $(document).on('click', '.editar', function() {

                var rowId = $(this).attr("id");
                // alert(id_micro);

                // Obtén el id de la fila seleccionada
                //const rowId = $(this).closest('tr').data('id');

                //alert(rowId);

                if (rowId) {

                    // Redirigir a otra página con el ID como parámetro
                    window.location.href = 'consultar_micro.php?id=' + rowId;
                } else {

                    alert('ID no encontrado.');
                }


            });


            //Funcionalidad de imprimir
            $(document).on('click', '.imprimir', function() {

                var id_micro = $(this).attr("id");
                // alert(id_micro);

                if (id_micro) {
                    window.open("imprimirMicro.php?id=" + id_micro);
                }
            });

            //Funcionalida de borrar            
            $(document).on('click', '.borrar', function() {
                // Validación del estado del periodo
                if (estadoPeriodo === 'BLOQUEADO') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Acción no permitida',
                        text: 'No puede eliminar Microcurriculo en un periodo cerrado o bloqueado.',
                        confirmButtonText: 'Aceptar'
                    });
                    return; // Detener ejecución
                }

                var id_micro = $(this).attr("id");

                Swal.fire({
                    title: '¿Estás seguro de borrar este registro: ' + id_micro + '?',
                    text: "No podrás revertir los cambios!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, bórralo!'
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
                                });
                                dataTable.ajax.reload();
                            }
                        });
                    } else {
                        return false;
                    }
                });
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