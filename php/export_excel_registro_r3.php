<?php
include 'conexion2.php';

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$periodo         = $_GET['periodo'] ?? '';
$programa        = $_GET['programa'] ?? '';
$asignatura      = $_GET['asignatura'] ?? '';
$semestre        = $_GET['semestre'] ?? '';
$grupo           = $_GET['grupo'] ?? '';


$params = [$periodo]; // periodo

$filters = "";
$join_extra = "";

if (!empty($programa)) {
    $join_extra .= " AND m3.codigo_programa = ?";
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

if (!empty($grupo)) {
    $filters .= " AND m3.grupo = ?";
    $params[] = $grupo;
}

if (!in_array($programa, [26, 31, 32, 30])) {
    $query = "
SELECT 
    p.codigo_asignatura,
    p.nom_asignatura,
    COALESCE(CAST(m3.grupo AS TEXT), 'Sin datos') AS grupo,
    COALESCE(m3.codigo_programa, p.codigo_programa) AS codigo_programa,
    COALESCE(m3.semestre, p.semestre) AS semestre,
    COALESCE(m3.codigo_docente, 'Sin datos') AS codigo_docente,
    COALESCE(m3.nombre_docente, 'Sin datos') AS nombre_docente,
    COALESCE(TO_CHAR(m3.fecha_registro, 'YYYY-MM-DD'), 'Sin datos') AS fecha_registro,
    pr.nombre_programa, 
   
    SUM(
        (CASE WHEN TRIM(s1_descripcion) != ''  THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s2_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s3_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s4_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s5_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s6_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s7_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s8_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s9_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s10_descripcion) != ''  THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s11_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s12_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s13_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s14_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s15_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s16_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s17_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s18_descripcion) != '' THEN 1 ELSE 0 END)
    ) as semanas_diligenciadas

FROM sistema.pensum p
LEFT JOIN sistema.m3 m3 ON m3.codigo_asignatura = p.codigo_asignatura AND m3.codigo_periodo = ?
$join_extra
LEFT JOIN sistema.programas pr ON pr.codigo_programa = COALESCE(m3.codigo_programa, p.codigo_programa)
WHERE 1=1
$filters
GROUP BY 
    p.codigo_asignatura,
    p.nom_asignatura,
    m3.grupo,
    m3.codigo_programa,
    p.codigo_programa,
    m3.semestre,
    p.semestre,
    m3.codigo_docente,
    m3.nombre_docente,
    m3.fecha_registro,
    pr.nombre_programa
ORDER BY p.codigo_programa, p.codigo_asignatura, p.semestre
";
} else {
    $query = "
SELECT 
    p.codigo_asignatura,
    p.nom_asignatura,
    COALESCE(CAST(m3.grupo AS TEXT), 'Sin datos') AS grupo,
    COALESCE(m3.codigo_programa, p.codigo_programa) AS codigo_programa,
    COALESCE(m3.semestre, p.semestre) AS semestre,
    COALESCE(m3.codigo_docente, 'Sin datos') AS codigo_docente,
    COALESCE(m3.nombre_docente, 'Sin datos') AS nombre_docente,
    COALESCE(TO_CHAR(m3.fecha_registro, 'YYYY-MM-DD'), 'Sin datos') AS fecha_registro,
    pr.nombre_programa, 
   
    SUM(
        (CASE WHEN TRIM(s1_descripcion_p) != ''  THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s2_descripcion_p) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s3_descripcion_p) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s4_descripcion_p) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s5_descripcion_p) != '' THEN 1 ELSE 0 END)
    ) as semanas_diligenciadas

FROM sistema.pensum p
LEFT JOIN sistema.m3 m3 ON m3.codigo_asignatura = p.codigo_asignatura AND m3.codigo_periodo = ?
$join_extra
LEFT JOIN sistema.programas pr ON pr.codigo_programa = COALESCE(m3.codigo_programa, p.codigo_programa)
WHERE 1=1
$filters
GROUP BY 
    p.codigo_asignatura,
    p.nom_asignatura,
    m3.grupo,
    m3.codigo_programa,
    p.codigo_programa,
    m3.semestre,
    p.semestre,
    m3.codigo_docente,
    m3.nombre_docente,
    m3.fecha_registro,
    pr.nombre_programa
ORDER BY p.codigo_programa, p.codigo_asignatura, p.semestre
";
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Codigo Programa')->setCellValue('B1', 'Programa')->setCellValue('C1', 'Codigo_Asignatura')
    ->setCellValue('D1', 'Asignatura')->setCellValue('E1', 'Semestre')->setCellValue('F1', 'Grupo')
    ->setCellValue('G1', 'Codigo_Docente')->setCellValue('H1', 'Nombre Docente')->setCellValue('I1', 'Semanas Dil. Avance')
    ->setCellValue('J1', 'Fecha Consignación')->setCellValue('K1', 'Año');


$row = 2;
foreach ($datos as $dato) {
    $sheet->setCellValue("A$row", $dato['codigo_programa'])
        ->setCellValue("B$row", $dato['nombre_programa'])
        ->setCellValue("C$row", $dato['codigo_asignatura'])
        ->setCellValue("D$row", $dato['nom_asignatura'])
        ->setCellValue("E$row", $dato['semestre'])
        ->setCellValue("F$row", $dato['grupo'])
        ->setCellValue("G$row", $dato['codigo_docente'])
        ->setCellValue("H$row", $dato['nombre_docente'])
        ->setCellValue("I$row", $dato['semanas_diligenciadas'])
        ->setCellValue("J$row", $dato['fecha_registro'])
        ->setCellValue("K$row", $periodo);
    $row++;
}
date_default_timezone_set("America/Bogota");
$fechaCreacion = date('Ymd_His');
//$nombreArchivo = "consignador_{$fechaCreacion}.xlsx";

// Guardar archivo en el servidor temporalmente
$nombreArchivo = 'reporte_diligenciamiento_avance_Registro_' . $fechaCreacion . '.xlsx';
$rutaArchivo = __DIR__ . '/' . $nombreArchivo;
$writer = new Xlsx($spreadsheet);
$writer->save($rutaArchivo);

// Redirigir a página con SweetAlert y enlace de descarga
header("Location: mensaje_descarga_rr3.php?archivo=$nombreArchivo");
exit;
