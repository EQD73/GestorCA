<?php
// Incluir FPDF y conexión
require "../fpdf/fpdf.php"; 
require('conexion.php');

// Si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $facultad = $_POST['facultad'] ?? 'todos';
    $programa = $_POST['programa'] ?? 'todos';
    $docente = $_POST['docente'] ?? 'todos';
    $asignatura = $_POST['asignatura'] ?? 'todos';
    $semestre = $_POST['semestre'] ?? 'todos';

    // Construcción de la consulta
    $query = "SELECT 
                m1.nombre_asignatura, 
                m1.nombre_docente, 
                m1.nombre_programa, 
                m1.semestre, 
                m1.nombre_facultad 
              FROM sistema.m1 AS m1 
              WHERE 1=1";

    if ($facultad !== 'todos') $query .= " AND m1.codigo_facultad = '$facultad'";
    if ($programa !== 'todos') $query .= " AND m1.codigo_programa = '$programa'";
    if ($docente !== 'todos') $query .= " AND m1.codigo_docente = '$docente'";
    if ($asignatura !== 'todos') $query .= " AND m1.codigo_asignaturacurso = '$asignatura'";
    if ($semestre !== 'todos') $query .= " AND m1.semestre = $semestre";

    $query .= " ORDER BY m1.nombre_asignatura";

    $result = pg_query($conexion, $query);

    // Validar si hay resultados
    if (pg_num_rows($result) > 0) {
        // Generar el reporte con FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Cursos', 0, 1, 'C');
        $pdf->Ln(10);

        // Encabezados de la tabla
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(60, 10, 'Asignatura', 1);
        $pdf->Cell(40, 10, 'Docente', 1);
        $pdf->Cell(50, 10, 'Programa', 1);
        $pdf->Cell(20, 10, 'Semestre', 1);
        $pdf->Cell(40, 10, 'Facultad', 1);
        $pdf->Ln();

        // Cuerpo de la tabla
        $pdf->SetFont('Arial', '', 10);
        while ($row = pg_fetch_assoc($result)) {
            $pdf->Cell(60, 10, $row['nombre_asignatura'], 1);
            $pdf->Cell(40, 10, $row['codigo_docente'], 1);
            $pdf->Cell(50, 10, $row['nombre_programa'], 1);
            $pdf->Cell(20, 10, $row['semestre'], 1);
            $pdf->Cell(40, 10, $row['nombre_facultad'], 1);
            $pdf->Ln();
        }

        $pdf->Output();
        exit;
    } else {
        echo "<div class='alert alert-warning text-center'>No se encontraron resultados para los filtros seleccionados.</div>";
    }
}

// Función para obtener opciones dinámicas
function getOptions($conexion, $campo, $tabla) {
    $query = "SELECT DISTINCT $campo FROM $tabla ORDER BY $campo";
    $result = pg_query($conexion, $query);
    $options = [];
    while ($row = pg_fetch_assoc($result)) {
        $options[] = $row[$campo];
    }
    return $options;
}

// Obtener opciones de las tablas relacionadas
$facultades = getOptions($conexion, 'codigo_facultad', 'sistema.facultades');
$programas = getOptions($conexion, 'codigo_programa', 'sistema.programas');
$docentes = getOptions($conexion, 'codigo_usuario', 'sistema.usuarios');
$asignaturas = getOptions($conexion, 'codigo_asignatura', 'sistema.asignaturas');
$semestres = getOptions($conexion, 'semestre', 'sistema.m1');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Generar Reporte de Cursos</h1>
        <form method="POST" action="" class="row g-3">
            <div class="col-md-6">
                <label for="facultad" class="form-label">Facultad:</label>
                <select name="facultad" id="facultad" class="form-select">
                    <option value="todos">Todos</option>
                    <?php foreach ($facultades as $facultad): ?>
                        <option value="<?= $facultad ?>"><?= $facultad ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="programa" class="form-label">Programa:</label>
                <select name="programa" id="programa" class="form-select">
                    <option value="todos">Todos</option>
                    <?php foreach ($programas as $programa): ?>
                        <option value="<?= $programa ?>"><?= $programa ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="docente" class="form-label">Docente:</label>
                <select name="docente" id="docente" class="form-select">
                    <option value="todos">Todos</option>
                    <?php foreach ($docentes as $docente): ?>
                        <option value="<?= $docente ?>"><?= $docente ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="asignatura" class="form-label">Asignatura:</label>
                <select name="asignatura" id="asignatura" class="form-select">
                    <option value="todos">Todos</option>
                    <?php foreach ($asignaturas as $asignatura): ?>
                        <option value="<?= $asignatura ?>"><?= $asignatura ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="semestre" class="form-label">Semestre:</label>
                <select name="semestre" id="semestre" class="form-select">
                    <option value="todos">Todos</option>
                    <?php foreach ($semestres as $semestre): ?>
                        <option value="<?= $semestre ?>"><?= $semestre ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Generar Reporte</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
