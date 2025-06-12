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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
            <h3 class="text-center">Carga Masiva de la tabla Usuarios</h3>

            <!-- Enlace de descarga con una imagen -->
            <div class="text-center">
                <a href="descargar1.php" class="btn btn-danger">
                    <img src="https://img.icons8.com/?size=100&id=11594&format=png&color=000000" alt="Descargar CSV" style="width: 24px; height: 24px; margin-right: 8px;">
                    Descargar Plantilla Usuarios.CSV
                </a>
            </div>

            <!-- Formulario para subir archivo con barra de progreso -->
            <form id="csvForm" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="csvFile" class="form-label">Seleccione un archivo CSV</label>
                    <input class="form-control" type="file" id="csvFile" name="csvFile" accept=".csv" required>
                </div>
                <button type="submit" class="btn btn-danger">Subir CSV</button>
            </form>

            <!-- Barra de progreso -->
            <div class="progress mt-3" style="height: 30px;">
                <div id="progressBar" class="progress-bar bg-danger" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
            </div>

            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tabla de Usuarios</h5>
                    <button id="infoProgramasBtn" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-question-circle me-1"></i> Códigos Roles
                    </button>
                </div>
                <div class="card-body">
                    <h2 class="mt-5">Vista previa del CSV</h2>
                    <table id="csvPreview" class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Email Institucional</th>
                                <th>Codigo_rol</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aquí se mostrará la vista previa -->
                        </tbody>
                    </table>
                </div>
            </div>

            <footer>
                <p>© 2024 UniCorsalud. Todos los derechos reservados.</p>
            </footer>
        </main>
    <?php
}
    ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            //sweet alert inicial

            $('#infoProgramasBtn').on('click', function() {
                Swal.fire({
                    title: 'Recuerda:',
                    icon: 'info',
                    html: `
                    <ul class="text-start mb-0" style="max-height: 300px; overflow-y: auto;">
                        <li><strong>Codigo_rol = 2</strong> → Docente</li>
                        <li><strong>Codigo_rol = 4</strong> → Director/Coordinador</li>
                        <li><strong>Codigo_rol = 5</strong> → Directivo</li>                       
                    </ul>
                `,
                    confirmButtonText: 'Cerrar',
                    width: 'auto',
                    customClass: {
                        popup: 'text-start p-3'
                    }
                });
            });
        });
        //******* Validacion del archivo CSV que se carga*/
        document.getElementById('csvFile').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.readAsText(file);

            reader.onload = function(e) {
                try {
                    const content = e.target.result;
                    console.log("Contenido leído del archivo:", content);
                    const lines = content.split(/\r\n|\n/).filter(line => line.trim() !== '');



                    //const lines = content.split(/\r\n|\n/).filter(line => line.trim() !== '');

                    // Detectar si la primera línea es encabezado
                    const headerWords = ['codigo', 'nombre', 'apellido', 'email', 'rol', 'estado'];
                    const firstLine = lines[0].toLowerCase();
                    const isHeader = headerWords.some(word => firstLine.includes(word));

                    const startRow = isHeader ? 1 : 0;
                    let tableHtml = '';
                    const lineCount = Math.min(lines.length, startRow + 10);

                    for (let i = startRow; i < lineCount; i++) {
                        // Manejar celdas con comas dentro de comillas
                        const cells = lines[i].match(/(".*?"|[^",]+)(?=\s*,|\s*$)/g) || [];
                        const cleanCells = cells.map(cell =>
                            cell.replace(/^"|"$/g, '').trim()
                        );

                        if (cleanCells.length >= 6) {
                            tableHtml += `<tr>
                        <td>${cleanCells[0] || ''}</td>
                        <td>${cleanCells[1] || ''}</td>
                        <td>${cleanCells[2] || ''}</td>
                        <td>${cleanCells[3] || ''}</td>
                        <td>${cleanCells[4] || ''}</td> 
                        <td>${cleanCells[5] || ''}</td>                     
                    </tr>`;
                        }
                    }

                    document.querySelector('#csvPreview tbody').innerHTML = tableHtml ||
                        '<tr><td colspan="6">No se pudieron leer datos del archivo</td></tr>';

                } catch (error) {
                    console.error('Error procesando CSV:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo leer el archivo CSV. Verifique el formato y codificación.',
                        confirmButtonText: 'Entendido'
                    });
                }
            };

            reader.onerror = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de lectura',
                    text: 'No se pudo leer el archivo. Asegúrese que está en formato UTF-8.',
                    confirmButtonText: 'Entendido'
                });
            };
        });


        function resetFormUI() {
            // Limpiar formulario
            document.getElementById('csvForm').reset();

            // Reiniciar barra de progreso
            $('#progressBar').css('width', '0%').attr('aria-valuenow', 0).text('0%');

            // Limpiar tabla de vista previa (si la tienes en un div con id #previewTable, cámbialo según tu caso)
            document.querySelector('#csvPreview tbody').innerHTML = '';
        }

        $('#csvForm').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se va a procesar el archivo CSV. Esta acción no se puede deshacer.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, cargar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData(this);
                    $('#progressBar').css('width', '0%').attr('aria-valuenow', 0).text('0%');

                    $.ajax({
                        xhr: function() {
                            var xhr = new XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function(e) {
                                if (e.lengthComputable) {
                                    var percentComplete = Math.round((e.loaded / e.total) * 100);
                                    $('#progressBar').css('width', percentComplete + '%')
                                        .attr('aria-valuenow', percentComplete)
                                        .text(percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        type: 'POST',
                        url: 'upload1.php',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            try {
                                var res = response;

                                if (res.status === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Carga exitosa!',
                                        text: res.message,
                                        confirmButtonText: 'Aceptar'
                                    }).then(() => {
                                        resetFormUI();
                                    });
                                    if (res.preview) {
                                        renderPreview(res.preview); // si aplica
                                    }

                                } else if (res.status === 'parcial') {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Carga parcial',
                                        html: `
                                    <p>${res.message}</p>
                                    <p><strong>Duplicados:</strong> ${res.duplicados.join(', ')}</p>
                                `,
                                        confirmButtonText: 'Aceptar'
                                    }).then(() => {
                                        resetFormUI();
                                    });

                                } else if (res.status === 'noparcial') {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Carga No Realizada',
                                        html: `
                                    <p>${res.message}</p>
                                    <p><strong>Duplicados:</strong> ${res.duplicados.join(', ')}</p>
                                `,
                                        confirmButtonText: 'Aceptar'
                                    }).then(() => {
                                        resetFormUI();
                                    });

                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error en la carga',
                                        text: res.message || 'Ocurrió un error desconocido.',
                                        confirmButtonText: 'Aceptar'
                                    }).then(() => {
                                        resetFormUI();
                                    });
                                }
                            } catch (e) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Respuesta inesperada',
                                    html: '<pre>' + response + '</pre>',
                                    confirmButtonText: 'Cerrar'
                                });
                            }
                        }
                    }); // <- Fin de $.ajax
                } // <- Fin de if (result.isConfirmed)
            }); // <- Fin de .then()
        }); // <- Fin de $('#csvForm').on()

        function renderPreview(data) {
            let tbody = $('#csvPreview tbody');
            tbody.empty();

            if (Array.isArray(data) && data.length > 0) {
                data.forEach(function(row) {
                    tbody.append(
                        '<tr>' +
                        '<td>' + row.codigo + '</td>' +
                        '<td>' + row.nombre + '</td>' +
                        '<td>' + row.apellido + '</td>' +
                        '<td>' + row.email + '</td>' +
                        '<td>' + row.rol + '</td>' +
                        '<td>' + row.estado + '</td>' +
                        '</tr>'
                    );
                });
            } else {
                tbody.append('<tr><td colspan="6" class="text-center">No hay datos para mostrar</td></tr>');
            }
        }
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