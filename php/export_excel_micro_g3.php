<?php
include 'conexion6.php';

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/* $docente = $_POST['docente'];
$ano_micro = $_POST['ano_micro']; */


$query = "SELECT 
            sistema.m1.codigo_asignaturacurso, 
            sistema.m1.nombre_asignatura, 
            sistema.m1.grupo, 
            sistema.m1.nombre_programa, 
            sistema.m1.semestre, 
            ROUND(
                ( 
                    (CASE WHEN LENGTH(TRIM(sistema.m1.u1_resultados)) > 1 THEN 1 ELSE 0 END) +
                    (CASE WHEN LENGTH(TRIM(sistema.m1.u2_resultados)) > 1 THEN 1 ELSE 0 END) +
                    (CASE WHEN LENGTH(TRIM(sistema.m1.u3_resultados)) > 1 THEN 1 ELSE 0 END) +
                    (CASE WHEN LENGTH(TRIM(sistema.m1.u4_resultados)) > 1 THEN 1 ELSE 0 END) +
                    (CASE WHEN LENGTH(TRIM(sistema.m1.u5_resultados)) > 1 THEN 1 ELSE 0 END)
                ) / 5.0 * 100, 2
            ) AS avance,
            sistema.m1.fecha_actualizacion
          FROM sistema.m1
          WHERE sistema.m1.codigo_docente = ? AND sistema.m1.ano_micro = ?";


$stmt = $conn->prepare($query);
$stmt->execute([$docente, $ano_micro]);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Codigo Asignatura')->setCellValue('B1', 'Asignatura')->setCellValue('C1', 'Semestre')
    ->setCellValue('D1', 'Grupo')->setCellValue('E1', 'Programa')->setCellValue('F1', 'Avance (%)')
    ->setCellValue('G1', 'Última Actualización');

$row = 2;
foreach ($datos as $dato) {
    $sheet->setCellValue("A$row", $dato['codigo_asignaturacurso'])
        ->setCellValue("B$row", $dato['nombre_asignatura'])
        ->setCellValue("C$row", $dato['semestre'])
        ->setCellValue("D$row", $dato['grupo'])
        ->setCellValue("E$row", $dato['nombre_programa'])
        ->setCellValue("F$row", $dato['avance'])
        ->setCellValue("G$row", $dato['fecha_actualizacion']);
    $row++;
}

$writer = new Xlsx($spreadsheet);
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment;filename="reporte.xlsx"');
$writer->save('reporte_avance.xlsx');
