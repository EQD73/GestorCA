<?php
include 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Diligenciamiento</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <div class="container mt-4">
        <h2 class="text-center mb-4">📊 Reporte de Diligenciamiento por Docente</h2>

        <!-- Filtros -->
        <div class="row g-3">
            <div class="col-md-3">
                <label for="selectAno" class="form-label">Año:</label>
                <select id="selectAno" class="form-select">
                    <option value="">Todos</option>
                    <?php
                    for ($i = date("Y"); $i >= 2020; $i--) {
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
                    $query = "SELECT codigo_programa, nombre_programa FROM programas";
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
                    $query = "SELECT DISTINCT semestre FROM sistema.asignaturas ORDER BY semestre";
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
            <button onclick="cargarDatos()" class="btn btn-primary">🔄 Aplicar Filtros</button>
        </div>

        <!-- Opciones de Exportación -->
        <div class="text-center mt-3">
            <a href="exportar_excel.php" class="btn btn-success">📊 Exportar a Excel</a>
            <a href="exportar_pdf.php" class="btn btn-danger">📄 Exportar a PDF</a>
        </div>

        <!-- Gráfica -->
        <div class="card mt-4">
            <div class="card-body">
                <canvas id="graficoDocentes"></canvas>
            </div>
        </div>
    </div>

    <script>
        let chart;

        function cargarDatos() {
            let ano_micro = document.getElementById('selectAno').value;
            let codigo_programa = document.getElementById('selectPrograma').value;
            let codigo_asignaturacurso = document.getElementById('selectAsignatura').value;
            let semestre = document.getElementById('selectSemestre').value;

            let url = 'getdatos_micro.php?ano_micro=' + ano_micro +
                '&codigo_programa=' + codigo_programa +
                '&codigo_asignaturacurso=' + codigo_asignaturacurso +
                '&semestre=' + semestre;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    let nombres = data.map(d => d.nombre_docente);
                    let avance = data.map(d => d.unidades_diligenciadas);

                    if (chart) {
                        chart.destroy();
                    }

                    const ctx = document.getElementById('graficoDocentes').getContext('2d');
                    chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: nombres,
                            datasets: [{
                                label: 'Unidades Diligenciadas',
                                data: avance,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error cargando los datos:', error));
        }

        cargarDatos();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>