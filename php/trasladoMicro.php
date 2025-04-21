<?php
session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}
$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];

require_once 'conexion2.php'; // Conexión PDO a PostgreSQL

// Obtener periodos
$periodos = $pdo->query("SELECT codigo_periodo, nombre_periodo FROM sistema.periodos WHERE estado='ACTIVO' ORDER BY anio DESC, codigo_periodo DESC")->fetchAll(PDO::FETCH_ASSOC);
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
                    <div class="card shadow-lg p-4">
                        <h3 class="mb-4 text-center">Traslado entre periodos - Microcurrículos</h3>
                        <form id="trasladarForm">
                            <div class="row mb-3">
                                <div class="col">
                                    <label>Periodo Origen:</label>
                                    <select name="periodo_origen" id="periodo_origen" class="form-select" required>
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($periodos as $p): ?>
                                            <option value="<?= $p['codigo_periodo'] ?>"><?= $p['nombre_periodo'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label>Periodo Destino:</label>
                                    <select name="periodo_destino" id="periodo_destino" class="form-select" required>
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($periodos as $p): ?>
                                            <option value="<?= $p['codigo_periodo'] ?>"><?= $p['nombre_periodo'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Asignatura:</label>
                                <select name="codigo_asignatura" id="codigo_asignatura" class="form-select" required>
                                    <option value="">Seleccione una asignatura</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="codigo_usuario">Código del docente:</label>
                                <input type="text" class="form-control" id="codigo_usuario" name="codigo_usuario" required>
                            </div>

                            <div class="form-group">
                                <label for="nombre_docente">Nombre del docente:</label>
                                <input type="text" class="form-control" id="nombre_docente" name="nombre_docente" readonly>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary px-5">Trasladar</button>
                            </div>
                        </form>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        document.getElementById("periodo_origen").addEventListener("change", function() {
            const periodo = this.value;
            const selectAsignatura = document.getElementById("codigo_asignatura");
            selectAsignatura.innerHTML = "<option>Cargando...</option>";

            fetch("get_asignaturas3_traslado.php?periodo=" + periodo)
                .then(res => res.json())
                .then(data => {
                    selectAsignatura.innerHTML = '<option value="">Seleccione una asignatura</option>';
                    data.forEach(item => {
                        const option = document.createElement("option");
                        option.value = item.codigo_asignatura;
                        option.text = item.codigo_asignatura + " | " + item.nom_asignatura + " - " + " (Grupo " + item.grupo + ")";
                        selectAsignatura.appendChild(option);
                    });
                });
        });
    </script>

    <script>
        document.getElementById('codigo_usuario').addEventListener('blur', function() {
            const codigo = this.value.trim();
            if (codigo === '') return;

            fetch('buscar_usuario_tm1.php?codigo=' + codigo)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('nombre_docente').value = data.nombre;
                    } else {
                        document.getElementById('nombre_docente').value = '';
                        Swal.fire('No encontrado', 'No se encontró un docente con ese código.', 'warning');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'No se pudo buscar el nombre del docente.', 'error');
                    console.error(error);
                });
        });

        document.getElementById('trasladarForm').addEventListener('submit', function(e) {
            e.preventDefault();

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

                    fetch('trasladar3_m1.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire(data.title, data.message, data.status);
                            // if (data.status === 'success') {
                            // Limpiar el formulario
                            document.getElementById('trasladarForm').reset();

                            // Enfocar en periodo_origen
                            const periodoOrigenInput = document.getElementById('periodo_origen');
                            if (periodoOrigenInput) {
                                periodoOrigenInput.focus();
                            }
                            // }
                        })

                        .catch(err => {
                            console.error(err);
                            Swal.fire('Error', 'Error al conectar con el servidor.', 'error');
                        });
                }
            });
        });
    </script>
    </body>

</html>