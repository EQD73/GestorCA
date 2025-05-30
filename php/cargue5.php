<?php
session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}
$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.css" integrity="sha512-us/9of/cEp3FrrmLUpCcWUAzm2gE7EOPnfEAWBMwdWR1Lpxw0orMoVvLyyoGSD9iMGAUlEd8XHzt5+SDwmdGLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.js" integrity="sha512-vgklhe3vcXaOdX0on3diSDRNRFlqWR9sLH6mMT4gm8ZzSMG0OxE8S1Tm8LHUOfEdZICn45OO2eluLLt81oHvtQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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
                                    <a class="dropdown-item" href="logout.php" onclick="cerrarsession()"><i data-feather="log-out"></i> Salir</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container mt-5">
                    <h3 class="text-center">Carga Masiva de la tabla Carga Académica</h3>

                    <!-- Enlace de descarga con una imagen -->
                    <div class="text-center">
                        <a href="descargar5.php" class="btn btn-danger">
                            <img src="https://img.icons8.com/?size=100&id=11594&format=png&color=000000" alt="Descargar CSV" style="width: 24px; height: 24px; margin-right: 8px;">
                            Descargar Plantilla Carga.CSV
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
                            <h5 class="mb-0">Tabla de Carga Académica</h5>
                            <button id="infoProgramasBtn" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-question-circle me-1"></i> Códigos de programas
                            </button>
                        </div>
                        <div class="card-body">
                            <h2 class="mt-5">Vista previa del CSV</h2>
                            <table id="csvPreview" class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>Código Docente</th>
                                        <th>Código Asig</th>
                                        <th>Semestre</th>
                                        <th>Grupo</th>
                                        <th>Código Programa</th>
                                        <th>Código Periodo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Aquí se mostrará la vista previa -->
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-start">
                    <p>2024 &copy; UniCorsalud </p>
                </div>
            </div>
        </footer>
        </div>
        </div>
    <?php
}
    ?>

    <!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script> -->
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        $(document).ready(function() {
            //sweet alert inicial

            $('#infoProgramasBtn').on('click', function() {
                Swal.fire({
                    title: 'Recuerda:',
                    icon: 'info',
                    html: `
                     <ul class="text-start mb-0" style="max-height: 300px; overflow-y: auto;">
                        <li><strong>Codigo_programa = 24</strong> → INGENIERÍA INDUSTRIAL</li>
                        <li><strong>Codigo_programa = 25</strong> → INGENIERÍA AMBIENTAL</li>
                        <li><strong>Codigo_programa = 26</strong> → GERENCIA SALUD OCUPACIONAL</li>
                        <li><strong>Codigo_programa = 27</strong> → CONTADURÍA Y FINANZAS INTERNACIONALES</li>
                        <li><strong>Codigo_programa = 28</strong> → SEGURIDAD Y SALUD EN EL TRABAJO</li>
                        <li><strong>Codigo_programa = 29</strong> → RADIOLOGÍA E IMÁGENES DIAGNÓSTICAS</li>
                        <li><strong>Codigo_programa = 30</strong> → GERENCIA SST</li>
                        <li><strong>Codigo_programa = 31</strong> → HIGIENE INDUSTRIAL</li>
                        <li><strong>Codigo_programa = 32</strong> → SISTEMAS INTEGRADOS DE GESTIÓN</li>
                        <li><strong>Codigo_programa = 38</strong> → SST (Montería)</li>
                        <li><strong>Codigo_programa = 39</strong> → RADIOLOGÍA (Montería)</li>
                        <li><strong>Codigo_programa = 53</strong> → INGENIERÍA DE SOFTWARE</li>
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
                    const headerWords = ['docente', 'asignatura', 'semestre', 'grupo', 'programa', 'periodo'];
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
                        url: 'upload5.php',
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
                        '<td>' + row.codigo_docente + '</td>' +
                        '<td>' + row.codigo_asignatura + '</td>' +
                        '<td>' + row.semestre + '</td>' +
                        '<td>' + row.grupo + '</td>' +
                        '<td>' + row.codigo_programa + '</td>' +
                        '<td>' + row.codigo_periodo + '</td>' +
                        '</tr>'
                    );
                });
            } else {
                tbody.append('<tr><td colspan="6" class="text-center">No hay datos para mostrar</td></tr>');
            }
        }
    </script>

    </body>

</html>