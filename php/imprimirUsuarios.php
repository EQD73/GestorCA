<?php

session_start();

require "conexion.php";
require "../fpdf/fpdf.php";
//require('../fpdf/multicellmax.php');
//require('../fpdf/force_justify.php');

//iso formato
$m="m3";
$sql2= "SELECT * FROM version_formato WHERE nombre_formato='$m'";
$result2= pg_query($conexion,$sql2);
$obj2=pg_fetch_object($result2);


$sql1 = "SELECT * FROM sistema.usuarios ORDER BY apellidos, estado ASC";
$resultado = pg_query($conexion, $sql1);
$row =pg_fetch_assoc($resultado);

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
$this->Cell(60, 21, $this->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
$this->SetFont("Arial", "B", 12);
$this->Cell(100, 21, "Reporte de Usuarios", 1, 0, "C");
$this->SetFont("Arial", "", 9);
$this->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
$this->Cell(25, 7, mb_convert_encoding("", 'ISO-8859-1'), 1, 1, "L");
$this->Cell(160);
$this->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
$this->Cell(25, 7, mb_convert_encoding("", 'ISO-8859-1'), 1, 1, "L");
$this->Cell(160);
$this->SetFont("Arial", "", 9);
$this->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
$this->Cell(25, 7, mb_convert_encoding("", 'ISO-8859-1'), 1, 1, "L");
$this->SetFont("Arial", "B", 8);
//thisdf->Ln(1);
$this->Cell(16, 5, mb_convert_encoding("Código",'ISO-8859-1'), 1, 0, "C");
//thisdf->Cell(15);
$this->Cell(25, 5, mb_convert_encoding("Nombres",'ISO-8859-1'), 1, 0, "C");
$this->Cell(30, 5, mb_convert_encoding("Apellidos",'ISO-8859-1'), 1, 0, "C");
$this->Cell(52, 5, mb_convert_encoding("Nombre Completo",'ISO-8859-1'), 1, 0, "C");
$this->Cell(20, 5, mb_convert_encoding("Celular",'ISO-8859-1'), 1, 0, "C");
$this->Cell(35, 5, mb_convert_encoding("Correo Inst.",'ISO-8859-1'), 1, 0, "C");
$this->Cell(15, 5, mb_convert_encoding("Estado",'ISO-8859-1'), 1, 0, "C");
$this->Cell(7, 5, mb_convert_encoding("Rol",'ISO-8859-1'), 1, 1, "C");
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
$this->SetY(-15);
$this->SetFont("Arial", "", 6);
$this->Cell(25, 5, mb_convert_encoding("Fecha y Hora de impresión", 'ISO-8859-1'), 0, 0, "L");
$this->Cell(5);
$this->Cell(10, 5, date('d/m/Y'), 0, 0, 'L');
$this->Cell(5);
date_default_timezone_set("America/Bogota");
$this->Cell(10, 5, date("h:i:sa"), 0, 0, 'L');
$this->Cell(5);
$this->Cell(80, 5, mb_convert_encoding('', 'ISO-8859-1'), 0, 0, "L");
$this->Cell(0, 5, mb_convert_encoding('Página: ', 'ISO-8859-1') . $this->PageNo() . '/{nb}', 0, 0, "R");
}
}


$pdf = new PDF();
$pdf->SetTitle('Reporte Usuarios');
$pdf->AliasNbPages();
$pdf->AddPage("P", "Letter");

$pdf->SetFont("Arial", "", 6);
while ($row=pg_fetch_assoc($resultado)){
    $pdf->Cell(16, 5, mb_convert_encoding($row['codigo_usuario'], 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(25, 5, mb_convert_encoding($row['nombres'], 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(30, 5, mb_convert_encoding($row['apellidos'], 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(52, 5, mb_convert_encoding($row['nomcompleto'], 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(20, 5, mb_convert_encoding($row['Celular'], 'ISO-8859-1'), 1 , 0, "L");
    $pdf->Cell(35, 5, mb_convert_encoding($row['email_institucional'], 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(15, 5, mb_convert_encoding($row['estado'], 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(7, 5, mb_convert_encoding($row['codigo_rol'], 'ISO-8859-1'), 1, 1, "L");
}



//pie de pagina


$pdf->Output('I', 'reporte_usuarios.pdf');
