<?php
require __DIR__ . '/../vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Crear un nuevo archivo Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', '¡Hola, PhpSpreadsheet!');

// Guardar el archivo
$writer = new Xlsx($spreadsheet);
$writer->save('archivo.xlsx');

echo "Archivo Excel creado correctamente.";
