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