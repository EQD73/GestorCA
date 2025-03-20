<?php
include 'conexion.php';

// Obtener filtros seleccionados
$ano_micro = isset($_GET['ano_micro']) ? $_GET['ano_micro'] : '';
$codigo_docente = isset($_GET['codigo_docente']) ? $_GET['codigo_docente'] : '';

// Consultar años disponibles
$query_anos = "SELECT DISTINCT ano_micro FROM sistema.m1 ORDER BY ano_micro DESC";
$result_anos = pg_query($conexion, $query_anos);

// Consultar docentes disponibles
$query_docentes = "SELECT DISTINCT codigo_docente, nombre_docente FROM sistema.m1 ORDER BY nombre_docente";
$result_docentes = pg_query($conexion, $query_docentes);

// Construir consulta principal
$query = "SELECT nombre_asignatura, 
                 ((u1_hp + u2_hp + u3_hp + u4_hp + u5_hp) * 100 / tht) AS porcentaje_avance, 
                 fecha_actualizacion
          FROM sistema.m1 
          WHERE 1=1";

// Aplicar filtros si están seleccionados
if (!empty($ano_micro)) {
    $query .= " AND ano_micro = '$ano_micro'";
}
if (!empty($codigo_docente)) {
    $query .= " AND codigo_docente = '$codigo_docente'";
}

$query .= " ORDER BY fecha_actualizacion DESC";

$result = pg_query($conexion, $query);

$asignaturas = [];
$avances = [];
$fechas = [];

while ($row = pg_fetch_assoc($result)) {
    $asignaturas[] = $row['nombre_asignatura'];
    $avances[] = round($row['porcentaje_avance'], 2);
    $fechas[] = $row['fecha_actualizacion'];
}

// Convertir a JSON para usar en JavaScript
$asignaturas_json = json_encode($asignaturas);
$avances_json = json_encode($avances);
$fechas_json = json_encode($fechas);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Avance</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container mt-4">

    <h3>Reporte de Avance por Asignaturas</h3>

    <form method="GET" class="row mb-4">
        <div class="col-md-3">
            <label for="selectAno" class="form-label">Año:</label>
            <select id="selectAno" name="ano_micro" class="form-select">
                <option value="">Todos</option>
                <?php while ($row = pg_fetch_assoc($result_anos)) {
                    $selected = ($row['ano_micro'] == $ano_micro) ? "selected" : "";
                    echo "<option value='{$row['ano_micro']}' $selected>{$row['ano_micro']}</option>";
                } ?>
            </select>
        </div>

        <div class="col-md-3">
            <label for="selectDocente" class="form-label">Docente:</label>
            <select id="selectDocente" name="codigo_docente" class="form-select">
                <option value="">Todos</option>
                <?php while ($row = pg_fetch_assoc($result_docentes)) {
                    $selected = ($row['codigo_docente'] == $codigo_docente) ? "selected" : "";
                    echo "<option value='{$row['codigo_docente']}' $selected>{$row['nombre_docente']}</option>";
                } ?>
            </select>
        </div>

        <div class="col-md-3">
            <label for="selectTipoGrafico" class="form-label">Tipo de Gráfica:</label>
            <select id="selectTipoGrafico" class="form-select">
                <option value="bar">Barras</option>
                <option value="line">Líneas</option>
                <option value="pie">Pastel</option>
                <option value="doughnut">Dona</option>
            </select>
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <canvas id="graficoAvance" class="mt-4"></canvas>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Asignatura</th>
                <th>Porcentaje de Avance</th>
                <th>Última Actualización</th>
            </tr>
        </thead>
        <tbody>
            <?php
            pg_result_seek($result, 0);
            while ($row = pg_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['nombre_asignatura']}</td>
                        <td>" . round($row['porcentaje_avance'], 2) . "%</td>
                        <td>{$row['fecha_actualizacion']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>

    <button class="btn btn-success" onclick="exportarExcel()">Exportar a Excel</button>
    <button class="btn btn-danger" onclick="exportarPDF()">Exportar a PDF</button>

    <script>
        let asignaturas = <?php echo $asignaturas_json; ?>;
        let avances = <?php echo $avances_json; ?>;
        let fechas = <?php echo $fechas_json; ?>;
        let tipoGrafico = document.getElementById('selectTipoGrafico').value;

        let ctx = document.getElementById('graficoAvance').getContext('2d');
        let graficoAvance = new Chart(ctx, {
            type: tipoGrafico,
            data: {
                labels: asignaturas,
                datasets: [{
                    label: 'Porcentaje de Avance (%)',
                    data: avances,
                    backgroundColor: '#36A2EB',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            afterLabel: function(tooltipItem) {
                                return 'Última actualización: ' + fechas[tooltipItem.dataIndex];
                            }
                        }
                    }
                }
            }
        });

        document.getElementById('selectTipoGrafico').addEventListener('change', function() {
            graficoAvance.destroy();
            graficoAvance = new Chart(ctx, {
                type: this.value,
                data: graficoAvance.data,
                options: graficoAvance.options
            });
        });

        function exportarExcel() {
            let tabla = document.querySelector("table");
            let wb = XLSX.utils.table_to_book(tabla, {
                sheet: "Reporte"
            });
            XLSX.writeFile(wb, "reporte_avance.xlsx");
        }

        function exportarPDF() {
            const {
                jsPDF
            } = window.jspdf;
            let doc = new jsPDF();
            doc.text("Reporte de Avance", 10, 10);
            doc.autoTable({
                html: "table"
            });
            doc.save("reporte_avance.pdf");
        }
    </script>

</body>

</html>