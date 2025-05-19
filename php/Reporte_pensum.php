<?php
require('../fpdf/fpdf.php');
require 'conexion2.php';

/* // Conexión PDO
try {
    $pdo = new PDO("pgsql:host=localhost;port=5432;dbname=tu_basededatos", "tu_usuario", "tu_contraseña");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
 */
// Clase PDF
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'REPORTE DE PENSUM POR PROGRAMA', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Consulta con PDO
$sql = "
    SELECT 
        pe.codigo_asignatura,
        pe.codigo_programa,
        a.nom_asignatura,
        a.semestre,
        p.nombre_programa
    FROM sistema.pensum pe
    LEFT JOIN sistema.asignaturas a ON pe.codigo_asignatura = a.codigo_asignatura
    LEFT JOIN sistema.programas p ON pe.codigo_programa = p.codigo_programa
    ORDER BY pe.codigo_programa, a.semestre, pe.codigo_asignatura
";

$stmt = $pdo->query($sql);

$programa_actual = '';

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nombre_programa = $row['nombre_programa'];

    if ($programa_actual !== $nombre_programa) {
        $programa_actual = $nombre_programa;

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 10, mb_convert_encoding("Programa: " . $programa_actual, 'ISO-8859-1', 'UTF-8'), 0, 1);

        // Encabezado de tabla
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 8, 'Código', 1);
        $pdf->Cell(100, 8, 'Asignatura', 1);
        $pdf->Cell(30, 8, 'Semestre', 1);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
    }

    $pdf->Cell(30, 8, $row['codigo_asignatura'], 1);
    $pdf->Cell(100, 8, mb_convert_encoding($row['nom_asignatura'], 'ISO-8859-1', 'UTF-8'), 1);
    $pdf->Cell(30, 8, $row['semestre'], 1);
    $pdf->Ln();
}

$pdf->Output();
