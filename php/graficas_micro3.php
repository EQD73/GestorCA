<?php include 'conexion6.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Avance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Reporte de Avance por Docente</h2>

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
                    $stmt = $conn->query("SELECT DISTINCT ano_micro FROM sistema.m1 ORDER BY ano_micro DESC");
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

        <h4 class="mt-4">Asignaturas Asignadas</h4>
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

        <h4 class="mt-4">Gráfico de Avance</h4>
        <canvas id="graficoAvance"></canvas>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                                <td>${item.nombre_asignatura}</td>
                                <td>${item.semestre}</td>
                                <td>${item.grupo}</td>
                                <td>${item.nombre_programa}</td>
                                <td>${item.avance}%</td>
                                <td>${item.fecha_actualizacion}</td>
                            </tr>`;

                            labels.push(item.nombre_asignatura);
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
                window.location.href = "export_excel_micro_g3.php"; // Redirige a exportar_excel.php
            });

            $("#exportPDF").click(function() {
                let canvas = document.getElementById("graficoAvance");
                let imageData = canvas.toDataURL("image/png"); // Convierte el gráfico a una imagen Base64

                $.ajax({
                    url: "guardar_grafico_micro3.php",
                    type: "POST",
                    data: {
                        image: imageData
                    },
                    success: function(response) {
                        if (response == "success") {
                            window.open("export_pdf_micro_g3.php", "_blank"); // Redirige a exportar_pdf.php; // Ejecuta la exportación a PDF después de guardar el gráfico

                        } else {
                            alert("Error al guardar el gráfico");
                        }
                    }
                });

            });
        });
    </script>
</body>

</html>