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

$estado = $_SESSION['estado_periodo'] ?? null;
$periodo = $_SESSION['codigo_periodo'] ?? null;

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

// Obtener periodos
$periodos = $pdo->query("SELECT codigo_periodo, nombre_periodo FROM sistema.periodos WHERE estado='ACTIVO' ORDER BY anio DESC, codigo_periodo DESC")->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        <?php require('stylepanel.html'); ?>
    </style>
    <style>
        .form-check-input.danger {
            border-color: #dc3545;
            /* rojo Bootstrap */
        }

        .form-check-input.danger:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
            /* sombra al hacer foco */
        }

        .form-check-input.danger:checked {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .select2-container--default .select2-selection--single {
            /* background-color: #f8d7da; */
            /* Rojo atenuado (similar a Bootstrap danger-light) */
            border-color: #f5c6cb;
            /* Borde rojo claro */
            color: #721c24;
            /* Texto rojo oscuro */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #721c24;
            /* Texto del elemento seleccionado */
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #f8d7da;
            /* Color al hacer hover o seleccionar opción */
            color: #721c24;
        }
    </style>
</head>


<?php
/* if ($codigo_rol == '3' || $codigo_rol == '4' || $codigo_rol == '5' || $codigo_rol == '2') { ?>
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
} else { */
?>


<body>
    <?php include("sidebar.html");
    //Define esto antes de incluir el topbar -->
    $iconColor = 'text-success';
    $iconClass = 'bi-tools';
    $pageTitle = "Gestión de Utilidades"; // Cambia esto según la lógica de tu aplicación style="font-size:0.8em"
    include("topbar.html"); ?>
    <!-- <div class="container mt-5 pt-3" style="margin-left: var(--sidebar-width); max-width:87%;"> -->
    <main id="content">
        <div class="card shadow-lg p-4">
            <h3 class="mb-4 text-center">Traslado Entre Asignaturas - Consignador de Actividades</h3>

            <form id="trasladarForm">
                <div class="row">
                    <div class="col-md-6">
                        <label for="codigo_asignatura_origen" class="form-label">Asignatura Origen:</label>
                        <select name="codigo_asignatura_origen" id="codigo_asignatura_origen" class="form-select select2" style="width: 100%;">
                            <option value="">Seleccione una asignatura</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="codigo_asignatura_destino" class="form-label">Asignatura Destino:</label>
                        <select name="codigo_asignatura_destino" id="codigo_asignatura_destino" class="form-select select2" style="width: 100%;">
                            <option value="">Seleccione una asignatura</option>
                        </select>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-danger px-5">Trasladar</button>
                </div>
            </form>
        </div>
        <footer>
            <p>© 2024 UniCorsalud. Todos los derechos reservados.</p>
        </footer>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // Cargar periodos
            $.getJSON('get_asignaturas_trasladoc.php', function(data) {
                data.forEach(p => {
                    $('#codigo_asignatura_origen, #codigo_asignatura_destino').append(
                        `<option value="${p.id}">${p.id} - ${p.text}</option>`
                    );
                });
            });
        });
    </script>

    <script>
        document.getElementById('trasladarForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const periodo = "<?php echo $periodo; ?>";

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Este proceso es irreversible. ¿Deseas continuar con el traslado?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, trasladar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(this);
                    formData.append('periodo', periodo);

                    fetch('trasladar3_m2.php', {
                            method: 'POST',
                            body: formData,


                        })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire(data.title, data.message, data.status);
                            //if (data.status === 'success') {
                            // Limpiar el formulario
                            document.getElementById('trasladarForm').reset();
                            // Recargar las asignaturas
                            $('#codigo_asignatura_origen, #codigo_asignatura_destino').trigger('change');
                        })

                        .catch(err => {
                            console.error(err);
                            Swal.fire('Error', 'Error al conectar con el servidor.', 'error');
                        });
                }
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