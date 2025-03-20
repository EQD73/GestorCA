<?php
session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}
$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.css" integrity="sha512-us/9of/cEp3FrrmLUpCcWUAzm2gE7EOPnfEAWBMwdWR1Lpxw0orMoVvLyyoGSD9iMGAUlEd8XHzt5+SDwmdGLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.2/sweetalert2.js" integrity="sha512-vgklhe3vcXaOdX0on3diSDRNRFlqWR9sLH6mMT4gm8ZzSMG0OxE8S1Tm8LHUOfEdZICn45OO2eluLLt81oHvtQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <h1 class="text-center">Cargar archivo Asignaturas.CSV</h1>

    <!-- Enlace de descarga con una imagen -->
    <div class="text-center">
        <a href="descargar2.php" class="btn btn-success">
            <img src="https://img.icons8.com/?size=100&id=11594&format=png&color=000000" alt="Descargar CSV" style="width: 24px; height: 24px; margin-right: 8px;">
            Descargar Plantilla Asignaturas.CSV
        </a> </div>
   <!-- Mostrar alertas dependiendo del estado -->
   <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'success'): ?>
            <div class="alert alert-success" role="alert">
                El archivo CSV se ha cargado correctamente en la base de datos.
            </div>
        <?php elseif ($_GET['status'] == 'error_file'): ?>
            <div class="alert alert-danger" role="alert">
            Hubo un problema al subir el archivo. Falla de conexion a BD o Asignaturas ya existen en BD. Por favor valide logs de cargue/duplicados, intente de nuevo.
            </div>
        <?php elseif ($_GET['status'] == 'error_db'): ?>
            <div class="alert alert-danger" role="alert">
                Error al conectar con la base de datos. Verifique su configuración.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Formulario para subir archivo con barra de progreso -->
    <form id="csvForm" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="csvFile" class="form-label">Seleccione un archivo CSV</label>
            <input class="form-control" type="file" id="csvFile" name="csvFile" accept=".csv" required>
        </div>
        <button type="submit" class="btn btn-primary">Subir CSV</button>
    </form>

    <!-- Barra de progreso -->
    <div class="progress mt-3" style="height: 30px;">
        <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>

    <h2 class="mt-5">Vista previa del CSV</h2>
    <table id="csvPreview" class="table table-bordered mt-3">
        <thead>
        <tr>
            <th>Codigo</th>
            <th>Nombre Asig</th>
            <th>Codigo_Prog</th>
            <th>Sem</th>
            <th>Grupo</th>
            <th>Ihs</th>
            <th>Creditos</th>
            <th>Cod. Docente</th>
            <th>Nom. Docente</th>
            <th>Periodo</th>
        </tr>
        </thead>
        <tbody>
        <!-- Aquí se mostrará la vista previa -->
        </tbody>
    </table>
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

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript para previsualizar el archivo CSV y manejar la barra de progreso -->
<script>
document.getElementById('csvFile').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const csvData = event.target.result;
            const rows = csvData.split('\n');
            let html = '';
            rows.forEach((row, index) => {
                const cols = row.split(',');
                if (cols.length === 10 && index > 0) {  // Asumiendo que hay 10 columnas
                  
                    html += `<tr><td>${cols[0]}</td><td>${cols[1]}</td><td>${cols[2]}</td><td>${cols[3]}</td><td>${cols[4]}</td><td>${cols[5]}</td><td>${cols[6]}</td><td>${cols[7]}</td><td>${cols[8]}</td><td>${cols[9]}</td></tr>`;
                }
            });
            document.querySelector('#csvPreview tbody').innerHTML = html;

        };
        reader.readAsText(file);
    }
});

// Manejar el formulario de subida con AJAX para la barra de progreso
document.getElementById('csvForm').onsubmit = function(event) {
    event.preventDefault();

    const fileInput = document.getElementById('csvFile');
    const formData = new FormData();
    formData.append('csvFile', fileInput.files[0]);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'upload2.php', true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            // Parsear la respuesta JSON desde el servidor
            var response = JSON.parse(xhr.responseText);
            if (response.status === 'duplicados') {
                // Mostrar la alerta con los códigos de usuario duplicados
                alert(response.message);
                window.location.href = 'cargue2.php?status=error_file';
            } else if (response.status === 'success') {
                // Mostrar mensaje de éxito si no hay duplicados
                alert(response.message);
                window.location.href = 'cargue2.php?status=success';
            }          
                   
        }

    };

    xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
            const percentComplete = (e.loaded / e.total) * 100;
            const progressBar = document.getElementById('progressBar');
            progressBar.style.width = percentComplete + '%';
            progressBar.setAttribute('aria-valuenow', percentComplete);
            progressBar.textContent = Math.round(percentComplete) + '%';
        }
    };
    xhr.send(formData);
};
</script>
</body>
</html>
