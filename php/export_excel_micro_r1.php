<?php
include 'conexion2.php';

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$ano             = $_GET['ano'] ?? '';
$programa        = $_GET['programa'] ?? '';
$nombre_programa = $_GET['nombrePrograma'] ?? 'Sin datos';
$asignatura      = $_GET['asignatura'] ?? '';
$semestre        = $_GET['semestre'] ?? '';


$params = [$ano]; // ano_micro van primero

$filters = "";
$join_extra = "";

if (!empty($programa)) {
    $join_extra .= " AND m1.codigo_programa = ?";
    $params[] = $programa;

    $filters .= " AND p.codigo_programa = ?";
    $params[] = $programa;
}

if (!empty($asignatura)) {
    $filters .= " AND p.codigo_asignatura = ?";
    $params[] = $asignatura;
}

if (!empty($semestre)) {
    $filters .= " AND p.semestre = ?";
    $params[] = $semestre;
}

$query = "
SELECT 
    p.codigo_asignatura AS codigo_asignaturacurso,
    p.nom_asignatura,
    COALESCE(CAST(m1.grupo AS TEXT), 'Sin datos') AS grupo,
    COALESCE(m1.codigo_programa, p.codigo_programa) AS codigo_programa,
    COALESCE(m1.semestre, p.semestre) AS semestre,
    COALESCE(m1.codigo_docente, 'Sin datos') AS codigo_docente,
    COALESCE(m1.nombre_docente, 'Sin datos') AS nombre_docente,
    COALESCE(TO_CHAR(m1.fecha_actualizacion, 'YYYY-MM-DD'), 'Sin datos') AS fecha_actualizacion,
    pr.nombre_programa, 
   
    ROUND(
        (
            (CASE WHEN LENGTH(TRIM(m1.u1_resultados)) > 1 THEN 1 ELSE 0 END) +
            (CASE WHEN LENGTH(TRIM(m1.u2_resultados)) > 1 THEN 1 ELSE 0 END) +
            (CASE WHEN LENGTH(TRIM(m1.u3_resultados)) > 1 THEN 1 ELSE 0 END) +
            (CASE WHEN LENGTH(TRIM(m1.u4_resultados)) > 1 THEN 1 ELSE 0 END) +
            (CASE WHEN LENGTH(TRIM(m1.u5_resultados)) > 1 THEN 1 ELSE 0 END)
        ) / 3.0 * 100, 2
    ) AS avance

FROM sistema.pensum p
LEFT JOIN sistema.m1 m1 ON m1.codigo_asignaturacurso = p.codigo_asignatura AND m1.ano_micro = ?
$join_extra
LEFT JOIN sistema.programas pr ON pr.codigo_programa = COALESCE(m1.codigo_programa, p.codigo_programa)
WHERE 1=1
$filters
ORDER BY p.codigo_programa, p.codigo_asignatura, p.semestre
";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Codigo Programa')->setCellValue('B1', 'Programa')->setCellValue('C1', 'Codigo_Asignatura')
    ->setCellValue('D1', 'Asignatura')->setCellValue('E1', 'Semestre')->setCellValue('F1', 'Grupo')
    ->setCellValue('G1', 'Codigo_Docente')->setCellValue('H1', 'Nombre Docente')->setCellValue('I1', 'Avance (%)')
    ->setCellValue('J1', 'Última Actualización')->setCellValue('K1', 'Año');


$row = 2;
foreach ($datos as $dato) {
    $sheet->setCellValue("A$row", $dato['codigo_programa'])
        ->setCellValue("B$row", $dato['nombre_programa'])
        ->setCellValue("C$row", $dato['codigo_asignaturacurso'])
        ->setCellValue("D$row", $dato['nom_asignatura'])
        ->setCellValue("E$row", $dato['semestre'])
        ->setCellValue("F$row", $dato['grupo'])
        ->setCellValue("G$row", $dato['codigo_docente'])
        ->setCellValue("H$row", $dato['nombre_docente'])
        ->setCellValue("I$row", $dato['avance'])
        ->setCellValue("J$row", $dato['fecha_actualizacion'])
        ->setCellValue("K$row", $ano);
    $row++;
}

date_default_timezone_set("America/Bogota");
$fechaCreacion = date('Ymd_His');
// Guardar archivo en el servidor temporalmente
$nombreArchivo = 'reporte_diligenciamiento_avance_micro_' . $fechaCreacion . '.xlsx';
$rutaArchivo = __DIR__ . '/' . $nombreArchivo;
$writer = new Xlsx($spreadsheet);
$writer->save($rutaArchivo);

// Redirigir a página con SweetAlert y enlace de descarga
header("Location: mensaje_descarga_mr1.php?archivo=$nombreArchivo");
exit;
