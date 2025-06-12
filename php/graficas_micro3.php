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

$query_periodo = "SELECT codigo_periodo, nombre_periodo, estado, descripcion FROM sistema.periodos WHERE estado='ACTIVO'";
$resultado_qp = pg_query($conexion, $query_periodo);

$query_roles = "SELECT * FROM sistema.roles WHERE codigo_rol='$codigo_rol'";
$resultado_qr = pg_query($conexion, $query_roles);
$objroles = pg_fetch_object($resultado_qr);
$nombre_rol = $objroles->nombre_rol;
$_SESSION['nombre_rol'] = $nombre_rol;
include 'conexion6.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Contenidos Académicos - UniCorsalud</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        <?php require('stylepanel.html'); ?>
    </style>
</head>

<body>

    <?php include("sidebar.html");
    //Define esto antes de incluir el topbar -->
    $iconColor = 'text-info';
    $iconClass = 'bi-bar-chart-fill';
    $pageTitle = "Gestión de Graficos/Estadísticas"; // Cambia esto según la lógica de tu aplicación style="font-size:0.8em"
    include("topbar.html"); ?>
    <!-- <div class="container mt-5 pt-3" style="margin-left: var(--sidebar-width); max-width:87%;"> -->
    <main id="content">
        <h2 class="text-center mb-4 fw-bold">Microcurriculo</h2>
        <h2 class="text-center">📊 Gráfico/Estadística de Avance por Docente</h2>

        <div class="d-flex justify-content-end gap-2">
            <button id="exportExcel" class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Exportar a Excel</button>
            <button id="exportPDF" class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i> Exportar a PDF</button>
        </div>

        <form id="filtro-form" method='POST' class="row g-3">
            <div class="col-md-4">

                <label for="docente" class="form-label">Seleccionar Docente:</label>
                <select id="docente" name="docente" class="form-select">
                    <option value="">Seleccione...</option>
                    <?php
                    $stmt = $conn->query("SELECT DISTINCT codigo_docente, nombre_docente FROM sistema.m1 WHERE codigo_docente IS NOT NULL AND TRIM(codigo_docente) != '' AND codigo_docente != '0' ORDER BY nombre_docente");

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['codigo_docente']}'>{$row['codigo_docente']} | {$row['nombre_docente']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="ano_micro" class="form-label">Seleccionar Año:</label>
                <select id="ano_micro" name="ano_micro" class="form-select">
                    <option value="">Seleccione...</option>
                    <?php
                    $stmt = $conn->query("SELECT DISTINCT ano_micro FROM sistema.m1 WHERE ano_micro ~ '^\d{4}$' AND ano_micro::int >= 2024 ORDER BY ano_micro DESC");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['ano_micro']}'>{$row['ano_micro']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="button" id="filtrar-btn" class="btn btn-primary"><i class="fa-solid fa-filter"></i> Filtrar</button>
            </div>
        </form>
        <hr>

        <h4 class="mt-4">Asignaturas del Docente</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Asignatura</th>
                    <th>Semestre</th>
                    <th>Grupo</th>
                    <th>Programa</th>
                    <th>Avance (%)</th>
                    <th>Última Actualización</th>
                </tr>
            </thead>
            <tbody id="tabla-datos">
                <tr>
                    <td colspan="7" class="text-center">Seleccione un docente y año para ver los datos</td>
                </tr>
            </tbody>
        </table>

        <h4 class="mt-4"><i class="fa-solid fa-chart-column"></i> Gráfico de Avance <i class="fa-solid fa-chart-column"></i></h4>

        <!-- <canvas id="graficoAvance"></canvas> -->
        <div style="width: 100%; max-width: 800px; margin: 0 auto;">
            <canvas id="graficoAvance" height="600"></canvas>
        </div>
        <footer>
            <p>© 2024 UniCorsalud. Todos los derechos reservados.</p>
        </footer>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




    <script>
        let chartAvance = null; // Variable global para almacenar el gráfico

        $(document).ready(function() {
            $("#filtrar-btn").click(function() {
                let docente = $("#docente").val();
                let ano_micro = $("#ano_micro").val();

                if (!docente || !ano_micro) {
                    alert("Seleccione un docente y un año");
                    return;
                }

                $.ajax({
                    url: "get_datos_g3.php",
                    type: "POST",
                    data: {
                        docente,
                        ano_micro
                    },
                    dataType: "json",
                    success: function(response) {
                        let tablaHtml = "";
                        let labels = [];
                        let data = [];

                        response.forEach(item => {
                            tablaHtml += `<tr>
                                <td>${item.codigo_asignaturacurso}</td>
                                <td>${item.nom_asignatura}</td>
                                <td>${item.semestre}</td>
                                <td>${item.grupo}</td>
                                <td>${item.nombre_programa}</td>
                                <td>${item.avance}%</td>
                                <td>${item.fecha_actualizacion}</td>
                            </tr>`;

                            labels.push(item.nom_asignatura);
                            data.push(item.avance);
                        });

                        $("#tabla-datos").html(tablaHtml);

                        // Limpiar gráfico si ya existe
                        if (chartAvance) {
                            chartAvance.destroy();
                        }

                        let ctx = document.getElementById("graficoAvance").getContext("2d");
                        chartAvance = new Chart(ctx, {
                            type: "bar",
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: "Avance (%)",
                                    data: data,
                                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1,
                                    barThickness: 35 // Controla el ancho de las barras
                                }]
                            },
                            options: {
                                responsive: true, // Hace que el gráfico sea responsive
                                maintainAspectRatio: false, // Permite controlar la altura/ancho libremente
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        max: 100,
                                        title: {
                                            display: true,
                                            text: 'Porcentaje (%)'
                                        }
                                    },
                                    x: {
                                        ticks: {
                                            autoSkip: true,
                                            maxRotation: 45,
                                            minRotation: 30
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        position: 'top', // Posición de la leyenda
                                        labels: {
                                            boxWidth: 12
                                        }
                                    }
                                },
                                // Tamaño del gráfico (se aplica cuando responsive es true)
                                layout: {
                                    padding: {
                                        top: 20,
                                        right: 20,
                                        bottom: 20,
                                        left: 20
                                    }
                                }
                            }
                        });
                    }
                });
            });
        });

        //exportacion

        $(document).ready(function() {
            $("#exportExcel").click(function() {
                let docente = $("#docente").val();
                let ano_micro = $("#ano_micro").val();
                window.location.href = "export_excel_micro_g3.php?docente=" + docente + "&ano_micro=" + ano_micro; // Redirige a exportar_excel.php
            });

            $("#exportPDF").click(function() {
                let canvas = document.getElementById("graficoAvance");
                let imageData = canvas.toDataURL("image/png"); // Convierte el gráfico a una imagen Base64

                let docente = $("#docente").val();
                let ano_micro = $("#ano_micro").val();

                if (!docente || !ano_micro) {
                    alert("Seleccione un docente y un año antes de exportar a PDF");
                    return;
                }

                $.ajax({
                    url: "guardar_grafico_micro3.php",
                    type: "POST",
                    data: {
                        image: imageData
                    },
                    success: function(response) {
                        if (response == "success") {
                            window.open("export_pdf_micro_g3.php?docente=" + docente + "&ano_micro=" + ano_micro, "_blank"); // Redirige a exportar_pdf.php; // Ejecuta la exportación a PDF después de guardar el gráfico

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
            // const content = document.getElementById('content');
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