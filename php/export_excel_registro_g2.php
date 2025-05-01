<?php
include 'conexion6.php';

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$docente = $_GET['docente'] ?? null;
$periodo = $_GET['periodo'] ?? null;


$query = "SELECT 
  m3.codigo_asignatura, 
  m3.nombre_asignatura, 
  m3.grupo, 
  m3.nombre_programa, 
  m3.semestre,

  ROUND(
    (
      SELECT COUNT(*) 
      FROM (
        SELECT unnest(array[
          m3.s1_descripcion, m3.s2_descripcion, m3.s3_descripcion,
          m3.s4_descripcion, m3.s5_descripcion, m3.s6_descripcion,
          m3.s7_descripcion, m3.s8_descripcion, m3.s9_descripcion,
          m3.s10_descripcion, m3.s11_descripcion, m3.s12_descripcion,
          m3.s13_descripcion, m3.s14_descripcion, m3.s15_descripcion,
          m3.s16_descripcion, m3.s17_descripcion, m3.s18_descripcion
        ]) AS contenido
      ) AS unn
      WHERE LENGTH(TRIM(contenido)) > 1
    ) / 18.0 * 100
  , 2) AS avance,

  (
    SELECT COUNT(*) 
    FROM (
      SELECT unnest(array[
        m3.s1_descripcion, m3.s2_descripcion, m3.s3_descripcion,
        m3.s4_descripcion, m3.s5_descripcion, m3.s6_descripcion,
        m3.s7_descripcion, m3.s8_descripcion, m3.s9_descripcion,
        m3.s10_descripcion, m3.s11_descripcion, m3.s12_descripcion,
        m3.s13_descripcion, m3.s14_descripcion, m3.s15_descripcion,
        m3.s16_descripcion, m3.s17_descripcion, m3.s18_descripcion
      ]) AS contenido
    ) AS unn
    WHERE LENGTH(TRIM(contenido)) > 1
  ) AS total_semanas,

  m3.fecha_registro

FROM sistema.m3 m3
WHERE m3.codigo_docente = ?
  AND m3.codigo_periodo = ?";


$stmt = $conn->prepare($query);
$stmt->execute([$docente, $periodo]);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Codigo Asignatura')->setCellValue('B1', 'Asignatura')->setCellValue('C1', 'Semestre')
  ->setCellValue('D1', 'Grupo')->setCellValue('E1', 'Programa')->setCellValue('F1', 'Avance (%)')
  ->setCellValue('G1', 'Fecha Registro');

$row = 2;
foreach ($datos as $dato) {
  $sheet->setCellValue("A$row", $dato['codigo_asignatura'])
    ->setCellValue("B$row", $dato['nombre_asignatura'])
    ->setCellValue("C$row", $dato['semestre'])
    ->setCellValue("D$row", $dato['grupo'])
    ->setCellValue("E$row", $dato['nombre_programa'])
    ->setCellValue("F$row", $dato['avance'])
    ->setCellValue("G$row", $dato['fecha_registro']);
  $row++;
}

/* $writer = new Xlsx($spreadsheet);
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment;filename="reporte.xlsx"');
$writer->save('reporte_avance.xlsx');
 */
// Guardar archivo en el servidor temporalmente
$nombreArchivo = 'reporte_avance_registro_' . time() . '.xlsx';
$rutaArchivo = __DIR__ . '/' . $nombreArchivo;
$writer = new Xlsx($spreadsheet);
$writer->save($rutaArchivo);

// Redirigir a página con SweetAlert y enlace de descarga
header("Location: mensaje_descarga_rg2.php?archivo=$nombreArchivo");
exit;
