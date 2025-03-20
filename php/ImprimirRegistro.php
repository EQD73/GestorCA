<?php

session_start();

require "conexion.php";
require "../fpdf/fpdf.php"; 

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

$tablam3 =$_SESSION['tablam3'];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
}
$codigoConsulta = $id;

//iso formato
$m="m3";
$sql2= "SELECT * FROM version_formato WHERE nombre_formato='$m'";
$result2= pg_query($conexion,$sql2);
$obj2=pg_fetch_object($result2);

$sql1= "SELECT * FROM $tablam3 WHERE id ='$codigoConsulta'";
$resultado= pg_query($conexion,$sql1);
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
        $this->Cell(60, 21, $this->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
        $this->SetFont("Arial", "B", 12);
        $this->rect(10,10, 260, 21);
        $this->Cell(160, 14, mb_convert_encoding("REGISTRO DE ACTIVIDADES ACADEMICAS POR DOCENTE", 'ISO-8859-1'), 1, 0, "C");
        $this->SetFont("Arial", "", 9);
        $this->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
        $this->Cell(25, 7, mb_convert_encoding($this->headerData->codigo, 'ISO-8859-1'), 1, 1, "L");
        $this->Cell(220);
        $this->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
        $this->Cell(25, 7, mb_convert_encoding($this->headerData->version, 'ISO-8859-1'), 1, 1, "L");
        $this->Cell(60);
        $this->SetFont("Arial", "", 12);
        $this->Cell(160, 7, mb_convert_encoding("DOCENTE:"." ".$this->footerData->nombre_docente,'ISO-8859-1'), 0, 0, "C");
        $this->SetFont("Arial", "", 9);
        $this->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
        $this->Cell(25, 7, mb_convert_encoding($this->headerData->fecha, 'ISO-8859-1'), 1, 1, "L");
        $this->SetFont("Arial", "B", 9);
        $this->SetFillColor(181,178,178);
        $this->SetTextColor(0,0,0);
        $this->Cell(260, 5, mb_convert_encoding("Datos Principales", 'ISO-8859-1'), 1, 1, "C", true);
        $this->SetFont("Arial", "", 9);
        $this->SetTextColor(0,0,0);
        $this->rect(10,36, 260, 10);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(30, 5, mb_convert_encoding("ASIGNATURA:",'ISO-8859-1'), 0, 0, "L");
        $this->SetFont("Arial", "", 10);
        $this->Cell(20, 5, mb_convert_encoding($this->footerData->codigo_asignatura, 'ISO-8859-1'), 0, 0, "L");
        $this->Cell(140, 5, mb_convert_encoding($this->footerData->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
        $this->SetFont("Arial", "B", 10);
        $this->Cell(20, 5, mb_convert_encoding("GRUPO:",'ISO-8859-1'), 0, 0, "L");
        $this->SetFont("Arial", "", 10);
        $this->Cell(10, 5, mb_convert_encoding($this->footerData->grupo, 'ISO-8859-1'), 0, 0, "L");
        $this->Cell(30, 5, mb_convert_encoding("SEMESTRE:",'ISO-8859-1'), 0, 0, "L");
        $this->SetFont("Arial", "", 10);
        $this->Cell(10, 5, mb_convert_encoding($this->footerData->semestre, 'ISO-8859-1'), 0, 1, "L");
        $this->SetFont("Arial", "B", 10);
        $this->Cell(30, 5, mb_convert_encoding("PROGRAMA:",'ISO-8859-1'), 0, 0, "L");
        $this->SetFont("Arial", "", 10);
        $this->Cell(230, 5, mb_convert_encoding($this->footerData->nombre_programa, 'ISO-8859-1'), 0, 1, "L");
        $this->SetFont("Arial", "B", 6);
        $this->SetLineWidth(0.5);
        $this->line(10,56, 270, 56);
        $this->Cell(210);
        $this->SetFont("Arial", "B", 6);
        $this->Cell(40, 4, mb_convert_encoding("REPROGRAMACION",'ISO-8859-1'), 0, 1, "C");
        $this->SetFont("Arial", "B", 6);
        $y = $this->GetY();
        $this->Cell(20, 5, mb_convert_encoding("SEMANA",'ISO-8859-1'), 0, 0, "L");
        $this->Cell(50, 5, mb_convert_encoding("CONTENIDOS",'ISO-8859-1'), 0, 0, "L");
        $this->MultiCell(14, 3, mb_convert_encoding("FECHA \n"."REGISTRO",'ISO-8859-1'), 0,"C",0);
        $this->SetXY(92,$y);
        $this->MultiCell(14, 3, mb_convert_encoding("HORA \n"."REGISTRO",'ISO-8859-1'), 0,"C",0);
        $this->SetXY(104,$y);
        $this->MultiCell(15, 3, mb_convert_encoding("TIPO \n"."ACTIVIDAD",'ISO-8859-1'), 0, "C",0);
        $this->SetXY(119,$y);
        $this->MultiCell(40, 3, mb_convert_encoding("DESCRIPCION \n"."ACTIVIDAD",'ISO-8859-1'), 0, "C",0);
        $this->SetXY(168,$y);
        $this->Cell(14, 4, mb_convert_encoding("JUSTIFICACIÓN",'ISO-8859-1'), 0, 0, "C");
        $this->SetXY(182,$y);
        $this->MultiCell(40, 3, mb_convert_encoding("FECHA \n"."NOVEDAD",'ISO-8859-1'), 0, "C",0);
        $this->SetXY(208,$y);
        $this->MultiCell(20, 3, mb_convert_encoding("TIPO \n"."NOVEDAD",'ISO-8859-1'), 0, "C",0);
        $this->SetFont("Arial", "B", 6);
        $this->SetXY(225,$y);
        $this->MultiCell(20, 3, mb_convert_encoding("FECHA \n"."1",'ISO-8859-1'), 0,"C",0);
        $this->SetXY(235,$y);
        $this->MultiCell(20, 3, mb_convert_encoding("FECHA \n"."2",'ISO-8859-1'), 0, "C", 0);
        $this->SetFont("Arial", "B", 7);
        $this->SetXY(252,$y);
        $this->Cell(15, 4, mb_convert_encoding("ESTADO",'ISO-8859-1'), 0, 1, "L");
        date_default_timezone_set("America/Bogota");
    }

    //Pie de página
    function Footer() {
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
        $this->Cell(80, 5, mb_convert_encoding($this->footerData->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
        $this->Cell(0, 5, mb_convert_encoding('Página ', 'ISO-8859-1') . $this->PageNo() . '/{nb}', 0, 0, "R");
    }

    // Función para controlar el salto de página
    public function checkPageBreak($bottomMargin, $yFin) {
        $pageHeight = $this->GetPageHeight(); // Obtiene la altura de la página
        //if ($this->GetY() > ($pageHeight - $bottomMargin)) {
            //if ($yFin > ($pageHeight - $bottomMargin)) {
        if ($yFin > (210 - $bottomMargin)) {
            $this->AddPage();
            $this->Ln(3);
        }
    }
}


if ($obj->codigo_programa <> "26" && $obj->codigo_programa <> "30" && $obj->codigo_programa <> "31" && $obj->codigo_programa <> "32") {

$pdf= new PDF("L","mm", "Letter");
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
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s1_titulo." del ".$obj->s1_rangoi." hasta \n".$obj->s1_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont1 = $obj->s1_contenidos;
$cleanedCont1 = preg_replace("/\n\s*\n/", "\n", trim($cont1));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont1, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s1_fecharegistro==" " || $obj->s1_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s1_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s1_horaregistro==" " || $obj->s1_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s1_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s1_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des1 = $obj->s1_descripcion;
$cleanedDes1 = preg_replace("/\n\s*\n/", "\n", trim($des1));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes1, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s1_justifica_nov==" " || $obj->s1_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s1_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s1_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s1_fechanovedad==" " || $obj->s1_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s1_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s1_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();    
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s1_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s1_tiponovedad==" " || $obj->s1_tiponovedad==null){
    $ylines3 = 0;
}    
$pdf->SetXY(228,$y);
if ($obj->s1_fechareprog1==" " || $obj->s1_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s1_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s1_fechareprog2==" " || $obj->s1_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s1_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s1_estadoregistro==" " || $obj->s1_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s1_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
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
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s2_titulo." del ".$obj->s2_rangoi." hasta \n".$obj->s2_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont2 = $obj->s2_contenidos;
$cleanedCont2 = preg_replace("/\n\s*\n/", "\n", trim($cont2));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont2, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s2_fecharegistro==" " || $obj->s2_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s2_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s2_horaregistro==" " || $obj->s2_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s2_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s2_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des2 = $obj->s2_descripcion;
$cleanedDes2 = preg_replace("/\n\s*\n/", "\n", trim($des2));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes2, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s2_justifica_nov==" " || $obj->s2_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s2_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s2_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s2_fechanovedad==" " || $obj->s2_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s2_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s2_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s2_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s2_tiponovedad==" " || $obj->s2_tiponovedad==null){
    $ylines3 = 0;
}    
$pdf->SetXY(228,$y);
if ($obj->s2_fechareprog1==" " || $obj->s2_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s2_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s2_fechareprog2==" " || $obj->s2_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s2_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s2_estadoregistro==" " || $obj->s2_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s2_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}

if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
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
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s3_titulo." del ".$obj->s3_rangoi." hasta \n".$obj->s3_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont3 = $obj->s3_contenidos;
$cleanedCont3 = preg_replace("/\n\s*\n/", "\n", trim($cont3));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont3, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s3_fecharegistro==" " || $obj->s3_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s3_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s3_horaregistro==" " || $obj->s3_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s3_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s3_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des3 = $obj->s3_descripcion;
$cleanedDes3 = preg_replace("/\n\s*\n/", "\n", trim($des3));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes3, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s3_justifica_nov==" " || $obj->s3_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s3_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s3_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s3_fechanovedad==" " || $obj->s3_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s3_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s3_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s3_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s3_tiponovedad==" " || $obj->s3_tiponovedad==null){
    $ylines3 = 0;
}    
$pdf->SetXY(228,$y);
if ($obj->s3_fechareprog1==" " || $obj->s3_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s3_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s3_fechareprog2==" " || $obj->s3_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s3_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s3_estadoregistro==" " || $obj->s3_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s3_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}

if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
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
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s4_titulo." del ".$obj->s4_rangoi." hasta \n".$obj->s4_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont4 = $obj->s4_contenidos;
$cleanedCont4 = preg_replace("/\n\s*\n/", "\n", trim($cont4));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont4, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s4_fecharegistro==" " || $obj->s4_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s4_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s4_horaregistro==" " || $obj->s4_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s4_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s4_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des4 = $obj->s4_descripcion;
$cleanedDes4 = preg_replace("/\n\s*\n/", "\n", trim($des4));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes4, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s4_justifica_nov==" " || $obj->s4_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s4_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s4_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s4_fechanovedad==" " || $obj->s4_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s4_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s4_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s4_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s4_tiponovedad==" " || $obj->s4_tiponovedad==null){
    $ylines3 = 0;
}    
$pdf->SetXY(228,$y);
if ($obj->s4_fechareprog1==" " || $obj->s4_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s4_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s4_fechareprog2==" " || $obj->s4_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s4_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s4_estadoregistro==" " || $obj->s4_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s4_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
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
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s5_titulo." del ".$obj->s5_rangoi." hasta \n".$obj->s5_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont5 = $obj->s5_contenidos;
$cleanedCont5 = preg_replace("/\n\s*\n/", "\n", trim($cont5));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont5, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s5_fecharegistro==" " || $obj->s5_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s5_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s5_horaregistro==" " || $obj->s5_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s5_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s5_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des5 = $obj->s5_descripcion;
$cleanedDes5 = preg_replace("/\n\s*\n/", "\n", trim($des5));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes5, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s5_justifica_nov==" " || $obj->s5_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s5_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s5_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s5_fechanovedad==" " || $obj->s5_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s5_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s5_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s5_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s5_tiponovedad==" " || $obj->s5_tiponovedad==null){
    $ylines3 = 0;
}    
$pdf->SetXY(228,$y);
if ($obj->s5_fechareprog1==" " || $obj->s5_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s5_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s5_fechareprog2==" " || $obj->s5_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s5_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s5_estadoregistro==" " || $obj->s5_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s5_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
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
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s6_titulo." del ".$obj->s6_rangoi." hasta \n".$obj->s6_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont6 = $obj->s6_contenidos;
$cleanedCont6 = preg_replace("/\n\s*\n/", "\n", trim($cont6));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont6, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s6_fecharegistro==" " || $obj->s6_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s6_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s6_horaregistro==" " || $obj->s6_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s6_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s6_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des6 = $obj->s6_descripcion;
$cleanedDes6 = preg_replace("/\n\s*\n/", "\n", trim($des6));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes6, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s6_justifica_nov==" " || $obj->s6_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s6_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s6_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s6_fechanovedad==" " || $obj->s6_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s6_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s6_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s6_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s6_tiponovedad==" " || $obj->s6_tiponovedad==null){
    $ylines3 = 0;
}   
$pdf->SetXY(228,$y);
if ($obj->s6_fechareprog1==" " || $obj->s6_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s6_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s6_fechareprog2==" " || $obj->s6_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s6_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s6_estadoregistro==" " || $obj->s6_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s6_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}

if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
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
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s7_titulo." del ".$obj->s7_rangoi." hasta \n".$obj->s7_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont7 = $obj->s7_contenidos;
$cleanedCont7 = preg_replace("/\n\s*\n/", "\n", trim($cont7));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont7, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s7_fecharegistro==" " || $obj->s7_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s7_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s7_horaregistro==" " || $obj->s7_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s7_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s7_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des7 = $obj->s7_descripcion;
$cleanedDes7 = preg_replace("/\n\s*\n/", "\n", trim($des7));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes7, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s7_justifica_nov==" " || $obj->s7_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s7_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s7_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s7_fechanovedad==" " || $obj->s7_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s7_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s7_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s7_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s7_tiponovedad==" " || $obj->s7_tiponovedad==null){
    $ylines3 = 0;
}   
$pdf->SetXY(228,$y);
if ($obj->s7_fechareprog1==" " || $obj->s7_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s7_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s7_fechareprog2==" " || $obj->s7_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s7_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s7_estadoregistro==" " || $obj->s7_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s7_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}

if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
    
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
    
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
    
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
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s8_titulo." del ".$obj->s8_rangoi." hasta \n".$obj->s8_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont8 = $obj->s8_contenidos;
$cleanedCont8 = preg_replace("/\n\s*\n/", "\n", trim($cont8));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont8, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s8_fecharegistro==" " || $obj->s8_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s8_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s8_horaregistro==" " || $obj->s8_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s8_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s8_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des8 = $obj->s8_descripcion;
$cleanedDes8 = preg_replace("/\n\s*\n/", "\n", trim($des8));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes8, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s8_justifica_nov==" " || $obj->s8_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s8_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s8_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s8_fechanovedad==" " || $obj->s8_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s8_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s8_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s8_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s8_tiponovedad==" " || $obj->s8_tiponovedad==null){
    $ylines3 = 0;
}   
$pdf->SetXY(228,$y);
if ($obj->s8_fechareprog1==" " || $obj->s8_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s8_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s8_fechareprog2==" " || $obj->s8_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s8_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s8_estadoregistro==" " || $obj->s8_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s8_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
    
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
    
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
    
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
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s9_titulo." del ".$obj->s9_rangoi." hasta \n".$obj->s9_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont9 = $obj->s9_contenidos;
$cleanedCont9 = preg_replace("/\n\s*\n/", "\n", trim($cont9));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont9, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s9_fecharegistro==" " || $obj->s9_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s9_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s9_horaregistro==" " || $obj->s9_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s9_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s9_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des9 = $obj->s9_descripcion;
$cleanedDes9 = preg_replace("/\n\s*\n/", "\n", trim($des9));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes9, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s9_justifica_nov==" " || $obj->s9_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s9_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s9_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s9_fechanovedad==" " || $obj->s9_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s9_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s9_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s9_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s9_tiponovedad==" " || $obj->s9_tiponovedad==null){
    $ylines3 = 0;
}   
$pdf->SetXY(228,$y);
if ($obj->s9_fechareprog1==" " || $obj->s9_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s9_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s9_fechareprog2==" " || $obj->s9_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s9_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s9_estadoregistro==" " || $obj->s9_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s9_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}

if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
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
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s10_titulo." del ".$obj->s10_rangoi." hasta \n".$obj->s10_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont10 = $obj->s10_contenidos;
$cleanedCont10 = preg_replace("/\n\s*\n/", "\n", trim($cont10));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont10, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s10_fecharegistro==" " || $obj->s10_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s10_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s10_horaregistro==" " || $obj->s10_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s10_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s10_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des10 = $obj->s10_descripcion;
$cleanedDes10 = preg_replace("/\n\s*\n/", "\n", trim($des10));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes10, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s10_justifica_nov==" " || $obj->s10_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s10_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s10_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s10_fechanovedad==" " || $obj->s10_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s10_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s8_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s10_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s10_tiponovedad==" " || $obj->s10_tiponovedad==null){
    $ylines3 = 0;
}  
$pdf->SetXY(228,$y);
if ($obj->s10_fechareprog1==" " || $obj->s10_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s10_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s10_fechareprog2==" " || $obj->s10_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s10_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s10_estadoregistro==" " || $obj->s10_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s10_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}

if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
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
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s11_titulo." del ".$obj->s11_rangoi." hasta \n".$obj->s11_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont11 = $obj->s11_contenidos;
$cleanedCont11 = preg_replace("/\n\s*\n/", "\n", trim($cont11));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont11, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s11_fecharegistro==" " || $obj->s11_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s11_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s11_horaregistro==" " || $obj->s11_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s11_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s11_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des11 = $obj->s11_descripcion;
$cleanedDes11 = preg_replace("/\n\s*\n/", "\n", trim($des11));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes11, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s11_justifica_nov==" " || $obj->s11_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s11_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s11_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s11_fechanovedad==" " || $obj->s11_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s11_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s8_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s11_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s11_tiponovedad==" " || $obj->s11_tiponovedad==null){
    $ylines3 = 0;
}  
$pdf->SetXY(228,$y);
if ($obj->s11_fechareprog1==" " || $obj->s11_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s11_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s11_fechareprog2==" " || $obj->s11_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s11_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s11_estadoregistro==" " || $obj->s11_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s11_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}

if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
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
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s12_titulo." del ".$obj->s12_rangoi." hasta \n".$obj->s12_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont12 = $obj->s12_contenidos;
$cleanedCont12 = preg_replace("/\n\s*\n/", "\n", trim($cont12));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont12, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s12_fecharegistro==" " || $obj->s12_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s12_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s12_horaregistro==" " || $obj->s12_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s12_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s12_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des12 = $obj->s12_descripcion;
$cleanedDes12 = preg_replace("/\n\s*\n/", "\n", trim($des12));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes12, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s12_justifica_nov==" " || $obj->s12_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s12_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s12_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s12_fechanovedad==" " || $obj->s12_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s12_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s8_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s12_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s12_tiponovedad==" " || $obj->s12_tiponovedad==null){
    $ylines3 = 0;
}  
$pdf->SetXY(228,$y);
if ($obj->s12_fechareprog1==" " || $obj->s12_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s12_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s12_fechareprog2==" " || $obj->s12_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s12_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s12_estadoregistro==" " || $obj->s12_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s12_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
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
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s13_titulo." del ".$obj->s13_rangoi." hasta \n".$obj->s13_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont13 = $obj->s13_contenidos;
$cleanedCont13 = preg_replace("/\n\s*\n/", "\n", trim($cont13));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont13, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s13_fecharegistro==" " || $obj->s13_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s13_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s13_horaregistro==" " || $obj->s13_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s13_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s13_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des13 = $obj->s13_descripcion;
$cleanedDes13 = preg_replace("/\n\s*\n/", "\n", trim($des13));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes13, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s13_justifica_nov==" " || $obj->s13_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s13_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s13_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s13_fechanovedad==" " || $obj->s13_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s13_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s8_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s13_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s13_tiponovedad==" " || $obj->s13_tiponovedad==null){
    $ylines3 = 0;
}  
$pdf->SetXY(228,$y);
if ($obj->s13_fechareprog1==" " || $obj->s13_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s13_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s13_fechareprog2==" " || $obj->s13_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s13_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s13_estadoregistro==" " || $obj->s13_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s13_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}

if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
}
$flag=0;
if ($yFin > 180) { 
    $pdf->AddPage();
    $pdf->Ln(3);
    $flag=1;

}else{ 
$pdf->checkPageBreak($bottomMargin, $yFin);
}
//$pdf->Cell(12, 6, $flag, 0, 0, "L");
if ($yFin < 190 && $flag==0) { 
     realizarSalto($ylines, $ylines3, $pdf);
}
//semana 14
$x14 = $pdf->GetX();
$y14 = $pdf->GetY();
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s14_titulo." del ".$obj->s14_rangoi." hasta \n".$obj->s14_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont14 = $obj->s14_contenidos;
$cleanedCont14 = preg_replace("/\n\s*\n/", "\n", trim($cont14));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont14, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s14_fecharegistro==" " || $obj->s14_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s14_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s14_horaregistro==" " || $obj->s14_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s14_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s14_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des14 = $obj->s14_descripcion;
$cleanedDes14 = preg_replace("/\n\s*\n/", "\n", trim($des14));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes14, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s14_justifica_nov==" " || $obj->s14_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s14_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s14_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s14_fechanovedad==" " || $obj->s14_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s14_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s8_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s14_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s14_tiponovedad==" " || $obj->s14_tiponovedad==null){
    $ylines3 = 0;
}  
$pdf->SetXY(228,$y);
if ($obj->s14_fechareprog1==" " || $obj->s14_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s14_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s14_fechareprog2==" " || $obj->s14_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s14_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s14_estadoregistro==" " || $obj->s14_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s14_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}

if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
}
//$pdf->Cell(12, 6, $yFin, 0, 0, "L");
// $pdf->Cell(12, 6, $ylines1, 0, 0, "L");
//$pdf->Cell(12, 6, $endY3, 0, 0, "L");
$flag=0;
if ($yFin > 180) { 
    $pdf->AddPage();
    $pdf->Ln(3);
    $flag=1;

}else{ 
$pdf->checkPageBreak($bottomMargin, $yFin);
}
//$pdf->Cell(12, 6, $flag, 0, 0, "L");
if ($yFin < 190 && $flag==0) { 
     realizarSalto($ylines, $ylines3, $pdf);
}
//semana 15
$x15 = $pdf->GetX();
$y15 = $pdf->GetY();
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s15_titulo." del ".$obj->s15_rangoi." hasta \n".$obj->s15_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont15 = $obj->s15_contenidos;
$cleanedCont15 = preg_replace("/\n\s*\n/", "\n", trim($cont15));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont15, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s15_fecharegistro==" " || $obj->s15_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s15_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s15_horaregistro==" " || $obj->s15_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s15_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s15_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des15 = $obj->s15_descripcion;
$cleanedDes15 = preg_replace("/\n\s*\n/", "\n", trim($des15));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes15, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s15_justifica_nov==" " || $obj->s15_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s15_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s15_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s15_fechanovedad==" " || $obj->s15_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s15_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s8_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s15_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s15_tiponovedad==" " || $obj->s15_tiponovedad==null){
    $ylines3 = 0;
}  
$pdf->SetXY(228,$y);
if ($obj->s15_fechareprog1==" " || $obj->s15_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s15_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s15_fechareprog2==" " || $obj->s15_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s15_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s15_estadoregistro==" " || $obj->s15_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s15_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}

if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
}
// $pdf->Cell(12, 6, $endY1, 0, 0, "L");
// $pdf->Cell(12, 6, $ylines1, 0, 0, "L");
//$pdf->Cell(12, 6, $endY3, 0, 0, "L");
$flag=0;
if ($yFin > 180) { 
    $pdf->AddPage();
    $flag=1;

}else{ 
$pdf->checkPageBreak($bottomMargin, $yFin);
}
//$pdf->Cell(12, 6, $flag, 0, 0, "L");
if ($yFin < 190 && $flag==0) { 
     realizarSalto($ylines, $ylines3, $pdf);
}

//semana 16
$x16 = $pdf->GetX();
$y16 = $pdf->GetY();
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s16_titulo." del ".$obj->s16_rangoi." hasta \n".$obj->s16_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont16 = $obj->s16_contenidos;
$cleanedCont16 = preg_replace("/\n\s*\n/", "\n", trim($cont16));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont16, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s16_fecharegistro==" " || $obj->s16_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s16_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s16_horaregistro==" " || $obj->s16_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s16_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s16_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des16 = $obj->s16_descripcion;
$cleanedDes16 = preg_replace("/\n\s*\n/", "\n", trim($des16));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes16, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s16_justifica_nov==" " || $obj->s16_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s16_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s16_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s16_fechanovedad==" " || $obj->s16_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s16_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s8_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s16_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s16_tiponovedad==" " || $obj->s16_tiponovedad==null){
    $ylines3 = 0;
}  
$pdf->SetXY(228,$y);
if ($obj->s16_fechareprog1==" " || $obj->s16_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s16_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s16_fechareprog2==" " || $obj->s16_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s16_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s16_estadoregistro==" " || $obj->s16_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s16_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}

if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
}
if ($yFin > 180) { 
    $pdf->AddPage();
    //$pdf->Ln(3);

}else{ 
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
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s17_titulo." del ".$obj->s17_rangoi." hasta \n".$obj->s17_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont17 = $obj->s17_contenidos;
$cleanedCont17 = preg_replace("/\n\s*\n/", "\n", trim($cont17));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont17, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s17_fecharegistro==" " || $obj->s17_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s17_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s17_horaregistro==" " || $obj->s17_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s17_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s17_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des17 = $obj->s17_descripcion;
$cleanedDes17 = preg_replace("/\n\s*\n/", "\n", trim($des17));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes17, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s17_justifica_nov==" " || $obj->s17_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s17_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s17_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s17_fechanovedad==" " || $obj->s17_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s17_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s8_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s17_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s17_tiponovedad==" " || $obj->s17_tiponovedad==null){
    $ylines3 = 0;
} 
$pdf->SetXY(228,$y);
if ($obj->s17_fechareprog1==" " || $obj->s17_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s17_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s17_fechareprog2==" " || $obj->s17_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s17_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s17_estadoregistro==" " || $obj->s17_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s17_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}

if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
}
if ($yFin > 180) { 
    $pdf->AddPage();
    //$pdf->Ln(3);

}else{ 
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
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s18_titulo." del ".$obj->s18_rangoi." hasta \n".$obj->s18_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$cont18 = $obj->s18_contenidos;
$cleanedCont18 = preg_replace("/\n\s*\n/", "\n", trim($cont18));
$startY1 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedCont18, 'ISO-8859-1'), 0,'J',0,4);
$endX1 = $pdf->GetX();
$endY1 = $pdf->GetY();
$ylines1 = $endY1 - $startY1;
if ($ylines1==2){
    $endY1 = $endY1+4;
}
if ($ylines1==4){
    $endY1 = $endY1+2;
}
$pdf->SetXY(80,$y);
if ($obj->s18_fecharegistro==" " || $obj->s18_fecharegistro==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s18_fecharegistro)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s18_horaregistro==" " || $obj->s18_horaregistro==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s18_horaregistro)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s18_tipoactividad, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$des18 = $obj->s18_descripcion;
$cleanedDes18 = preg_replace("/\n\s*\n/", "\n", trim($des18));
$startY2 = $pdf->GetY();
$pdf->MultiCell(50,2, mb_convert_encoding($cleanedDes18, 'ISO-8859-1'), 0,'J',0,4);
$endX2 = $pdf->GetX();
$endY2 = $pdf->GetY();
$ylines2 = $endY2 - $startY2;
if ($ylines2==2){
    $endY2 = $endY2+4;
}
if ($ylines2==4){
    $endY2 = $endY2+2;
}
$pdf->SetXY(165,$y);
if ($obj->s18_justifica_nov==" " || $obj->s18_justifica_nov==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s18_justifica_reprog, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s18_justifica_nov, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s18_fechanovedad==" " || $obj->s18_fechanovedad==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s18_fechanovedad)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s8_tiponovedad=='Fueradefecha'){ 
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}else if ($obj->s18_tiponovedad=='Reprogramacion'){
  $startY3 = $pdf->GetY();  
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
  $endX3 = $pdf->GetX();
  $endY3 = $pdf->GetY();
  $ylines3 = $endY3 - $startY3;
}
if ($obj->s18_tiponovedad==" " || $obj->s18_tiponovedad==null){
    $ylines3 = 0;
} 
$pdf->SetXY(228,$y);
if ($obj->s18_fechareprog1==" " || $obj->s18_fechareprog1==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s18_fechareprog1)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s18_fechareprog2==" " || $obj->s18_fechareprog2==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s18_fechareprog2)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s18_estadoregistro==" " || $obj->s18_estadoregistro==null){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s18_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}

if ($ylines1 >= $ylines2 && $ylines1 >= $ylines3) {
    $pdf->line($endX1,$endY1, 270, $endY1);
    $yFin =$endY1;
    $ylines= $ylines1;
} elseif ($ylines2 >= $ylines1 && $ylines2 >= $ylines3) {
    $pdf->line($endX2,$endY2, 270, $endY2);
    $yFin =$endY2;
    $ylines= $ylines2;
} else {
    $pdf->line($endX3,$endY3, 270, $endY3);
    $yFin =$endY3;
    $ylines= $ylines3;
}
if ($yFin > 180) { 
    $pdf->AddPage();
    //$pdf->Ln(3);

}else{ 
$pdf->checkPageBreak($bottomMargin, $yFin);
}
if ($yFin < 190) { 
     realizarSalto($ylines, $ylines3, $pdf);
}

}else{
    $pdf= new FPDF("L","mm", "Letter");
    $pdf->SetTitle("Formato Registro de Actividades");
    $pdf->AddPage();
    $pdf->Cell(60, 21, $pdf->Image("../assets/images/logo.png", 12,12,50),1,0);
    $pdf->SetFont("Arial", "B", 12);
    $pdf->rect(10,10, 260, 21);
    $pdf->Cell(160, 14, mb_convert_encoding("REGISTRO DE ACTIVIDADES ACADEMICAS POR DOCENTE", 'ISO-8859-1'), 0, 0, "C");
    $pdf->SetFont("Arial", "", 9);
    $pdf->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(25, 7, mb_convert_encoding($obj2->codigo, 'ISO-8859-1'), 1, 1, "L");
    $pdf->Cell(220);
    $pdf->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(25, 7, mb_convert_encoding($obj2->version, 'ISO-8859-1'), 1, 1, "L");
    $pdf->Cell(60);
    $pdf->SetFont("Arial", "", 12);
    $pdf->Cell(160, 7, mb_convert_encoding("DOCENTE:"." ".$obj->nombre_docente,'ISO-8859-1'), 0, 0, "C");
    $pdf->SetFont("Arial", "", 9);
    $pdf->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(25, 7, mb_convert_encoding($obj2->fecha, 'ISO-8859-1'), 1, 1, "L");
    $pdf->SetFont("Arial", "B", 9);
    $pdf->SetFillColor(181,178,178);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(260, 5, mb_convert_encoding("Datos Principales", 'ISO-8859-1'), 1, 1, "C", true);
    $pdf->SetFont("Arial", "", 9);
    $pdf->SetTextColor(0,0,0);
    $pdf->rect(10,36, 260, 10);
    $pdf->SetFont("Arial", "B", 10);
    $pdf->Cell(30, 5, mb_convert_encoding("ASIGNATURA:",'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 10);
    $pdf->Cell(20, 5, mb_convert_encoding($obj->codigo_asignatura, 'ISO-8859-1'), 0, 0, "L");
    $pdf->Cell(140, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "B", 10);
    $pdf->Cell(20, 5, mb_convert_encoding("GRUPO:",'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 10);
    $pdf->Cell(10, 5, mb_convert_encoding($obj->grupo, 'ISO-8859-1'), 0, 0, "L");
    $pdf->Cell(30, 5, mb_convert_encoding("SEMESTRE:",'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 10);
    $pdf->Cell(10, 5, mb_convert_encoding($obj->semestre, 'ISO-8859-1'), 0, 1, "L");
    $pdf->SetFont("Arial", "B", 10);
    $pdf->Cell(30, 5, mb_convert_encoding("PROGRAMA:",'ISO-8859-1'), 0, 0, "L");
    $pdf->SetFont("Arial", "", 10);
    $pdf->Cell(230, 5, mb_convert_encoding($obj->nombre_programa, 'ISO-8859-1'), 0, 1, "L");
    $pdf->SetFont("Arial", "B", 7);
    $pdf->SetLineWidth(0.5);
    $pdf->line(10,56, 270, 56);
    $pdf->Cell(210);
    $pdf->SetFont("Arial", "B", 6);
    $pdf->Cell(40, 4, mb_convert_encoding("REPROGRAMACION",'ISO-8859-1'), 0, 1, "C");
    $pdf->SetFont("Arial", "B", 6);
    $y = $pdf->GetY();
    $pdf->Cell(20, 5, mb_convert_encoding("SEMANA",'ISO-8859-1'), 0, 0, "L");
    $pdf->Cell(50, 5, mb_convert_encoding("CONTENIDOS",'ISO-8859-1'), 0, 0, "L");
    $pdf->MultiCell(14, 3, mb_convert_encoding("FECHA \n"."REGISTRO",'ISO-8859-1'), 0,"C",0);
    $pdf->SetXY(92,$y);
    $pdf->MultiCell(14, 3, mb_convert_encoding("HORA \n"."REGISTRO",'ISO-8859-1'), 0,"C",0);
    $pdf->SetXY(104,$y);
    $pdf->MultiCell(15, 3, mb_convert_encoding("TIPO \n"."ACTIVIDAD",'ISO-8859-1'), 0, "C",0);
    $pdf->SetXY(119,$y);
    $pdf->MultiCell(40, 3, mb_convert_encoding("DESCRIPCION \n"."ACTIVIDAD",'ISO-8859-1'), 0, "C",0);
    $pdf->SetXY(168,$y);
    $pdf->Cell(14, 4, mb_convert_encoding("JUSTIFICACIÓN",'ISO-8859-1'), 0, 0, "C");
    $pdf->SetXY(182,$y);
    $pdf->MultiCell(40, 3, mb_convert_encoding("FECHA \n"."NOVEDAD",'ISO-8859-1'), 0, "C",0);
    $pdf->SetXY(208,$y);
    $pdf->MultiCell(20, 3, mb_convert_encoding("TIPO \n"."NOVEDAD",'ISO-8859-1'), 0, "C",0);
    $pdf->SetFont("Arial", "B", 6);
    $pdf->SetXY(225,$y);
    $pdf->MultiCell(20, 3, mb_convert_encoding("FECHA \n"."1",'ISO-8859-1'), 0,"C",0);
    $pdf->SetXY(235,$y);
    $pdf->MultiCell(20, 3, mb_convert_encoding("FECHA \n"."2",'ISO-8859-1'), 0, "C", 0);
    $pdf->SetFont("Arial", "B", 7);
    $pdf->SetXY(252,$y);
    $pdf->Cell(15, 4, mb_convert_encoding("ESTADO",'ISO-8859-1'), 0, 1, "L");
    date_default_timezone_set("America/Bogota");
    $pdf->Ln(3);
    //semana 1
    $pdf->SetFont("Arial", "", 6);
    $y = $pdf->GetY();
    $pdf->MultiCell(20, 2, mb_convert_encoding($obj->s1_titulo_p." del ".$obj->s1_rangoi_p." hasta \n".$obj->s1_rangof_p, 'ISO-8859-1'), 0,'J',0,4);
    $pdf->SetXY(30,$y);
    $pdf->MultiCell(50,2, mb_convert_encoding($obj->s1_contenidos_p, 'ISO-8859-1'), 0,'J',0,4);
    $pdf->SetXY(80,$y);
    if ($obj->s1_fecharegistro_p==" " || $obj->s1_fecharegistro_p==null ){
        $pdf->Cell(12, 6, " ", 0, 0, "L");
    }else{    
    $pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s1_fecharegistro_p)), 0, 0, "L");
    }
    $pdf->SetXY(92,$y);
    if ($obj->s1_horaregistro_p==" " || $obj->s1_horaregistro_p==null){
        $pdf->Cell(10, 6, " ", 0, 0, "L");
    }else {    
    $pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s1_horaregistro_p)), 0, 0, "L");
    }
    $pdf->SetXY(105,$y);
    $pdf->Cell(10, 6, mb_convert_encoding($obj->s1_tipoactividad_p, 'ISO-8859-1'), 0, 0, "L");
    $pdf->SetXY(115,$y);
    $pdf->MultiCell(50,2, mb_convert_encoding($obj->s1_descripcion_p, 'ISO-8859-1'), 0,'J',0,4);
    $pdf->SetXY(165,$y);
    if ($obj->s1_justifica_nov_p==" " || $obj->s1_justifica_nov_p==null){
        $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s1_justifica_reprog_p, 'ISO-8859-1'), 0,'J',0,4);
    }else{
        $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s1_justifica_nov_p, 'ISO-8859-1'), 0,'J',0,4);
    }
    $pdf->SetXY(195,$y);
    if ($obj->s1_fechanovedad_p==" " || $obj->s1_fechanovedad_p==null){
        $pdf->Cell(15, 6, " ", 0, 0, "L");
    }else { 
        $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s1_fechanovedad_p)), 0, 0, "L");
    }
    $pdf->SetXY(208,$y);
    if ($obj->s1_tiponovedad_p=='Fueradefecha'){ 
      $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
    }else if ($obj->s1_tiponovedad_p=='Reprogramacion'){
      $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
    }
    $pdf->SetXY(228,$y);
    if ($obj->s1_fechareprog1_p==" " || $obj->s1_fechareprog1_p==null){
        $pdf->Cell(10, 6, " ", 0, 0, "L");
    }else{   
        $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s1_fechareprog1_p)), 0, 0, "L"); 
    }
    $pdf->SetXY(240,$y);
    if ($obj->s1_fechareprog2_p==" " || $obj->s1_fechareprog2_p==null){
        $pdf->Cell(10, 6, " ", 0, 0, "L");
    }else{    
        $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s1_fechareprog2_p)), 0, 0, "L");
    }    
    $pdf->SetXY(251,$y);
    if ($obj->s1_estadoregistro_p==" "){
        $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
    }else{
        $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s1_estadoregistro_p, 'ISO-8859-1'), 0,'C',0,4);
    }
    if ($obj->s1_estadoregistro_p==" "){
        $pdf->Ln(4);
      } else if ($obj->s1_estadoregistro_p=="REGISTRO VALIDO") {
          $pdf->Ln(6);
      } else if ($obj->s1_estadoregistro_p=="REGISTRO CON NOVEDAD") {    
          $pdf->Ln(4);
      }
    $pdf->line(10,66, 270, 66);
    //semana 2
    $pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s2_titulo_p." del ".$obj->s2_rangoi_p." hasta \n".$obj->s2_rangof_p, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s2_contenidos_p, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(80,$y);
if ($obj->s2_fecharegistro_p==" " || $obj->s2_fecharegistro_p==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s2_fecharegistro_p)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s2_horaregistro_p==" " || $obj->s2_horaregistro_p==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s2_horaregistro_p)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s2_tipoactividad_p, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s2_descripcion_p, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(165,$y);
if ($obj->s2_justifica_nov_p==" " || $obj->s2_justifica_nov_p==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s2_justifica_reprog_p, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s2_justifica_nov_p, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s2_fechanovedad_p==" " || $obj->s2_fechanovedad_p==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s2_fechanovedad_p)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s2_tiponovedad_p=='Fueradefecha'){ 
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s2_tiponovedad_p=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(228,$y);
if ($obj->s2_fechareprog1_p==" " || $obj->s2_fechareprog1_p==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s2_fechareprog1_p)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s2_fechareprog2_p==" " || $obj->s2_fechareprog2_p==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s2_fechareprog2_p)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s2_estadoregistro_p==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s2_estadoregistro_p, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s2_estadoregistro_p==" "){
    $pdf->Ln(4);
  } else if ($obj->s2_estadoregistro_p=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s2_estadoregistro_p=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,76, 270, 76);
    //semana 3
    $pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s3_titulo_p." del ".$obj->s3_rangoi_p." hasta \n".$obj->s3_rangof_p, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s3_contenidos_p, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(80,$y);
if ($obj->s3_fecharegistro_p==" " || $obj->s3_fecharegistro_p==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s3_fecharegistro_p)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s3_horaregistro_p==" " || $obj->s3_horaregistro_p==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s3_horaregistro_p)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s3_tipoactividad_p, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s3_descripcion_p, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(165,$y);
if ($obj->s3_justifica_nov_p==" " || $obj->s3_justifica_nov_p==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s3_justifica_reprog_p, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s3_justifica_nov_p, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s3_fechanovedad_p==" " || $obj->s3_fechanovedad_p==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s3_fechanovedad_p)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s3_tiponovedad_p=='Fueradefecha'){ 
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s3_tiponovedad_p=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(228,$y);
if ($obj->s3_fechareprog1_p==" " || $obj->s3_fechareprog1_p==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s3_fechareprog1_p)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s3_fechareprog2_p==" " || $obj->s3_fechareprog2_p==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s3_fechareprog2_p)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s3_estadoregistro_p==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s3_estadoregistro_p, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s3_estadoregistro_p==" "){
    $pdf->Ln(4);
  } else if ($obj->s3_estadoregistro_p=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s3_estadoregistro_p=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
    $pdf->line(10,86, 270, 86);
    //semana 4
    $pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s4_titulo_p." del ".$obj->s4_rangoi_p." hasta \n".$obj->s4_rangof_p, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s4_contenidos_p, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(80,$y);
if ($obj->s4_fecharegistro_p==" " || $obj->s4_fecharegistro_p==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s4_fecharegistro_p)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s4_horaregistro_p==" " || $obj->s4_horaregistro_p==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s4_horaregistro_p)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s4_tipoactividad_p, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s4_descripcion_p, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(165,$y);
if ($obj->s4_justifica_nov_p==" " || $obj->s4_justifica_nov_p==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s4_justifica_reprog_p, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s4_justifica_nov_p, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s4_fechanovedad_p==" " || $obj->s4_fechanovedad_p==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s4_fechanovedad_p)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s4_tiponovedad_p=='Fueradefecha'){ 
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s4_tiponovedad_p=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(228,$y);
if ($obj->s4_fechareprog1_p==" " || $obj->s4_fechareprog1_p==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s4_fechareprog1_p)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s4_fechareprog2_p==" " || $obj->s4_fechareprog2_p==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s4_fechareprog2_p)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s4_estadoregistro_p==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s4_estadoregistro_p, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s4_estadoregistro_p==" "){
    $pdf->Ln(4);
  } else if ($obj->s4_estadoregistro_p=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s4_estadoregistro_p=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
    $pdf->line(10,96, 270, 96);
    //semana 5
    $pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s5_titulo_p." del ".$obj->s5_rangoi_p." hasta \n".$obj->s5_rangof_p, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s5_contenidos_p, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(80,$y);
if ($obj->s5_fecharegistro_p==" " || $obj->s5_fecharegistro_p==null ){
    $pdf->Cell(12, 6, " ", 0, 0, "L");
}else{    
$pdf->Cell(12, 6, date("d-m-Y",strtotime($obj->s5_fecharegistro_p)), 0, 0, "L");
}
$pdf->SetXY(92,$y);
if ($obj->s5_horaregistro_p==" " || $obj->s5_horaregistro_p==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else {    
$pdf->Cell(10, 6, date("h:i:sa",strtotime($obj->s5_horaregistro_p)), 0, 0, "L");
}
$pdf->SetXY(105,$y);
$pdf->Cell(10, 6, mb_convert_encoding($obj->s5_tipoactividad_p, 'ISO-8859-1'), 0, 0, "L");
$pdf->SetXY(115,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s5_descripcion_p, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(165,$y);
if ($obj->s5_justifica_nov_p==" " || $obj->s5_justifica_nov_p==null){
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s5_justifica_reprog_p, 'ISO-8859-1'), 0,'J',0,4);
}else{
    $pdf->MultiCell(30, 2, mb_convert_encoding($obj->s5_justifica_nov_p, 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(195,$y);
if ($obj->s5_fechanovedad_p==" " || $obj->s5_fechanovedad_p==null){
    $pdf->Cell(15, 6, " ", 0, 0, "L");
}else { 
    $pdf->Cell(15, 6, date("d-m-Y",strtotime($obj->s5_fechanovedad_p)), 0, 0, "L");
}
$pdf->SetXY(208,$y);
if ($obj->s5_tiponovedad_p=='Fueradefecha'){ 
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s5_tiponovedad_p=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
}
$pdf->SetXY(228,$y);
if ($obj->s5_fechareprog1_p==" " || $obj->s5_fechareprog1_p==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{   
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s5_fechareprog1_p)), 0, 0, "L"); 
}
$pdf->SetXY(240,$y);
if ($obj->s5_fechareprog2_p==" " || $obj->s5_fechareprog2_p==null){
    $pdf->Cell(10, 6, " ", 0, 0, "L");
}else{    
    $pdf->Cell(10, 6, date("d-m-Y",strtotime($obj->s5_fechareprog2_p)), 0, 0, "L");
}    
$pdf->SetXY(251,$y);
if ($obj->s5_estadoregistro_p==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s5_estadoregistro_p, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s5_estadoregistro_p==" "){
    $pdf->Ln(4);
  } else if ($obj->s5_estadoregistro_p=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s5_estadoregistro_p=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
    $pdf->line(10,106, 270, 106);
//pie de pagina 1
$pdf->AliasNbPages();
$pdf->Ln(80);
$pdf->SetFont("Arial", "", 6);
$pdf->Cell(25, 5, mb_convert_encoding("Fecha y Hora de impresión", 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(5);
$pdf->Cell(10,5,date('d/m/Y'),0,0,'L'); 
$pdf->Cell(5);
date_default_timezone_set("America/Bogota");
$pdf->Cell(10,5,date("h:i:sa"),0,0,'L');
$pdf->Cell(5);
$pdf->Cell(80, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(0,5, mb_convert_encoding('Página ', 'ISO-8859-1').$pdf->PageNo().'/ {nb}',0, 0, "R"); 
}
$pdf->Output('I', 'reporte_registro_actividades.pdf');
