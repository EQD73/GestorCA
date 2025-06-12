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
    <style>
        <?php require('stylepanel.html'); ?>
    </style>
    <style>
        .bg-orange {
            background-color: #fd7e14 !important;
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
        $iconColor = 'text-success';
        $iconClass = 'bi-tools';
        $pageTitle = "Gestión de Utilidades"; // Cambia esto según la lógica de tu aplicación style="font-size:0.8em"
        include("topbar.html"); ?>
        <!-- <div class="container mt-5 pt-3" style="margin-left: var(--sidebar-width); max-width:87%;"> -->
        <main id="content">
            <h1 class="text-center">Restaurar Base de Datos</h1>
            <div class="mt-4">
                <form id="restoreForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="backupFile">Selecciona el archivo de backup (.sql):</label>
                        <input type="file" id="backupFile" name="backupFile" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-danger text-center mt-3" id="restoreBtn"><i class="bi bi-database-up"></i> Restaurar Base de Datos</button>
                </form>
            </div>
            <div class="progress mt-4 position-relative" style="height: 30px; display: none;" id="progressContainer">
                <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                <span id="progressText" class="position-absolute w-100 text-center text-white" style="line-height: 30px;">0%</span>
            </div>
            <div id="responseMsg" class="text-center mt-3"></div>
            <footer>
                <p>© 2024 UniCorsalud. Todos los derechos reservados.</p>
            </footer>
        </main>

    <?php
}
    ?>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $('#restoreForm').submit(function(event) {
            event.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Antes de restaurar asegúrese de realizar un backup. Esto restaurará completamente la base de datos desde la copia seleccionada. Puede sufrir pérdida de información.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, restaurar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#restoreBtn').attr('disabled', true).text('Restaurando...');
                    // $('#responseMsg').hide().html('');
                    $('#responseMsg').html('').removeClass().hide();
                    $('#progressBar').css('width', '0%').text('0%');
                    $('#progressContainer').show();

                    let progress = 0;
                    const interval = setInterval(() => {
                        // Muy poco incremento: entre 0.2% y 0.5%
                        progress = Math.min(progress + (0.2 + Math.random() * 0.3), 95);
                        let percent = Math.floor(progress);

                        $('#progressBar').css('width', percent + '%');
                        $('#progressText').text(percent + '%');

                        // Cambios de color más notorios
                        let colorClass = 'bg-danger'; // rojo por defecto

                        if (percent >= 80) {
                            colorClass = 'bg-success'; // verde
                        } else if (percent >= 60) {
                            colorClass = 'bg-warning'; // amarillo
                        } else if (percent >= 30) {
                            colorClass = 'bg-orange'; // naranja (debes definirla si no existe en Bootstrap)
                        }

                        $('#progressBar')
                            .removeClass('bg-danger bg-warning bg-success bg-orange')
                            .addClass(colorClass);
                    }, 300); // tiempo más lento entre actualizaciones





                    const formData = new FormData($('#restoreForm')[0]);

                    $.ajax({
                        url: 'restore.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            clearInterval(interval);
                            $('#progressBar').css('width', '100%');
                            $('#progressText').text('100%');
                            $('#restoreBtn').attr('disabled', false).text('Restaurar Base de Datos');
                            $('#responseMsg').html(response).fadeIn();
                            Swal.fire('¡Restauración completada!', '', 'success');
                        },
                        error: function() {
                            clearInterval(interval);
                            $('#progressBar').css('width', '100%');
                            $('#progressText').text('100%');
                            $('#restoreBtn').attr('disabled', false).text('Restaurar Base de Datos');
                            $('#responseMsg').html('<strong>Error durante la restauración.</strong>').fadeIn();
                            Swal.fire('Error', 'Ocurrió un error durante la restauración.', 'error');
                        }
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