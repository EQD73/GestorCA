<?php

session_start();

require "conexion.php";
require "../fpdf/fpdf.php"; 
//require('../fpdf/force_justify.php');
//require('../fpdf/multicellmax.php');

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

if ($obj->codigo_programa <> "26" && $obj->codigo_programa <> "30" && $obj->codigo_programa <> "31" && $obj->codigo_programa <> "32") {

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
$pdf->SetFont("Arial", "B", 6);
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
//$x1 = $pdf->GetX();
//$y1 = $pdf->GetY();

//semana 1
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s1_titulo." del ".$obj->s1_rangoi." hasta \n".$obj->s1_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s1_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s1_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s1_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s1_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s1_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s1_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s1_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s1_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,66, 270, 66);
//semana 2
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s2_titulo." del ".$obj->s2_rangoi." hasta \n".$obj->s2_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s2_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s2_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s2_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s2_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s2_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s2_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s2_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s2_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,76, 270, 76);
//semana 3
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s3_titulo." del ".$obj->s3_rangoi." hasta \n".$obj->s3_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s3_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s3_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s3_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s3_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s3_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s3_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s3_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s3_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,86, 270, 86);
//semana 4
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s4_titulo." del ".$obj->s4_rangoi." hasta \n".$obj->s4_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s4_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s4_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s4_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s4_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s4_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s4_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s4_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s4_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,96, 270, 96);
//semana 5
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s5_titulo." del ".$obj->s5_rangoi." hasta \n".$obj->s5_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s5_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s5_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s5_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s5_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s5_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s5_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s5_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s5_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,106, 270, 106);
// //semana 6
//semana 6
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s6_titulo." del ".$obj->s6_rangoi." hasta \n".$obj->s6_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s6_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s6_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s6_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s6_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s6_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s6_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s6_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s6_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,116, 270, 116);
//semana 7
$pdf->SetFont("Arial", "", 7);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s7_titulo." del ".$obj->s7_rangoi." hasta \n".$obj->s7_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s7_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s7_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s7_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s7_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s7_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s7_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s7_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s7_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,126, 270, 126);
//semana 8
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s8_titulo." del ".$obj->s8_rangoi." hasta \n".$obj->s8_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s8_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s8_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s8_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s8_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s8_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s8_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s8_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s8_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,136, 270, 136);
//semana 9
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s9_titulo." del ".$obj->s9_rangoi." hasta \n".$obj->s9_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s9_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s9_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s9_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s9_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s9_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s9_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s9_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s9_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,146, 270, 146);
//semana 10
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s10_titulo." del ".$obj->s10_rangoi." hasta \n".$obj->s10_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s10_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s10_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s10_tiponovedad=='Fueradefecha'){ 
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s10_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s10_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s10_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s10_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s10_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s10_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,156, 270, 156);
//semana 11
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s11_titulo." del ".$obj->s11_rangoi." hasta \n".$obj->s11_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s11_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s11_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s11_tiponovedad=='Fueradefecha'){ 
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s11_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s11_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s11_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s11_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s11_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s11_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,166, 270, 166);
//semana 12
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s12_titulo." del ".$obj->s12_rangoi." hasta \n".$obj->s12_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s12_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s12_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s12_tiponovedad=='Fueradefecha'){ 
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s12_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s12_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s12_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s12_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s12_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s12_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,176, 270, 176);
//pie de pagina 1
$pdf->SetY(190); // Posición desde el final
$pdf->AliasNbPages();
//$pdf->Ln(10);
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
//`pagina 2
$pdf->AddPage("L", "Letter");
$pdf->SetTitle("Formato Registro de Actividades");
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
//semana 13
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s13_titulo." del ".$obj->s13_rangoi." hasta \n".$obj->s13_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s13_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s13_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s13_tiponovedad=='Fueradefecha'){ 
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s13_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s13_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s13_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s13_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s13_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s13_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,66, 270, 66);
//semana 14
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s14_titulo." del ".$obj->s14_rangoi." hasta \n".$obj->s14_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s14_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s14_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s14_tiponovedad=='Fueradefecha'){ 
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s14_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s14_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s14_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s14_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s14_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s14_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,76, 270, 76);
//semana 15
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s15_titulo." del ".$obj->s15_rangoi." hasta \n".$obj->s15_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s15_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s15_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s15_tiponovedad=='Fueradefecha'){ 
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s15_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s15_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s15_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s15_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s15_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s15_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10, 86, 270, 86);
//semana 16
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s16_titulo." del ".$obj->s16_rangoi." hasta \n".$obj->s16_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s16_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s16_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s16_tiponovedad=='Fueradefecha'){ 
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s16_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s16_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s16_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s16_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s16_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s16_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,96, 270, 96);
//
//semana 17
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s17_titulo." del ".$obj->s17_rangoi." hasta \n".$obj->s17_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s17_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s17_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s17_tiponovedad=='Fueradefecha'){ 
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s17_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s17_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s17_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s17_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s17_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s17_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,106, 270, 106);
//
//semana 18
$pdf->SetFont("Arial", "", 6);
$y = $pdf->GetY();
$pdf->MultiCell(20, 2, mb_convert_encoding($obj->s18_titulo." del ".$obj->s18_rangoi." hasta \n".$obj->s18_rangof, 'ISO-8859-1'), 0,'J',0,4);
$pdf->SetXY(30,$y);
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s18_contenidos, 'ISO-8859-1'), 0,'J',0,4);
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
$pdf->MultiCell(50,2, mb_convert_encoding($obj->s18_descripcion, 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s18_tiponovedad=='Fueradefecha'){ 
  $pdf->MultiCell(20, 2, mb_convert_encoding("Registro de Actividad Académica Fuera de fecha", 'ISO-8859-1'), 0,'J',0,4);
}else if ($obj->s18_tiponovedad=='Reprogramacion'){
  $pdf->MultiCell(20, 2, mb_convert_encoding("Reprogramación de Actividad Académica", 'ISO-8859-1'), 0,'J',0,4);
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
if ($obj->s18_estadoregistro==" "){
    $pdf->MultiCell(15, 2, mb_convert_encoding("REGISTRO POR DEFINIR", 'ISO-8859-1'), 0,'C',0,4);
}else{
    $pdf->MultiCell(15, 2, mb_convert_encoding($obj->s18_estadoregistro, 'ISO-8859-1'), 0,'C',0,4);
}
if ($obj->s18_estadoregistro==" "){
    $pdf->Ln(4);
  } else if ($obj->s18_estadoregistro=="REGISTRO VALIDO") {
      $pdf->Ln(6);
  } else if ($obj->s18_estadoregistro=="REGISTRO CON NOVEDAD") {    
      $pdf->Ln(4);
  }
$pdf->line(10,116, 270, 116);
//pie de pagina 2
$pdf->SetY(190); // Posición desde el final
$pdf->AliasNbPages();
//$pdf->Ln(90);
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
