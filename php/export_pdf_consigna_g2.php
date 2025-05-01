<?php
date_default_timezone_set("America/Bogota");
require('../fpdf/fpdf.php');

$docente = $_GET['docente'] ?? null;
$periodo = $_GET['periodo'] ?? null;

include 'conexion6.php';

// Validar
if (!$docente || !$periodo) {
    die("Faltan parámetros para generar el PDF.");
}

// Obtener nombre del docente
$stmtDoc = $conn->prepare("SELECT nomcompleto FROM sistema.usuarios WHERE codigo_usuario = :codigo");
$stmtDoc->execute(['codigo' => $docente]);
$nombreDocente = $stmtDoc->fetchColumn() ?: "No encontrado";

class PDF extends FPDF
{
    public $nombre_docente;
    public $periodo;

    function setDatos($nombre_docente, $periodo)
    {
        $this->nombre_docente = $nombre_docente;
        $this->periodo = $periodo;
    }

    function Header()
    {
        $this->Cell(60, 21, $this->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
        $this->SetFont("Arial", "B", 12);
        $this->rect(10, 10, 260, 21);
        $this->Cell(200, 14, mb_convert_encoding("CONSIGNADOR ACADEMICO / GRAFICO AVANCE POR DOCENTE", 'ISO-8859-1'), 0, 1, "C");

        $this->SetFont("Arial", "", 9);
        /* $this->Cell(220); */
        $this->Cell(60);

        $this->SetFont("Arial", "B", 12);
        $texto = "DOCENTE: " . $this->nombre_docente . "   AÑO: " . $this->periodo;
        $this->Cell(200, 7, mb_convert_encoding($texto, 'ISO-8859-1'), 0, 0, "C");

        $this->SetFont("Arial", "B", 9);
        $this->SetFillColor(181, 178, 178);
        $this->SetTextColor(0, 0, 0);
        $this->Ln(5);
    }
    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);

        // Fecha de generación
        $fecha = date('d/m/Y H:i:s');

        // Número de página y fecha
        $this->Cell(0, 10, mb_convert_encoding('Generado el: ' . $fecha . ' | Página', 'ISO-8859-1')  . $this->PageNo() . '/{nb}',  0, 0, 'C');
    }
}


$pdf = new PDF();
$pdf->AliasNbPages(); // Para total de páginas
$pdf->setDatos($nombreDocente, $periodo); // <- pasar nombre y periodo
$pdf->AddPage("L", "Letter");
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln(5);

// Verificar si el gráfico existe y agregarlo al PDF
if (file_exists("../images/graficos/graficoc2.png")) {
    $grafico_y_inicial = 35; // Esto evita que se sobreponga al encabezado
    $pdf->SetY($grafico_y_inicial);

    $grafico_ancho = 150;
    $grafico_x = ($pdf->GetPageWidth() - $grafico_ancho) / 2;

    $pdf->Image("../images/graficos/graficoc2.png", $grafico_x, $grafico_y_inicial, $grafico_ancho);

    // Mover el cursor más abajo para evitar que la tabla se pegue al gráfico
    $pdf->SetY($grafico_y_inicial + 80);
    $pdf->Ln(5);
}

// Encabezados de la tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 10, mb_convert_encoding("Código", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(85, 10, 'Asignatura', 1);
$pdf->Cell(12, 10, 'Sem.', 1);
$pdf->Cell(12, 10, 'Grupo', 1);
$pdf->Cell(80, 10, 'Programa', 1);
$pdf->Cell(22, 10, 'Avance (%)', 1);
$pdf->Cell(25, 10, mb_convert_encoding("F. Consigna...", 'ISO-8859-1'), 1, 0, "L");
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);


$query = "SELECT 
  m2.codigo_asignatura, 
  m2.nombre_asignatura, 
  m2.grupo, 
  m2.nombre_programa, 
  m2.semestre,

  ROUND(
    (
      SELECT COUNT(*) 
      FROM (
        SELECT unnest(array[
          m2.s1_contenidos, m2.s2_contenidos, m2.s3_contenidos,
          m2.s4_contenidos, m2.s5_contenidos, m2.s6_contenidos,
          m2.s7_contenidos, m2.s8_contenidos, m2.s9_contenidos,
          m2.s10_contenidos, m2.s11_contenidos, m2.s12_contenidos,
          m2.s13_contenidos, m2.s14_contenidos, m2.s15_contenidos,
          m2.s16_contenidos, m2.s17_contenidos, m2.s18_contenidos
        ]) AS contenido
      ) AS unn
      WHERE LENGTH(TRIM(contenido)) > 1
    ) / 18.0 * 100
  , 2) AS avance,

  (
    SELECT COUNT(*) 
    FROM (
      SELECT unnest(array[
        m2.s1_contenidos, m2.s2_contenidos, m2.s3_contenidos,
        m2.s4_contenidos, m2.s5_contenidos, m2.s6_contenidos,
        m2.s7_contenidos, m2.s8_contenidos, m2.s9_contenidos,
        m2.s10_contenidos, m2.s11_contenidos, m2.s12_contenidos,
        m2.s13_contenidos, m2.s14_contenidos, m2.s15_contenidos,
        m2.s16_contenidos, m2.s17_contenidos, m2.s18_contenidos
      ]) AS contenido
    ) AS unn
    WHERE LENGTH(TRIM(contenido)) > 1
  ) AS total_semanas,

  m2.fecha_consigna

FROM sistema.m2 m2
WHERE m2.codigo_docente = '$docente'
  AND m2.codigo_periodo = '$periodo'";


$stmt = $conn->query($query);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(20, 10, $row['codigo_asignatura'], 1);
    $nombre_asig = mb_strimwidth($row['nombre_asignatura'], 0, 35, '...'); // 35 + 3 = 38
    $pdf->Cell(85, 10, mb_convert_encoding($nombre_asig, 'ISO-8859-1'), 1);
    $pdf->Cell(12, 10, $row['semestre'], 1, 0);
    $pdf->Cell(12, 10, $row['grupo'], 1, 0);
    $nombre_programa = mb_strimwidth($row['nombre_programa'], 0, 38, '...'); // 38 + 3 = 41
    $pdf->Cell(80, 10, mb_convert_encoding($nombre_programa, 'ISO-8859-1'), 1);
    /* $pdf->Cell(50, 10, mb_convert_encoding($row['nombre_programa'], 'ISO-8859-1'), 1); */
    $pdf->Cell(22, 10, $row['avance'] . '%', 1);
    $pdf->Cell(25, 10, $row['fecha_consigna'], 1);
    $pdf->Ln();
}

$pdf->Output("I", "reporte_avance_c.pdf");
