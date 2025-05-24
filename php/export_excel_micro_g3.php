<?php
include 'conexion2.php';

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$docente = $_GET['docente'] ?? null;
$ano_micro = $_GET['ano_micro'] ?? null;


$params = [$ano_micro, $docente, $ano_micro];

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
LEFT JOIN sistema.programas pr ON pr.codigo_programa = COALESCE(m1.codigo_programa, p.codigo_programa)
WHERE m1.codigo_docente = ? AND m1.ano_micro = ?
GROUP BY 
    p.codigo_asignatura, 
    p.nom_asignatura, 
    m1.grupo, 
    m1.codigo_programa, 
    p.codigo_programa, 
    m1.semestre, 
    p.semestre, 
    m1.codigo_docente, 
    m1.nombre_docente, 
    m1.fecha_actualizacion, 
    pr.nombre_programa,
    m1.u1_resultados,
    m1.u2_resultados,
    m1.u3_resultados,
    m1.u4_resultados,
    m1.u5_resultados    

ORDER BY p.codigo_programa, p.codigo_asignatura, p.semestre
";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Codigo Asignatura')->setCellValue('B1', 'Asignatura')->setCellValue('C1', 'Semestre')
    ->setCellValue('D1', 'Grupo')->setCellValue('E1', 'Programa')->setCellValue('F1', 'Avance (%)')
    ->setCellValue('G1', 'Última Actualización');

$row = 2;
foreach ($datos as $dato) {
    $sheet->setCellValue("A$row", $dato['codigo_asignaturacurso'])
        ->setCellValue("B$row", $dato['nom_asignatura'])
        ->setCellValue("C$row", $dato['semestre'])
        ->setCellValue("D$row", $dato['grupo'])
        ->setCellValue("E$row", $dato['nombre_programa'])
        ->setCellValue("F$row", $dato['avance'])
        ->setCellValue("G$row", $dato['fecha_actualizacion']);
    $row++;
}

date_default_timezone_set("America/Bogota");
$fechaCreacion = date('Ymd_His');
// Guardar archivo en el servidor temporalmente
$nombreArchivo = 'reporte_avance_micro_pordocente_' . $fechaCreacion . '.xlsx';
$rutaArchivo = __DIR__ . '/' . $nombreArchivo;
$writer = new Xlsx($spreadsheet);
$writer->save($rutaArchivo);

// Redirigir a página con SweetAlert y enlace de descarga
header("Location: mensaje_descarga_mg3.php?archivo=$nombreArchivo");
exit;
