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
include 'conexion6.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graficos Reporte de Avance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <link rel="shortcut icon" href="../images/faviconV2.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

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
                        <label for="periodo" class="form-label">Seleccionar Periodo:</label>
                        <select id="periodo" name="periodo" class="form-select">
                            <option value="">Seleccione...</option>
                            <?php
                            $stmt = $conn->query("SELECT DISTINCT codigo_periodo, nombre_periodo, descripcion FROM sistema.periodos WHERE estado= 'ACTIVO' ORDER BY codigo_periodo DESC");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['codigo_periodo']}'>{$row['descripcion']} | {$row['nombre_periodo']}</option>";
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
                            <th>Fecha Consignación</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-datos">
                        <tr>
                            <td colspan="7" class="text-center">Seleccione un docente y periodo para ver los datos</td>
                        </tr>
                    </tbody>
                </table>

                <h4 class="mt-4"><i class="fa-solid fa-chart-column"></i> Gráfico de Avance <i class="fa-solid fa-chart-column"></i></h4>

                <canvas id="graficoAvance"></canvas>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
            <script src="../assets/js/feather-icons/feather.min.js"></script>
            <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
            <script src="../assets/js/main.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

            <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
            <script>
                let chartAvance = null; // Variable global para almacenar el gráfico

                $(document).ready(function() {
                    $("#filtrar-btn").click(function() {
                        let docente = $("#docente").val();
                        let periodo = $("#periodo").val();

                        if (!docente || !periodo) {
                            alert("Seleccione un docente y un periodo");
                            return;
                        }

                        $.ajax({
                            url: "get_datosc_g2.php",
                            type: "POST",
                            data: {
                                docente,
                                periodo
                            },
                            dataType: "json",
                            success: function(response) {
                                let tablaHtml = "";
                                let labels = [];
                                let data = [];
                                let semanas = []; // Define la variable semanas aquí

                                response.forEach(item => {
                                    tablaHtml += `<tr>
                                <td>${item.codigo_asignatura}</td>
                                <td>${item.nombre_asignatura}</td>
                                <td>${item.semestre}</td>
                                <td>${item.grupo}</td>
                                <td>${item.nombre_programa}</td>
                                <td>${item.avance}%</td>
                                <td>${item.fecha_consigna}</td>
                            </tr>`;

                                    labels.push(item.nombre_asignatura);
                                    data.push(item.avance);
                                    semanas.push(item.total_semanas); // Agregar el total de semanas al array
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
                                            backgroundColor: "rgba(75, 192, 192, 0.6)",
                                            borderColor: "rgba(75, 192, 192, 1)",
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                max: 100
                                            }
                                        },
                                        plugins: {
                                            tooltip: {
                                                callbacks: {
                                                    // Modificar el tooltip para incluir el total de semanas
                                                    afterLabel: function(tooltipItem) {
                                                        // Obtén el índice de la etiqueta actual en el gráfico
                                                        var index = tooltipItem.dataIndex;
                                                        // Retorna el texto del tooltip
                                                        return `Total de semanas: ${semanas[index]}`;
                                                    }
                                                }
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
                        let periodo = $("#periodo").val();
                        window.location.href = "export_excel_consigna_g2.php?docente=" + docente + "&periodo=" + periodo; // Redirige a exportar_excel.php
                    });

                    $("#exportPDF").click(function() {
                        let canvas = document.getElementById("graficoAvance");
                        let imageData = canvas.toDataURL("image/png"); // Convierte el gráfico a una imagen Base64

                        let docente = $("#docente").val();
                        let periodo = $("#periodo").val();

                        if (!docente || !periodo) {
                            alert("Seleccione un docente y un año antes de exportar a PDF");
                            return;
                        }

                        $.ajax({
                            url: "guardar_grafico_consigna2.php",
                            type: "POST",
                            data: {
                                image: imageData
                            },
                            success: function(response) {
                                if (response == "success") {
                                    window.open("export_pdf_consigna_g2.php?docente=" + docente + "&periodo=" + periodo, "_blank"); // Redirige a exportar_pdf.php; // Ejecuta la exportación a PDF después de guardar el gráfico

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