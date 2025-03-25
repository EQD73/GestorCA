<?php
include("conexion.php"); // Conexión a PostgreSQL

// Obtener valores únicos para los filtros con nombres en lugar de códigos
function getOptions($conexion, $valueColumn, $labelColumn, $table)
{
    $query = "SELECT DISTINCT $valueColumn, $labelColumn FROM $table WHERE $valueColumn IS NOT NULL ORDER BY $labelColumn";
    $result = pg_query($conexion, $query);
    $options = [];
    while ($row = pg_fetch_assoc($result)) {
        $options[] = $row;
    }
    return $options;
}

// Obtener opciones para los filtros
$periodos = getOptions($conexion, "ano_micro", "ano_micro", "sistema.m1");
$programas = getOptions($conexion, "codigo_programa", "nombre_programa", "sistema.m1");
$asignaturas = getOptions($conexion, "codigo_asignaturacurso", "nombre_asignatura", "sistema.m1");
$docentes = getOptions($conexion, "codigo_docente", "nombre_docente", "sistema.m1");
$semestres = getOptions($conexion, "semestre", "semestre", "sistema.m1");

// Capturar valores del formulario
$periodo = $_GET['periodo'] ?? '';
$programa = $_GET['programa'] ?? '';
$asignatura = $_GET['asignatura'] ?? '';
$docente = $_GET['docente'] ?? '';
$semestre = $_GET['semestre'] ?? '';

$sql = "SELECT * FROM sistema.m1 WHERE 1=1";
if (!empty($periodo)) $sql .= " AND ano_micro = '$periodo'";
if (!empty($programa)) $sql .= " AND codigo_programa = '$programa'";
if (!empty($asignatura)) $sql .= " AND codigo_asignaturacurso = '$asignatura'";
if (!empty($docente)) $sql .= " AND codigo_docente = '$docente'";
if (!empty($semestre)) $sql .= " AND semestre = $semestre";

$result = pg_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Asignaturas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Reporte de Asignaturas</h2>

        <!-- Formulario de Filtros -->
        <form method="GET" class="row g-3">
            <div class="col-md-2">
                <label class="form-label">Periodo</label>
                <select name="periodo" class="form-select">
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
                <select name="programa" class="form-select">
                    <option value="">Todos</option>
                    <?php foreach ($programas as $prog): ?>
                        <option value="<?= $prog['codigo_programa'] ?>" <?= $prog['codigo_programa'] == $programa ? 'selected' : '' ?>>
                            <?= $prog['nombre_programa'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Asignatura</label>
                <select name="asignatura" class="form-control">
                    <option value="">Todas</option>
                    <?php foreach ($asignaturas as $asig): ?>
                        <option value="<?= $asig['codigo_asignaturacurso'] ?>" <?= $asig['codigo_asignaturacurso'] == $asignatura ? 'selected' : '' ?>>
                            <?= $asig['nombre_asignatura'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Docente</label>
                <select name="docente" class="form-control">
                    <option value="">Todos</option>
                    <?php foreach ($docentes as $doc): ?>
                        <option value="<?= $doc['codigo_docente'] ?>" <?= $doc['codigo_docente'] == $docente ? 'selected' : '' ?>>
                            <?= $doc['nombre_docente'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Semestre</label>
                <select name="semestre" class="form-control">
                    <option value="">Todos</option>
                    <?php foreach ($semestres as $sem): ?>
                        <option value="<?= $sem['semestre'] ?>" <?= $sem['semestre'] == $semestre ? 'selected' : '' ?>>
                            <?= $sem['semestre'] ?>
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
                    <th>Grupo</th>
                    <th>Periodo</th>
                    <th>Docente</th>
                    <th>Facultad</th>
                    <th>Programa</th>
                    <th>Semestre</th>
                    <th>Créditos</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = pg_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['codigo_asignaturacurso']) ?></td>
                        <td><?= htmlspecialchars($row['nombre_asignatura']) ?></td>
                        <td><?= htmlspecialchars($row['grupo']) ?></td>
                        <td><?= htmlspecialchars($row['ano_micro']) ?></td>
                        <td><?= htmlspecialchars($row['nombre_docente']) ?></td>
                        <td><?= htmlspecialchars($row['nombre_facultad']) ?></td>
                        <td><?= htmlspecialchars($row['nombre_programa']) ?></td>
                        <td><?= htmlspecialchars($row['semestre']) ?></td>
                        <td><?= htmlspecialchars($row['creditos']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>