<?php
include 'conexion6.php';

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$docente = $_GET['docente'] ?? null;
$periodo = $_GET['periodo'] ?? null;


$query = "SELECT 
  m2.codigo_asignatura, 
  m2.nombre_asignatura, 
  m2.grupo, 
  m2.nombre_programa, 
  m2.semestre,

  ROUND(
    (
      SELECT COUNT(*) 
      FROM (
        SELECT unnest(array[
          m2.s1_contenidos, m2.s2_contenidos, m2.s3_contenidos,
          m2.s4_contenidos, m2.s5_contenidos, m2.s6_contenidos,
          m2.s7_contenidos, m2.s8_contenidos, m2.s9_contenidos,
          m2.s10_contenidos, m2.s11_contenidos, m2.s12_contenidos,
          m2.s13_contenidos, m2.s14_contenidos, m2.s15_contenidos,
          m2.s16_contenidos, m2.s17_contenidos, m2.s18_contenidos
        ]) AS contenido
      ) AS unn
      WHERE LENGTH(TRIM(contenido)) > 1
    ) / 18.0 * 100
  , 2) AS avance,

  (
    SELECT COUNT(*) 
    FROM (
      SELECT unnest(array[
        m2.s1_contenidos, m2.s2_contenidos, m2.s3_contenidos,
        m2.s4_contenidos, m2.s5_contenidos, m2.s6_contenidos,
        m2.s7_contenidos, m2.s8_contenidos, m2.s9_contenidos,
        m2.s10_contenidos, m2.s11_contenidos, m2.s12_contenidos,
        m2.s13_contenidos, m2.s14_contenidos, m2.s15_contenidos,
        m2.s16_contenidos, m2.s17_contenidos, m2.s18_contenidos
      ]) AS contenido
    ) AS unn
    WHERE LENGTH(TRIM(contenido)) > 1
  ) AS total_semanas,

  m2.fecha_consigna

FROM sistema.m2 m2
WHERE m2.codigo_docente = ?
  AND m2.codigo_periodo = ?";


$stmt = $conn->prepare($query);
$stmt->execute([$docente, $periodo]);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Codigo Asignatura')->setCellValue('B1', 'Asignatura')->setCellValue('C1', 'Semestre')
    ->setCellValue('D1', 'Grupo')->setCellValue('E1', 'Programa')->setCellValue('F1', 'Avance (%)')
    ->setCellValue('G1', 'Fecha Consignación');

$row = 2;
foreach ($datos as $dato) {
    $sheet->setCellValue("A$row", $dato['codigo_asignatura'])
        ->setCellValue("B$row", $dato['nombre_asignatura'])
        ->setCellValue("C$row", $dato['semestre'])
        ->setCellValue("D$row", $dato['grupo'])
        ->setCellValue("E$row", $dato['nombre_programa'])
        ->setCellValue("F$row", $dato['avance'])
        ->setCellValue("G$row", $dato['fecha_consigna']);
    $row++;
}

/* $writer = new Xlsx($spreadsheet);
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment;filename="reporte.xlsx"');
$writer->save('reporte_avance.xlsx');
 */
// Guardar archivo en el servidor temporalmente
$nombreArchivo = 'reporte_avance_consignador_' . time() . '.xlsx';
$rutaArchivo = __DIR__ . '/' . $nombreArchivo;
$writer = new Xlsx($spreadsheet);
$writer->save($rutaArchivo);

// Redirigir a página con SweetAlert y enlace de descarga
header("Location: mensaje_descarga_cg2.php?archivo=$nombreArchivo");
exit;
