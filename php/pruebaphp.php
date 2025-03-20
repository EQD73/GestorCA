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
// if ($obj->s3_estadoregistro==" "){
//     $pdf->Ln(4);
//   } else if ($obj->s3_estadoregistro=="REGISTRO VALIDO") {
//       $pdf->Ln(6);
//   } else if ($obj->s3_estadoregistro=="REGISTRO CON NOVEDAD") {    
//       $pdf->Ln(4);
// }
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
     realizarSalto($ylines, $pdf);
}
//$pdf->Ln(3);