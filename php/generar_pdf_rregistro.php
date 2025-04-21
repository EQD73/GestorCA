<?php

session_start();

require "conexion.php";
require '../fpdf/fpdf.php';

function realizarSalto($ylines, $ylines3, $pdf)
{
    if ($ylines >= 2 && $ylines % 2 == 0) {
        //$pdf->Ln($ylines - (($ylines /2)+1));
        if ($ylines == 0) {
            $ylines = 12;
        }
        if ($ylines == 2 && $ylines3 == 0) {
            $ylines = 7;
            $pdf->Ln($ylines - 5);
            return;
        }
        if ($ylines == 2) {
            $ylines = 5;
        }
        if ($ylines == 4 && $ylines3 == 0) {
            $ylines = 7;
            $pdf->Ln($ylines - 5);
            return;
        }
        if ($ylines == 4) {
            $ylines = 7;
        }
        if ($ylines == 6 && $ylines3 == 0) {
            $ylines = 7;
            $pdf->Ln($ylines - 5);
            return;
        }
        if ($ylines == 6) {
            $ylines = 9;
            //return;
        }
        if ($ylines == 8 && $ylines3 == 0) {
            $ylines = 7;
            $pdf->Ln($ylines - 3);
            return;
        }
        if ($ylines == 8) {
            $ylines = 7;
        }
        if ($ylines == 10) {
            $ylines = 9;
        }
        if ($ylines == 12) {
            $ylines = 14;
        }
        if ($ylines == 14 && $ylines3 == 0) {
            $ylines = 14;
            $pdf->Ln($ylines - 5);
            return;
        }
        if ($ylines == 16 && $ylines3 == 0) {
            $ylines = 18;
            $pdf->Ln($ylines - 5);
            return;
        }
        if ($ylines == 24) {
            $ylines = $ylines + 2;
        }

        $pdf->Ln($ylines - 5);
    }
}

$tablam3 = $_SESSION['tablam3'];

// Consulta para obtener los datos del formato
$m = "m3";
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
$sql = "SELECT * FROM sistema.m3 WHERE 1=1";
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
        $this->Cell(60, 21, $this->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
        $this->SetFont("Arial", "B", 12);
        $this->rect(10, 10, 260, 21);
        $this->Cell(160, 14, mb_convert_encoding("REGISTRO DE ACTIVIDADES ACADEMICAS POR DOCENTE", 'ISO-8859-1'), 1, 0, "C");
        $this->SetFont("Arial", "", 9);
        $this->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
        $this->Cell(25, 7, mb_convert_encoding($this->headerData->codigo, 'ISO-8859-1'), 1, 1, "L");
        $this->Cell(220);
        $this->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
        $this->Cell(25, 7, mb_convert_encoding($this->headerData->version, 'ISO-8859-1'), 1, 1, "L");
        $this->Cell(60);
        $this->SetFont("Arial", "", 12);
        $this->Cell(160, 7, mb_convert_encoding("DOCENTE:" . " " . $this->footerData['nombre_docente'], 'ISO-8859-1'), 0, 0, "C");
        $this->SetFont("Arial", "", 9);
        $this->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
        $this->Cell(25, 7, mb_convert_encoding($this->headerData->fecha, 'ISO-8859-1'), 1, 1, "L");
        $this->SetFont("Arial", "B", 9);
        $this->SetFillColor(181, 178, 178);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(260, 5, mb_convert_encoding("Datos Principales", 'ISO-8859-1'), 1, 1, "C", true);
        $this->SetFont("Arial", "", 9);
        $this->SetTextColor(0, 0, 0);
        $this->rect(10, 36, 260, 10);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(30, 5, mb_convert_encoding("ASIGNATURA:", 'ISO-8859-1'), 0, 0, "L");
        $this->SetFont("Arial", "", 10);
        $this->Cell(20, 5, mb_convert_encoding($this->footerData['codigo_asignatura'], 'ISO-8859-1'), 0, 0, "L");
        $this->Cell(140, 5, mb_convert_encoding($this->footerData['nombre_asignatura'], 'ISO-8859-1'), 0, 0, "L");
        $this->SetFont("Arial", "B", 10);
        $this->Cell(20, 5, mb_convert_encoding("GRUPO:", 'ISO-8859-1'), 0, 0, "L");
        $this->SetFont("Arial", "", 10);
        $this->Cell(10, 5, mb_convert_encoding($this->footerData['grupo'], 'ISO-8859-1'), 0, 0, "L");
        $this->Cell(30, 5, mb_convert_encoding("SEMESTRE:", 'ISO-8859-1'), 0, 0, "L");
        $this->SetFont("Arial", "", 10);
        $this->Cell(10, 5, mb_convert_encoding($this->footerData['semestre'], 'ISO-8859-1'), 0, 1, "L");
        $this->SetFont("Arial", "B", 10);

        $this->Cell(30, 5, mb_convert_encoding("PROGRAMA:", 'ISO-8859-1'), 0, 0, "L");
        $this->SetFont("Arial", "", 10);
        $this->Cell(230, 5, mb_convert_encoding($this->footerData['nombre_programa'], 'ISO-8859-1'), 0, 1, "L");
        $this->SetFont("Arial", "B", 6);
        $this->SetLineWidth(0.5);
        $this->line(10, 56, 270, 56);
        $this->Cell(210);
        $this->SetFont("Arial", "B", 6);
        $this->Cell(40, 4, mb_convert_encoding("REPROGRAMACION", 'ISO-8859-1'), 0, 1, "C");
        $this->SetFont("Arial", "B", 6);
        $y = $this->GetY();
        $this->Cell(20, 5, mb_convert_encoding("SEMANA", 'ISO-8859-1'), 0, 0, "L");
        $this->Cell(50, 5, mb_convert_encoding("CONTENIDOS", 'ISO-8859-1'), 0, 0, "L");
        $this->MultiCell(14, 3, mb_convert_encoding("FECHA \n" . "REGISTRO", 'ISO-8859-1'), 0, "C", 0);
        $this->SetXY(92, $y);
        $this->MultiCell(14, 3, mb_convert_encoding("HORA \n" . "REGISTRO", 'ISO-8859-1'), 0, "C", 0);
        $this->SetXY(104, $y);
        $this->MultiCell(15, 3, mb_convert_encoding("TIPO \n" . "ACTIVIDAD", 'ISO-8859-1'), 0, "C", 0);
        $this->SetXY(119, $y);
        $this->MultiCell(40, 3, mb_convert_encoding("DESCRIPCION \n" . "ACTIVIDAD", 'ISO-8859-1'), 0, "C", 0);
        $this->SetXY(168, $y);
        $this->Cell(14, 4, mb_convert_encoding("JUSTIFICACIÓN", 'ISO-8859-1'), 0, 0, "C");
        $this->SetXY(182, $y);
        $this->MultiCell(40, 3, mb_convert_encoding("FECHA \n" . "NOVEDAD", 'ISO-8859-1'), 0, "C", 0);
        $this->SetXY(208, $y);
        $this->MultiCell(20, 3, mb_convert_encoding("TIPO \n" . "NOVEDAD", 'ISO-8859-1'), 0, "C", 0);
        $this->SetFont("Arial", "B", 6);
        $this->SetXY(225, $y);
        $this->MultiCell(20, 3, mb_convert_encoding("FECHA \n" . "1", 'ISO-8859-1'), 0, "C", 0);
        $this->SetXY(235, $y);
        $this->MultiCell(20, 3, mb_convert_encoding("FECHA \n" . "2", 'ISO-8859-1'), 0, "C", 0);
        $this->SetFont("Arial", "B", 7);
        $this->SetXY(252, $y);
        $this->Cell(15, 4, mb_convert_encoding("ESTADO", 'ISO-8859-1'), 0, 1, "L");
        date_default_timezone_set("America/Bogota");
    }

    //Pie de página
    function Footer()
    {
        // Posición a 1.5 cm del final de la página
        $this->SetY(-15);
        // Fuente del pie de página
        $this->SetFont('Arial', '', 6);
        // Número de página
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
        if ($yFin > (210 - $bottomMargin)) {
            $this->AddPage();
            $this->Ln(3);
        }
    }
}

$pdf = new PDF("L", "mm", "Letter");
while ($row = pg_fetch_assoc($resultado)) {

    if ($row['codigo_programa'] <> "26" && $row['codigo_programa'] <> "30" && $row['codigo_programa'] <> "31" && $row['codigo_programa'] <> "32") {

        //$pdf = new PDF("P", "mm", "Letter");
        $pdf->setHeaderData($obj2);
        $pdf->setFooterData($row);
        $pdf->SetTitle('Formato Consignador Academico de contenidos');
        $pdf->AddPage();
        $pdf->Ln(3);
        $bottomMargin = 20; // Espacio reservado para el footer
        $pageHeight = 216;  // Altura total de la página Letter en mm (216 x 279)
        //semana 1
        $x1 = $pdf->GetX();
        $y1 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s1_titulo'] . " del " . $row['s1_rangoi'] . " hasta \n" . $row['s1_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont1 = $row['s1_contenidos'];
        $cleanedCont1 = preg_replace("/\n\s*\n/", "\n", trim($cont1));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont1, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s1_fecharegistro'] == " " || $row['s1_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s1_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s1_horaregistro'] == " " || $row['s1_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s1_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s1_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des1 = $row['s1_descripcion'];
        $cleanedDes1 = preg_replace("/\n\s*\n/", "\n", trim($des1));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes1, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s1_justifica_nov'] == " " || $row['s1_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s1_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s1_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s1_fechanovedad'] == " " || $row['s1_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s1_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s1_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s1_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s1_tiponovedad'] == " " || $row['s1_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s1_fechareprog1'] == " " || $row['s1_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s1_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s1_fechareprog2'] == " " || $row['s1_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s1_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s1_estadoregistro'] == " " || $row['s1_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s1_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }
        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        // $pdf->Cell(12, 6, $ylines1, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines2, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines3, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines, 0, 0, "L");
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }

        //semana 2
        $x2 = $pdf->GetX();
        $y2 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s2_titulo'] . " del " . $row['s2_rangoi'] . " hasta \n" . $row['s2_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont2 = $row['s2_contenidos'];
        $cleanedCont2 = preg_replace("/\n\s*\n/", "\n", trim($cont2));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont2, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s2_fecharegistro'] == " " || $row['s2_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s2_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s2_horaregistro'] == " " || $row['s2_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s2_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s2_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des2 = $row['s2_descripcion'];
        $cleanedDes2 = preg_replace("/\n\s*\n/", "\n", trim($des2));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes2, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s2_justifica_nov'] == " " || $row['s2_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s2_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s2_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s2_fechanovedad'] == " " || $row['s2_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s2_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s2_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s2_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s2_tiponovedad'] == " " || $row['s2_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s2_fechareprog1'] == " " || $row['s2_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s2_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s2_fechareprog2'] == " " || $row['s2_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s2_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s2_estadoregistro'] == " " || $row['s2_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s2_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }

        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        // $pdf->Cell(12, 6, $ylines1, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines2, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines3, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines, 0, 0, "L");
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }

        //semana 3
        $x3 = $pdf->GetX();
        $y3 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s3_titulo'] . " del " . $row['s3_rangoi'] . " hasta \n" . $row['s3_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont3 = $row['s3_contenidos'];
        $cleanedCont3 = preg_replace("/\n\s*\n/", "\n", trim($cont3));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont3, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s3_fecharegistro'] == " " || $row['s3_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s3_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s3_horaregistro'] == " " || $row['s3_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s3_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s3_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des3 = $row['s3_descripcion'];
        $cleanedDes3 = preg_replace("/\n\s*\n/", "\n", trim($des3));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes3, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s3_justifica_nov'] == " " || $row['s3_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s3_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s3_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s3_fechanovedad'] == " " || $row['s3_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s3_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s3_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s3_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s3_tiponovedad'] == " " || $row['s3_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s3_fechareprog1'] == " " || $row['s3_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s3_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s3_fechareprog2'] == " " || $row['s3_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s3_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s3_estadoregistro'] == " " || $row['s3_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s3_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }

        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        // $pdf->Cell(12, 6, $ylines1, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines2, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines3, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines, 0, 0, "L");
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }

        //semana 4
        $x4 = $pdf->GetX();
        $y4 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s4_titulo'] . " del " . $row['s4_rangoi'] . " hasta \n" . $row['s4_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont4 = $row['s4_contenidos'];
        $cleanedCont4 = preg_replace("/\n\s*\n/", "\n", trim($cont4));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont4, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s4_fecharegistro'] == " " || $row['s4_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s4_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s4_horaregistro'] == " " || $row['s4_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s4_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s4_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des4 = $row['s4_descripcion'];
        $cleanedDes4 = preg_replace("/\n\s*\n/", "\n", trim($des4));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes4, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s4_justifica_nov'] == " " || $row['s4_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s4_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s4_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s4_fechanovedad'] == " " || $row['s4_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s4_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s4_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s4_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s4_tiponovedad'] == " " || $row['s4_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s4_fechareprog1'] == " " || $row['s4_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s4_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s4_fechareprog2'] == " " || $row['s4_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s4_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s4_estadoregistro'] == " " || $row['s4_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s4_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }
        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        // $pdf->Cell(12, 6, $ylines1, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines2, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines3, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines, 0, 0, "L");
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
        //semana 5
        $x5 = $pdf->GetX();
        $y5 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s5_titulo'] . " del " . $row['s5_rangoi'] . " hasta \n" . $row['s5_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont5 = $row['s5_contenidos'];
        $cleanedCont5 = preg_replace("/\n\s*\n/", "\n", trim($cont5));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont5, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s5_fecharegistro'] == " " || $row['s5_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s5_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s5_horaregistro'] == " " || $row['s5_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s5_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s5_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des5 = $row['s5_descripcion'];
        $cleanedDes5 = preg_replace("/\n\s*\n/", "\n", trim($des5));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes5, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s5_justifica_nov'] == " " || $row['s5_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s5_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s5_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s5_fechanovedad'] == " " || $row['s5_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s5_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s5_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s5_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s5_tiponovedad'] == " " || $row['s5_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s5_fechareprog1'] == " " || $row['s5_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s5_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s5_fechareprog2'] == " " || $row['s5_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s5_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s5_estadoregistro'] == " " || $row['s5_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s5_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }
        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;

            $ylines = $ylines3;
        }

        // $pdf->Cell(12, 6, $ylines1, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines2, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines3, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines, 0, 0, "L");

        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
        //semana 6
        $x6 = $pdf->GetX();
        $y6 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s6_titulo'] . " del " . $row['s6_rangoi'] . " hasta \n" . $row['s6_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont6 = $row['s6_contenidos'];
        $cleanedCont6 = preg_replace("/\n\s*\n/", "\n", trim($cont6));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont6, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s6_fecharegistro'] == " " || $row['s6_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s6_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s6_horaregistro'] == " " || $row['s6_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s6_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s6_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des6 = $row['s6_descripcion'];
        $cleanedDes6 = preg_replace("/\n\s*\n/", "\n", trim($des6));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes6, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s6_justifica_nov'] == " " || $row['s6_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s6_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s6_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s6_fechanovedad'] == " " || $row['s6_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s6_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s6_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s6_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s6_tiponovedad'] == " " || $row['s6_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s6_fechareprog1'] == " " || $row['s6_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s6_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s6_fechareprog2'] == " " || $row['s6_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s6_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s6_estadoregistro'] == " " || $row['s6_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s6_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }

        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        // $pdf->Cell(12, 6, $ylines1, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines2, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines3, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines, 0, 0, "L");
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
        //semana 7
        $x7 = $pdf->GetX();
        $y7 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s7_titulo'] . " del " . $row['s7_rangoi'] . " hasta \n" . $row['s7_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont7 = $row['s7_contenidos'];
        $cleanedCont7 = preg_replace("/\n\s*\n/", "\n", trim($cont7));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont7, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s7_fecharegistro'] == " " || $row['s7_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s7_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s7_horaregistro'] == " " || $row['s7_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s7_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s7_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des7 = $row['s7_descripcion'];
        $cleanedDes7 = preg_replace("/\n\s*\n/", "\n", trim($des7));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes7, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s7_justifica_nov'] == " " || $row['s7_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s7_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s7_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s7_fechanovedad'] == " " || $row['s7_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s7_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s7_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s7_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s7_tiponovedad'] == " " || $row['s7_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s7_fechareprog1'] == " " || $row['s7_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s7_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s7_fechareprog2'] == " " || $row['s7_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s7_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s7_estadoregistro'] == " " || $row['s7_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s7_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }

        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }

        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }

        //semana 8
        $x8 = $pdf->GetX();
        $y8 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s8_titulo'] . " del " . $row['s8_rangoi'] . " hasta \n" . $row['s8_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont8 = $row['s8_contenidos'];
        $cleanedCont8 = preg_replace("/\n\s*\n/", "\n", trim($cont8));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont8, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s8_fecharegistro'] == " " || $row['s8_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s8_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s8_horaregistro'] == " " || $row['s8_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s8_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s8_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des8 = $row['s8_descripcion'];
        $cleanedDes8 = preg_replace("/\n\s*\n/", "\n", trim($des8));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes8, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s8_justifica_nov'] == " " || $row['s8_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s8_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s8_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s8_fechanovedad'] == " " || $row['s8_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s8_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s8_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s8_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s8_tiponovedad'] == " " || $row['s8_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s8_fechareprog1'] == " " || $row['s8_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s8_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s8_fechareprog2'] == " " || $row['s8_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s8_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s8_estadoregistro'] == " " || $row['s8_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s8_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }
        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        // $pdf->Cell(12, 6, $ylines1, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines2, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines3, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines, 0, 0, "L");
        //$pdf->Cell(12, 6, $f2, 0, 0, "L");
        //$pdf->Cell(12, 6, $f3, 0, 0, "L");
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
        //semana 9
        $x9 = $pdf->GetX();
        $y9 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s9_titulo'] . " del " . $row['s9_rangoi'] . " hasta \n" . $row['s9_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont9 = $row['s9_contenidos'];
        $cleanedCont9 = preg_replace("/\n\s*\n/", "\n", trim($cont9));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont9, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s9_fecharegistro'] == " " || $row['s9_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s9_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s9_horaregistro'] == " " || $row['s9_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s9_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s9_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des9 = $row['s9_descripcion'];
        $cleanedDes9 = preg_replace("/\n\s*\n/", "\n", trim($des9));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes9, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s9_justifica_nov'] == " " || $row['s9_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s9_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s9_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s9_fechanovedad'] == " " || $row['s9_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s9_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s9_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s9_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s9_tiponovedad'] == " " || $row['s9_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s9_fechareprog1'] == " " || $row['s9_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s9_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s9_fechareprog2'] == " " || $row['s9_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s9_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s9_estadoregistro'] == " " || $row['s9_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s9_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }

        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        // $pdf->Cell(12, 6, $endY1, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines1, 0, 0, "L");
        // $pdf->Cell(12, 6, $endY3, 0, 0, "L");
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
        //semana 10
        $x10 = $pdf->GetX();
        $y10 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s10_titulo'] . " del " . $row['s10_rangoi'] . " hasta \n" . $row['s10_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont10 = $row['s10_contenidos'];
        $cleanedCont10 = preg_replace("/\n\s*\n/", "\n", trim($cont10));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont10, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s10_fecharegistro'] == " " || $row['s10_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s10_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s10_horaregistro'] == " " || $row['s10_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s10_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s10_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des10 = $row['s10_descripcion'];
        $cleanedDes10 = preg_replace("/\n\s*\n/", "\n", trim($des10));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes10, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s10_justifica_nov'] == " " || $row['s10_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s10_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s10_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s10_fechanovedad'] == " " || $row['s10_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s10_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s10_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s10_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s10_tiponovedad'] == " " || $row['s10_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s10_fechareprog1'] == " " || $row['s10_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s10_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s10_fechareprog2'] == " " || $row['s10_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s10_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s10_estadoregistro'] == " " || $row['s10_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s10_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }

        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        // $pdf->Cell(12, 6, $endY1, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines1, 0, 0, "L");
        //$pdf->Cell(12, 6, $endY3, 0, 0, "L");
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
        //semana 11
        $x11 = $pdf->GetX();
        $y11 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s11_titulo'] . " del " . $row['s11_rangoi'] . " hasta \n" . $row['s11_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont11 = $row['s11_contenidos'];
        $cleanedCont11 = preg_replace("/\n\s*\n/", "\n", trim($cont11));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont11, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s11_fecharegistro'] == " " || $row['s11_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s11_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s11_horaregistro'] == " " || $row['s11_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s11_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s11_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des11 = $row['s11_descripcion'];
        $cleanedDes11 = preg_replace("/\n\s*\n/", "\n", trim($des11));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes11, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s11_justifica_nov'] == " " || $row['s11_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s11_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s11_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s11_fechanovedad'] == " " || $row['s11_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s11_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s11_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s11_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s11_tiponovedad'] == " " || $row['s11_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s11_fechareprog1'] == " " || $row['s11_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s11_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s11_fechareprog2'] == " " || $row['s11_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s11_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s11_estadoregistro'] == " " || $row['s11_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s11_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }

        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        // $pdf->Cell(12, 6, $endY1, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines1, 0, 0, "L");
        //$pdf->Cell(12, 6, $endY3, 0, 0, "L");
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
        //semana 12
        $x12 = $pdf->GetX();
        $y12 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s12_titulo'] . " del " . $row['s12_rangoi'] . " hasta \n" . $row['s12_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont12 = $row['s12_contenidos'];
        $cleanedCont12 = preg_replace("/\n\s*\n/", "\n", trim($cont12));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont12, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s12_fecharegistro'] == " " || $row['s12_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s12_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s12_horaregistro'] == " " || $row['s12_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s12_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s12_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des12 = $row['s12_descripcion'];
        $cleanedDes12 = preg_replace("/\n\s*\n/", "\n", trim($des12));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes12, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s12_justifica_nov'] == " " || $row['s12_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s12_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s12_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s12_fechanovedad'] == " " || $row['s12_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s12_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s12_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s12_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s12_tiponovedad'] == " " || $row['s12_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s12_fechareprog1'] == " " || $row['s12_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s12_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s12_fechareprog2'] == " " || $row['s12_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s12_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s12_estadoregistro'] == " " || $row['s12_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s12_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }
        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        // $pdf->Cell(12, 6, $endY1, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines1, 0, 0, "L");
        //$pdf->Cell(12, 6, $endY3, 0, 0, "L");
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
        //semana 13
        $x13 = $pdf->GetX();
        $y13 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s13_titulo'] . " del " . $row['s13_rangoi'] . " hasta \n" . $row['s13_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont13 = $row['s13_contenidos'];
        $cleanedCont13 = preg_replace("/\n\s*\n/", "\n", trim($cont13));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont13, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s13_fecharegistro'] == " " || $row['s13_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s13_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s13_horaregistro'] == " " || $row['s13_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s13_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s13_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des13 = $row['s13_descripcion'];
        $cleanedDes13 = preg_replace("/\n\s*\n/", "\n", trim($des13));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes13, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s13_justifica_nov'] == " " || $row['s13_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s13_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s13_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s13_fechanovedad'] == " " || $row['s13_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s13_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s13_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s13_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s13_tiponovedad'] == " " || $row['s13_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s13_fechareprog1'] == " " || $row['s13_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s13_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s13_fechareprog2'] == " " || $row['s13_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s13_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s13_estadoregistro'] == " " || $row['s13_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s13_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }

        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        $flag = 0;
        if ($yFin > 180) {
            $pdf->AddPage();
            $pdf->Ln(3);
            $flag = 1;
        } else {
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        //$pdf->Cell(12, 6, $flag, 0, 0, "L");
        if ($yFin < 190 && $flag == 0) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
        //semana 14
        $x14 = $pdf->GetX();
        $y14 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s14_titulo'] . " del " . $row['s14_rangoi'] . " hasta \n" . $row['s14_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont14 = $row['s14_contenidos'];
        $cleanedCont14 = preg_replace("/\n\s*\n/", "\n", trim($cont14));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont14, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s14_fecharegistro'] == " " || $row['s14_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s14_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s14_horaregistro'] == " " || $row['s14_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s14_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s14_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des14 = $row['s14_descripcion'];
        $cleanedDes14 = preg_replace("/\n\s*\n/", "\n", trim($des14));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes14, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s14_justifica_nov'] == " " || $row['s14_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s14_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s14_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s14_fechanovedad'] == " " || $row['s14_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s14_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s14_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s14_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s14_tiponovedad'] == " " || $row['s14_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s14_fechareprog1'] == " " || $row['s14_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s14_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s14_fechareprog2'] == " " || $row['s14_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s14_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s14_estadoregistro'] == " " || $row['s14_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s14_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }

        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        //$pdf->Cell(12, 6, $yFin, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines1, 0, 0, "L");
        //$pdf->Cell(12, 6, $endY3, 0, 0, "L");
        $flag = 0;
        if ($yFin > 180) {
            $pdf->AddPage();
            $pdf->Ln(3);
            $flag = 1;
        } else {
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        //$pdf->Cell(12, 6, $flag, 0, 0, "L");
        if ($yFin < 190 && $flag == 0) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
        //semana 15
        $x15 = $pdf->GetX();
        $y15 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s15_titulo'] . " del " . $row['s15_rangoi'] . " hasta \n" . $row['s15_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont15 = $row['s15_contenidos'];
        $cleanedCont15 = preg_replace("/\n\s*\n/", "\n", trim($cont15));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont15, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s15_fecharegistro'] == " " || $row['s15_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s15_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s15_horaregistro'] == " " || $row['s15_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s15_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s15_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des15 = $row['s15_descripcion'];
        $cleanedDes15 = preg_replace("/\n\s*\n/", "\n", trim($des15));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes15, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s15_justifica_nov'] == " " || $row['s15_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s15_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s15_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s15_fechanovedad'] == " " || $row['s15_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s15_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s15_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s15_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s15_tiponovedad'] == " " || $row['s15_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s15_fechareprog1'] == " " || $row['s15_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s15_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s15_fechareprog2'] == " " || $row['s15_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s15_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s15_estadoregistro'] == " " || $row['s15_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s15_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }

        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        // $pdf->Cell(12, 6, $endY1, 0, 0, "L");
        // $pdf->Cell(12, 6, $ylines1, 0, 0, "L");
        //$pdf->Cell(12, 6, $endY3, 0, 0, "L");
        $flag = 0;
        if ($yFin > 180) {
            $pdf->AddPage();
            $flag = 1;
        } else {
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        //$pdf->Cell(12, 6, $flag, 0, 0, "L");
        if ($yFin < 190 && $flag == 0) {
            realizarSalto($ylines, $ylines3, $pdf);
        }

        //semana 16
        $x16 = $pdf->GetX();
        $y16 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s16_titulo'] . " del " . $row['s16_rangoi'] . " hasta \n" . $row['s16_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont16 = $row['s16_contenidos'];
        $cleanedCont16 = preg_replace("/\n\s*\n/", "\n", trim($cont16));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont16, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s16_fecharegistro'] == " " || $row['s16_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s16_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s16_horaregistro'] == " " || $row['s16_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s16_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s16_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des16 = $row['s16_descripcion'];
        $cleanedDes16 = preg_replace("/\n\s*\n/", "\n", trim($des16));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes16, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s16_justifica_nov'] == " " || $row['s16_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s16_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s16_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s16_fechanovedad'] == " " || $row['s16_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s16_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s16_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s16_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s16_tiponovedad'] == " " || $row['s16_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s16_fechareprog1'] == " " || $row['s16_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s16_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s16_fechareprog2'] == " " || $row['s16_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s16_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s16_estadoregistro'] == " " || $row['s16_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s16_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }

        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        if ($yFin > 180) {
            $pdf->AddPage();
            //$pdf->Ln(3);

        } else {
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
        //semana 17
        $x17 = $pdf->GetX();
        $y17 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s17_titulo'] . " del " . $row['s17_rangoi'] . " hasta \n" . $row['s17_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont17 = $row['s17_contenidos'];
        $cleanedCont17 = preg_replace("/\n\s*\n/", "\n", trim($cont17));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont17, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s17_fecharegistro'] == " " || $row['s17_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s17_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s17_horaregistro'] == " " || $row['s17_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s17_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s17_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des17 = $row['s17_descripcion'];
        $cleanedDes17 = preg_replace("/\n\s*\n/", "\n", trim($des17));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes17, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s17_justifica_nov'] == " " || $row['s17_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s17_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s17_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s17_fechanovedad'] == " " || $row['s17_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s17_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s17_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s17_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s17_tiponovedad'] == " " || $row['s17_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s17_fechareprog1'] == " " || $row['s17_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s17_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s17_fechareprog2'] == " " || $row['s17_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s17_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s17_estadoregistro'] == " " || $row['s17_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s17_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }

        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        if ($yFin > 180) {
            $pdf->AddPage();
            //$pdf->Ln(3);

        } else {
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
        //semana 18
        $x18 = $pdf->GetX();
        $y18 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s18_titulo'] . " del " . $row['s18_rangoi'] . " hasta \n" . $row['s18_rangof'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont18 = $row['s18_contenidos'];
        $cleanedCont18 = preg_replace("/\n\s*\n/", "\n", trim($cont18));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont18, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s18_fecharegistro'] == " " || $row['s18_fecharegistro'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s18_fecharegistro'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s18_horaregistro'] == " " || $row['s18_horaregistro'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s18_horaregistro'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s18_tipoactividad'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des18 = $row['s18_descripcion'];
        $cleanedDes18 = preg_replace("/\n\s*\n/", "\n", trim($des18));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes18, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s18_justifica_nov'] == " " || $row['s18_justifica_nov'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s18_justifica_reprog'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s18_justifica_nov'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s18_fechanovedad'] == " " || $row['s18_fechanovedad'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s18_fechanovedad'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s18_tiponovedad'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s18_tiponovedad'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s18_tiponovedad'] == " " || $row['s18_tiponovedad'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s18_fechareprog1'] == " " || $row['s18_fechareprog1'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s18_fechareprog1'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s18_fechareprog2'] == " " || $row['s18_fechareprog2'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s18_fechareprog2'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s18_estadoregistro'] == " " || $row['s18_estadoregistro'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s18_estadoregistro'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }

        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        if ($yFin > 180) {
            $pdf->AddPage();
            //$pdf->Ln(3);

        } else {
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
    } else {

        $pdf = new PDF("L", "mm", "Letter");
        $pdf->setHeaderData($obj2);
        $pdf->setFooterData($obj);
        $pdf->SetTitle("Formato Registro de Actividades");
        $pdf->AddPage();
        $bottomMargin = 20; // Espacio reservado para el footer
        $pageHeight = 216;  // Altura total de la página Letter en mm (216 x 279)
        $pdf->Ln(3);
        //semana 1
        $x1 = $pdf->GetX();
        $y1 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s1_titulo_p'] . " del " . $row['s1_rangoi_p'] . " hasta \n" . $row['s1_rangof_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont1 = $row['s1_contenidos_p'];
        $cleanedCont1 = preg_replace("/\n\s*\n/", "\n", trim($cont1));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont1, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s1_fecharegistro_p'] == " " || $row['s1_fecharegistro_p'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s1_fecharegistro_p'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s1_horaregistro_p'] == " " || $row['s1_horaregistro_p'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s1_horaregistro_p'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s1_tipoactividad_p'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des1 = $row['s1_descripcion_p'];
        $cleanedDes1 = preg_replace("/\n\s*\n/", "\n", trim($des1));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes1, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s1_justifica_nov_p'] == " " || $row['s1_justifica_nov_p'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s1_justifica_reprog_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s1_justifica_nov_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s1_fechanovedad_p'] == " " || $row['s1_fechanovedad_p'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s1_fechanovedad_p'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s1_tiponovedad_p'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s1_tiponovedad_p'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s1_tiponovedad_p'] == " " || $row['s1_tiponovedad_p'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s1_fechareprog1_p'] == " " || $row['s1_fechareprog1_p'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s1_fechareprog1_p'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s1_fechareprog2_p'] == " " || $row['s1_fechareprog2_p'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s1_fechareprog2_p'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s1_estadoregistro_p'] == " " || $row['s1_estadoregistro_p'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s1_estadoregistro_p'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }
        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }

        //semana 2
        $x2 = $pdf->GetX();
        $y2 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s2_titulo_p'] . " del " . $row['s2_rangoi_p'] . " hasta \n" . $row['s2_rangof_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont2 = $row['s2_contenidos_p'];
        $cleanedCont2 = preg_replace("/\n\s*\n/", "\n", trim($cont2));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont2, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s2_fecharegistro_p'] == " " || $row['s2_fecharegistro_p'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s2_fecharegistro_p'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s2_horaregistro_p'] == " " || $row['s2_horaregistro_p'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s2_horaregistro_p'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s2_tipoactividad_p'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des2 = $row['s2_descripcion_p'];
        $cleanedDes2 = preg_replace("/\n\s*\n/", "\n", trim($des2));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes2, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s2_justifica_nov_p'] == " " || $row['s2_justifica_nov_p'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s2_justifica_reprog_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s2_justifica_nov_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s2_fechanovedad_p'] == " " || $row['s2_fechanovedad_p'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s2_fechanovedad_p'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s2_tiponovedad_p'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s2_tiponovedad_p'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s2_tiponovedad_p'] == " " || $row['s2_tiponovedad_p'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s2_fechareprog1_p'] == " " || $row['s2_fechareprog1_p'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s2_fechareprog1_p'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s2_fechareprog2_p'] == " " || $row['s2_fechareprog2_p'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s2_fechareprog2_p'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s2_estadoregistro_p'] == " " || $row['s2_estadoregistro_p'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s2_estadoregistro_p'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }

        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }

        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
        //semana 3
        $x3 = $pdf->GetX();
        $y3 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s3_titulo_p'] . " del " . $row['s3_rangoi_p'] . " hasta \n" . $row['s3_rangof_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont3 = $row['s3_contenidos_p'];
        $cleanedCont3 = preg_replace("/\n\s*\n/", "\n", trim($cont3));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont3, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s3_fecharegistro_p'] == " " || $row['s3_fecharegistro_p'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s3_fecharegistro_p'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s3_horaregistro_p'] == " " || $row['s3_horaregistro_p'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s3_horaregistro_p'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s3_tipoactividad_p'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des3 = $row['s3_descripcion_p'];
        $cleanedDes3 = preg_replace("/\n\s*\n/", "\n", trim($des3));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes3, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s3_justifica_nov_p'] == " " || $row['s3_justifica_nov_p'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s3_justifica_reprog_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s3_justifica_nov_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s3_fechanovedad_p'] == " " || $row['s3_fechanovedad_p'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s3_fechanovedad_p'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s3_tiponovedad_p'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s3_tiponovedad_p'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s3_tiponovedad_p'] == " " || $row['s3_tiponovedad_p'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s3_fechareprog1_p'] == " " || $row['s3_fechareprog1_p'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s3_fechareprog1_p'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s3_fechareprog2_p'] == " " || $row['s3_fechareprog2_p'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s3_fechareprog2_p'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s3_estadoregistro_p'] == " " || $row['s3_estadoregistro_p'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s3_estadoregistro_p'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }

        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }

        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
        //semana 4
        $x4 = $pdf->GetX();
        $y4 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s4_titulo_p'] . " del " . $row['s4_rangoi_p'] . " hasta \n" . $row['s4_rangof_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont4 = $row['s4_contenidos_p'];
        $cleanedCont4 = preg_replace("/\n\s*\n/", "\n", trim($cont4));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont4, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s4_fecharegistro_p'] == " " || $row['s4_fecharegistro_p'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s4_fecharegistro_p'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s4_horaregistro_p'] == " " || $row['s4_horaregistro_p'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s4_horaregistro_p'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s4_tipoactividad_p'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des4 = $row['s4_descripcion_p'];
        $cleanedDes4 = preg_replace("/\n\s*\n/", "\n", trim($des4));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes4, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s4_justifica_nov_p'] == " " || $row['s4_justifica_nov_p'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s4_justifica_reprog_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s4_justifica_nov_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s4_fechanovedad_p'] == " " || $row['s4_fechanovedad_p'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s4_fechanovedad_p'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s4_tiponovedad_p'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s4_tiponovedad_p'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s4_tiponovedad_p'] == " " || $row['s4_tiponovedad_p'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s4_fechareprog1_p'] == " " || $row['s4_fechareprog1_p'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s4_fechareprog1_p'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s4_fechareprog2_p'] == " " || $row['s4_fechareprog2_p'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s4_fechareprog2_p'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s4_estadoregistro_p'] == " " || $row['s4_estadoregistro_p'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s4_estadoregistro_p'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }
        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        $pdf->checkPageBreak($bottomMargin, $yFin);
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
        //semana 5
        $x5 = $pdf->GetX();
        $y5 = $pdf->GetY();
        $pdf->SetFont("Arial", "", 6);
        $y = $pdf->GetY();
        $pdf->MultiCell(20, 2, mb_convert_encoding($row['s5_titulo_p'] . " del " . $row['s5_rangoi_p'] . " hasta \n" . $row['s5_rangof_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        $pdf->SetXY(30, $y);
        $cont5 = $row['s5_contenidos_p'];
        $cleanedCont5 = preg_replace("/\n\s*\n/", "\n", trim($cont5));
        $startY1 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedCont5, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX1 = $pdf->GetX();
        $endY1 = $pdf->GetY();
        $ylines1 = $endY1 - $startY1;
        if ($ylines1 == 2) {
            $endY1 = $endY1 + 4;
        }
        if ($ylines1 == 4) {
            $endY1 = $endY1 + 2;
        }
        $pdf->SetXY(80, $y);
        if ($row['s5_fecharegistro_p'] == " " || $row['s5_fecharegistro_p'] == null) {
            $pdf->Cell(12, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(12, 6, date("d-m-Y", strtotime($row['s5_fecharegistro_p'])), 0, 0, "L");
        }
        $pdf->SetXY(92, $y);
        if ($row['s5_horaregistro_p'] == " " || $row['s5_horaregistro_p'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("h:i:sa", strtotime($row['s5_horaregistro_p'])), 0, 0, "L");
        }
        $pdf->SetXY(105, $y);
        $pdf->Cell(10, 6, mb_convert_encoding($row['s5_tipoactividad_p'], 'ISO-8859-1'), 0, 0, "L");
        $pdf->SetXY(115, $y);
        $des5 = $row['s5_descripcion_p'];
        $cleanedDes5 = preg_replace("/\n\s*\n/", "\n", trim($des5));
        $startY2 = $pdf->GetY();
        $pdf->MultiCell(50, 2, mb_convert_encoding($cleanedDes5, 'ISO-8859-1'), 0, 'J', 0, 4);
        $endX2 = $pdf->GetX();
        $endY2 = $pdf->GetY();
        $ylines2 = $endY2 - $startY2;
        if ($ylines2 == 2) {
            $endY2 = $endY2 + 4;
        }
        if ($ylines2 == 4) {
            $endY2 = $endY2 + 2;
        }
        $pdf->SetXY(165, $y);
        if ($row['s5_justifica_nov_p'] == " " || $row['s5_justifica_nov_p'] == null) {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s5_justifica_reprog_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        } else {
            $pdf->MultiCell(30, 2, mb_convert_encoding($row['s5_justifica_nov_p'], 'ISO-8859-1'), 0, 'J', 0, 4);
        }
        $pdf->SetXY(195, $y);
        if ($row['s5_fechanovedad_p'] == " " || $row['s5_fechanovedad_p'] == null) {
            $pdf->Cell(15, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(15, 6, date("d-m-Y", strtotime($row['s5_fechanovedad_p'])), 0, 0, "L");
        }
        $pdf->SetXY(208, $y);
        if ($row['s5_tiponovedad_p'] == 'Fueradefecha') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        } else if ($row['s5_tiponovedad_p'] == 'Reprogramacion') {
            $startY3 = $pdf->GetY();
            $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0, 'J', 0, 4);
            $endX3 = $pdf->GetX();
            $endY3 = $pdf->GetY();
            $ylines3 = $endY3 - $startY3;
        }
        if ($row['s5_tiponovedad_p'] == " " || $row['s5_tiponovedad_p'] == null) {
            $ylines3 = 0;
        }
        $pdf->SetXY(228, $y);
        if ($row['s5_fechareprog1_p'] == " " || $row['s5_fechareprog1_p'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s5_fechareprog1_p'])), 0, 0, "L");
        }
        $pdf->SetXY(240, $y);
        if ($row['s5_fechareprog2_p'] == " " || $row['s5_fechareprog2_p'] == null) {
            $pdf->Cell(10, 6, " ", 0, 0, "L");
        } else {
            $pdf->Cell(10, 6, date("d-m-Y", strtotime($row['s5_fechareprog2_p'])), 0, 0, "L");
        }
        $pdf->SetXY(251, $y);
        if ($row['s5_estadoregistro_p'] == " " || $row['s5_estadoregistro_p'] == null) {
            $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0, 'C', 0, 4);
        } else {
            $pdf->MultiCell(15, 2, mb_convert_encoding($row['s5_estadoregistro_p'], 'ISO-8859-1'), 0, 'C', 0, 4);
        }

        if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
            $pdf->line($endX1, $endY1, 270, $endY1);
            $yFin = $endY1;
            $ylines = $ylines1;
        } elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
            $pdf->line($endX2, $endY2, 270, $endY2);
            $yFin = $endY2;
            $ylines = $ylines2;
        } else {
            $pdf->line($endX3, $endY3, 270, $endY3);
            $yFin = $endY3;
            $ylines = $ylines3;
        }
        if ($yFin > 180) {
            $pdf->AddPage();
            //$pdf->Ln(3);

        } else {
            $pdf->checkPageBreak($bottomMargin, $yFin);
        }
        if ($yFin < 190) {
            realizarSalto($ylines, $ylines3, $pdf);
        }
    }
}
$pdf->Output('I', 'reporte_registro_actividades_.pdf');
