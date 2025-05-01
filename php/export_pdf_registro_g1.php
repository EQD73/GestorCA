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
        $this->Cell(200, 14, mb_convert_encoding("REGISTRO DE ACTIVIDADES / GRAFICO AVANCE POR PROGRAMA", 'ISO-8859-1'), 0, 1, "C");

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
if (file_exists("../images/graficos/graficor1.png")) {
    $grafico_y_inicial = 35; // Esto evita que se sobreponga al encabezado
    $pdf->SetY($grafico_y_inicial);

    $grafico_ancho = 150;
    $grafico_x = ($pdf->GetPageWidth() - $grafico_ancho) / 2;

    $pdf->Image("../images/graficos/graficor1.png", $grafico_x, $grafico_y_inicial, $grafico_ancho);

    // Mover el cursor más abajo para evitar que la tabla se pegue al gráfico
    $pdf->SetY($grafico_y_inicial + 80);
    $pdf->Ln(5);
}


$pdf->Output("I", "reporte_avance_programasr.pdf");
