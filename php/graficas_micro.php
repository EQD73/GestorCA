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
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<style>
    .chart-container {
        width: 100%;
        overflow-x: auto;
    }
</style>

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
                <h2 class="text-center mb-4 fw-bold">Microcurriculo</h2>
                <h2 class="text-center mb-4">📊 Gráfico/Estadística Diligenciamiento por Programa</h2>

                <!-- Filtros -->
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="selectAno" class="form-label">Año:</label>
                        <select id="selectAno" class="form-select">
                            <option value="">Todos</option>
                            <?php
                            for ($i = date("Y"); $i >= 2024; $i--) {
                                echo "<option value='$i'>$i</option>";
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
                            $query = "SELECT codigo_programa, nombre_programa FROM programas ORDER BY codigo_programa";
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


                    <div class="col-md-3">
                        <label for="selectSemestre" class="form-label">Semestre:</label>
                        <select id="selectSemestre" class="form-select">
                            <option value="">Todos</option>
                            <?php
                            $query = "SELECT DISTINCT semestre FROM sistema.pensum ORDER BY semestre";
                            $result = pg_query($conexion, $query);
                            while ($row = pg_fetch_assoc($result)) {
                                echo "<option value='{$row['semestre']}'>Semestre {$row['semestre']}</option>";
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

                <!-- Opciones de Exportación -->
                <div class="text-center mt-3">
                    <!--  <a href="exportar_excel_mg1.php" class="btn btn-success">📊 Exportar a Excel</a> -->
                    <!--  <a href="exportar_pdf_mg1.php" class="btn btn-danger">📄 Exportar a PDF</a> -->
                </div>

                <h4 class="mt-4"><i class="fa-solid fa-chart-column"></i> Gráfico de Avance <i class="fa-solid fa-chart-column"></i></h4>


                <div class="chart-wrapper" style="width: 100%; overflow-x: auto; background: #f8f9fa; border-radius: 8px; padding: 15px; position: relative;">
                    <div class="chart-container" style="position: relative; height: 550px;">
                        <canvas id="graficoDocentes"></canvas>
                    </div>
                    <div class="chart-legend" style="text-align: center; margin-top: 10px;">
                        <span style="display: inline-block; margin: 0 10px;">
                            <span style="display: inline-block; width: 15px; height: 15px; background-color: rgba(54, 162, 235, 0.7); margin-right: 5px;"></span>
                            Con unidades
                        </span>
                        <span style="display: inline-block; margin: 0 10px;">
                            <span style="display: inline-block; width: 15px; height: 15px; background-color: rgba(255, 99, 132, 0.7); margin-right: 5px;"></span>
                            Sin unidades (0)
                        </span>
                    </div>
                    <div class="text-muted text-center mt-2" style="font-size: 12px;">
                        <i class="fas fa-arrows-alt-h"></i> Desplázate horizontalmente para ver todos los docentes
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
                //let chart;

                function cargarDatos() {
                    const ano_micro = document.getElementById('selectAno').value;
                    const codigo_programa = document.getElementById('selectPrograma').value;
                    const codigo_asignaturacurso = document.getElementById('selectAsignatura').value;
                    const semestre = document.getElementById('selectSemestre').value;

                    fetch(`getdatos_micro.php?ano_micro=${ano_micro}&codigo_programa=${codigo_programa}&codigo_asignaturacurso=${codigo_asignaturacurso}&semestre=${semestre}`)
                        .then(response => response.json())
                        .then(datos => {
                            const canvas = document.getElementById('graficoDocentes');
                            const ctx = canvas.getContext('2d');

                            if (window.myChart) {
                                window.myChart.destroy();
                            }

                            const dataLength = datos.length;
                            let fontSize = 10;
                            let maxRotation = 90;
                            let minRotation = 45;
                            let autoSkip = false;
                            let barThickness = 30;

                            if (dataLength > 100) {
                                fontSize = 8;
                                maxRotation = 90;
                                minRotation = 45;
                                autoSkip = true;
                                barThickness = 20;
                            } else if (dataLength > 50) {
                                fontSize = 9;
                                maxRotation = 90;
                                minRotation = 60;
                                autoSkip = false;
                            }

                            const config = {
                                type: 'bar',
                                data: {
                                    labels: datos.map(d => d.nombre_docente),
                                    datasets: [{
                                        label: 'Unidades diligenciadas',
                                        data: datos.map(d => Math.max(d.unidades_diligenciadas, 0.1)),
                                        backgroundColor: function(context) {
                                            return context.raw <= 0.1 ? 'rgba(255, 99, 132, 0.7)' : 'rgba(54, 162, 235, 0.7)';
                                        },
                                        borderColor: function(context) {
                                            return context.raw <= 0.1 ? 'rgba(255, 99, 132, 1)' : 'rgba(54, 162, 235, 1)';
                                        },
                                        borderWidth: 1,
                                        barThickness: barThickness,
                                        minBarLength: 5
                                    }]
                                },
                                options: {
                                    responsive: false,
                                    maintainAspectRatio: false,
                                    scales: {
                                        x: {
                                            ticks: {
                                                font: {
                                                    size: fontSize
                                                },
                                                maxRotation: maxRotation,
                                                minRotation: minRotation,
                                                autoSkip: autoSkip
                                            },
                                            grid: {
                                                display: false
                                            }
                                        },
                                        y: {
                                            ticks: {
                                                stepSize: 1,
                                                callback: function(value) {
                                                    if (value < 1) return '0';
                                                    return value;
                                                }
                                            },
                                            beginAtZero: true,
                                            suggestedMin: 0,
                                            suggestedMax: 5,
                                            title: {
                                                display: true,
                                                text: 'Unidades diligenciadas'
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        tooltip: {
                                            callbacks: {
                                                title: function(context) {
                                                    return context[0].label;
                                                },
                                                label: function(context) {
                                                    const dataIndex = context.dataIndex;
                                                    const asignatura = datos[dataIndex].nom_asignatura;
                                                    const unidades = datos[dataIndex].unidades_diligenciadas;
                                                    return [
                                                        `Asignatura: ${asignatura}`,
                                                        `Unidades: ${unidades}`
                                                    ];
                                                },
                                                backgroundColor: function(context) {
                                                    return datos[context.dataIndex].unidades_diligenciadas === 0 ?
                                                        'rgba(255, 99, 132, 0.9)' : 'rgba(54, 162, 235, 0.9)';
                                                }
                                            }
                                        },
                                        // NUEVO: Plugin para mostrar nombres de asignatura sobre las barras
                                        datalabels: {
                                            align: 'top',
                                            anchor: 'center',
                                            rotation: -90, // Rotación de 45 grados (negativo para inclinación hacia la derecha)
                                            color: '#333',
                                            font: {
                                                size: fontSize - 1 // Un poco más pequeño que las otras fuentes
                                            },
                                            formatter: function(value, context) {
                                                return datos[context.dataIndex].nom_asignatura;
                                            }
                                        }
                                    }
                                },
                                plugins: [ChartDataLabels] // Asegúrate de tener este plugin importado
                            };

                            const requiredWidth = Math.max(
                                canvas.parentElement.offsetWidth,
                                dataLength * (barThickness + 10)
                            );
                            canvas.width = requiredWidth;
                            canvas.height = 500;
                            canvas.style.width = requiredWidth + 'px';
                            canvas.style.height = '500px';

                            window.myChart = new Chart(ctx, config);
                            canvas.parentElement.scrollLeft = 0;
                        });
                }
            </script>

            <script>
                $(document).ready(function() {

                    $("#exportPDF").click(function() {
                        let canvas = document.getElementById("graficoDocentes");
                        let imageData = canvas.toDataURL("image/png"); // Convierte el gráfico a una imagen Base64


                        let ano_micro = document.getElementById('selectAno').value;
                        let codigo_programa = document.getElementById('selectPrograma').value;
                        let codigo_asignaturacurso = document.getElementById('selectAsignatura').value;
                        let semestre = document.getElementById('selectSemestre').value;


                        $.ajax({
                            url: "guardar_grafico_micro1.php",
                            type: "POST",
                            data: {
                                image: imageData
                            },
                            success: function(response) {
                                if (response == "success") {
                                    window.open("export_pdf_micro_g1.php?ano_micro=" + ano_micro +
                                        '&codigo_programa=' + codigo_programa +
                                        '&codigo_asignaturacurso=' + codigo_asignaturacurso +
                                        '&semestre=' + semestre, "_blank"); // Redirige a exportar_pdf.php; // Ejecuta la exportación a PDF después de guardar el gráfico

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
            ```

</body>

</html>