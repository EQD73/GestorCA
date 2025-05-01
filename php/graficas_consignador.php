<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}


$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];

require "conexion.php";


$query_periodo = "SELECT codigo_periodo, nombre_periodo, estado, descripcion FROM sistema.periodos WHERE estado='ACTIVO'";
$resultado_qp = pg_query($conexion, $query_periodo);

$query_roles = "SELECT * FROM sistema.roles WHERE codigo_rol='$codigo_rol'";
$resultado_qr = pg_query($conexion, $query_roles);
$objroles = pg_fetch_object($resultado_qr);
$nombre_rol = $objroles->nombre_rol;
$_SESSION['nombre_rol'] = $nombre_rol;

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Diligenciamiento por programas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">

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
                                                No hay información
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
                                <a class="dropdown-item" href="logout.php" onclick="cerrarsession()"><i data-feather="log-out"></i>Salir</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container mt-4">
                <h2 class="text-center mb-4 fw-bold">Consignador Académico</h2>
                <h2 class="text-center mb-4">📊 Gráfico/Estadística Diligenciamiento por Programa</h2>

                <!-- Filtros -->
                <div class="row g-3">
                    <div class="col-md-2">
                        <label for="selectPeriodo" class="form-label">Periodo:</label>
                        <select id="selectPeriodo" class="form-select">
                            <option value="">Todos</option>
                            <?php
                            include 'conexion.php'; // Asegúrate de incluir tu archivo de conexión
                            $query = "SELECT codigo_periodo, nombre_periodo FROM sistema.periodos WHERE estado='ACTIVO'";
                            $result = pg_query($conexion, $query);
                            while ($row = pg_fetch_assoc($result)) {
                                echo "<option value='{$row['codigo_periodo']}'>{$row['codigo_periodo']} | {$row['nombre_periodo']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="selectPrograma" class="form-label">Programa:</label>
                        <select id="selectPrograma" class="form-select">
                            <option value="">Todos</option>
                            <?php
                            include 'conexion.php'; // Asegúrate de incluir tu archivo de conexión
                            $query = "SELECT codigo_programa, nombre_programa FROM sistema.programas";
                            $result = pg_query($conexion, $query);
                            while ($row = pg_fetch_assoc($result)) {
                                echo "<option value='{$row['codigo_programa']}'>{$row['codigo_programa']} | {$row['nombre_programa']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="selectAsignatura" class="form-label">Asignatura:</label>
                        <select id="selectAsignatura" class="form-select">
                            <option value="">Todas</option>
                        </select>
                    </div>

                    <script>
                        document.getElementById('selectPrograma').addEventListener('change', function() {
                            let codigoPrograma = this.value;
                            let asignaturaSelect = document.getElementById('selectAsignatura');

                            // Limpiar opciones previas
                            asignaturaSelect.innerHTML = '<option value="">Todas</option>';

                            if (codigoPrograma !== "") {
                                fetch('get_asignaturas.php?codigo_programa=' + codigoPrograma)
                                    .then(response => response.json())
                                    .then(data => {
                                        data.forEach(asignatura => {
                                            let option = document.createElement('option');
                                            option.value = asignatura.codigo_asignatura;
                                            option.textContent = asignatura.codigo_asignatura + " " + asignatura.nom_asignatura;
                                            asignaturaSelect.appendChild(option);
                                        });
                                    })
                                    .catch(error => console.error('Error al cargar asignaturas:', error));
                            }
                        });
                    </script>


                    <div class="col-md-2">
                        <label for="selectSemestre" class="form-label">Semestre:</label>
                        <select id="selectSemestre" class="form-select">
                            <option value="">Todos</option>
                            <?php
                            $query = "SELECT DISTINCT semestre FROM sistema.asignaturas ORDER BY semestre";
                            $result = pg_query($conexion, $query);
                            while ($row = pg_fetch_assoc($result)) {
                                echo "<option value='{$row['semestre']}'>Semestre {$row['semestre']}</option>";
                            }
                            ?>
                        </select>
                    </div>


                    <div class="col-md-2">
                        <label for="selectGrupo" class="form-label">Grupo:</label>
                        <select id="selectGrupo" class="form-select">
                            <option value="">Todos</option>
                            <?php
                            $query = "SELECT DISTINCT grupo FROM sistema.asignaturas ORDER BY grupo";
                            $result = pg_query($conexion, $query);
                            while ($row = pg_fetch_assoc($result)) {
                                echo "<option value='{$row['grupo']}'>Grupo {$row['grupo']}</option>";
                            }
                            ?>
                        </select>

                    </div>
                </div>


                <!-- Botón de actualización -->
                <div class="text-center mt-4">
                    <button onclick="cargarDatos()" type="button" class="btn btn-primary">🔄 Aplicar Filtros</button>
                    <button id="exportPDF" class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i> Exportar a PDF</button>
                </div>


                <h4 class="mt-4"><i class="fa-solid fa-chart-column"></i> Gráfico de Avance <i class="fa-solid fa-chart-column"></i></h4>

                <!-- Gráfica -->
                <div class="card mt-4">
                    <div class="card-body">
                        <canvas id="graficoDocentes" width="800" height="600"></canvas>
                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
            <script src="../assets/js/feather-icons/feather.min.js"></script>
            <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
            <script src="../assets/js/main.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


            <script>
                let chart;

                function cargarDatos() {

                    let periodos = document.getElementById('selectPeriodo').value;
                    let codigo_programa = document.getElementById('selectPrograma').value;
                    let codigo_asignatura = document.getElementById('selectAsignatura').value;
                    let semestre = document.getElementById('selectSemestre').value;
                    let grupo = document.getElementById('selectGrupo').value;

                    let url = 'getdatos_consigna.php?periodo=' + periodos +
                        '&codigo_programa=' + codigo_programa +
                        '&codigo_asignatura=' + codigo_asignatura +
                        '&semestre=' + semestre + '&grupo=' + grupo;

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            let nombres = data.map(d => d.nombre_docente);
                            let avance = data.map(d => d.semanas_diligenciadas);
                            let etiquetas = data.map(d => d.nombre_asignatura); // Nueva línea

                            if (chart) {
                                chart.destroy();
                            }

                            const ctx = document.getElementById('graficoDocentes').getContext('2d');
                            chart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: nombres,
                                    datasets: [{
                                        label: 'Semanas Diligenciadas',
                                        data: avance,
                                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1,
                                        asignaturas: etiquetas
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        datalabels: {
                                            anchor: 'end',
                                            align: 'start',
                                            offset: -4,
                                            font: {
                                                size: 8
                                            },
                                            color: '#000',
                                            formatter: function(value, context) {
                                                return context.dataset.asignaturas[context.dataIndex];
                                            }
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    const index = context.dataIndex;
                                                    const asignatura = context.dataset.asignaturas[index];
                                                    return 'Semanas: ' + context.formattedValue + ' | ' + asignatura;
                                                }
                                            }
                                        },
                                        legend: {
                                            display: false
                                        }
                                    },
                                    scales: {
                                        x: {
                                            ticks: {
                                                maxRotation: 45,
                                                minRotation: 45
                                            }
                                        },
                                        y: {
                                            beginAtZero: true,
                                            min: 1,
                                            max: 18,
                                            ticks: {
                                                stepSize: 1,
                                                callback: function(value) {
                                                    return 'Semanas: ' + value;
                                                }
                                            }
                                        }
                                    }
                                },
                                plugins: [ChartDataLabels] // ACTIVA el plugin

                            });


                        })
                        .catch(error => console.error('Error cargando los datos:', error));
                }

                cargarDatos();
            </script>

            <script>
                $(document).ready(function() {

                    $("#exportPDF").click(function() {
                        let canvas = document.getElementById("graficoDocentes");
                        let imageData = canvas.toDataURL("image/png"); // Convierte el gráfico a una imagen Base64


                        let periodos = document.getElementById('selectPeriodo').value;
                        let codigo_programa = document.getElementById('selectPrograma').value;
                        let codigo_asignatura = document.getElementById('selectAsignatura').value;
                        let semestre = document.getElementById('selectSemestre').value;
                        let grupo = document.getElementById('selectGrupo').value;


                        $.ajax({
                            url: "guardar_grafico_consigna1.php",
                            type: "POST",
                            data: {
                                image: imageData
                            },
                            success: function(response) {
                                if (response == "success") {
                                    window.open("export_pdf_consigna_g1.php?periodo=" + periodos +
                                        '&codigo_programa=' + codigo_programa +
                                        '&codigo_asignatura=' + codigo_asignatura +
                                        '&semestre=' + semestre + '&grupo=' + grupo, "_blank"); // Redirige a exportar_pdf.php; // Ejecuta la exportación a PDF después de guardar el gráfico

                                } else {
                                    alert("Error al guardar el gráfico");
                                }
                            }
                        });

                    });
                });
            </script>
            <script type="text/javascript">
                function cerrarsession() {
                    window.sessionStorage.removeItem("mostrarModal");
                }
            </script>


</body>

</html>