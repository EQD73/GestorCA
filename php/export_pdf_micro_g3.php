<?php

require('../fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(190, 10, 'Reporte de Avance por Docente', 1, 1, 'C');
        $this->Ln(10);
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

// Verificar si el gráfico existe y agregarlo al PDF
if (file_exists("grafico.png")) {
    $pdf->Image("grafico.png", 30, 20, 150); // (x, y, ancho)
    $pdf->Ln(80); // Espacio después del gráfico
}

// Encabezados de la tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 10, 'Código', 1);
$pdf->Cell(50, 10, 'Asignatura', 1);
$pdf->Cell(15, 10, 'Sem.', 1);
$pdf->Cell(15, 10, 'Grupo', 1);
$pdf->Cell(40, 10, 'Programa', 1);
$pdf->Cell(20, 10, 'Avance (%)', 1);
$pdf->Cell(40, 10, 'Última Actualización', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);

include 'conexion6.php';

$docente = '32773466';
$ano_micro = '2024';

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
          WHERE sistema.m1.codigo_docente = '$docente' AND sistema.m1.ano_micro = '$ano_micro' ";

$stmt = $conn->query($query);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(15, 10, $row['codigo_asignaturacurso'], 1);
    $pdf->Cell(50, 10, mb_convert_encoding($row['nombre_asignatura'], 'ISO-8859-1'), 1);
    $pdf->Cell(15, 10, $row['semestre'], 1);
    $pdf->Cell(15, 10, $row['grupo'], 1);
    $pdf->Cell(30, 10, mb_convert_encoding($row['nombre_programa'], 'ISO-8859-1'), 1);
    $pdf->Cell(20, 10, $row['avance'] . '%', 1);
    $pdf->Cell(40, 10, $row['fecha_actualizacion'], 1);
    $pdf->Ln();
}

$pdf->Output("I", "reporte_avance.pdf");
?>
/