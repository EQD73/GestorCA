<?php

require "conexion.php";
require '../fpdf/fpdf.php';

function realizarSalto($ylines, $pdf)
{
    if ($ylines >= 3 && $ylines % 3 == 0) {
        $pdf->Ln($ylines - 3);
    }
}

// Consulta para obtener los datos del formato
$m = "m2";
$sql2 = "SELECT * FROM version_formato WHERE nombre_formato='$m'";
$result2 = pg_query($conexion, $sql2);
$obj2 = pg_fetch_object($result2);

/// Capturar filtros desde el formulario
$periodo = $_GET['periodo'] ?? '';
$programa = $_GET['programa'] ?? '';
$asignatura = $_GET['asignatura'] ?? '';
$docente = $_GET['docente'] ?? '';
$semestre = $_GET['semestre'] ?? '';
$grupo = $_GET['grupo'] ?? '';

// Consulta con filtros
$sql = "SELECT * FROM sistema.m2 WHERE 1=1";
if (!empty($periodo)) $sql .= " AND codigo_periodo = '$periodo'";
if (!empty($programa)) $sql .= " AND codigo_programa = '$programa'";
if (!empty($asignatura)) $sql .= " AND codigo_asignatura = '$asignatura'";
if (!empty($docente)) $sql .= " AND codigo_docente = '$docente'";
if (!empty($semestre)) $sql .= " AND semestre = $semestre";
if (!empty($grupo)) $sql .= " AND grupo = $grupo";
$sql .= " ORDER BY codigo_asignatura ASC, grupo ASC";

$resultado = pg_query($conexion, $sql);

class PDF extends FPDF
{
    public $headerData; // Variable para almacenar los datos del encabezado
    public $footerData; // Variable para almacenar los datos del pie de pagina

    // Método para establecer los datos del encabezado
    public function setHeaderData($data)
    {
        $this->headerData = $data;
    }
    // Método para establecer los datos del encabezado
    public function setFooterData($data)
    {
        $this->footerData = $data;
    }

    // Encabezado
    function Header()
    {
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
    function Footer()
    {
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
        $this->Cell(80, 5, mb_convert_encoding($this->footerData['nombre_asignatura'], 'ISO-8859-1'), 0, 0, "L");
        $this->Cell(0, 5, mb_convert_encoding('Página ', 'ISO-8859-1') . $this->PageNo() . '/{nb}', 0, 0, "R");
    }

    // Función para controlar el salto de página
    public function checkPageBreak($bottomMargin, $yFin)
    {
        $pageHeight = $this->GetPageHeight(); // Obtiene la altura de la página
        //if ($this->GetY() > ($pageHeight - $bottomMargin)) {
        //if ($yFin > ($pageHeight - $bottomMargin)) {
        if ($yFin > (270 - $bottomMargin)) {
            $this->AddPage();
            $this->Ln(3);
        }
    }
}

$pdf = new PDF("P", "mm", "Letter");

while ($row = pg_fetch_assoc($resultado)) {

    if ($row['codigo_programa'] <> "26" && $row['codigo_programa'] <> "30" && $row['codigo_programa'] <> "31" && $row['codigo_programa'] <> "32") {

        //$pdf = new PDF("P", "mm", "Letter");
        $pdf->setHeaderData($obj2);
        $pdf->setFooterData($row);
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
        $pdf->Cell(15, 5, mb_convert_encoding($row['num_consignacion'], 'ISO-8859-1'), 1, 0, "C");
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(15, 5, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(20, 5, date("d-m-Y", strtotime($row['fecha_consigna'])), 1, 1, "C");
        $pdf->Cell(200, 1, "", 0, 1);
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(25, 5, mb_convert_encoding("Programa:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(100, 5, mb_convert_encoding($row['nombre_programa'], 'ISO-8859-1'), 1, 0, "C");
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(35, 5, mb_convert_encoding("Periodo Académico:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(25, 5, mb_convert_encoding($row['codigo_periodo'], 'ISO-8859-1'), 1, 1, "C");
        $pdf->Cell(200, 1, "", 0, 1);
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(25, 5, mb_convert_encoding("Asignatura:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(25, 5, mb_convert_encoding($row['codigo_asignatura'], 'ISO-8859-1'), 1, 0, "C");
        $pdf->Cell(75, 5, mb_convert_encoding($row['nombre_asignatura'], 'ISO-8859-1'), 1, 0, "C");
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(12, 5, mb_convert_encoding("Grupo:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(8, 5, mb_convert_encoding($row['grupo'], 'ISO-8859-1'), 1, 0, "C");
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(10, 5, mb_convert_encoding("Sem:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(8, 5, mb_convert_encoding($row['semestre'], 'ISO-8859-1'), 1, 0, "C");
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(15, 5, mb_convert_encoding("H.T.T.S:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(8, 5, mb_convert_encoding($row['htts'], 'ISO-8859-1'), 1, 1, "C");
        $pdf->Cell(200, 1, "", 0, 1);
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(30, 5, mb_convert_encoding("Nombre del Docente:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(95, 5, mb_convert_encoding($row['nombre_docente'], 'ISO-8859-1'), 1, 0, "C");
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
        $content1 = $row['resultados_aprendizaje'];

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
        $pdf->Cell(10, 5, mb_convert_encoding($row['htts'], 'ISO-8859-1'), 1, 0, "C");
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(50, 5, mb_convert_encoding("Horas de trabajo práctico Semanal:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(10, 5, mb_convert_encoding($row['htps'], 'ISO-8859-1'), 1, 0, "C");
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(60, 5, mb_convert_encoding("Horas de trabajo independiente Semanal:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(10, 5, mb_convert_encoding($row['htis'], 'ISO-8859-1'), 1, 0, "C");
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
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s1_titulo'] . " (" . $row['s1_rangoi'] . " al " . $row['s1_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        // Contenido original con líneas en blanco
        $cont1 = $row['s1_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont1 = preg_replace("/\n\s*\n/", "\n", trim($cont1));
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont1, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s1_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s1_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x1, $y1, 200, $ylines);
        $yFin = $endY;
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 2
        $x2 = $pdf->GetX();
        $y2 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s2_titulo'] . " (" . $row['s2_rangoi'] . " al " . $row['s2_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        // Contenido original con líneas en blanco
        $cont2 = $row['s2_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont2 = preg_replace("/\n\s*\n/", "\n", trim($cont2));
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont2, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s2_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s2_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x2, $y2, 200, $ylines);
        $yFin = $endY;
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 3
        $x3 = $pdf->GetX();
        $y3 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s3_titulo'] . " (" . $row['s3_rangoi'] . " al " . $row['s3_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        // Contenido original con líneas en blanco
        $cont3 = $row['s3_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont3 = preg_replace("/\n\s*\n/", "\n", trim($cont3));
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont3, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s3_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s3_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x3, $y3, 200, $ylines);
        $yFin = $endY;
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 4
        $x4 = $pdf->GetX();
        $y4 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s4_titulo'] . " (" . $row['s4_rangoi'] . " al " . $row['s4_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        // Contenido original con líneas en blanco
        $cont4 = $row['s4_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont4 = preg_replace("/\n\s*\n/", "\n", trim($cont4));
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont4, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s4_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s4_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x4, $y4, 200, $ylines);
        $yFin = $endY;
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
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s5_titulo'] . " (" . $row['s5_rangoi'] . " al " . $row['s5_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        // Contenido original con líneas en blanco
        $cont5 = $row['s5_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont5 = preg_replace("/\n\s*\n/", "\n", trim($cont5));
        $startY = $pdf->GetY();
        //$pdf->checkPageBreak($bottomMargin);
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont5, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        //$pdf->checkPageBreak($bottomMargin);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s5_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s5_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x5, $y5, 200, $ylines);
        $yFin = $endY;
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
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s6_titulo'] . " (" . $row['s6_rangoi'] . " al " . $row['s6_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        // Contenido original con líneas en blanco
        $cont6 = $row['s6_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont6 = preg_replace("/\n\s*\n/", "\n", trim($cont6));
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont6, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s6_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s6_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x6, $y6, 200, $ylines);
        $yFin = $endY;

        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 7
        // Contenido original con líneas en blanco
        $cont7 = $row['s7_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont7 = preg_replace("/\n\s*\n/", "\n", trim($cont7));
        $lineas = explode("\n", $cont7);
        $cantidadLineas = count($lineas);
        if ($yFin + $cantidadLineas > 250) {
            $yFin = ($yFin + $cantidadLineas);
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        $x7 = $pdf->GetX();
        $y7 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s7_titulo'] . " (" . $row['s7_rangoi'] . " al " . $row['s7_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont7, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s7_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s7_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x7, $y7, 200, $ylines);
        $yFin = intval($endY);
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }

        //semana 8
        // Contenido original con líneas en blanco
        $cont8 = $row['s8_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont8 = preg_replace("/\n\s*\n/", "\n", trim($cont8));
        $lineas = explode("\n", $cont8);
        $cantidadLineas = count($lineas);
        if ($yFin + $cantidadLineas > 250) {
            $yFin = ($yFin + $cantidadLineas);
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        $x8 = $pdf->GetX();
        $y8 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s8_titulo'] . " (" . $row['s8_rangoi'] . " al " . $row['s8_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont8, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s8_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s8_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x8, $y8, 200, $ylines);
        $yFin = intval($endY);
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 9
        // Contenido original con líneas en blanco
        $cont9 = $row['s9_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont9 = preg_replace("/\n\s*\n/", "\n", trim($cont9));
        $lineas = explode("\n", $cont9);
        $cantidadLineas = count($lineas);
        if ($yFin + $cantidadLineas > 250) {
            $yFin = ($yFin + $cantidadLineas);
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        $x9 = $pdf->GetX();
        $y9 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s9_titulo'] . " (" . $row['s9_rangoi'] . " al " . $row['s9_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont9, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s9_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s9_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x9, $y9, 200, $ylines);
        $yFin = $endY;
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 10
        // Contenido original con líneas en blanco
        $cont10 = $row['s10_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont10 = preg_replace("/\n\s*\n/", "\n", trim($cont10));
        $lineas = explode("\n", $cont10);
        $cantidadLineas = count($lineas);
        if ($yFin + $cantidadLineas > 250) {
            $yFin = ($yFin + $cantidadLineas);
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        $x10 = $pdf->GetX();
        $y10 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        //$pdf->checkPageBreak($bottomMargin);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s10_titulo'] . " (" . $row['s10_rangoi'] . " al " . $row['s10_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont10, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s10_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s10_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x10, $y10, 200, $ylines);
        $yFin = $endY;
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 11
        // Contenido original con líneas en blanco
        $cont11 = $row['s11_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont11 = preg_replace("/\n\s*\n/", "\n", trim($cont11));
        $lineas = explode("\n", $cont11);
        $cantidadLineas = count($lineas);
        if ($yFin + $cantidadLineas > 250) {
            $yFin = ($yFin + $cantidadLineas);
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        $x11 = $pdf->GetX();
        $y11 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s11_titulo'] . " (" . $row['s11_rangoi'] . " al " . $row['s11_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont11, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s11_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s11_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x11, $y11, 200, $ylines);
        $yFin = $endY;
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 12
        // Contenido original con líneas en blanco
        $cont12 = $row['s12_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont12 = preg_replace("/\n\s*\n/", "\n", trim($cont12));
        $lineas = explode("\n", $cont12);
        $cantidadLineas = count($lineas);
        if ($yFin + $cantidadLineas > 250) {
            $yFin = ($yFin + $cantidadLineas);
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        $x12 = $pdf->GetX();
        $y12 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s12_titulo'] . " (" . $row['s12_rangoi'] . " al " . $row['s12_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont12, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s12_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s12_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x12, $y12, 200, $ylines);
        $yFin = $endY;
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 13
        // Contenido original con líneas en blanco
        $cont13 = $row['s13_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont13 = preg_replace("/\n\s*\n/", "\n", trim($cont13));
        $lineas = explode("\n", $cont13);
        $cantidadLineas = count($lineas);
        if ($yFin + $cantidadLineas > 250) {
            $yFin = ($yFin + $cantidadLineas);
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        $x13 = $pdf->GetX();
        $y13 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s13_titulo'] . " (" . $row['s13_rangoi'] . " al " . $row['s13_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont13, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s13_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s13_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x13, $y13, 200, $ylines);
        $yFin = $endY;
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 14
        // Contenido original con líneas en blanco
        $cont14 = $row['s14_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont14 = preg_replace("/\n\s*\n/", "\n", trim($cont14));
        $lineas = explode("\n", $cont14);
        $cantidadLineas = count($lineas);
        if ($yFin + $cantidadLineas > 250) {
            $yFin = ($yFin + $cantidadLineas);
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        $x14 = $pdf->GetX();
        $y14 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s14_titulo'] . " (" . $row['s14_rangoi'] . " al " . $row['s14_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont14, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s14_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s14_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x14, $y14, 200, $ylines);
        $yFin = intval($endY);
        //$pdf->Cell(10, 5, $yFin);
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 15
        // Contenido original con líneas en blanco
        $cont15 = $row['s15_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont15 = preg_replace("/\n\s*\n/", "\n", trim($cont15));
        $lineas = explode("\n", $cont15);
        $cantidadLineas = count($lineas);
        //$pdf->Cell(10, 5, $cantidadLineas);
        if ($yFin + $cantidadLineas > 250) {
            $yFin = ($yFin + $cantidadLineas);

            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        $x15 = $pdf->GetX();
        $y15 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s15_titulo'] . " (" . $row['s15_rangoi'] . " al " . $row['s15_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont15, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s15_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s15_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x15, $y15, 200, $ylines);
        $yFin = intval($endY);
        //$pdf->Cell(10, 5, $yFin);
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 16
        // Contenido original con líneas en blanco
        $cont16 = $row['s16_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont16 = preg_replace("/\n\s*\n/", "\n", trim($cont16));
        $lineas = explode("\n", $cont16);
        $cantidadLineas = count($lineas);
        if ($yFin + $cantidadLineas > 250) {
            $yFin = ($yFin + $cantidadLineas);
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        $x16 = $pdf->GetX();
        $y16 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s16_titulo'] . " (" . $row['s16_rangoi'] . " al " . $row['s16_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont16, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s16_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s16_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x16, $y16, 200, $ylines);
        $yFin = $endY;
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 17
        // Contenido original con líneas en blanco
        $cont17 = $row['s17_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont17 = preg_replace("/\n\s*\n/", "\n", trim($cont17));
        $lineas = explode("\n", $cont17);
        $cantidadLineas = count($lineas);
        if ($yFin + $cantidadLineas > 250) {
            $yFin = ($yFin + $cantidadLineas);
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        $x17 = $pdf->GetX();
        $y17 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s17_titulo'] . " (" . $row['s17_rangoi'] . " al " . $row['s17_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont17, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s17_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s17_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x17, $y17, 200, $ylines);
        $yFin = $endY;
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 18
        // Contenido original con líneas en blanco
        $cont18 = $row['s18_contenidos'];
        // Eliminar líneas en blanco
        $cleanedCont18 = preg_replace("/\n\s*\n/", "\n", trim($cont18));
        $lineas = explode("\n", $cont18);
        $cantidadLineas = count($lineas);
        if ($yFin + $cantidadLineas > 250) {
            $yFin = ($yFin + $cantidadLineas);
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        $x18 = $pdf->GetX();
        $y18 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s18_titulo'] . " (" . $row['s18_rangoi'] . " al " . $row['s18_rangof'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont18, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s18_estrategia'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s18_metodologia'], 'ISO-8859-1'), 0, 'J', 0, 4);
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
        $pdf->Cell(65, 3, mb_convert_encoding($row['nombre_docente'], 'ISO-8859-1'), 0, 0, "C");
        $pdf->Cell(70, 3, mb_convert_encoding($row['validador1'], 'ISO-8859-1'), 0, 0, "C");
        $pdf->Cell(65, 3, mb_convert_encoding($row['validador2'], 'ISO-8859-1'), 0, 1, "C");
        $pdf->SetFont("Arial", "", 5);
        $pdf->Cell(65, 2, mb_convert_encoding($row['nombre_programa'], 'ISO-8859-1'), 0, 0, "C");
        $pdf->Cell(70, 2, mb_convert_encoding("COORDINADOR " . $row['nombre_programa'], 'ISO-8859-1'), 0, 0, "C");
        $pdf->Cell(65, 2, mb_convert_encoding("VICERECTORIA ACADEMICA", 'ISO-8859-1'), 0, 1, "C");
        $pdf->SetFont("Arial", "", 6);
        $pdf->Cell(65, 2, mb_convert_encoding("ELABORÓ", 'ISO-8859-1'), 0, 0, "C");
        $pdf->Cell(70, 2, mb_convert_encoding("REVISÓ", 'ISO-8859-1'), 0, 0, "C");
        $pdf->Cell(65, 2, mb_convert_encoding("APROBÓ", 'ISO-8859-1'), 0, 1, "C");
    } else {
        //$pdf = new FPDF("P", "mm", "Letter");
        $pdf = new PDF("P", "mm", "Letter");
        $pdf->setHeaderData($obj2);
        $pdf->setFooterData($row);
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
        $pdf->Cell(15, 5, mb_convert_encoding($row['num_consignacion'], 'ISO-8859-1'), 1, 0, "C");
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(15, 5, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(20, 5, date("d-m-Y", strtotime($row['fecha_consigna'])), 1, 1, "C");
        $pdf->Cell(200, 1, "", 0, 1);
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(25, 5, mb_convert_encoding("Programa:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(100, 5, mb_convert_encoding($row['nombre_programa'], 'ISO-8859-1'), 1, 0, "C");
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(35, 5, mb_convert_encoding("Periodo Académico:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(25, 5, mb_convert_encoding($row['codigo_periodo'], 'ISO-8859-1'), 1, 1, "C");
        $pdf->Cell(200, 1, "", 0, 1);
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(25, 5, mb_convert_encoding("Asignatura:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(25, 5, mb_convert_encoding($row['codigo_asignatura'], 'ISO-8859-1'), 1, 0, "C");
        $pdf->Cell(75, 5, mb_convert_encoding($row['nombre_asignatura'], 'ISO-8859-1'), 1, 0, "C");
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(12, 5, mb_convert_encoding("Grupo:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(8, 5, mb_convert_encoding($row['grupo'], 'ISO-8859-1'), 1, 0, "C");
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(10, 5, mb_convert_encoding("Sem:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(8, 5, mb_convert_encoding($row['semestre'], 'ISO-8859-1'), 1, 0, "C");
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(15, 5, mb_convert_encoding("H.T.T.S:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(8, 5, mb_convert_encoding($row['htts'], 'ISO-8859-1'), 1, 1, "C");
        $pdf->Cell(200, 1, "", 0, 1);
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(30, 5, mb_convert_encoding("Nombre del Docente:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(95, 5, mb_convert_encoding($row['nombre_docente'], 'ISO-8859-1'), 1, 0, "C");
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
        $content1 = $row['resultados_aprendizaje'];

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
        $pdf->Cell(10, 5, mb_convert_encoding($row['htts'], 'ISO-8859-1'), 1, 0, "C");
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(50, 5, mb_convert_encoding("Horas de trabajo práctico Semanal:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(10, 5, mb_convert_encoding($row['htps'], 'ISO-8859-1'), 1, 0, "C");
        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(60, 5, mb_convert_encoding("Horas de trabajo independiente Semanal:", 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(10, 5, mb_convert_encoding($row['htis'], 'ISO-8859-1'), 1, 0, "C");
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
        //semana 1 postgrado
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s1_titulo_p'] . " (" . $row['s1_rangoi_p'] . " al " . $row['s1_rangof_p'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        // Contenido original con líneas en blanco
        $cont1 = $row['s1_contenidos_p'];
        // Eliminar líneas en blanco
        $cleanedCont1 = preg_replace("/\n\s*\n/", "\n", trim($cont1));
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont1, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s1_estrategia_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s1_metodologia_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x1, $y1, 200, $ylines);
        $yFin = $endY;
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }

        //semana 2 postgrados
        $x2 = $pdf->GetX();
        $y2 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s2_titulo_p'] . " (" . $row['s2_rangoi_p'] . " al " . $row['s2_rangof_p'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        // Contenido original con líneas en blanco
        $cont2 = $row['s2_contenidos_p'];
        // Eliminar líneas en blanco
        $cleanedCont2 = preg_replace("/\n\s*\n/", "\n", trim($cont2));
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont2, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s2_estrategia_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s2_metodologia_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x2, $y2, 200, $ylines);
        $yFin = $endY;
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 3 postgrados
        $x3 = $pdf->GetX();
        $y3 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s3_titulo_p'] . " (" . $row['s3_rangoi_p'] . " al " . $row['s3_rangof_p'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        // Contenido original con líneas en blanco
        $cont3 = $row['s3_contenidos_p'];
        // Eliminar líneas en blanco
        $cleanedCont3 = preg_replace("/\n\s*\n/", "\n", trim($cont3));
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont3, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s3_estrategia_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s3_metodologia_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x3, $y3, 200, $ylines);
        $yFin = $endY;
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 4 postgrados
        $x4 = $pdf->GetX();
        $y4 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s4_titulo_p'] . " (" . $row['s4_rangoi_p'] . " al " . $row['s4_rangof_p'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        // Contenido original con líneas en blanco
        $cont4 = $row['s4_contenidos_p'];
        // Eliminar líneas en blanco
        $cleanedCont4 = preg_replace("/\n\s*\n/", "\n", trim($cont4));
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont4, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s4_estrategia_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s4_metodologia_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x4, $y4, 200, $ylines);
        $yFin = $endY;
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 250) {
            realizarSalto($ylines, $pdf);
        }
        //semana 5 postgrados
        // Contenido original con líneas en blanco
        $cont5 = $row['s5_contenidos_p'];
        // Eliminar líneas en blanco
        $cleanedCont5 = preg_replace("/\n\s*\n/", "\n", trim($cont5));
        $lineas = explode("\n", $cont5);
        $cantidadLineas = count($lineas);
        if ($yFin + $cantidadLineas > 250) {
            $yFin = ($yFin + $cantidadLineas);
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        $x5 = $pdf->GetX();
        $y5 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s5_titulo_p'] . " (" . $row['s5_rangoi_p'] . " al " . $row['s5_rangof_p'] . ")", 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(50, $y);
        $startY = $pdf->GetY();
        $pdf->MultiCell(80, 3, mb_convert_encoding($cleanedCont5, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endY = $pdf->GetY();
        $ylines = $endY - $startY;
        $pdf->SetXY(130, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s5_estrategia_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(170, $y);
        $pdf->MultiCell(40, 3, mb_convert_encoding($row['s5_metodologia_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->rect($x5, $y5, 200, $ylines);
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
        $pdf->Cell(65, 3, mb_convert_encoding($row['nombre_docente'], 'ISO-8859-1'), 0, 0, "C");
        $pdf->Cell(70, 3, mb_convert_encoding($row['validador1'], 'ISO-8859-1'), 0, 0, "C");
        $pdf->Cell(65, 3, mb_convert_encoding($row['validador'], 'ISO-8859-1'), 0, 1, "C");
        $pdf->SetFont("Arial", "", 5);
        $pdf->Cell(65, 2, mb_convert_encoding($row['nombre_programa'], 'ISO-8859-1'), 0, 0, "C");
        $pdf->Cell(70, 2, mb_convert_encoding("COORDINADOR " . $row['nombre_programa'], 'ISO-8859-1'), 0, 0, "C");
        $pdf->Cell(65, 2, mb_convert_encoding("VICERECTORIA ACADEMICA", 'ISO-8859-1'), 0, 1, "C");
        $pdf->SetFont("Arial", "", 6);
        $pdf->Cell(65, 2, mb_convert_encoding("ELABORÓ", 'ISO-8859-1'), 0, 0, "C");
        $pdf->Cell(70, 2, mb_convert_encoding("REVISÓ", 'ISO-8859-1'), 0, 0, "C");
        $pdf->Cell(65, 2, mb_convert_encoding("APROBÓ", 'ISO-8859-1'), 0, 1, "C");
    }
}

$pdf->Output('I', 'reporte_consignador_academico_.pdf');
