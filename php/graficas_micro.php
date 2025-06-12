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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        <?php require('stylepanel.html'); ?>
    </style>
    <style>
        .chart-container {
            width: 100%;
            overflow-x: auto;
        }
    </style>
</head>

<body class="bg-light">

    <?php include("sidebar.html");
    //Define esto antes de incluir el topbar -->
    $iconColor = 'text-info';
    $iconClass = 'bi-bar-chart-fill';
    $pageTitle = "Gestión de Graficos/Estadísticas"; // Cambia esto según la lógica de tu aplicación style="font-size:0.8em"
    include("topbar.html"); ?>
    <!-- <div class="container mt-5 pt-3" style="margin-left: var(--sidebar-width); max-width:87%;"> -->
    <main id="content">
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
        <footer>
            <p>© 2024 UniCorsalud. Todos los derechos reservados.</p>
        </footer>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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