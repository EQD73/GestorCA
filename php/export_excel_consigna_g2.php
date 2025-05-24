<?php
include 'conexion2.php';

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$docente = $_GET['docente'] ?? null;
$periodo = $_GET['periodo'] ?? null;


$params = [$periodo, $docente, $periodo];

$query = "SELECT 
  p.codigo_asignatura,
  p.nom_asignatura,
  COALESCE(CAST(m2.grupo AS TEXT), 'Sin datos') AS grupo,
  COALESCE(m2.codigo_programa, p.codigo_programa) AS codigo_programa,
  COALESCE(m2.semestre, p.semestre) AS semestre,
  COALESCE(m2.codigo_docente, 'Sin datos') AS codigo_docente,
  COALESCE(m2.nombre_docente, 'Sin datos') AS nombre_docente,
  COALESCE(TO_CHAR(m2.fecha_consigna, 'YYYY-MM-DD'), 'Sin datos') AS fecha_consigna,
  pr.nombre_programa,
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
  ) AS total_semanas

FROM sistema.pensum p
LEFT JOIN sistema.m2 m2 
  ON m2.codigo_asignatura = p.codigo_asignatura AND m2.codigo_periodo = ?
LEFT JOIN sistema.programas pr 
  ON pr.codigo_programa = COALESCE(m2.codigo_programa, p.codigo_programa)
WHERE m2.codigo_docente = ? AND m2.codigo_periodo = ?
";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Codigo Asignatura')->setCellValue('B1', 'Asignatura')->setCellValue('C1', 'Semestre')
  ->setCellValue('D1', 'Grupo')->setCellValue('E1', 'Programa')->setCellValue('F1', 'Avance (%)')
  ->setCellValue('G1', 'Fecha Consignación');

$row = 2;
foreach ($datos as $dato) {
  $sheet->setCellValue("A$row", $dato['codigo_asignatura'])
    ->setCellValue("B$row", $dato['nom_asignatura'])
    ->setCellValue("C$row", $dato['semestre'])
    ->setCellValue("D$row", $dato['grupo'])
    ->setCellValue("E$row", $dato['nombre_programa'])
    ->setCellValue("F$row", $dato['avance'])
    ->setCellValue("G$row", $dato['fecha_consigna']);
  $row++;
}

date_default_timezone_set("America/Bogota");
$fechaCreacion = date('Ymd_His');
// Guardar archivo en el servidor temporalmente
$nombreArchivo = 'reporte_avance_consignador_pordocente_' . $fechaCreacion . '.xlsx';
$rutaArchivo = __DIR__ . '/' . $nombreArchivo;
$writer = new Xlsx($spreadsheet);
$writer->save($rutaArchivo);

// Redirigir a página con SweetAlert y enlace de descarga
header("Location: mensaje_descarga_cg2.php?archivo=$nombreArchivo");
exit;
