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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        $iconColor = 'text-success';
        $iconClass = 'bi-tools';
        $pageTitle = "Gestión de Utilidades"; // Cambia esto según la lógica de tu aplicación style="font-size:0.8em"
        include("topbar.html"); ?>
        <!-- <div class="container mt-5 pt-3" style="margin-left: var(--sidebar-width); max-width:87%;"> -->
        <main id="content">
            <h1 class="text-center">Backup de Base de Datos (Copia de Soporte)</h1>
            <div class="text-center mt-3">
                <button id="backupBtn" class="btn btn-danger"><i class="bi bi-database-lock"></i> Generar Backup</button>
            </div>
            <div id="progressContainer" class="text-center mt-3" style="display: none;">
                <div class="progress" style="height: 25px; width: 50%; margin: 0 auto;">
                    <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-danger text-white"
                        role="progressbar" style="width: 0%;">0%</div>
                </div>
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
        $(document).ready(function() {
            $('#backupBtn').click(function() {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Este proceso es irreversible. Se generará una copia de seguridad de la base de datos.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, generar backup',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#backupBtn').attr('disabled', true).text('Generando Backup...');
                        $('#progressContainer').show();
                        $('#responseMsg').html('').removeClass().hide();

                        let progress = 0;
                        let progressBar = $('#progressBar');

                        // Simular progreso lento
                        const interval = setInterval(() => {
                            if (progress < 95) {
                                progress += Math.floor(Math.random() * 3) + 1; // suma 1 a 3%
                                progress = Math.min(progress, 95); // no pasar de 95%
                                progressBar.css('width', progress + '%').text(progress + '%');
                            }
                        }, 200); // cada 300ms

                        // Hacer el AJAX
                        $.ajax({
                            url: 'backup.php',
                            method: 'POST',
                            success: function(response) {
                                clearInterval(interval);
                                progressBar.css('width', '100%').text('100%');

                                setTimeout(() => {
                                    $('#progressContainer').hide();
                                    $('#backupBtn').attr('disabled', false).text('Generar Backup');

                                    $('#responseMsg')
                                        .html(response)
                                        // .removeClass()
                                        // .addClass('alert bg-danger text-white text-center mt-3')
                                        .show();

                                    progressBar.css('width', '0%').text('0%');
                                }, 2200);
                            },
                            error: function() {
                                clearInterval(interval);
                                progressBar.css('width', '100%').text('Error');

                                setTimeout(() => {
                                    $('#progressContainer').hide();
                                    $('#backupBtn').attr('disabled', false).text('Generar Backup');

                                    $('#responseMsg')
                                        .html('<strong>Error:</strong> No se pudo generar el backup.')
                                        .removeClass()
                                        .addClass('alert bg-danger text-white text-center mt-3')
                                        .show();

                                    progressBar.css('width', '0%').text('0%');
                                }, 1500);
                            }
                        });
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