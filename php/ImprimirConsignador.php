<?php

session_start();

require "conexion.php";
require "../fpdf/fpdf.php";


function realizarSalto($ylines, $pdf)
{
    if ($ylines >= 3 && $ylines % 3 == 0) {
        $pdf->Ln($ylines - 3);
    }
}

$tablam2 = $_SESSION['tablam2'];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
}
$codigoConsulta = $id;

$m = "m2";
$sql2 = "SELECT * FROM version_formato WHERE nombre_formato='$m'";
$result2 = pg_query($conexion, $sql2);
$obj2 = pg_fetch_object($result2);

$sql1 = "SELECT * FROM $tablam2 WHERE id ='$codigoConsulta'";
$resultado = pg_query($conexion, $sql1);
$obj = pg_fetch_object($resultado);

class PDF extends FPDF {
    public $headerData; // Variable para almacenar los datos del encabezado
    public $footerData; // Variable para almacenar los datos del pie de pagina
    // Método para establecer los datos del encabezado
    public function setHeaderData($data) {
        $this->headerData = $data;
    }
    // Método para establecer los datos del encabezado
    public function setFooterData($data) {
        $this->footerData = $data;
    }

    // Encabezado
    function Header() {
        // // Fuente del encabezado
        // $this->SetFont('Arial', 'B', 12);
        // // Título del encabezado
        // $this->Cell(0, 10, 'Encabezado Predeterminado', 0, 1, 'C');
        // // Línea divisoria
        // $this->Ln(5);
        $this->Cell(60, 21, $this->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
        $this->SetFont("Arial", "B", 12);
        $this->Cell(100, 21, mb_convert_encoding("Consignación Académica de Contenidos", 'ISO-8859-1'), 1, 0, "C");
        $this->SetFont("Arial", "", 9);
        $this->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
        $this->Cell(25, 7, mb_convert_encoding($this->headerData->codigo, 'ISO-8859-1'), 1, 1, "L");
        $this->Cell(160);
        $this->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
        $this->Cell(25, 7, mb_convert_encoding($this->headerData->version, 'ISO-8859-1'), 1, 1, "L");
        $this->Cell(160);
        $this->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
        $this->Cell(25, 7, mb_convert_encoding($this->headerData->fecha, 'ISO-8859-1'), 1, 1, "L");
        //$this->Ln(5);
    }

    //Pie de página
    function Footer() {
        // Posición a 1.5 cm del final de la página
        $this->SetY(-15);
        // Fuente del pie de página
        $this->SetFont('Arial', '', 6);
        // Número de página
        //$this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
        $this->AliasNbPages();
      
        $this->Cell(25, 5, mb_convert_encoding("Fecha y Hora de impresión", 'ISO-8859-1'), 0, 0, "L");
        $this->Cell(5);
        $this->Cell(10, 5, date('d/m/Y'), 0, 0, 'L');
        $this->Cell(5);
        date_default_timezone_set("America/Bogota");
        $this->Cell(10, 5, date("h:i:sa"), 0, 0, 'L');
        $this->Cell(5);
        $this->Cell(80, 5, mb_convert_encoding($this->footerData->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
        $this->Cell(0, 5, mb_convert_encoding('Página ', 'ISO-8859-1') . $this->PageNo() . '/{nb}', 0, 0, "R");
    }

    // Función para controlar el salto de página
    public function checkPageBreak($bottomMargin, $yFin) {
        $pageHeight = $this->GetPageHeight(); // Obtiene la altura de la página
        //if ($this->GetY() > ($pageHeight - $bottomMargin)) {
            //if ($yFin > ($pageHeight - $bottomMargin)) {
        if ($yFin > (270 - $bottomMargin)) {
            $this->AddPage();
            $this->Ln(3);
        }
    }
}

if ($obj->codigo_programa <> "26" && $obj->codigo_programa <> "30" && $obj->codigo_programa <> "31" && $obj->codigo_programa <> "32") {

    $pdf = new PDF("P", "mm", "Letter");
    $pdf->setHeaderData($obj2); 
    $pdf->setFooterData($obj); 
    $pdf->SetTitle('Formato Consignador Academico de contenidos');
    $pdf->AddPage();
    // Márgenes y altura de página
    $bottomMargin = 20; // Espacio reservado para el footer
    $pageHeight = 279;  // Altura total de la página Letter en mm (216 x 279)
    $pdf->SetFont("Arial", "B", 9);
    $pdf->SetFillColor(181, 178, 178);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(200, 5, mb_convert_encoding("Datos Principales", 'ISO-8859-1'), 1, 1, "C", true);
    $pdf->SetFont("Arial", "", 9);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->rect(10, 36, 200, 25);
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(40, 5, mb_convert_encoding("Número Consignador:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(15, 5, mb_convert_encoding($obj->num_consignacion, 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(15, 5, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(20, 5, date("d-m-Y", strtotime($obj->fecha_consigna)), 1, 1, "C");
    $pdf->Cell(200, 1, "", 0, 1);
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(25, 5, mb_convert_encoding("Programa:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(100, 5, mb_convert_encoding($obj->nombre_programa, 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(35, 5, mb_convert_encoding("Periodo Académico:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(25, 5, mb_convert_encoding($obj->codigo_periodo, 'ISO-8859-1'), 1, 1, "C");
    $pdf->Cell(200, 1, "", 0, 1);
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(25, 5, mb_convert_encoding("Asignatura:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(25, 5, mb_convert_encoding($obj->codigo_asignatura, 'ISO-8859-1'), 1, 0, "C");
    $pdf->Cell(75, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(12, 5, mb_convert_encoding("Grupo:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(8, 5, mb_convert_encoding($obj->grupo, 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(10, 5, mb_convert_encoding("Sem:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(8, 5, mb_convert_encoding($obj->semestre, 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(15, 5, mb_convert_encoding("H.T.T.S:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(8, 5, mb_convert_encoding($obj->htts, 'ISO-8859-1'), 1, 1, "C");
    $pdf->Cell(200, 1, "", 0, 1);
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(30, 5, mb_convert_encoding("Nombre del Docente:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(95, 5, mb_convert_encoding($obj->nombre_docente, 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(28, 5, mb_convert_encoding("Correo electrónico:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(46, 5, mb_convert_encoding("correo@", 'ISO-8859-1'), 1, 1, "C");
    $pdf->Cell(200, 1, "", 0, 1);
    $pdf->SetFillColor(181, 178, 178);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont("Arial", "B", 9);
    $pdf->Cell(200, 5, mb_convert_encoding("Resultados del aprendizaje del programa", 'ISO-8859-1'), 1, 1, "C", true);

    // Contenido original con líneas en blanco
    $content1 = $obj->resultados_aprendizaje;

    // Eliminar líneas en blanco
    $cleanedContent1 = preg_replace("/\n\s*\n/", "\n", trim($content1));

    //$pdf->rect(10, 65, 200, 24);
    $pdf->SetFont("Arial", "", 7);
    $pdf->MultiCell(200, 3, mb_convert_encoding($cleanedContent1, 'ISO-8859-1'), 1, 'J', 0, 5);

    $pdf->SetFillColor(181, 178, 178);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont("Arial", "B", 9);
    $pdf->Cell(200, 5, mb_convert_encoding("Intensidad Horaria Semanal", 'ISO-8859-1'), 1, 1, "C", true);
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(50, 5, mb_convert_encoding("Horas de trabajo teórico Semanal:", 'ISO-8859-1'), 1, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(10, 5, mb_convert_encoding($obj->htts, 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(50, 5, mb_convert_encoding("Horas de trabajo práctico Semanal:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(10, 5, mb_convert_encoding($obj->htps, 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(60, 5, mb_convert_encoding("Horas de trabajo independiente Semanal:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(10, 5, mb_convert_encoding($obj->htis, 'ISO-8859-1'), 1, 0, "C");
    $pdf->Cell(10, 5, mb_convert_encoding("", 'ISO-8859-1'), 1, 1, "C");
    $pdf->SetFillColor(181, 178, 178);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont("Arial", "B", 9);
    $pdf->Cell(200, 5, mb_convert_encoding("DESARROLLO DE LA ASIGNATURA", 'ISO-8859-1'), 1, 1, "C", true);
    //$pdf->rect(10,105, 200, 5);
    $pdf->SetFont("Arial", "", 6);
    $pdf->Cell(200, 6, mb_convert_encoding(" SEMANA                                                                       CONTENIDOS                                                                                                  ESTRATEGIAS METODOLÓGICAS          METODOS DE EVALUACIÓN", 'ISO-8859-1'), 1, 1, "L");
    $x1 = $pdf->GetX();
    $y1 = $pdf->GetY();
    //semana 1
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s1_titulo . " (" . $obj->s1_rangoi . " al " . $obj->s1_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    // Contenido original con líneas en blanco
    $cont1 = $obj->s1_contenidos;
    // Eliminar líneas en blanco
    $cleanedCont1 = preg_replace("/\n\s*\n/", "\n", trim($cont1));
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont1, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s1_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s1_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x1, $y1, 200, $ylines);
    $yFin =$endY;
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
     realizarSalto($ylines, $pdf);
    }
    //semana 2
    $x2 = $pdf->GetX();
    $y2 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s2_titulo . " (" . $obj->s2_rangoi . " al " . $obj->s2_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    // Contenido original con líneas en blanco
    $cont2 = $obj->s2_contenidos;
    // Eliminar líneas en blanco
    $cleanedCont2 = preg_replace("/\n\s*\n/", "\n", trim($cont2));
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont2, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s2_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s2_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x2, $y2, 200, $ylines);
    $yFin =$endY;
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
     realizarSalto($ylines, $pdf);
    }
    //semana 3
    $x3 = $pdf->GetX();
    $y3 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s3_titulo . " (" . $obj->s3_rangoi . " al " . $obj->s3_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    // Contenido original con líneas en blanco
    $cont3 = $obj->s3_contenidos;
    // Eliminar líneas en blanco
    $cleanedCont3 = preg_replace("/\n\s*\n/", "\n", trim($cont3));
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding( $cleanedCont3, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s3_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s3_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x3, $y3, 200, $ylines);
    $yFin =$endY;
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
     realizarSalto($ylines, $pdf);
    }
    //semana 4
    $x4 = $pdf->GetX();
    $y4 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s4_titulo . " (" . $obj->s4_rangoi . " al " . $obj->s4_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    // Contenido original con líneas en blanco
    $cont4 = $obj->s4_contenidos;
    // Eliminar líneas en blanco
    $cleanedCont4 = preg_replace("/\n\s*\n/", "\n", trim($cont4));
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont4, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s4_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s4_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x4, $y4, 200, $ylines);
    $yFin =$endY;
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
     realizarSalto($ylines, $pdf);
    }
    //semana 5
    $x5 = $pdf->GetX();
    $y5 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    //$pdf->checkPageBreak($bottomMargin);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s5_titulo . " (" . $obj->s5_rangoi . " al " . $obj->s5_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    // Contenido original con líneas en blanco
    $cont5 = $obj->s5_contenidos;
    // Eliminar líneas en blanco
    $cleanedCont5 = preg_replace("/\n\s*\n/", "\n", trim($cont5));
    $startY = $pdf->GetY();
    //$pdf->checkPageBreak($bottomMargin);
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont5, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    //$pdf->checkPageBreak($bottomMargin);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s5_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s5_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x5, $y5, 200, $ylines);
    $yFin =$endY;
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
     realizarSalto($ylines, $pdf);
    }
    //semana 6
    $x6 = $pdf->GetX();
    $y6 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    //$pdf->checkPageBreak($bottomMargin);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s6_titulo . " (" . $obj->s6_rangoi . " al " . $obj->s6_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    // Contenido original con líneas en blanco
    $cont6 = $obj->s6_contenidos;
    // Eliminar líneas en blanco
    $cleanedCont6 = preg_replace("/\n\s*\n/", "\n", trim($cont6));
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont6, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s6_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s6_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x6, $y6, 200, $ylines);
    $yFin =$endY;
    
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
     realizarSalto($ylines, $pdf);
    }
    //semana 7
    // Contenido original con líneas en blanco
    $cont7 = $obj->s7_contenidos;
    // Eliminar líneas en blanco
    $cleanedCont7 = preg_replace("/\n\s*\n/", "\n", trim($cont7));
    $lineas = explode("\n", $cont7);
    $cantidadLineas = count($lineas);
    if ($yFin+$cantidadLineas > 250){
        $yFin= ($yFin+$cantidadLineas);
        $pdf->checkPageBreak($bottomMargin, $yFin);
    }
    $x7 = $pdf->GetX();
    $y7 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s7_titulo . " (" . $obj->s7_rangoi . " al " . $obj->s7_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont7, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s7_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s7_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x7, $y7, 200, $ylines);
    $yFin =intval($endY);
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
     realizarSalto($ylines, $pdf);
    }
    
    //semana 8
    // Contenido original con líneas en blanco
    $cont8 = $obj->s8_contenidos;
    // Eliminar líneas en blanco
    $cleanedCont8 = preg_replace("/\n\s*\n/", "\n", trim($cont8));
    $lineas = explode("\n", $cont8);
    $cantidadLineas = count($lineas);
    if ($yFin+$cantidadLineas > 250){
        $yFin= ($yFin+$cantidadLineas);
        $pdf->checkPageBreak($bottomMargin, $yFin);
    }
    $x8 = $pdf->GetX();
    $y8 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s8_titulo . " (" . $obj->s8_rangoi . " al " . $obj->s8_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont8, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s8_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s8_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x8, $y8, 200, $ylines);
    $yFin =intval($endY);
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
     realizarSalto($ylines, $pdf);
    }
    //semana 9
    // Contenido original con líneas en blanco
    $cont9 = $obj->s9_contenidos;
    // Eliminar líneas en blanco
    $cleanedCont9 = preg_replace("/\n\s*\n/", "\n", trim($cont9));
    $lineas = explode("\n", $cont9);
    $cantidadLineas = count($lineas);
    if ($yFin+$cantidadLineas > 250){
        $yFin= ($yFin+$cantidadLineas);
        $pdf->checkPageBreak($bottomMargin, $yFin);
    }
    $x9 = $pdf->GetX();
    $y9 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s9_titulo . " (" . $obj->s9_rangoi . " al " . $obj->s9_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont9, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s9_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s9_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x9, $y9, 200, $ylines);
    $yFin =$endY;
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
     realizarSalto($ylines, $pdf);
    }
    //semana 10
    // Contenido original con líneas en blanco
    $cont10 = $obj->s10_contenidos;
    // Eliminar líneas en blanco
    $cleanedCont10 = preg_replace("/\n\s*\n/", "\n", trim($cont10));
    $lineas = explode("\n", $cont10);
    $cantidadLineas = count($lineas);
    if ($yFin+$cantidadLineas > 250){
        $yFin= ($yFin+$cantidadLineas);
        $pdf->checkPageBreak($bottomMargin, $yFin);
    }
    $x10 = $pdf->GetX();
    $y10 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    //$pdf->checkPageBreak($bottomMargin);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s10_titulo . " (" . $obj->s10_rangoi . " al " . $obj->s10_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont10, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s10_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s10_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x10, $y10, 200, $ylines);
    $yFin =$endY;
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
     realizarSalto($ylines, $pdf);
    }
    //semana 11
    // Contenido original con líneas en blanco
    $cont11 = $obj->s11_contenidos;
    // Eliminar líneas en blanco
    $cleanedCont11 = preg_replace("/\n\s*\n/", "\n", trim($cont11));
    $lineas = explode("\n", $cont11);
    $cantidadLineas = count($lineas);
    if ($yFin+$cantidadLineas > 250){
        $yFin= ($yFin+$cantidadLineas);
        $pdf->checkPageBreak($bottomMargin, $yFin);
    }
    $x11 = $pdf->GetX();
    $y11 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s11_titulo . " (" . $obj->s11_rangoi . " al " . $obj->s11_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont11, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s11_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s11_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x11, $y11, 200, $ylines);
    $yFin =$endY;
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
     realizarSalto($ylines, $pdf);
    }
    //semana 12
    // Contenido original con líneas en blanco
    $cont12 = $obj->s12_contenidos;
    // Eliminar líneas en blanco
    $cleanedCont12 = preg_replace("/\n\s*\n/", "\n", trim($cont12));
    $lineas = explode("\n", $cont12);
    $cantidadLineas = count($lineas);
    if ($yFin+$cantidadLineas > 250){
        $yFin= ($yFin+$cantidadLineas);
        $pdf->checkPageBreak($bottomMargin, $yFin);
    }
    $x12 = $pdf->GetX();
    $y12 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s12_titulo . " (" . $obj->s12_rangoi . " al " . $obj->s12_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont12, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s12_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s12_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x12, $y12, 200, $ylines);
    $yFin =$endY;
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
     realizarSalto($ylines, $pdf);
    }
    //semana 13
    // Contenido original con líneas en blanco
    $cont13 = $obj->s13_contenidos;
    // Eliminar líneas en blanco
    $cleanedCont13 = preg_replace("/\n\s*\n/", "\n", trim($cont13));
    $lineas = explode("\n", $cont13);
    $cantidadLineas = count($lineas);
    if ($yFin+$cantidadLineas > 250){
        $yFin= ($yFin+$cantidadLineas);
        $pdf->checkPageBreak($bottomMargin, $yFin);
    }
    $x13 = $pdf->GetX();
    $y13 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s13_titulo . " (" . $obj->s13_rangoi . " al " . $obj->s13_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont13, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s13_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s13_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x13, $y13, 200, $ylines);
    $yFin =$endY;
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
     realizarSalto($ylines, $pdf);
    }
    //semana 14
     // Contenido original con líneas en blanco
     $cont14 = $obj->s14_contenidos;
     // Eliminar líneas en blanco
     $cleanedCont14 = preg_replace("/\n\s*\n/", "\n", trim($cont14));
     $lineas = explode("\n", $cont14);
     $cantidadLineas = count($lineas);
     if ($yFin+$cantidadLineas > 250){
         $yFin= ($yFin+$cantidadLineas);
         $pdf->checkPageBreak($bottomMargin, $yFin);
     }
    $x14 = $pdf->GetX();
    $y14 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s14_titulo . " (" . $obj->s14_rangoi . " al " . $obj->s14_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont14, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s14_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s14_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x14, $y14, 200, $ylines);
    $yFin =intval($endY);
    //$pdf->Cell(10, 5, $yFin);
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
     realizarSalto($ylines, $pdf);
    }
    //semana 15
     // Contenido original con líneas en blanco
     $cont15 = $obj->s15_contenidos;
     // Eliminar líneas en blanco
     $cleanedCont15 = preg_replace("/\n\s*\n/", "\n", trim($cont15));
     $lineas = explode("\n", $cont15);
     $cantidadLineas = count($lineas);
     //$pdf->Cell(10, 5, $cantidadLineas);
     if ($yFin+$cantidadLineas > 250){
         $yFin= ($yFin+$cantidadLineas);
         
         $pdf->checkPageBreak($bottomMargin, $yFin);
     }
    $x15 = $pdf->GetX();
    $y15 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s15_titulo . " (" . $obj->s15_rangoi . " al " . $obj->s15_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont15, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s15_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s15_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x15, $y15, 200, $ylines);
    $yFin =intval($endY);
    //$pdf->Cell(10, 5, $yFin);
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
        realizarSalto($ylines, $pdf);
    }
    //semana 16
    // Contenido original con líneas en blanco
    $cont16 = $obj->s16_contenidos;
    // Eliminar líneas en blanco
    $cleanedCont16 = preg_replace("/\n\s*\n/", "\n", trim($cont16));
    $lineas = explode("\n", $cont16);
    $cantidadLineas = count($lineas);
    if ($yFin+$cantidadLineas > 250){
        $yFin= ($yFin+$cantidadLineas);
        $pdf->checkPageBreak($bottomMargin, $yFin);
    }
    $x16 = $pdf->GetX();
    $y16 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s16_titulo . " (" . $obj->s16_rangoi . " al " . $obj->s16_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont16, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s16_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s16_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x16, $y16, 200, $ylines);
    $yFin =$endY;
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
     realizarSalto($ylines, $pdf);
    }
    //semana 17
    // Contenido original con líneas en blanco
    $cont17 = $obj->s17_contenidos;
    // Eliminar líneas en blanco
    $cleanedCont17 = preg_replace("/\n\s*\n/", "\n", trim($cont17));
    $lineas = explode("\n", $cont17);
    $cantidadLineas = count($lineas);
    if ($yFin+$cantidadLineas > 250){
        $yFin= ($yFin+$cantidadLineas);
        $pdf->checkPageBreak($bottomMargin, $yFin);
    }
    $x17 = $pdf->GetX();
    $y17 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s17_titulo . " (" . $obj->s17_rangoi . " al " . $obj->s17_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont17, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s17_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s17_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x17, $y17, 200, $ylines);
    $yFin =$endY;
    $pdf->checkPageBreak($bottomMargin, $yFin);
    if ($yFin < 250) { 
     realizarSalto($ylines, $pdf);
    }
    //semana 18
    // Contenido original con líneas en blanco
    $cont18 = $obj->s18_contenidos;
    // Eliminar líneas en blanco
    $cleanedCont18 = preg_replace("/\n\s*\n/", "\n", trim($cont18));
    $lineas = explode("\n", $cont18);
    $cantidadLineas = count($lineas);
    if ($yFin+$cantidadLineas > 250){
        $yFin= ($yFin+$cantidadLineas);
        $pdf->checkPageBreak($bottomMargin, $yFin);
    }
    $x18 = $pdf->GetX();
    $y18 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s18_titulo . " (" . $obj->s18_rangoi . " al " . $obj->s18_rangof . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $startY = $pdf->GetY();
    $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont18, 'ISO-8859-1'), 0, 'J', 0, 4);
    $endY = $pdf->GetY();
    $ylines = $endY - $startY;
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s18_estrategia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s18_metodologia, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->rect($x18, $y18, 200, $ylines);
    if ($endY > 240) { 
        $pdf->AddPage();
    }
    //validacion
    $pdf->SetFillColor(181, 178, 178);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont("Arial", "B", 9);
    $pdf->Cell(200, 5, mb_convert_encoding("RESPONSABLES CONSIGNACION ACADÉMICA", 'ISO-8859-1'), 1, 1, "C", true);
    $X1 = $pdf->GetX();
    $Y1 = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $pdf->rect($X1, $Y1, 65, 23);
    $pdf->rect(75, $Y1, 70, 23);
    $pdf->rect(145, $Y1, 65, 23);
    $pdf->Ln(14);
    $pdf->Cell(65, 3, mb_convert_encoding($obj->nombre_docente, 'ISO-8859-1'), 0, 0, "C");
    $pdf->Cell(70, 3, mb_convert_encoding($obj->validador1, 'ISO-8859-1'), 0, 0, "C");
    $pdf->Cell(65, 3, mb_convert_encoding($obj->validador2, 'ISO-8859-1'), 0, 1, "C");
    $pdf->SetFont("Arial", "", 5);
    $pdf->Cell(65, 2, mb_convert_encoding($obj->nombre_programa, 'ISO-8859-1'), 0, 0, "C");
    $pdf->Cell(70, 2, mb_convert_encoding("COORDINADOR " . $obj->nombre_programa, 'ISO-8859-1'), 0, 0, "C");
    $pdf->Cell(65, 2, mb_convert_encoding("VICERECTORIA ACADEMICA", 'ISO-8859-1'), 0, 1, "C");
    $pdf->SetFont("Arial", "", 6);
    $pdf->Cell(65, 2, mb_convert_encoding("ELABORÓ", 'ISO-8859-1'), 0, 0, "C");
    $pdf->Cell(70, 2, mb_convert_encoding("REVISÓ", 'ISO-8859-1'), 0, 0, "C");
    $pdf->Cell(65, 2, mb_convert_encoding("APROBÓ", 'ISO-8859-1'), 0, 1, "C");
    //$pdf->Ln(6);
    //pie de pagina 2
    // $pdf->SetY(250); // Posición desde el final
    // $pdf->SetFont("Arial", "", 6);
    // $pdf->Cell(25, 5, mb_convert_encoding("Fecha y Hora de impresión", 'ISO-8859-1'), 0, 0, "L");
    // $pdf->Cell(5);
    // $pdf->Cell(10, 5, date('d/m/Y'), 0, 0, 'L');
    // $pdf->Cell(5);
    // date_default_timezone_set("America/Bogota");
    // $pdf->Cell(10, 5, date("h:i:sa"), 0, 0, 'L');
    // $pdf->Cell(5);
    // $pdf->Cell(80, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
    // $pdf->Cell(0, 5, mb_convert_encoding('Página ', 'ISO-8859-1') . $pdf->PageNo() . '/{nb}', 0, 0, "R");

} else {

    //$pdf = new FPDF("P", "mm", "Letter");
    $pdf = new PDF_TextBox("P", "mm", "Letter");
    $pdf->SetTitle('Formato Consignador Academico de contenidos');
    $pdf->AddPage();
    $pdf->Cell(60, 21, $pdf->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
    $pdf->SetFont("Arial", "B", 12);
    $pdf->Cell(100, 21, mb_convert_encoding("Consignación Académica de Contenidos", 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "", 9);
    $pdf->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(25, 7, mb_convert_encoding($obj2->codigo, 'ISO-8859-1'), 1, 1, "L");
    $pdf->Cell(160);
    $pdf->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(25, 7, mb_convert_encoding($obj2->version, 'ISO-8859-1'), 1, 1, "L");
    $pdf->Cell(160);
    $pdf->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(25, 7, mb_convert_encoding($obj2->fecha, 'ISO-8859-1'), 1, 1, "L");
    $pdf->SetFont("Arial", "B", 9);
    $pdf->SetFillColor(181, 178, 178);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(200, 5, mb_convert_encoding("Datos Principales", 'ISO-8859-1'), 1, 1, "C", true);
    $pdf->SetFont("Arial", "", 9);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->rect(10, 36, 200, 25);
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(40, 5, mb_convert_encoding("Número Consignador:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(15, 5, mb_convert_encoding($obj->num_consignacion, 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(15, 5, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(20, 5, date("d-m-Y", strtotime($obj->fecha_consigna)), 1, 1, "C");
    $pdf->Cell(200, 1, "", 0, 1);
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(25, 5, mb_convert_encoding("Programa:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(100, 5, mb_convert_encoding($obj->nombre_programa, 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(35, 5, mb_convert_encoding("Periodo Académico:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(25, 5, mb_convert_encoding($obj->codigo_periodo, 'ISO-8859-1'), 1, 1, "C");
    $pdf->Cell(200, 1, "", 0, 1);
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(25, 5, mb_convert_encoding("Asignatura:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(25, 5, mb_convert_encoding($obj->codigo_asignatura, 'ISO-8859-1'), 1, 0, "C");
    $pdf->Cell(75, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(12, 5, mb_convert_encoding("Grupo:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(8, 5, mb_convert_encoding($obj->grupo, 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(10, 5, mb_convert_encoding("Sem:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(8, 5, mb_convert_encoding($obj->semestre, 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(15, 5, mb_convert_encoding("H.T.T.S:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(8, 5, mb_convert_encoding($obj->htts, 'ISO-8859-1'), 1, 1, "C");
    $pdf->Cell(200, 1, "", 0, 1);
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(30, 5, mb_convert_encoding("Nombre del Docente:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(95, 5, mb_convert_encoding($obj->nombre_docente, 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(28, 5, mb_convert_encoding("Correo electrónico:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(46, 5, mb_convert_encoding("correo@", 'ISO-8859-1'), 1, 1, "C");
    $pdf->Cell(200, 1, "", 0, 1);
    $pdf->SetFillColor(181, 178, 178);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont("Arial", "B", 9);
    $pdf->Cell(200, 5, mb_convert_encoding("Resultados del aprendizaje del programa", 'ISO-8859-1'), 1, 1, "C", true);
    $pdf->rect(10, 65, 200, 25);
    $pdf->SetFont("Arial", "", 7);
    //$pdf->MultiCell(200, 3, mb_convert_encoding($obj->resultados_aprendizaje, 'ISO-8859-1'), 0,'J',0,5);
    $pdf->SetXY(10, 65);
    $pdf->drawTextBox($obj->resultados_aprendizaje, 200, 25, 'J', 'T');
    $pdf->SetXY(10, 90);
    $pdf->SetFillColor(181, 178, 178);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont("Arial", "B", 9);
    $pdf->Cell(200, 5, mb_convert_encoding("Intensidad Horaria Semanal", 'ISO-8859-1'), 1, 1, "C", true);
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(50, 5, mb_convert_encoding("Horas de trabajo teórico Semanal:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(10, 5, mb_convert_encoding($obj->htts, 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(50, 5, mb_convert_encoding("Horas de trabajo práctico Semanal:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(10, 5, mb_convert_encoding($obj->htps, 'ISO-8859-1'), 1, 0, "C");
    $pdf->SetFont("Arial", "B", 8);
    $pdf->Cell(60, 5, mb_convert_encoding("Horas de trabajo independiente Semanal:", 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 8);
    $pdf->Cell(10, 5, mb_convert_encoding($obj->htis, 'ISO-8859-1'), 1, 1, "C");
    $pdf->SetFillColor(181, 178, 178);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont("Arial", "B", 9);
    $pdf->Cell(200, 5, mb_convert_encoding("DESARROLLO DE LA ASIGNATURA", 'ISO-8859-1'), 1, 1, "C", true);
    //$pdf->rect(10,105, 200, 5);
    $pdf->SetFont("Arial", "", 6);
    $pdf->Cell(200, 6, mb_convert_encoding(" SEMANA                                                                       CONTENIDOS                                                                                                  ESTRATEGIAS METODOLÓGICAS          METODOS DE EVALUACIÓN", 'ISO-8859-1'), 1, 1, "L");

    //semana 1 postgrado
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s1_titulo_p . " (" . $obj->s1_rangoi_p . " al " . $obj->s1_rangof_p . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $pdf->MultiCell(80, 3, mb_convert_encoding($obj->s1_contenidos_p, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s1_estrategia_p, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s1_metodologia_p, 'ISO-8859-1'), 0, 'J', 0, 4);
    if ($obj->resultados_aprendizaje == " " || $obj->resultados_aprendizaje == null) {
        $inc = 6;
        $pdf->rect(10, 170 - $inc, 200, 11);
    } else {
        $pdf->rect(10, 170, 200, 11);
    }
    $pdf->Ln(8);
    //semana 2 postgrados
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s2_titulo_p . " (" . $obj->s2_rangoi_p . " al " . $obj->s2_rangof_p . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $pdf->MultiCell(80, 3, mb_convert_encoding($obj->s2_contenidos_p, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s2_estrategia_p, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s2_metodologia_p, 'ISO-8859-1'), 0, 'J', 0, 4);
    if ($obj->resultados_aprendizaje == " " || $obj->resultados_aprendizaje == null) {
        $inc = 6;
        $pdf->rect(10, 107 - $inc, 200, 11);
    } else {
        $pdf->rect(10, 107, 200, 11);
    }
    $pdf->Ln(8);
    //semana 3 postgrados
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s3_titulo_p . " (" . $obj->s3_rangoi_p . " al " . $obj->s3_rangof_p . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $pdf->MultiCell(80, 3, mb_convert_encoding($obj->s3_contenidos_p, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s3_estrategia_p, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s3_metodologia_p, 'ISO-8859-1'), 0, 'J', 0, 4);
    if ($obj->resultados_aprendizaje == " " || $obj->resultados_aprendizaje == null) {
        $inc = 6;
        $pdf->rect(10, 118 - $inc, 200, 11);
    } else {
        $pdf->rect(10, 118, 200, 11);
    }
    $pdf->Ln(8);
    //semana 4
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s4_titulo_p . " (" . $obj->s4_rangoi_p . " al " . $obj->s4_rangof_p . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $pdf->MultiCell(80, 3, mb_convert_encoding($obj->s4_contenidos_p, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s4_estrategia_p, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s4_metodologia_p, 'ISO-8859-1'), 0, 'J', 0, 4);
    if ($obj->resultados_aprendizaje == " " || $obj->resultados_aprendizaje == null) {
        $inc = 6;
        $pdf->rect(10, 129 - $inc, 200, 11);
    } else {
        $pdf->rect(10, 129, 200, 11);
    }
    $pdf->Ln(8);
    //semana 5
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s5_titulo_p . " (" . $obj->s5_rangoi_p . " al " . $obj->s5_rangof_p . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(50, $y);
    $pdf->MultiCell(80, 3, mb_convert_encoding($obj->s5_contenidos_p, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s5_estrategia_p, 'ISO-8859-1'), 0, 'J', 0, 4);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(40, 3, mb_convert_encoding($obj->s5_metodologia_p, 'ISO-8859-1'), 0, 'J', 0, 4);
    if ($obj->resultados_aprendizaje == " " || $obj->resultados_aprendizaje == null) {
        $inc = 6;
        $pdf->rect(10, 140 - $inc, 200, 11);
    } else {
        $pdf->rect(10, 140, 200, 11);
    }
    $pdf->Ln(8);
    // paginas
    $pdf->AliasNbPages();
    //validacion
    $pdf->SetFillColor(181, 178, 178);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont("Arial", "B", 9);
    $pdf->Cell(200, 5, mb_convert_encoding("RESPONSABLES CONSIGNACION ACADÉMICA", 'ISO-8859-1'), 1, 1, "C", true);
    $pdf->SetFont("Arial", "", 6);
    $pdf->rect(10, 150, 65, 17);
    $pdf->rect(75, 150, 70, 17);
    $pdf->rect(145, 150, 65, 17);
    $pdf->Ln(5);
    $pdf->Cell(65, 3, mb_convert_encoding($obj->nombre_docente, 'ISO-8859-1'), 0, 0, "C");
    $pdf->Cell(70, 3, mb_convert_encoding($obj->validador1, 'ISO-8859-1'), 0, 0, "C");
    $pdf->Cell(65, 3, mb_convert_encoding($obj->validador2, 'ISO-8859-1'), 0, 1, "C");
    $y = $pdf->GetY();
    $pdf->SetFont("Arial", "", 5);
    $pdf->MultiCell(65, 2, mb_convert_encoding($obj->nombre_programa, 'ISO-8859-1'), 0, "C", 0);
    $pdf->SetXY(75, $y);
    $pdf->MultiCell(70, 2, mb_convert_encoding("COORDINADOR " . $obj->nombre_programa, 'ISO-8859-1'), 0, "C", 0);
    $pdf->SetXY(145, $y);
    $pdf->Cell(65, 2, mb_convert_encoding("VICERECTORIA ACADEMICA", 'ISO-8859-1'), 0, 1, "C");
    $pdf->Ln(2);
    $y = $pdf->GetY();
    $pdf->SetFont("Arial", "", 6);
    $pdf->Cell(65, 2, mb_convert_encoding("ELABORÓ", 'ISO-8859-1'), 0, 0, "C");
    $pdf->SetXY(75, $y);
    $pdf->Cell(70, 2, mb_convert_encoding("REVISÓ", 'ISO-8859-1'), 0, 0, "C");
    $pdf->SetXY(145, $y);
    $pdf->Cell(65, 2, mb_convert_encoding("APROBÓ", 'ISO-8859-1'), 0, 1, "C");
    $pdf->Ln(6);
    //pie de pagina 
    $pdf->SetFont("Arial", "", 6);
    $pdf->Cell(25, 5, mb_convert_encoding("Fecha y Hora de impresión", 'ISO-8859-1'), 0, 0, "L");
    $pdf->Cell(5);
    $pdf->Cell(10, 5, date('d/m/Y'), 0, 0, 'L');
    $pdf->Cell(5);
    date_default_timezone_set("America/Bogota");
    $pdf->Cell(10, 5, date("h:i:sa"), 0, 0, 'L');
    $pdf->Cell(5);
    $pdf->Cell(80, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
    $pdf->Cell(0, 5, mb_convert_encoding('Página ', 'ISO-8859-1') . $pdf->PageNo() . '/{nb}', 0, 0, "R");
}

$pdf->Output('I', 'reporte_consignador_academico.pdf');
