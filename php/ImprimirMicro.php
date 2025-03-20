<?php

session_start();

require "conexion.php";

require '../fpdf/fpdf.php';

$tablam1 = isset($_SESSION['tablam1']) ? $_SESSION['tablam1'] : null;


if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
}
$codigoConsulta = $id;

// Consulta para obtener los datos del formato
$m = "m1";
$sql2 = "SELECT * FROM version_formato WHERE nombre_formato = $1";
$result2 = pg_query_params($conexion, $sql2, [$m]);
if (!$result2 || pg_num_rows($result2) === 0) {
    die("Error: No se pudo encontrar el formato especificado.");
}
$obj2 = pg_fetch_object($result2);

// Consulta para obtener los datos del registro
$sql1 = "SELECT * FROM $tablam1 WHERE id = $1";
$resultado = pg_query_params($conexion, $sql1, [$codigoConsulta]);
if (!$resultado || pg_num_rows($resultado) === 0) {
    die("Error: No se encontraron datos para el ID especificado.");
}
$obj = pg_fetch_object($resultado);

$pdf = new FPDF("P", "mm", "Letter");
$pdf->SetTitle('Formato Microcurriculo');
$pdf->AddPage();
$pdf->Cell(60, 21, $pdf->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(100, 21, "Microcurriculo", 1, 0, "C");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->codigo, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(160);
$pdf->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->version, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(160);
$pdf->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->fecha, 'ISO-8859-1'), 1, 1, "L");
$pdf->SetFont("Arial", "B", 12);
$pdf->SetFillColor(181,178,178);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(200, 10, mb_convert_encoding("I. Identificación del Curso", 'ISO-8859-1'), 1, 1, "C", true);
$pdf->SetFont("Arial", "", 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(30, 7, "Nombre del Curso:", 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(130, 7, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(25, 7, mb_convert_encoding("Vigencia Año:", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 7, "$obj->ano_micro", 1, 1, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(55, 7, "Facultad a la que tributa el Curso:", 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(105, 7, mb_convert_encoding($obj->nombre_facultad, 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(20, 7, "Semestre:", 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(20, 7, "$obj->semestre", 1, 1, "C");
$pdf->SetFont("Arial", "B", 9);
$y = $pdf->GetY();
$pdf->Cell(60, 15, "Programa a los que tributa el Curso:", 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(90, 5, mb_convert_encoding($obj->nombre_programa, 'ISO-8859-1'), 0, 'FJ',0);
$pdf->SetFont("Arial", "B", 9);
$pdf->SetXY(160,$y);
$pdf->Cell(20, 5, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(30, 5, "$obj->codigo_asignaturacurso", 1, 1, "C");
$pdf->Cell(150);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(20, 5, mb_convert_encoding("Créditos:", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(30, 5, "$obj->creditos", 1, 1, "C");
$pdf->Cell(150);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(30, 5, mb_convert_encoding("Total Semanas:", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(20, 5, "$obj->total_semanas_periodo", 1, 1, "C");
// cargue de datos json requisitos
if ($obj->requisitos == '{}') {
  $text_array = '';
} else {
  $array = $obj->requisitos;
  $array = str_replace('{',' ',  $array);
  $array = str_replace('}',' ',  $array);    
  $valor = explode(",", $array); 
    foreach ($valor as $t) {
        $t = str_replace('"',' ',  $t);
        $result[] = $t;
    }
  $text_array = '';
  foreach ($result as $val) {
    $text_array .= $val . " | ";
  }
}
$pdf->SetFont("Arial", "B", 9);
$y = $pdf->GetY();
$pdf->MultiCell(30, 14, "Requisitos:", 1, 'FJ', 0);
$pdf->SetFont("Arial", "", 9);

$pdf->SetXY(40,$y);
$pdf->MultiCell(170, 7, mb_convert_encoding($text_array, 'ISO-8859-1'), 0, 'FJ', 0);
$pdf->Rect(40, 70, 170, 14);
$pdf->Ln(7);
// hasta aqui ///
//nivel de formacion
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(35, 7, mb_convert_encoding("Nivel de formación:", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(45, 7, mb_convert_encoding("Tecnológico", 'ISO-8859-1'), 1, 0, "L");
if ($obj->nivel_formacion == "Tecnológico") {
  $pdf->Cell(10, 7, " X ", 1, 0, "C");
} else {
  $pdf->Cell(10, 7, " ", 1, 0, "C");
}
$pdf->Cell(45, 7, mb_convert_encoding("Profesional", 'ISO-8859-1'), 1, 0, "L");
if ($obj->nivel_formacion == "Profesional") {
  $pdf->Cell(10, 7, " X ", 1, 0, "C");
} else {
  $pdf->Cell(10, 7, " ", 1, 0, "C");
}
$pdf->Cell(45, 7, mb_convert_encoding("Especialización", 'ISO-8859-1'), 1, 0, "L");
if ($obj->nivel_formacion == "Especialización") {
  $pdf->Cell(10, 7, " X ", 1, 1, "C");
} else {
  $pdf->Cell(10, 7, " ", 1, 1, "C");
}
//area de formacion
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(35, 7, mb_convert_encoding("Area de formación:", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(20, 7, mb_convert_encoding("Básica", 'ISO-8859-1'), 1, 0, "L");
if ($obj->area_formacion == "Básica") {
  $pdf->Cell(10, 7, " X ", 1, 0, "C");
} else {
  $pdf->Cell(10, 7, " ", 1, 0, "C");
}
$pdf->Cell(20, 7, mb_convert_encoding("Específica", 'ISO-8859-1'), 1, 0, "L");
if ($obj->area_formacion == "Específica") {
  $pdf->Cell(10, 7, " X ", 1, 0, "C");
} else {
  $pdf->Cell(10, 7, " ", 1, 0, "C");
}
$pdf->Cell(30, 7, mb_convert_encoding("Socio-Humanística", 'ISO-8859-1'), 1, 0, "L");
if ($obj->area_formacion == "Socio-Humanística") {
  $pdf->Cell(10, 7, " X ", 1, 0, "C");
} else {
  $pdf->Cell(10, 7, " ", 1, 0, "C");
}
$pdf->Cell(20, 7, mb_convert_encoding("Flexible", 'ISO-8859-1'), 1, 0, "L");
if ($obj->area_formacion == "Flexible") {
  $pdf->Cell(10, 7, " X ", 1, 0, "C");
} else {
  $pdf->Cell(10, 7, " ", 1, 0, "C");
}
$pdf->Cell(25, 7, mb_convert_encoding("Investigación", 'ISO-8859-1'), 1, 0, "L");
if ($obj->area_formacion == "Investigación") {
  $pdf->Cell(10, 7, " X ", 1, 1, "C");
} else {
  $pdf->Cell(10, 7, " ", 1, 1, "C");
}
//tipo de curso
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(35, 7, mb_convert_encoding("Tipo de Curso:", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(45, 7, mb_convert_encoding("Teórico", 'ISO-8859-1'), 1, 0, "L");
if ($obj->tipo_curso == "Teórico") {
  $pdf->Cell(10, 7, " X ", 1, 0, "C");
} else {
  $pdf->Cell(10, 7, " ", 1, 0, "C");
}
$pdf->Cell(45, 7, mb_convert_encoding("Práctico", 'ISO-8859-1'), 1, 0, "L");
if ($obj->tipo_curso == "Práctico") {
  $pdf->Cell(10, 7, " X ", 1, 0, "C");
} else {
  $pdf->Cell(10, 7, " ", 1, 0, "C");
}
$pdf->Cell(45, 7, mb_convert_encoding("Teórico-Práctico", 'ISO-8859-1'), 1, 0, "L");
if ($obj->tipo_curso == "Teórico-Práctico") {
  $pdf->Cell(10, 7, " X ", 1, 1, "C");
} else {
  $pdf->Cell(10, 7, " ", 1, 1, "C");
}
//modalidad
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(35, 7, mb_convert_encoding("Modalidad:", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(45, 7, mb_convert_encoding("Presencial", 'ISO-8859-1'), 1, 0, "L");
if ($obj->modalidad == "Presencial") {
  $pdf->Cell(10, 7, " X ", 1, 0, "C");
} else {
  $pdf->Cell(10, 7, " ", 1, 0, "C");
}
$pdf->Cell(45, 7, mb_convert_encoding("Virtual", 'ISO-8859-1'), 1, 0, "L");
if ($obj->modalidad == "Virtual") {
  $pdf->Cell(10, 7, " X ", 1, 0, "C");
} else {
  $pdf->Cell(10, 7, " ", 1, 0, "C");
}
$pdf->Cell(45, 7, mb_convert_encoding("Mixta", 'ISO-8859-1'), 1, 0, "L");
if ($obj->modalidad == "Mixta") {
  $pdf->Cell(10, 7, " X ", 1, 1, "C");
} else {
  $pdf->Cell(10, 7, " ", 1, 1, "C");
}
//Horas de Trabajo
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(45, 7, mb_convert_encoding("Total Horas de trabajo:", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(25, 7, "$obj->tht", 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(40, 7, mb_convert_encoding("Total H.T.I:", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(25, 7, "$obj->thti", 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(40, 7, mb_convert_encoding("Total H.T.P:", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(25, 7, "$obj->thtp", 1, 1, "C");
//celda en blanco - linea 
//$pdf->Cell(200, 5, "", 0, 1);
//descripcion
$pdf->SetFont("Arial", "B", 12);
$pdf->SetFillColor(181,178,178);
//$pdf->SetFillColor(255, 0, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(200, 12, mb_convert_encoding("II. Descripción", 'ISO-8859-1'), 1, 1, "C", true);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(200, 10, mb_convert_encoding("2.1. Descripción de la intención formativa del curso", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(200, 5, mb_convert_encoding($obj->descripcion_intension, 'ISO-8859-1'), 1, "J", false);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(200, 10, "2.2. Resultados de aprendizaje del programa a los que apunta la asignatura", 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(200, 5, mb_convert_encoding($obj->resultados_aprendizaje, 'ISO-8859-1'), 1, "J", false);
$pdf->SetY(250); // Posición desde el final
$pdf->AliasNbPages();
$pdf->SetFont("Arial", "", 6);
$pdf->Cell(25, 5, mb_convert_encoding("Fecha y Hora de impresión", 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(5);
$pdf->Cell(10, 5, date('d/m/Y'), 0, 0, 'L');
$pdf->Cell(5);
date_default_timezone_set("America/Bogota");
$pdf->Cell(10, 5, date("h:i:sa"), 0, 0, 'L');
$pdf->Cell(5);
$pdf->Cell(80, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(0, 5, mb_convert_encoding('Página', 'ISO-8859-1') . $pdf->PageNo() . '/{nb}', 0, 0, "R");
$pdf->Ln(2);
//pagina_2
$pdf->AddPage("P", "Letter");
$pdf->Cell(60, 21, $pdf->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(100, 21, "Microcurriculo", 1, 0, "C");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->codigo, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(160);
$pdf->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->version, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(160);
$pdf->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->fecha, 'ISO-8859-1'), 1, 1, "L");
$pdf->SetFont("Arial", "B", 12);
$pdf->SetFillColor(181,178,178);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(200, 12, mb_convert_encoding("2.3. Metodología", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->Cell(200, 8, mb_convert_encoding("2.3.1. Estrategia Pedagógica y didácticas", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetFont("Arial", "", 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(200, 5, mb_convert_encoding($obj->estrategia_pyd, 'ISO-8859-1'), 1, "J", false);
$pdf->SetFont("Arial", "B", 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(200, 8, "2.3.2. Recursos", 1, 1, "L", true);
$pdf->SetFont("Arial", "", 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(200, 5, mb_convert_encoding($obj->recursos, 'ISO-8859-1'), 1, "J", false);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(200, 12, mb_convert_encoding("2.4. Evaluación", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->Cell(200, 8, mb_convert_encoding("2.4.1. Momentos de Evaluación", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->Cell(200, 5, "", 0, 1);
$pdf->SetTextColor(0, 0, 0);
if ($pdf->GetY() > 260) { // Por ejemplo, si el cursor está a 260 mm o más
  $pdf->AddPage("P", "Letter"); // Agrega una nueva página
}

$pdf->Ln(-5);

// Ancho de las columnas
$widthCell1 = 40;
$widthMultiCell = 60;
$widthCell2 = 60;
$widthCell3 = 40;

// Altura de las filas
$rowHeight = 20;

// Contenido de la fila
$contentCell1 = "Momentos de Evaluación";
$contentMultiCell = "Porcentaje de actividades formativas (talleres, quices, actividades de seguimiento: trabajos en clases, trabajo independiente y trabajo final)";
$contentCell2 = "Porcentaje de actividad final de corte";
$contentCell3 = "Porcentaje Por corte";

// Posición inicial
$x = $pdf->GetX();
$y = $pdf->GetY();

// Primera celda (Cell)
$pdf->Cell($widthCell1, $rowHeight, mb_convert_encoding($contentCell1, 'ISO-8859-1'), 1, 0, 'C');

// MultiCell en la misma fila
$xMultiCell = $pdf->GetX(); // Posición X actual
$pdf->SetXY($xMultiCell, $y); // Restablecer la posición en la misma fila
$pdf->MultiCell($widthMultiCell, $rowHeight-15, mb_convert_encoding($contentMultiCell, 'ISO-8859-1'),  1, 'C');

// Ajustar posición para las celdas restantes
$yNextRow = $pdf->GetY(); // Obtener la posición Y después de MultiCell
$pdf->SetXY($xMultiCell + $widthMultiCell, $y); // Volver a la posición correcta para continuar la fila

// Tercera celda (Cell 2)
$pdf->Cell($widthCell2, $rowHeight, mb_convert_encoding($contentCell2, 'ISO-8859-1'), 1, 0, 'C');

// Cuarta celda (Cell 3)
$pdf->Cell($widthCell3, $rowHeight, mb_convert_encoding($contentCell3, 'ISO-8859-1'), 1, 0, 'C');

// Asegurarse de que la posición de Y esté correcta para la próxima fila
$pdf->SetY(max($yNextRow, $pdf->GetY())); // Tomar la posición más baja

if ($pdf->GetY() > 240) { // Por ejemplo, si el cursor está a 240 mm o más
    $pdf->SetFont("Arial", "", 6);
    $pdf->Cell(25, 5, mb_convert_encoding("Fecha y Hora de impresión", 'ISO-8859-1'), 0, 0, "L");
    $pdf->Cell(5);
    $pdf->Cell(10, 5, date('d/m/Y'), 0, 0, 'L');
    $pdf->Cell(5);
    date_default_timezone_set("America/Bogota");
    $pdf->Cell(10, 5, date("h:i:sa"), 0, 0, 'L');
    $pdf->Cell(5);
    $pdf->Cell(80, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
    $pdf->Cell(0, 5, mb_convert_encoding('Página', 'ISO-8859-1') . $pdf->PageNo() . '/{nb}', 0, 0, "R");
    $pdf->AddPage("P", "Letter"); // Agrega una nueva página
    $pdf->Cell(60, 21, $pdf->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
    $pdf->SetFont("Arial", "B", 12);
    $pdf->Cell(100, 21, "Microcurriculo", 1, 0, "C");
    $pdf->SetFont("Arial", "", 9);
    $pdf->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(25, 7, mb_convert_encoding($obj2->codigo, 'ISO-8859-1'), 1, 1, "L");
    $pdf->Cell(160);
    $pdf->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(25, 7, mb_convert_encoding($obj2->version, 'ISO-8859-1'), 1, 1, "L");
    $pdf->Cell(160);
    $pdf->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(25, 7, mb_convert_encoding($obj2->fecha, 'ISO-8859-1'), 1, 1, "L");        
}

//$pdf->Cell(40, 20,$pdf->GetY(), 1, 0, 'C');

$pdf->SetFont("Arial", "", 9);
$pdf->Cell(40, 9, mb_convert_encoding("Primer Corte", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(60, 9, mb_convert_encoding("15%", 'ISO-8859-1'), 1, 0, "C");
$pdf->Cell(60, 9, mb_convert_encoding("15%", 'ISO-8859-1'), 1, 0, "C");
$pdf->Cell(40, 9, mb_convert_encoding("30%", 'ISO-8859-1'), 1, 1, "C");

if ($pdf->GetY() > 240) { // Por ejemplo, si el cursor está a 240 mm o más
    $pdf->SetFont("Arial", "", 6);
    $pdf->Cell(25, 5, mb_convert_encoding("Fecha y Hora de impresión", 'ISO-8859-1'), 0, 0, "L");
    $pdf->Cell(5);
    $pdf->Cell(10, 5, date('d/m/Y'), 0, 0, 'L');
    $pdf->Cell(5);
    date_default_timezone_set("America/Bogota");
    $pdf->Cell(10, 5, date("h:i:sa"), 0, 0, 'L');
    $pdf->Cell(5);
    $pdf->Cell(80, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
    $pdf->Cell(0, 5, mb_convert_encoding('Página', 'ISO-8859-1') . $pdf->PageNo() . '/{nb}', 0, 0, "R");
    $pdf->AddPage("P", "Letter"); // Agrega una nueva página
    $pdf->Cell(60, 21, $pdf->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
    $pdf->SetFont("Arial", "B", 12);
    $pdf->Cell(100, 21, "Microcurriculo", 1, 0, "C");
    $pdf->SetFont("Arial", "", 9);
    $pdf->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(25, 7, mb_convert_encoding($obj2->codigo, 'ISO-8859-1'), 1, 1, "L");
    $pdf->Cell(160);
    $pdf->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(25, 7, mb_convert_encoding($obj2->version, 'ISO-8859-1'), 1, 1, "L");
    $pdf->Cell(160);
    $pdf->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
    $pdf->Cell(25, 7, mb_convert_encoding($obj2->fecha, 'ISO-8859-1'), 1, 1, "L");
}
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(40, 9, mb_convert_encoding("Segundo Corte", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(60, 9, mb_convert_encoding("15%", 'ISO-8859-1'), 1, 0, "C");
$pdf->Cell(60, 9, mb_convert_encoding("15%", 'ISO-8859-1'), 1, 0, "C");
$pdf->Cell(40, 9, mb_convert_encoding("30%", 'ISO-8859-1'), 1, 1, "C");

$pdf->Cell(40, 9, mb_convert_encoding("Tercer Corte", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(60, 9, mb_convert_encoding("20%", 'ISO-8859-1'), 1, 0, "C");
$pdf->Cell(60, 9, mb_convert_encoding("20%", 'ISO-8859-1'), 1, 0, "C");
$pdf->Cell(40, 9, mb_convert_encoding("40%", 'ISO-8859-1'), 1, 1, "C");
$pdf->Cell(160, 9, mb_convert_encoding("Porcentaje final", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(40, 9, mb_convert_encoding("100%", 'ISO-8859-1'), 1, 1, "C");
//$pdf->Cell(200, 12, "", 0, 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(200, 12, mb_convert_encoding("2.4.2. Escala de valoración de los niveles de desempeño", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(200, 12, mb_convert_encoding("Niveles de Desempeño", 'ISO-8859-1'), 1, 1, "C");
$pdf->Cell(50, 9, mb_convert_encoding("Nivel 1", 'ISO-8859-1'), 1, 0, "C");
$pdf->Cell(50, 9, mb_convert_encoding("Nivel 2", 'ISO-8859-1'), 1, 0, "C");
$pdf->Cell(50, 9, mb_convert_encoding("Nivel 3", 'ISO-8859-1'), 1, 0, "C");
$pdf->Cell(50, 9, mb_convert_encoding("Nivel 4", 'ISO-8859-1'), 1, 1, "C");
$pdf->Cell(50, 9, mb_convert_encoding("1.0 - 2.9", 'ISO-8859-1'), 1, 0, "C");
$pdf->Cell(50, 9, mb_convert_encoding("3.0 - 3.7", 'ISO-8859-1'), 1, 0, "C");
$pdf->Cell(50, 9, mb_convert_encoding("3.8 - 4.5", 'ISO-8859-1'), 1, 0, "C");
$pdf->Cell(50, 9, mb_convert_encoding("4.6 - 5.0", 'ISO-8859-1'), 1, 1, "C");
//$pdf->Ln(50); 
$pdf->SetY(250); // Posición desde el final
$pdf->SetFont("Arial", "", 6);
$pdf->Cell(25, 5, mb_convert_encoding("Fecha y Hora de impresión", 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(5);
$pdf->Cell(10, 5, date('d/m/Y'), 0, 0, 'L');
$pdf->Cell(5);
date_default_timezone_set("America/Bogota");
$pdf->Cell(10, 5, date("h:i:sa"), 0, 0, 'L');
$pdf->Cell(5);
$pdf->Cell(80, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(0, 5, mb_convert_encoding('Página', 'ISO-8859-1') . $pdf->PageNo() . '/{nb}', 0, 0, "R");


//pagina unidad 1
$pdf->AddPage("L", "Letter");
$pdf->Cell(60, 21, $pdf->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(160, 21, "Microcurriculo", 1, 0, "C");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->codigo, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(220);
$pdf->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->version, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(220);
$pdf->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->fecha, 'ISO-8859-1'), 1, 1, "L");
$pdf->SetFont("Arial", "B", 12);
$pdf->SetFillColor(181,178,178);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(260, 8, mb_convert_encoding("III. Unidades de formación", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 14);
$pdf->Cell(65, 8, mb_convert_encoding("Unidad 1", 'ISO-8859-1'), 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(50, 8, mb_convert_encoding("Horas Presenciales", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 8, mb_convert_encoding($obj->u1_hp, 'ISO-8859-1'), 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(50, 8, mb_convert_encoding("Horas Independientes", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 8, mb_convert_encoding($obj->u1_hi, 'ISO-8859-1'), 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(50, 8, mb_convert_encoding("Corte / Semanas", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 8, mb_convert_encoding($obj->u1_cortesemanas, 'ISO-8859-1'), 1, 1, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Resultados de aprendizaje de la asignatura", 'ISO-8859-1'), 1, 1, "L", true);

// Contenido original con líneas en blanco
$content1 = $obj->u1_resultados;
$content2 = $obj->u1_contenidos;
$content3 = $obj->u1_actividades;
$content4 = $obj->u1_evaluacion;


// Eliminar líneas en blanco
$cleanedContent1 = preg_replace("/\n\s*\n/", "\n", trim($content1));
$cleanedContent2 = preg_replace("/\n\s*\n/", "\n", trim($content2));
$cleanedContent3 = preg_replace("/\n\s*\n/", "\n", trim($content3));
$cleanedContent4 = preg_replace("/\n\s*\n/", "\n", trim($content4));
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent1, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Contenidos", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent2, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Actividades Formativas", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent3, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Sistema de evaluación", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent4, 'ISO-8859-1'), 1, "J");
$pdf->SetY(190); // Posición desde el final
$pdf->SetFont("Arial", "", 6);
$pdf->Cell(25, 5, mb_convert_encoding("Fecha y Hora de impresión", 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(5);
$pdf->Cell(10, 5, date('d/m/Y'), 0, 0, 'L');
$pdf->Cell(5);
date_default_timezone_set("America/Bogota");
$pdf->Cell(10, 5, date("h:i:sa"), 0, 0, 'L');
$pdf->Cell(5);
$pdf->Cell(80, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(0, 5, mb_convert_encoding('Página', 'ISO-8859-1') . $pdf->PageNo() . '/{nb}', 0, 0, "R");
//pagina unidad 2
$pdf->AddPage("L", "Letter");
$pdf->Cell(60, 21, $pdf->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(160, 21, "Microcurriculo", 1, 0, "C");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->codigo, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(220);
$pdf->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->version, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(220);
$pdf->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->fecha, 'ISO-8859-1'), 1, 1, "L");
$pdf->SetFont("Arial", "B", 12);
$pdf->SetFillColor(181,178,178);
//$pdf->SetFillColor(255, 0, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 14);
$pdf->Cell(65, 12, mb_convert_encoding("Unidad 2", 'ISO-8859-1'), 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(50, 12, mb_convert_encoding("Horas Presenciales", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 12, mb_convert_encoding($obj->u2_hp, 'ISO-8859-1'), 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(50, 12, mb_convert_encoding("Horas Independientes", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 12, mb_convert_encoding($obj->u2_hi, 'ISO-8859-1'), 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(50, 12, mb_convert_encoding("Corte / Semanas", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 12, mb_convert_encoding($obj->u2_cortesemanas, 'ISO-8859-1'), 1, 1, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Resultados de aprendizaje de la asignatura", 'ISO-8859-1'), 1, 1, "L", true);

// Contenido original con líneas en blanco
$content1 = $obj->u2_resultados;
$content2 = $obj->u2_contenidos;
$content3 = $obj->u2_actividades;
$content4 = $obj->u2_evaluacion;


// Eliminar líneas en blanco
$cleanedContent1 = preg_replace("/\n\s*\n/", "\n", trim($content1));
$cleanedContent2 = preg_replace("/\n\s*\n/", "\n", trim($content2));
$cleanedContent3 = preg_replace("/\n\s*\n/", "\n", trim($content3));
$cleanedContent4 = preg_replace("/\n\s*\n/", "\n", trim($content4));

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent1, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Contenidos", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent2, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Actividades Formativas", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent3, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Sistema de evaluación", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent4, 'ISO-8859-1'), 1, "J");
$pdf->SetY(190); // Posición desde el final
$pdf->SetFont("Arial", "", 6);
$pdf->Cell(25, 5, mb_convert_encoding("Fecha y Hora de impresión", 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(5);
$pdf->Cell(10, 5, date('d/m/Y'), 0, 0, 'L');
$pdf->Cell(5);
date_default_timezone_set("America/Bogota");
$pdf->Cell(10, 5, date("h:i:sa"), 0, 0, 'L');
$pdf->Cell(5);
$pdf->Cell(80, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(0, 5, mb_convert_encoding('Página', 'ISO-8859-1') . $pdf->PageNo() . '/{nb}', 0, 0, "R");
//pagina unidad 3
$pdf->AddPage("L", "Letter");
$pdf->Cell(60, 21, $pdf->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(160, 21, "Microcurriculo", 1, 0, "C");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->codigo, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(220);
$pdf->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->version, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(220);
$pdf->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->fecha, 'ISO-8859-1'), 1, 1, "L");
$pdf->SetFont("Arial", "B", 12);
$pdf->SetFillColor(181,178,178);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 14);
$pdf->Cell(65, 12, mb_convert_encoding("Unidad 3", 'ISO-8859-1'), 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(50, 12, mb_convert_encoding("Horas Presenciales", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 12, mb_convert_encoding($obj->u3_hp, 'ISO-8859-1'), 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(50, 12, mb_convert_encoding("Horas Independientes", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 12, mb_convert_encoding($obj->u3_hi, 'ISO-8859-1'), 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(50, 12, mb_convert_encoding("Corte / Semanas", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 12, mb_convert_encoding($obj->u3_cortesemanas, 'ISO-8859-1'), 1, 1, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Resultados de aprendizaje de la asignatura", 'ISO-8859-1'), 1, 1, "L", true);
// Contenido original con líneas en blanco
$content1 = $obj->u3_resultados;
$content2 = $obj->u3_contenidos;
$content3 = $obj->u3_actividades;
$content4 = $obj->u3_evaluacion;

// Eliminar líneas en blanco
$cleanedContent1 = preg_replace("/\n\s*\n/", "\n", trim($content1));
$cleanedContent2 = preg_replace("/\n\s*\n/", "\n", trim($content2));
$cleanedContent3 = preg_replace("/\n\s*\n/", "\n", trim($content3));
$cleanedContent4 = preg_replace("/\n\s*\n/", "\n", trim($content4));

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent1, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Contenidos", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent2, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Actividades Formativas", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent3, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Sistema de evaluación", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent4, 'ISO-8859-1'), 1, "J");
$pdf->SetY(190); // Posición desde el final
$pdf->SetFont("Arial", "", 6);
$pdf->Cell(25, 5, mb_convert_encoding("Fecha y Hora de impresión", 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(5);
$pdf->Cell(10, 5, date('d/m/Y'), 0, 0, 'L');
$pdf->Cell(5);
date_default_timezone_set("America/Bogota");
$pdf->Cell(10, 5, date("h:i:sa"), 0, 0, 'L');
$pdf->Cell(5);
$pdf->Cell(80, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(0, 5, mb_convert_encoding('Página', 'ISO-8859-1') . $pdf->PageNo() . '/{nb}', 0, 0, "R");
//pagina unidad 4
$pdf->AddPage("L", "Letter");
$pdf->Cell(60, 21, $pdf->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(160, 21, "Microcurriculo", 1, 0, "C");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->codigo, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(220);
$pdf->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->version, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(220);
$pdf->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->fecha, 'ISO-8859-1'), 1, 1, "L");
$pdf->SetFont("Arial", "B", 12);
$pdf->SetFillColor(181,178,178);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 14);
$pdf->Cell(65, 12, mb_convert_encoding("Unidad 4", 'ISO-8859-1'), 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(50, 12, mb_convert_encoding("Horas Presenciales", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 12, mb_convert_encoding($obj->u4_hp, 'ISO-8859-1'), 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(50, 12, mb_convert_encoding("Horas Independientes", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 12, mb_convert_encoding($obj->u4_hi, 'ISO-8859-1'), 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(50, 12, mb_convert_encoding("Corte / Semanas", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 12, mb_convert_encoding($obj->u4_cortesemanas, 'ISO-8859-1'), 1, 1, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Resultados de aprendizaje de la asignatura", 'ISO-8859-1'), 1, 1, "L", true);

// Contenido original con líneas en blanco
$content1 = $obj->u4_resultados;
$content2 = $obj->u4_contenidos;
$content3 = $obj->u4_actividades;
$content4 = $obj->u4_evaluacion;

// Eliminar líneas en blanco
$cleanedContent1 = preg_replace("/\n\s*\n/", "\n", trim($content1));
$cleanedContent2 = preg_replace("/\n\s*\n/", "\n", trim($content2));
$cleanedContent3 = preg_replace("/\n\s*\n/", "\n", trim($content3));
$cleanedContent4 = preg_replace("/\n\s*\n/", "\n", trim($content4));

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent1, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Contenidos", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent2, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Actividades Formativas", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent3, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Sistema de evaluación", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent4, 'ISO-8859-1'), 1, "J");
$pdf->SetY(190); // Posición desde el final
$pdf->SetFont("Arial", "", 6);
$pdf->Cell(25, 5, mb_convert_encoding("Fecha y Hora de impresión", 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(5);
$pdf->Cell(10, 5, date('d/m/Y'), 0, 0, 'L');
$pdf->Cell(5);
date_default_timezone_set("America/Bogota");
$pdf->Cell(10, 5, date("h:i:sa"), 0, 0, 'L');
$pdf->Cell(5);
$pdf->Cell(80, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(0, 5, mb_convert_encoding('Página', 'ISO-8859-1') . $pdf->PageNo() . '/{nb}', 0, 0, "R");
//pagina unidad 5
$pdf->AddPage("L", "Letter");
$pdf->Cell(60, 21, $pdf->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(160, 21, "Microcurriculo", 1, 0, "C");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->codigo, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(220);
$pdf->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->version, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(220);
$pdf->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->fecha, 'ISO-8859-1'), 1, 1, "L");
$pdf->SetFont("Arial", "B", 12);
$pdf->SetFillColor(181,178,178);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 14);
$pdf->Cell(65, 12, mb_convert_encoding("Unidad 5", 'ISO-8859-1'), 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(50, 12, mb_convert_encoding("Horas Presenciales", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 12, mb_convert_encoding($obj->u5_hp, 'ISO-8859-1'), 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(50, 12, mb_convert_encoding("Horas Independientes", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 12, mb_convert_encoding($obj->u5_hi, 'ISO-8859-1'), 1, 0, "C");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(50, 12, mb_convert_encoding("Corte / Semanas", 'ISO-8859-1'), 1, 0, "L");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 12, mb_convert_encoding($obj->u5_cortesemanas, 'ISO-8859-1'), 1, 1, "C");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Resultados de aprendizaje de la asignatura", 'ISO-8859-1'), 1, 1, "L", true);

// Contenido original con líneas en blanco
$content1 = $obj->u5_resultados;
$content2 = $obj->u5_contenidos;
$content3 = $obj->u5_actividades;
$content4 = $obj->u5_evaluacion;

// Eliminar líneas en blanco
$cleanedContent1 = preg_replace("/\n\s*\n/", "\n", trim($content1));
$cleanedContent2 = preg_replace("/\n\s*\n/", "\n", trim($content2));
$cleanedContent3 = preg_replace("/\n\s*\n/", "\n", trim($content3));
$cleanedContent4 = preg_replace("/\n\s*\n/", "\n", trim($content4));

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent1, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Contenidos", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent2, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Actividades Formativas", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent3, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 8, mb_convert_encoding("Sistema de evaluación", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($cleanedContent4, 'ISO-8859-1'), 1, "J");
$pdf->SetY(190); // Posición desde el final
$pdf->SetFont("Arial", "", 6);
$pdf->Cell(25, 5, mb_convert_encoding("Fecha y Hora de impresión", 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(5);
$pdf->Cell(10, 5, date('d/m/Y'), 0, 0, 'L');
$pdf->Cell(5);
date_default_timezone_set("America/Bogota");
$pdf->Cell(10, 5, date("h:i:sa"), 0, 0, 'L');
$pdf->Cell(5);
$pdf->Cell(80, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(0, 5, mb_convert_encoding('Página', 'ISO-8859-1') . $pdf->PageNo() . '/{nb}', 0, 0, "R");
//pagina proyecto
$pdf->AddPage("L", "Letter");
$pdf->Cell(60, 21, $pdf->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(160, 21, "Microcurriculo", 1, 0, "C");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->codigo, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(220);
$pdf->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->version, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(220);
$pdf->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->fecha, 'ISO-8859-1'), 1, 1, "L");
$pdf->SetFont("Arial", "B", 12);
$pdf->SetFillColor(181,178,178);
//$pdf->SetFillColor(255, 0, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(260, 8, mb_convert_encoding("IV. Proyecto Integrador", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 6, mb_convert_encoding("Nombre del Proyecto:", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(260, 20, mb_convert_encoding($obj->nombre_proyecto, 'ISO-8859-1'), 1, 1, "J");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 6, mb_convert_encoding("Objetivo General del proyecto", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($obj->proy_asignaturas, 'ISO-8859-1'), 1, "J");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 6, mb_convert_encoding("Objetivos especificos del proyecto:", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($obj->proy_tematicas, 'ISO-8859-1'), 1, "J");
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 6, mb_convert_encoding("Resultados esperados del proyecto:", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($obj->proy_acciones, 'ISO-8859-1'), 1, "J");
$pdf->SetFont("Arial", "", 6);
$pdf->Cell(25, 5, mb_convert_encoding("Fecha y Hora de impresión", 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(5);
$pdf->Cell(10, 5, date('d/m/Y'), 0, 0, 'L');
$pdf->Cell(5);
date_default_timezone_set("America/Bogota");
$pdf->Cell(10, 5, date("h:i:sa"), 0, 0, 'L');
$pdf->Cell(5);
$pdf->Cell(80, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(0, 5, mb_convert_encoding('Página', 'ISO-8859-1') . $pdf->PageNo() . '/{nb}', 0, 0, "R");
//pagina referencias
$pdf->AddPage("L", "Letter");
$pdf->Cell(60, 21, $pdf->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(160, 21, "Microcurriculo", 1, 0, "C");
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(15, 7, mb_convert_encoding("Código:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->codigo, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(220);
$pdf->Cell(15, 7, mb_convert_encoding("Versión:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->version, 'ISO-8859-1'), 1, 1, "L");
$pdf->Cell(220);
$pdf->Cell(15, 7, mb_convert_encoding("Fecha:", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(25, 7, mb_convert_encoding($obj2->fecha, 'ISO-8859-1'), 1, 1, "L");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(260, 7, mb_convert_encoding("V. Referencias", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 7, mb_convert_encoding("5.1. Bibliografía existente en la biblioteca institucional", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($obj->ref_biblio, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 7, mb_convert_encoding("5.2. Otra bibliografía", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($obj->ref_otra, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 7, mb_convert_encoding("5.3. Referencias en inglés", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($obj->ref_ingles, 'ISO-8859-1'), 1, "J");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 7, mb_convert_encoding("5.4. Webgrafía y bases de datos", 'ISO-8859-1'), 1, 1, "L", true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "", 9);
$pdf->MultiCell(260, 5, mb_convert_encoding($obj->ref_webgrafia, 'ISO-8859-1'), 1, "J");
$pdf->SetFont("Arial", "", 6);
//validacion
$pdf->SetFillColor(181, 178, 178);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont("Arial", "B", 9);
$pdf->Cell(260, 5, mb_convert_encoding("RESPONSABLES MICROCURRICULO", 'ISO-8859-1'), 1, 1, "C", true);
$X1=$pdf->GetX();
$Y1=$pdf->GetY();

$pdf->SetFont("Arial", "", 6);
$pdf->rect($X1, $Y1, 85, 25);
$pdf->rect(95, $Y1, 90, 25);
$pdf->rect(185, $Y1, 85, 25);
$pdf->Ln(16);
$pdf->Cell(85, 3, mb_convert_encoding($obj->nombre_docente, 'ISO-8859-1'), 0, 0, "C");
$pdf->Cell(90, 3, mb_convert_encoding($obj->validador1, 'ISO-8859-1'), 0, 0, "C");
$pdf->Cell(85, 3, mb_convert_encoding($obj->validador2, 'ISO-8859-1'), 0, 1, "C");
$pdf->SetFont("Arial", "", 5);
$pdf->Cell(85, 2, mb_convert_encoding($obj->nombre_programa, 'ISO-8859-1'), 0, 0, "C");
$pdf->Cell(90, 2, mb_convert_encoding("COORDINADOR " . $obj->nombre_programa, 'ISO-8859-1'), 0, 0, "C");
$pdf->Cell(85, 2, mb_convert_encoding("VICERECTORIA ACADEMICA", 'ISO-8859-1'), 0, 1, "C");
$pdf->SetFont("Arial", "", 6);
$pdf->Cell(85, 2, mb_convert_encoding("ELABORÓ", 'ISO-8859-1'), 0, 0, "C");
$pdf->Cell(90, 2, mb_convert_encoding("REVISÓ", 'ISO-8859-1'), 0, 0, "C");
$pdf->Cell(85, 2, mb_convert_encoding("APROBÓ", 'ISO-8859-1'), 0, 1, "C");
$pdf->Ln(3);
//pie de pagina ultima
$pdf->SetY(190); // Posición desde el final
$pdf->SetFont("Arial", "", 6);
$pdf->Cell(25, 5, mb_convert_encoding("Fecha y Hora de impresión", 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(5);
$pdf->Cell(10, 5, date('d/m/Y'), 0, 0, 'L');
$pdf->Cell(5);
date_default_timezone_set("America/Bogota");
$pdf->Cell(10, 5, date("h:i:sa"), 0, 0, 'L');
$pdf->Cell(5);
$pdf->Cell(80, 5, mb_convert_encoding($obj->nombre_asignatura, 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(22, 5, mb_convert_encoding("Fecha actualización:", 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(25, 5,date("d/m/Y", strtotime($obj->fecha_actualizacion)), 0, 0, "L");
//mb_convert_encoding($obj->fecha_actualizacion, 'ISO-8859-1'), 0, 0, "L");
$pdf->Cell(0, 5, mb_convert_encoding('Página ', 'ISO-8859-1') . $pdf->PageNo() . '/{nb}', 0, 0, "R");

$pdf->Output('I', 'reporte_microcurriculo.pdf');
