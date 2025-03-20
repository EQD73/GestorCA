<?php
require('../fpdf/fpdf.php');

class PDF extends FPDF {
    // Encabezado
    function Header() {
        // Fuente del encabezado
        $this->SetFont('Arial', 'B', 12);
        // Título del encabezado
        $this->Cell(0, 10, 'Encabezado Predeterminado', 0, 1, 'C');
        // Línea divisoria
        $this->Ln(5);
    }

    // Pie de página
    function Footer() {
        // Posición a 1.5 cm del final de la página
        $this->SetY(-15);
        // Fuente del pie de página
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Crear el objeto PDF
$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Márgenes y altura de página
$bottomMargin = 20; // Espacio reservado para el footer
$pageHeight = 279;  // Altura total de la página Letter en mm (216 x 279)

// Simulación de contenido largo
for ($i = 1; $i <= 100; $i++) {
    // Verifica si el contenido está cerca del pie de página
    if ($pdf->GetY() > $pageHeight - $bottomMargin) {
        $pdf->AddPage(); // Salta a la siguiente página
    }

    // Escribe una línea de contenido
    $pdf->Cell(0, 10, "Línea de contenido $i", 0, 1);
}

// Generar el PDF
$pdf->Output();
?>
