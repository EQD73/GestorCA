<?php
date_default_timezone_set("America/Bogota");
require('../fpdf/fpdf.php');

include 'conexion.php';

// Obtener los filtros desde la URL
$periodo = isset($_GET['periodo']) ? pg_escape_string($conexion, $_GET['periodo']) : '';
$codigo_programa = isset($_GET['codigo_programa']) ? pg_escape_string($conexion, $_GET['codigo_programa']) : '';
$codigo_asignatura = isset($_GET['codigo_asignatura']) ? pg_escape_string($conexion, $_GET['codigo_asignatura']) : '';
$semestre = isset($_GET['semestre']) ? pg_escape_string($conexion, $_GET['semestre']) : '';
$grupo = isset($_GET['grupo']) ? pg_escape_string($conexion, $_GET['grupo']) : '';


// Validar  || !$codigo_asignaturacurso || !$semestre
if (!$periodo || !$codigo_programa) {
    die("Faltan parámetros para generar el PDF.");
}

// Obtener nombre del programa
$consulta_programa = "SELECT nombre_programa FROM sistema.programas WHERE codigo_programa = '$codigo_programa' LIMIT 1";
$resultado_programa = pg_query($conexion, $consulta_programa);
$nombre_programa = "Programa desconocido";

if ($resultado_programa && pg_num_rows($resultado_programa) > 0) {
    $fila = pg_fetch_assoc($resultado_programa);
    $nombre_programa = $fila['nombre_programa'];
}

class PDF extends FPDF
{
    public $codigo_programa;
    public $periodo;
    public $codigo_asignatura;
    public $semestre;
    public $grupo;
    public $nombre_programa;


    function setDatos($periodo, $codigo_programa, $codigo_asignaturacurso, $semestre, $nombre_programa)
    {
        $this->codigo_programa = $codigo_programa;
        $this->periodo = $periodo;
        $this->codigo_asignaturacurso = $codigo_asignaturacurso;
        $this->semestre = $semestre;
        $this->nombre_programa = $nombre_programa;
    }

    function Header()
    {
        $this->Cell(60, 21, $this->Image("../assets/images/logo.png", 12, 12, 50), 1, 0);
        $this->SetFont("Arial", "B", 12);
        $this->rect(10, 10, 260, 21);
        $this->Cell(200, 14, mb_convert_encoding("CONSIGNADOR ACADEMICO / GRAFICO AVANCE POR PROGRAMA", 'ISO-8859-1'), 0, 1, "C");

        $this->SetFont("Arial", "", 9);
        /* $this->Cell(220); */
        $this->Cell(60);

        // Mostrar PROGRAMA, SEMESTRE y AÑO
        $this->SetFont("Arial", "B", 11);
        $texto = "PROGRAMA: " . mb_strtoupper($this->nombre_programa, 'UTF-8') .
            "   |   SEMESTRE: " . $this->semestre .
            "   |   PERIODO: " . $this->periodo;

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
$pdf->setDatos($periodo, $codigo_programa, $codigo_asignatura, $semestre, $nombre_programa);
$pdf->AddPage("L", "Letter");
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln(5);

// Verificar si el gráfico existe y agregarlo al PDF
if (file_exists("../images/graficos/graficoc1.png")) {
    $grafico_y_inicial = 35; // Esto evita que se sobreponga al encabezado
    $pdf->SetY($grafico_y_inicial);

    $grafico_ancho = 150;
    $grafico_x = ($pdf->GetPageWidth() - $grafico_ancho) / 2;

    $pdf->Image("../images/graficos/graficoc1.png", $grafico_x, $grafico_y_inicial, $grafico_ancho);

    // Mover el cursor más abajo para evitar que la tabla se pegue al gráfico
    $pdf->SetY($grafico_y_inicial + 80);
    $pdf->Ln(5);
}

//* / Encabezados de la tabla
/* $pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 10, mb_convert_encoding("Código", 'ISO-8859-1'), 1, 0, "L");
$pdf->Cell(85, 10, 'Asignatura', 1);
$pdf->Cell(12, 10, 'Sem.', 1);
$pdf->Cell(12, 10, 'Grupo', 1);
$pdf->Cell(80, 10, 'Programa', 1);
$pdf->Cell(22, 10, 'Avance (%)', 1);
$pdf->Cell(25, 10, mb_convert_encoding("Última Act.", 'ISO-8859-1'), 1, 0, "L");
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);

 */

/* $query = "SELECT 
            sistema.m1.codigo_asignaturacurso, 
            sistema.m1.nombre_asignatura, 
            sistema.m1.grupo, 
            sistema.m1.nombre_programa, 
            sistema.m1.semestre, 
            ROUND(
                ( 
                    (CASE WHEN LENGTH(TRIM(sistema.m1.u1_resultados)) > 1 THEN 1 ELSE 0 END) +
                    (CASE WHEN LENGTH(TRIM(sistema.m1.u2_resultados)) > 1 THEN 1 ELSE 0 END) +
                    (CASE WHEN LENGTH(TRIM(sistema.m1.u3_resultados)) > 1 THEN 1 ELSE 0 END) +
                    (CASE WHEN LENGTH(TRIM(sistema.m1.u4_resultados)) > 1 THEN 1 ELSE 0 END) +
                    (CASE WHEN LENGTH(TRIM(sistema.m1.u5_resultados)) > 1 THEN 1 ELSE 0 END)
                ) / 5.0 * 100, 2
            ) AS avance,
            sistema.m1.fecha_actualizacion
          FROM sistema.m1
          WHERE sistema.m1.codigo_docente = '$docente' AND sistema.m1.ano_micro = '$ano_micro' ";
 */
/*$stmt = $conn->query($query);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(20, 10, $row['codigo_asignaturacurso'], 1);
    $nombre_asig = mb_strimwidth($row['nombre_asignatura'], 0, 35, '...'); // 35 + 3 = 38
    $pdf->Cell(85, 10, mb_convert_encoding($nombre_asig, 'ISO-8859-1'), 1);
    $pdf->Cell(12, 10, $row['semestre'], 1, 0);
    $pdf->Cell(12, 10, $row['grupo'], 1, 0);
    $nombre_programa = mb_strimwidth($row['nombre_programa'], 0, 38, '...'); // 38 + 3 = 41
    $pdf->Cell(80, 10, mb_convert_encoding($nombre_programa, 'ISO-8859-1'), 1);
    /* $pdf->Cell(50, 10, mb_convert_encoding($row['nombre_programa'], 'ISO-8859-1'), 1); 
    $pdf->Cell(22, 10, $row['avance'] . '%', 1);
    $pdf->Cell(25, 10, $row['fecha_actualizacion'], 1);
    $pdf->Ln();
} */

$pdf->Output("I", "reporte_avance_programasc.pdf");
