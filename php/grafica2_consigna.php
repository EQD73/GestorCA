<?php include 'conexion2.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gráfico de Diligenciamiento Semanal</title>

    <!-- jQuery (requerido por Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        .select2-container .select2-selection--single {
            height: 38px !important;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Gráfico de Diligenciamiento Semanal de Contenidos</h5>
            </div>
            <div class="card-body">

                <!-- FORMULARIO -->
                <form id="filtrosForm" class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">Periodo</label>
                        <select class="form-select select2" name="periodo" required>
                            <option value="">Seleccione un periodo</option>
                            <?php
                            $stmt = $pdo->query("SELECT DISTINCT codigo_periodo, nombre_periodo FROM sistema.periodos ORDER BY codigo_periodo DESC");
                            foreach ($stmt as $row) {
                                echo "<option value='{$row['codigo_periodo']}'>{$row['codigo_periodo']} - {$row['nombre_periodo']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Programa</label>
                        <select class="form-select select2" id="programa" name="programa" required>
                            <option value="">Seleccione un programa</option>
                            <?php
                            $stmt = $pdo->query("SELECT codigo_programa, nombre_programa FROM sistema.programas ORDER BY codigo_programa");
                            foreach ($stmt as $row) {
                                echo "<option value='{$row['codigo_programa']}'>{$row['codigo_programa']} - {$row['nombre_programa']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- <div class="col-md-3">
                        <label class="form-label">Asignatura</label>
                        <select class="form-select select2" name="asignatura">
                            <option value="">Seleccione una asignatura</option>
                            <?php
                            //$stmt = $pdo->query("SELECT DISTINCT codigo_asignatura, nom_asignatura FROM sistema.pensum ORDER BY codigo_asignatura");
                            //foreach ($stmt as $row) {
                            //echo "<option value='{$row['codigo_asignatura']}'>{$row['codigo_asignatura']} - {$row['nom_asignatura']}</option>";
                            //}
                            ?> 
                        </select>
                    </div> -->

                    <div class="col-md-3">
                        <label for="asignatura" class="form-label">Asignatura</label>
                        <select class="form-control select2" id="asignatura" name="asignatura">
                            <option value="">Seleccione una asignatura</option>
                        </select>
                    </div>


                    <div class="col-md-2">
                        <label class="form-label">Semestre</label>
                        <select class="form-select select2" name="semestre">
                            <option value="">Seleccione un semestre</option>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>">Semestre <?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Grupo</label>
                        <input type="text" class="form-control" name="grupo">
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success">Generar Gráfico</button>
                    </div>
                </form>

                <hr>

                <!-- GRÁFICO -->
                <div class="mt-4">
                    <canvas id="graficoSemanal" height="100"></canvas>
                </div>

            </div>
        </div>
    </div>

    <!-- JS: Bootstrap, Select2, Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Inicializar Select2
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });

            $('#programa').on('change', function() {
                const codigo_programa = $(this).val();

                $('#asignatura').empty().append('<option value="">Cargando...</option>');

                $.ajax({
                    url: 'get_asignaturas_g2c.php',
                    method: 'POST',
                    data: {
                        codigo_programa
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#asignatura').empty().append('<option value="">Seleccione una asignatura</option>');

                        data.forEach(asignatura => {
                            $('#asignatura').append(
                                $('<option>', {
                                    value: asignatura.codigo_asignatura,
                                    text: asignatura.codigo_asignatura + " - " + asignatura.nom_asignatura
                                })
                            );
                        });

                        $('#asignatura').trigger('change'); // actualizar select2
                    }
                });
            });

        });


        // Envío del formulario y generación del gráfico
        document.getElementById('filtrosForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            fetch('backend_g2c.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    const labels = data.map(item => item.docente); // eje X: nombres de docentes
                    const datos = data.map(item => item.total_semanas_diligenciadas); // eje Y: semanas diligenciadas
                    const etiquetas = data.map(item => item.asignatura); // etiqueta: nombre de asignatura

                    const ctx = document.getElementById('graficoSemanal').getContext('2d');

                    if (window.miGrafico) window.miGrafico.destroy();

                    window.miGrafico = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Contenidos diligenciados',
                                data: datos,
                                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const index = context.dataIndex;
                                            return 'Asignatura: ' + etiquetas[index] + ' - ' + context.raw + ' semanas';
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                });

        });
    </script>
</body>

</html>