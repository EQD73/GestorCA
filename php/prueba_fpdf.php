<?php
require('../fpdf/fpdf.php');

// Clase personalizada extendiendo FPDF
class PDF extends FPDF {
    // Texto de ejemplo largo
    private $text = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
    Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";

    function Header() {
        // Título en cada página
        //$this->SetFont('Arial', 'B', 12);
        //$this->Cell(0, 10, 'Ejemplo de MultiCell con salto de página', 0, 1, 'C');
        $currentOrientation = $this->CurOrientation;

        if ($currentOrientation === 'P') {
            $this->Cell(60, 21, $this->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
            $this->SetFont("Arial", "B", 12);
            $this->Cell(100, 21, "Microcurriculo", 1, 0, "C");
            $this->SetFont("Arial", "", 9);
            $this->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 1, "L");
            //$pdf->Cell(25, 7, mb_convert_encoding($obj2->codigo, 'ISO-8859-1'), 1, 1, "L");
            $this->Cell(160);
            $this->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 1, "L");
            //$pdf->Cell(25, 7, mb_convert_encoding($obj2->version, 'ISO-8859-1'), 1, 1, "L");
            $this->Cell(160);
            $this->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
            //$pdf->Cell(25, 7, mb_convert_encoding($obj2->fecha, 'ISO-8859-1'), 1, 1, "L");
        } elseif ($currentOrientation === 'L') {
           $this->Cell(60, 21,$this->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
           $this->SetFont("Arial", "B", 12);
           $this->Cell(160, 21, "Microcurriculo", 1, 0, "C");
           $this->SetFont("Arial", "", 9);
           $this->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
           //$this->Cell(25, 7, mb_convert_encoding($obj2->codigo, 'ISO-8859-1'), 1, 1, "L");
           $this->Cell(220);
           $this->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
           //$this->Cell(25, 7, mb_convert_encoding($obj2->version, 'ISO-8859-1'), 1, 1, "L");
           $this->Cell(220);
           $this->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
           //$this->Cell(25, 7, mb_convert_encoding($obj2->fecha, 'ISO-8859-1'), 1, 1, "L");
            
        }
        $this->Ln(15); // Salto de línea
    }

    function Footer() {
        // Pie de página con número de página
        $this->SetY(-15); // Posición desde el final
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    function AddContent() {
        $this->SetFont('Arial', '', 12);
        $this->SetY(30); // Posición inicial debajo del encabezado
        $pageHeight = $this->GetPageHeight(); // Altura de la página
        $marginBottom = 15; // Espacio para el pie de página

        // Altura de cada línea en MultiCell
        $lineHeight = 10;

        // Divide el texto en fragmentos y ajusta
        for ($i = 0; $i < 50; $i++) { // Simulación de múltiples bloques de texto
            $currentY = $this->GetY();

            // Verifica si hay espacio suficiente para el texto
            if ($currentY + $lineHeight > $pageHeight - $marginBottom) {
                $this->AddPage();
            }

            // Agrega el texto con MultiCell
            $this->MultiCell(0, $lineHeight, $this->text);
        }
    }
}

// Instancia del PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->AddContent(); // Agregar contenido con gestión de saltos
$pdf->Output();
