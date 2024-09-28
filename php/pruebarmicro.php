<?php
include("conexion.php"); // Asegúrate de que está bien configurado

// Función para obtener opciones
function getOptions($conexion, $valueColumn, $valueColumn2, $labelColumn, $table)
{
    $query = "SELECT DISTINCT $valueColumn, $valueColumn2, $labelColumn FROM $table WHERE $valueColumn IS NOT NULL AND ($valueColumn::TEXT != '' AND $valueColumn::TEXT != '0') ORDER BY $labelColumn";
    //AND $valueColumn != '0'
    $result = pg_query($conexion, $query);
    $options = [];
    while ($row = pg_fetch_assoc($result)) {
        $options[] = $row;
    }
    return $options;
}

// Obtener opciones para los filtros
$periodos = getOptions($conexion, "ano_micro", "ano_micro", "ano_micro", "sistema.m1");
$programas = getOptions($conexion, "codigo_programa", "nombre_programa", "codigo_programa", "sistema.m1");
$docentes = getOptions($conexion, "codigo_docente",  "nombre_docente", "nombre_docente", "sistema.m1");
$semestres = getOptions($conexion, "semestre", "semestre", "semestre", "sistema.m1");
$grupos = getOptions($conexion, "grupo", "grupo", "grupo", "sistema.m1");
//nombre_docente

// Capturar valores del formulario
$periodo = $_GET['periodo'] ?? '';
$programa = $_GET['programa'] ?? '';
$asignatura = $_GET['asignatura'] ?? '';
$docente = $_GET['docente'] ?? '';
$semestre = $_GET['semestre'] ?? '';
$grupo = $_GET['grupo'] ?? '';

// Consulta dinámica
$sql = "SELECT * FROM sistema.m1 WHERE 1=1";
if (!empty($periodo)) $sql .= " AND ano_micro = '$periodo'";
if (!empty($programa)) $sql .= " AND codigo_programa = '$programa'";
if (!empty($asignatura)) $sql .= " AND codigo_asignaturacurso = '$asignatura'";
if (!empty($docente)) $sql .= " AND codigo_docente = '$docente'";
if (!empty($semestre)) $sql .= " AND semestre = $semestre";
if (!empty($grupo)) $sql .= " AND grupo = $grupo";
$sql .= " ORDER BY codigo_asignaturacurso ASC, grupo ASC";


$result = pg_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Asignaturas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Reporte de Asignaturas</h2>

        <!-- Formulario de Filtros -->
        <form method="GET" class="row g-3">
            <div class="col-md-2">
                <label class="form-label">Periodo</label>
                <select name="periodo" id="periodo" class="form-select">
                    <option value="">Todos</option>
                    <?php foreach ($periodos as $p): ?>
                        <option value="<?= $p['ano_micro'] ?>" <?= $p['ano_micro'] == $periodo ? 'selected' : '' ?>>
                            <?= $p['ano_micro'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Programa</label>
                <select name="programa" id="programa" class="form-select">
                    <option value="">Todos</option>
                    <?php foreach ($programas as $prog): ?>
                        <option value="<?= $prog['codigo_programa'] ?>" <?= $prog['codigo_programa'] == $programa ? 'selected' : '' ?>>
                            <?= $prog['codigo_programa'] . " - " . $prog['nombre_programa'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Asignatura</label>
                <select name="asignatura" id="asignatura" class="form-select">
                    <option value="">Todas</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Docente</label>
                <select name="docente" class="form-select">
                    <option value="">Todos</option>
                    <?php foreach ($docentes as $doc): ?>
                        <option value="<?= $doc['codigo_docente'] ?>" <?= $doc['codigo_docente'] == $docente ? 'selected' : '' ?>>
                            <?= $doc['codigo_docente'] . " - " . $doc['nombre_docente'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Semestre</label>
                <select name="semestre" class="form-select">
                    <option value="">Todos</option>
                    <?php foreach ($semestres as $s): ?>
                        <option value="<?= $s['semestre'] ?>" <?= $s['semestre'] == $semestre ? 'selected' : '' ?>>
                            <?= $s['semestre'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Grupo</label>
                <select name="grupo" class="form-select">
                    <option value="">Todos</option>
                    <?php foreach ($grupos as $g): ?>
                        <option value="<?= $g['grupo'] ?>" <?= $g['grupo'] == $grupo ? 'selected' : '' ?>>
                            <?= $g['grupo'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </form>

        <!-- Tabla de Resultados -->
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Código Asignatura</th>
                    <th>Nombre Asignatura</th>
                    <th>Año</th>
                    <th>Docente</th>
                    <th>Programa</th>
                    <th>Semestre</th>
                    <th>Grupo</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = pg_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['codigo_asignaturacurso']) ?></td>
                        <td><?= htmlspecialchars($row['nombre_asignatura']) ?></td>
                        <td><?= htmlspecialchars($row['ano_micro']) ?></td>
                        <td><?= htmlspecialchars($row['nombre_docente']) ?></td>
                        <td><?= htmlspecialchars($row['nombre_programa']) ?></td>
                        <td><?= htmlspecialchars($row['semestre']) ?></td>
                        <td><?= htmlspecialchars($row['grupo']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            function cargarAsignaturas() {
                var programa_id = $("#programa").val();
                var valor = $("#periodo").val();
                $.ajax({
                    url: "get_asignaturas_rmicro.php",
                    type: "POST",
                    data: {
                        programa: programa_id,
                        periodo: valor
                    },
                    success: function(data) {
                        $("#asignatura").html(data);
                    }
                });
            }
            $("#programa").change(cargarAsignaturas);
            $("#filterForm").submit(function() {
                setTimeout(cargarAsignaturas, 500);
            });

            // Cargar asignaturas al cargar la página si ya hay un programa seleccionado
            if ($("#programa").val()) {
                cargarAsignaturas();
            }
        });
    </script>
</body>

</html>