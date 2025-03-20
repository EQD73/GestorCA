<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];
$tablam2 = $_SESSION['tablam2'];
$tablam3 = $_SESSION['tablam3'];
$codperiodo = $_SESSION['codigo_periodo'];
$nomperiodo = $_SESSION['nombre_periodo'];


include('conexion.php');
include('scriptsweet.php');

$codigoprograma     = $_REQUEST['CodigoPrograma'];
$nombreprograma     = $_REQUEST['NombreProg'];
$codigocurso        = $_REQUEST['CodigoCur'];
$nombrecurso        = $_REQUEST['NombreCurso'];
$fechaconsigna     = date('d-m-Y');
$codigogrupo       = intval($_REQUEST['grupo']);
$semestre          = intval($_REQUEST['semestre']);
$codigodocente     = $_REQUEST['CodigoDocente'];
$nombredocente     = strval($_REQUEST['NomDocente']);
$resultados        = strval($_REQUEST['ResultadosTextarea1']);
$htts              = intval($_REQUEST['HorasTTS']);
$htps              = intval($_REQUEST['HorasTPS']);
$htis              = intval($_REQUEST['HorasTIS']);
/* variables semanas */
if (isset($_POST['titulosem1'])) {
    $titulos1              = strval($_REQUEST['titulosem1']);
} else {
    $titulos1 = "";
}
if (isset($_POST['rangoinicio1'])) {
    $rangoinicio1         = strval($_REQUEST['rangoinicio1']);
} else {
    $rangoinicio1 = "";
}
if (isset($_POST['rangofinal1'])) {
    $rangofinal1         = strval($_REQUEST['rangofinal1']);
} else {
    $rangofinal1 = "";
}

if (isset($_POST['ContenidoSem1'])) {
    $contenidosem1         = strval($_REQUEST['ContenidoSem1']);
} else {
    $contenidosem1 = "";
}
if (isset($_POST['NombreEstrategia1'])) {
    $nombreestrategia1    = strval($_REQUEST['NombreEstrategia1']);
} else {
    $nombreestrategia1 = "";
}
if (isset($_POST['NombreMetodo1'])) {
    $nombremetodo1         = strval($_REQUEST['NombreMetodo1']);
} else {
    $nombremetodo1 = "";
}
//semana 2
if (isset($_POST['titulosem2'])) {
    $titulos2              = strval($_REQUEST['titulosem2']);
} else {
    $titulos2 = "";
}
if (isset($_POST['rangoinicio2'])) {
    $rangoinicio2         = strval($_REQUEST['rangoinicio2']);
} else {
    $rangoinicio2 = "";
}
if (isset($_POST['rangofinal2'])) {
    $rangofinal2         = strval($_REQUEST['rangofinal2']);
} else {
    $rangofinal2 = "";
}
if (isset($_POST['ContenidoSem2'])) {
    $contenidosem2         = strval($_REQUEST['ContenidoSem2']);
} else {
    $contenidosem2 = "";
}
if (isset($_POST['NombreEstrategia2'])) {
    $nombreestrategia2    = strval($_REQUEST['NombreEstrategia2']);
} else {
    $nombreestrategia2 = "";
}
if (isset($_POST['NombreMetodo2'])) {
    $nombremetodo2         = strval($_REQUEST['NombreMetodo2']);
} else {
    $nombremetodo2 = "";
}
//semana 3
if (isset($_POST['titulosem3'])) {
    $titulos3              = strval($_REQUEST['titulosem3']);
} else {
    $titulos3 = "";
}
if (isset($_POST['rangoinicio3'])) {
    $rangoinicio3         = strval($_REQUEST['rangoinicio3']);
} else {
    $rangoinicio3 = "";
}
if (isset($_POST['rangofinal3'])) {
    $rangofinal3         = strval($_REQUEST['rangofinal3']);
} else {
    $rangofinal3 = "";
}
if (isset($_POST['ContenidoSem3'])) {
    $contenidosem3         = strval($_REQUEST['ContenidoSem3']);
} else {
    $contenidosem3 = "";
}
if (isset($_POST['NombreEstrategia3'])) {
    $nombreestrategia3    = strval($_REQUEST['NombreEstrategia3']);
} else {
    $nombreestrategia3 = "";
}
if (isset($_POST['NombreMetodo3'])) {
    $nombremetodo3         = strval($_REQUEST['NombreMetodo3']);
} else {
    $nombremetodo3 = "";
}
//semana 4
if (isset($_POST['titulosem4'])) {
    $titulos4              = strval($_REQUEST['titulosem4']);
} else {
    $titulos4 = "";
}
if (isset($_POST['rangoinicio4'])) {
    $rangoinicio4         = strval($_REQUEST['rangoinicio4']);
} else {
    $rangoinicio4 = "";
}
if (isset($_POST['rangofinal4'])) {
    $rangofinal4         = strval($_REQUEST['rangofinal4']);
} else {
    $rangofinal4 = "";
}
if (isset($_POST['ContenidoSem4'])) {
    $contenidosem4         = strval($_REQUEST['ContenidoSem4']);
} else {
    $contenidosem4 = "";
}
if (isset($_POST['NombreEstrategia4'])) {
    $nombreestrategia4    = strval($_REQUEST['NombreEstrategia4']);
} else {
    $nombreestrategia4 = "";
}
if (isset($_POST['NombreMetodo4'])) {
    $nombremetodo4         = strval($_REQUEST['NombreMetodo4']);
} else {
    $nombremetodo4 = "";
}
//semana 5
if (isset($_POST['titulosem5'])) {
    $titulos5              = strval($_REQUEST['titulosem5']);
} else {
    $titulos5 = "";
}
if (isset($_POST['rangoinicio5'])) {
    $rangoinicio5         = strval($_REQUEST['rangoinicio5']);
} else {
    $rangoinicio5 = "";
}
if (isset($_POST['rangofinal9'])) {
    $rangofinal5         = strval($_REQUEST['rangofinal5']);
} else {
    $rangofinal5 = "";
}

if (isset($_POST['ContenidoSem5'])) {
    $contenidosem5         = strval($_REQUEST['ContenidoSem5']);
} else {
    $contenidosem5 = "";
}
if (isset($_POST['NombreEstrategia5'])) {
    $nombreestrategia5    = strval($_REQUEST['NombreEstrategia5']);
} else {
    $nombreestrategia5 = "";
}
if (isset($_POST['NombreMetodo5'])) {
    $nombremetodo5         = strval($_REQUEST['NombreMetodo5']);
} else {
    $nombremetodo5 = "";
}
//semana 6
if (isset($_POST['titulosem6'])) {
    $titulos6              = strval($_REQUEST['titulosem6']);
} else {
    $titulos6 = "";
}
if (isset($_POST['rangoinicio6'])) {
    $rangoinicio6         = strval($_REQUEST['rangoinicio6']);
} else {
    $rangoinicio6 = "";
}
if (isset($_POST['rangofinal6'])) {
    $rangofinal6         = strval($_REQUEST['rangofinal6']);
} else {
    $rangofinal6 = "";
}

if (isset($_POST['ContenidoSem6'])) {
    $contenidosem6         = strval($_REQUEST['ContenidoSem6']);
} else {
    $contenidosem6 = "";
}
if (isset($_POST['NombreEstrategia6'])) {
    $nombreestrategia6    = strval($_REQUEST['NombreEstrategia6']);
} else {
    $nombreestrategia6 = "";
}
if (isset($_POST['NombreMetodo9'])) {
    $nombremetodo6         = strval($_REQUEST['NombreMetodo6']);
} else {
    $nombremetodo6 = "";
}
//semana 7
if (isset($_POST['titulosem7'])) {
    $titulos7              = strval($_REQUEST['titulosem7']);
} else {
    $titulos7 = "";
}
if (isset($_POST['rangoinicio7'])) {
    $rangoinicio7         = strval($_REQUEST['rangoinicio7']);
} else {
    $rangoinicio7 = "";
}
if (isset($_POST['rangofinal7'])) {
    $rangofinal7         = strval($_REQUEST['rangofinal7']);
} else {
    $rangofinal7 = "";
}

if (isset($_POST['ContenidoSem7'])) {
    $contenidosem7         = strval($_REQUEST['ContenidoSem7']);
} else {
    $contenidosem7 = "";
}
if (isset($_POST['NombreEstrategia7'])) {
    $nombreestrategia7    = strval($_REQUEST['NombreEstrategia7']);
} else {
    $nombreestrategia7 = "";
}
if (isset($_POST['NombreMetodo7'])) {
    $nombremetodo7         = strval($_REQUEST['NombreMetodo7']);
} else {
    $nombremetodo7 = "";
}
//semana 8
if (isset($_POST['titulosem8'])) {
    $titulos8              = strval($_REQUEST['titulosem8']);
} else {
    $titulos8 = "";
}
if (isset($_POST['rangoinicio8'])) {
    $rangoinicio8         = strval($_REQUEST['rangoinicio8']);
} else {
    $rangoinicio8 = "";
}
if (isset($_POST['rangofinal8'])) {
    $rangofinal8         = strval($_REQUEST['rangofinal8']);
} else {
    $rangofinal8 = "";
}

if (isset($_POST['ContenidoSem8'])) {
    $contenidosem8         = strval($_REQUEST['ContenidoSem8']);
} else {
    $contenidosem8 = "";
}
if (isset($_POST['NombreEstrategia8'])) {
    $nombreestrategia8    = strval($_REQUEST['NombreEstrategia8']);
} else {
    $nombreestrategia8 = "";
}
if (isset($_POST['NombreMetodo8'])) {
    $nombremetodo8         = strval($_REQUEST['NombreMetodo8']);
} else {
    $nombremetodo8 = "";
}
//semana 9
if (isset($_POST['titulosem9'])) {
    $titulos9              = strval($_REQUEST['titulosem9']);
} else {
    $titulos9 = "";
}
if (isset($_POST['rangoinicio9'])) {
    $rangoinicio9         = strval($_REQUEST['rangoinicio9']);
} else {
    $rangoinicio9 = "";
}
if (isset($_POST['rangofinal9'])) {
    $rangofinal9         = strval($_REQUEST['rangofinal9']);
} else {
    $rangofinal9 = "";
}

if (isset($_POST['ContenidoSem9'])) {
    $contenidosem9         = strval($_REQUEST['ContenidoSem9']);
} else {
    $contenidosem9 = "";
}
if (isset($_POST['NombreEstrategia9'])) {
    $nombreestrategia9    = strval($_REQUEST['NombreEstrategia9']);
} else {
    $nombreestrategia9 = "";
}
if (isset($_POST['NombreMetodo9'])) {
    $nombremetodo9         = strval($_REQUEST['NombreMetodo9']);
} else {
    $nombremetodo9 = "";
}
//semana 10
if (isset($_POST['titulosem10'])) {
    $titulos10              = strval($_REQUEST['titulosem10']);
} else {
    $titulos10 = "";
}
if (isset($_POST['rangoinicio10'])) {
    $rangoinicio10         = strval($_REQUEST['rangoinicio10']);
} else {
    $rangoinicio10 = "";
}
if (isset($_POST['rangofinal10'])) {
    $rangofinal10         = strval($_REQUEST['rangofinal10']);
} else {
    $rangofinal10 = "";
}

if (isset($_POST['ContenidoSem10'])) {
    $contenidosem10         = strval($_REQUEST['ContenidoSem10']);
} else {
    $contenidosem10 = "";
}
if (isset($_POST['NombreEstrategia10'])) {
    $nombreestrategia10    = strval($_REQUEST['NombreEstrategia10']);
} else {
    $nombreestrategia10 = "";
}
if (isset($_POST['NombreMetodo10'])) {
    $nombremetodo10         = strval($_REQUEST['NombreMetodo10']);
} else {
    $nombremetodo10 = "";
}
//semana 11
if (isset($_POST['titulosem11'])) {
    $titulos11              = strval($_REQUEST['titulosem11']);
} else {
    $titulos11 = "";
}
if (isset($_POST['rangoinicio11'])) {
    $rangoinicio11         = strval($_REQUEST['rangoinicio11']);
} else {
    $rangoinicio11 = "";
}
if (isset($_POST['rangofinal11'])) {
    $rangofinal11         = strval($_REQUEST['rangofinal11']);
} else {
    $rangofinal11 = "";
}

if (isset($_POST['ContenidoSem11'])) {
    $contenidosem11         = strval($_REQUEST['ContenidoSem11']);
} else {
    $contenidosem11 = "";
}
if (isset($_POST['NombreEstrategia11'])) {
    $nombreestrategia11    = strval($_REQUEST['NombreEstrategia11']);
} else {
    $nombreestrategia11 = "";
}
if (isset($_POST['NombreMetodo11'])) {
    $nombremetodo11         = strval($_REQUEST['NombreMetodo11']);
} else {
    $nombremetodo11 = "";
}
//semana 12
if (isset($_POST['titulosem12'])) {
    $titulos12              = strval($_REQUEST['titulosem12']);
} else {
    $titulos12 = "";
}
if (isset($_POST['rangoinicio12'])) {
    $rangoinicio12         = strval($_REQUEST['rangoinicio12']);
} else {
    $rangoinicio12 = "";
}
if (isset($_POST['rangofinal12'])) {
    $rangofinal12         = strval($_REQUEST['rangofinal12']);
} else {
    $rangofinal12 = "";
}
if (isset($_POST['ContenidoSem12'])) {
    $contenidosem12         = strval($_REQUEST['ContenidoSem12']);
} else {
    $contenidosem12 = "";
}
if (isset($_POST['NombreEstrategia12'])) {
    $nombreestrategia12    = strval($_REQUEST['NombreEstrategia12']);
} else {
    $nombreestrategia12 = "";
}
if (isset($_POST['NombreMetodo12'])) {
    $nombremetodo12         = strval($_REQUEST['NombreMetodo12']);
} else {
    $nombremetodo12 = "";
}
//semana 13
if (isset($_POST['titulosem13'])) {
    $titulos13              = strval($_REQUEST['titulosem13']);
} else {
    $titulos13 = "";
}
if (isset($_POST['rangoinicio13'])) {
    $rangoinicio13         = strval($_REQUEST['rangoinicio13']);
} else {
    $rangoinicio13 = "";
}
if (isset($_POST['rangofinal13'])) {
    $rangofinal13         = strval($_REQUEST['rangofinal13']);
} else {
    $rangofinal13 = "";
}

if (isset($_POST['ContenidoSem13'])) {
    $contenidosem13         = strval($_REQUEST['ContenidoSem13']);
} else {
    $contenidosem13 = "";
}
if (isset($_POST['NombreEstrategia13'])) {
    $nombreestrategia13    = strval($_REQUEST['NombreEstrategia13']);
} else {
    $nombreestrategia13 = "";
}
if (isset($_POST['NombreMetodo13'])) {
    $nombremetodo13         = strval($_REQUEST['NombreMetodo13']);
} else {
    $nombremetodo13 = "";
}
//semana 14
if (isset($_POST['titulosem14'])) {
    $titulos14              = strval($_REQUEST['titulosem14']);
} else {
    $titulos14 = "";
}
if (isset($_POST['rangoinicio14'])) {
    $rangoinicio14         = strval($_REQUEST['rangoinicio14']);
} else {
    $rangoinicio14 = "";
}
if (isset($_POST['rangofinal14'])) {
    $rangofinal14         = strval($_REQUEST['rangofinal14']);
} else {
    $rangofinal14 = "";
}
if (isset($_POST['ContenidoSem14'])) {
    $contenidosem14         = strval($_REQUEST['ContenidoSem14']);
} else {
    $contenidosem14 = "";
}
if (isset($_POST['NombreEstrategia14'])) {
    $nombreestrategia14    = strval($_REQUEST['NombreEstrategia14']);
} else {
    $nombreestrategia14 = "";
}
if (isset($_POST['NombreMetodo14'])) {
    $nombremetodo14         = strval($_REQUEST['NombreMetodo14']);
} else {
    $nombremetodo14 = "";
}
//semana 15
if (isset($_POST['titulosem15'])) {
    $titulos15              = strval($_REQUEST['titulosem15']);
} else {
    $titulos15 = "";
}
if (isset($_POST['rangoinicio15'])) {
    $rangoinicio15         = strval($_REQUEST['rangoinicio15']);
} else {
    $rangoinicio15 = "";
}
if (isset($_POST['rangofinal15'])) {
    $rangofinal15         = strval($_REQUEST['rangofinal15']);
} else {
    $rangofinal15 = "";
}
if (isset($_POST['ContenidoSem15'])) {
    $contenidosem15         = strval($_REQUEST['ContenidoSem15']);
} else {
    $contenidosem15 = "";
}
if (isset($_POST['NombreEstrategia15'])) {
    $nombreestrategia15    = strval($_REQUEST['NombreEstrategia15']);
} else {
    $nombreestrategia15 = "";
}
if (isset($_POST['NombreMetodo15'])) {
    $nombremetodo15         = strval($_REQUEST['NombreMetodo15']);
} else {
    $nombremetodo15 = "";
}
//semana 16
if (isset($_POST['titulosem16'])) {
    $titulos16              = strval($_REQUEST['titulosem16']);
} else {
    $titulos16 = "";
}
if (isset($_POST['rangoinicio16'])) {
    $rangoinicio16         = strval($_REQUEST['rangoinicio16']);
} else {
    $rangoinicio16 = "";
}
if (isset($_POST['rangofinal16'])) {
    $rangofinal16         = strval($_REQUEST['rangofinal16']);
} else {
    $rangofinal16 = "";
}

if (isset($_POST['ContenidoSem16'])) {
    $contenidosem16         = strval($_REQUEST['ContenidoSem16']);
} else {
    $contenidosem16 = "";
}
if (isset($_POST['NombreEstrategia16'])) {
    $nombreestrategia16    = strval($_REQUEST['NombreEstrategia16']);
} else {
    $nombreestrategia16 = "";
}
if (isset($_POST['NombreMetodo16'])) {
    $nombremetodo16         = strval($_REQUEST['NombreMetodo16']);
} else {
    $nombremetodo16 = "";
}
//semana 17
if (isset($_POST['titulosem17'])) {
    $titulos17              = strval($_REQUEST['titulosem17']);
} else {
    $titulos17 = "";
}
if (isset($_POST['rangoinicio17'])) {
    $rangoinicio17         = strval($_REQUEST['rangoinicio17']);
} else {
    $rangoinicio17 = "";
}
if (isset($_POST['rangofinal17'])) {
    $rangofinal17         = strval($_REQUEST['rangofinal17']);
} else {
    $rangofinal17 = "";
}

if (isset($_POST['ContenidoSem17'])) {
    $contenidosem17         = strval($_REQUEST['ContenidoSem17']);
} else {
    $contenidosem17 = "";
}
if (isset($_POST['NombreEstrategia17'])) {
    $nombreestrategia17    = strval($_REQUEST['NombreEstrategia17']);
} else {
    $nombreestrategia17 = "";
}
if (isset($_POST['NombreMetodo17'])) {
    $nombremetodo17         = strval($_REQUEST['NombreMetodo17']);
} else {
    $nombremetodo17 = "";
}
//semana 18
if (isset($_POST['titulosem18'])) {
    $titulos18              = strval($_REQUEST['titulosem18']);
} else {
    $titulos18 = "";
}
if (isset($_POST['rangoinicio18'])) {
    $rangoinicio18         = strval($_REQUEST['rangoinicio18']);
} else {
    $rangoinicio18 = "";
}
if (isset($_POST['rangofinal18'])) {
    $rangofinal18         = strval($_REQUEST['rangofinal18']);
} else {
    $rangofinal18 = "";
}

if (isset($_POST['ContenidoSem18'])) {
    $contenidosem18         = strval($_REQUEST['ContenidoSem18']);
} else {
    $contenidosem18 = "";
}
if (isset($_POST['NombreEstrategia18'])) {
    $nombreestrategia18    = strval($_REQUEST['NombreEstrategia18']);
} else {
    $nombreestrategia18 = "";
}
if (isset($_POST['NombreMetodo18'])) {
    $nombremetodo18         = strval($_REQUEST['NombreMetodo18']);
} else {
    $nombremetodo18 = "";
}
//semana1 postgrado
if (isset($_POST['titulosem1p'])) {
    $titulos1p              = strval($_REQUEST['titulosem1p']);
} else {
    $titulos1p = "";
}
if (!empty($_POST['frangoinicio1'])) {
    $rangoinicio1p          = strval($_REQUEST['frangoinicio1']);
} else {
    $rangoinicio1p = "";
}
if (!empty($_POST['frangofinal1'])) {
    $rangofinal1p           = strval($_REQUEST['frangofinal1']);
} else {
    $rangofinal1p = "";
}
if (!empty($_POST['ContenidoSem1p'])) {
    $contenidosem1p         = strval($_REQUEST['ContenidoSem1p']);
} else {
    $contenidosem1p = "";
}
if (!empty($_POST['NombreEstrategia1p'])) {
    $nombreestrategia1p     = strval($_REQUEST['NombreEstrategia1p']);
} else {
    $nombreestrategia1p = "";
}
if (!empty($_POST['NombreMetodo1p'])) {
    $nombremetodo1p         = strval($_REQUEST['NombreMetodo1p']);
} else {
    $nombremetodo1p = "";
}
//semana2 postgrado
if (isset($_POST['titulosem2p'])) {
    $titulos2p              = strval($_REQUEST['titulosem2p']);
} else {
    $titulos2p = "";
}
if (isset($_POST['frangoinicio2'])) {
    $rangoinicio2p          = strval($_REQUEST['frangoinicio2']);
} else {
    $rangoinicio2p = "";
}
if (isset($_POST['frangofinal2'])) {
    $rangofinal2p           = strval($_REQUEST['frangofinal2']);
} else {
    $rangofinal2p = "";
}
if (isset($_POST['ContenidoSem2p'])) {
    $contenidosem2p         = strval($_REQUEST['ContenidoSem2p']);
} else {
    $contenidosem2p = "";
}
if (isset($_POST['NombreEstrategia2p'])) {
    $nombreestrategia2p     = strval($_REQUEST['NombreEstrategia2p']);
} else {
    $nombreestrategia2p = "";
}
if (isset($_POST['NombreMetodo2p'])) {
    $nombremetodo2p         = strval($_REQUEST['NombreMetodo2p']);
} else {
    $nombremetodo2p = "";
}
//semana3 postgrado
if (isset($_POST['titulosem3p'])) {
    $titulos3p              = strval($_REQUEST['titulosem3p']);
} else {
    $titulos3p = "";
}
if (isset($_POST['frangoinicio3'])) {
    $rangoinicio3p          = strval($_REQUEST['frangoinicio3']);
} else {
    $rangoinicio3p = "";
}
if (isset($_POST['frangofinal3'])) {
    $rangofinal3p           = strval($_REQUEST['frangofinal3']);
} else {
    $rangofinal3p = "";
}
if (isset($_POST['ContenidoSem3p'])) {
    $contenidosem3p         = strval($_REQUEST['ContenidoSem3p']);
} else {
    $contenidosem3p = "";
}
if (isset($_POST['NombreEstrategia3p'])) {
    $nombreestrategia3p     = strval($_REQUEST['NombreEstrategia3p']);
} else {
    $nombreestrategia3p = "";
}
if (isset($_POST['NombreMetodo3p'])) {
    $nombremetodo3p         = strval($_REQUEST['NombreMetodo3p']);
} else {
    $nombremetodo3p = "";
}
//semana4 postgrado
if (isset($_POST['titulosem4p'])) {
    $titulos4p              = strval($_REQUEST['titulosem4p']);
} else {
    $titulos4p = "";
}
if (isset($_POST['frangoinicio4'])) {
    $rangoinicio4p          = strval($_REQUEST['frangoinicio4']);
} else {
    $rangoinicio4p = "";
}
if (isset($_POST['frangofinal4'])) {
    $rangofinal4p           = strval($_REQUEST['frangofinal4']);
} else {
    $rangofinal4p = "";
}
if (isset($_POST['ContenidoSem4p'])) {
    $contenidosem4p         = strval($_REQUEST['ContenidoSem4p']);
} else {
    $contenidosem4p = "";
}
if (isset($_POST['NombreEstrategia4p'])) {
    $nombreestrategia4p     = strval($_REQUEST['NombreEstrategia4p']);
} else {
    $nombreestrategia4p = "";
}
if (isset($_POST['NombreMetodo4p'])) {
    $nombremetodo4p         = strval($_REQUEST['NombreMetodo4p']);
} else {
    $nombremetodo4p = "";
}
//semana5 postgrado
if (isset($_POST['titulosem5p'])) {
    $titulos5p              = strval($_REQUEST['titulosem5p']);
} else {
    $titulos5p = "";
}
if (isset($_POST['frangoinicio5'])) {
    $rangoinicio5p          = strval($_REQUEST['frangoinicio5']);
} else {
    $rangoinicio5p = "";
}
if (isset($_POST['frangofinal5'])) {
    $rangofinal5p           = strval($_REQUEST['frangofinal5']);
} else {
    $rangofinal5p = "";
}
if (isset($_POST['ContenidoSem5p'])) {
    $contenidosem5p         = strval($_REQUEST['ContenidoSem5p']);
} else {
    $contenidosem5p = "";
}
if (isset($_POST['NombreEstrategia5p'])) {
    $nombreestrategia5p     = strval($_REQUEST['NombreEstrategia5p']);
} else {
    $nombreestrategia5p = "";
}
if (isset($_POST['NombreMetodo5p'])) {
    $nombremetodo5p         = strval($_REQUEST['NombreMetodo5p']);
} else {
    $nombremetodo5p = "";
}
// validador
$validador1             = strval($_REQUEST['Validador1']);
$validador2             = strval($_REQUEST['Validador2']);

$sqlSelect = "SELECT * FROM $tablam2 WHERE codigo_asignatura='$codigocurso' AND  grupo='$codigogrupo' AND codigo_periodo='$codperiodo'";
$resultSelect = pg_query($conexion, $sqlSelect);
$numrow=pg_num_rows($resultSelect);
//echo $numrow;

if ($numrow == 0) {

    $QueryInsert = ("INSERT INTO $tablam2 (
    codigo_asignatura,
	nombre_asignatura,
	codigo_periodo,
	nombre_periodo,
	codigo_programa,
	nombre_programa,
	fecha_consigna,
	semestre,
	grupo,
	codigo_docente,
	nombre_docente,
	resultados_aprendizaje,
	htts,
	htps,
	htis,
	s1_titulo,
	s1_rangoi,
	s1_rangof,
	s1_contenidos,
	s1_estrategia,
	s1_metodologia,
	s2_titulo,
	s2_rangoi,
	s2_rangof,
	s2_contenidos,
	s2_estrategia,
	s2_metodologia,
	s3_titulo,
	s3_rangoi,
	s3_rangof,
	s3_contenidos,
	s3_estrategia,
	s3_metodologia,
	s4_titulo,
	s4_rangoi,
	s4_rangof,
	s4_contenidos,
	s4_estrategia,
	s4_metodologia,
	s5_titulo,
	s5_rangoi,
	s5_rangof,
	s5_contenidos,
	s5_estrategia,
	s5_metodologia,
	s6_titulo,
	s6_rangoi,
	s6_rangof,
	s6_contenidos,
	s6_estrategia,
	s6_metodologia,
	s7_titulo,
	s7_rangoi,
	s7_rangof,
	s7_contenidos,
	s7_estrategia,
	s7_metodologia,
	s8_titulo,
	s8_rangoi,
	s8_rangof,
	s8_contenidos,
	s8_estrategia,
	s8_metodologia,
	s9_titulo,
	s9_rangoi,
	s9_rangof,
	s9_contenidos,
	s9_estrategia,
	s9_metodologia,
	s10_titulo,
	s10_rangoi,
	s10_rangof,
	s10_contenidos,
	s10_estrategia,
	s10_metodologia,
	s11_titulo,
	s11_rangoi,
	s11_rangof,
	s11_contenidos,
	s11_estrategia,
	s11_metodologia,
	s12_titulo,
	s12_rangoi,
	s12_rangof,
	s12_contenidos,
	s12_estrategia,
	s12_metodologia,
	s13_titulo,
	s13_rangoi,
	s13_rangof,
	s13_contenidos,
	s13_estrategia,
	s13_metodologia,
	s14_titulo,
	s14_rangoi,
	s14_rangof,
	s14_contenidos,
	s14_estrategia,
	s14_metodologia,
	s15_titulo,
	s15_rangoi,
	s15_rangof,
	s15_contenidos,
	s15_estrategia,
	s15_metodologia,
	s16_titulo,
	s16_rangoi,
	s16_rangof,
	s16_contenidos,
	s16_estrategia,
	s16_metodologia,
    s17_titulo,
	s17_rangoi,
	s17_rangof,
	s17_contenidos,
	s17_estrategia,
	s17_metodologia,
    s18_titulo,
	s18_rangoi,
	s18_rangof,
	s18_contenidos,
	s18_estrategia,
	s18_metodologia,
	s1_titulo_p,
	s1_rangoi_p,
	s1_rangof_p,
	s1_contenidos_p,
	s1_estrategia_p,
	s1_metodologia_p,
	s2_titulo_p,
	s2_rangoi_p,
	s2_rangof_p,
	s2_contenidos_p,
	s2_estrategia_p,
	s2_metodologia_p,
	s3_titulo_p,
	s3_rangoi_p,
	s3_rangof_p,
	s3_contenidos_p,
	s3_estrategia_p,
	s3_metodologia_p,
	s4_titulo_p,
	s4_rangoi_p,
	s4_rangof_p,
	s4_contenidos_p,
	s4_estrategia_p,
	s4_metodologia_p,
	s5_titulo_p,
	s5_rangoi_p,
	s5_rangof_p,
	s5_contenidos_p,
	s5_estrategia_p,
	s5_metodologia_p,
	validador1,
	validador2
)    
VALUES (  
    '" . $codigocurso . "',
    '" . $nombrecurso . "',
    '" . $codperiodo . "',
    '" . $nomperiodo . "',
    '" . $codigoprograma . "',
    '" . $nombreprograma . "',
    '" . $fechaconsigna . "',
    '" . $semestre . "',
    '" . $codigogrupo . "',
    '" . $codigodocente . "',
    '" . $nombredocente . "',
    '" . $resultados . "',   
    '" . $htts . "',   
    '" . $htps . "',   
    '" . $htis . "',   
    '" . $titulos1 . "',  
    '" . $rangoinicio1 . "',
    '" . $rangofinal1 . "',
    '" . $contenidosem1 . "',
    '" . $nombreestrategia1 . "',
    '" . $nombremetodo1 . "', 
    '" . $titulos2 . "',  
    '" . $rangoinicio2 . "',
    '" . $rangofinal2 . "',
    '" . $contenidosem2 . "',
    '" . $nombreestrategia2 . "',
    '" . $nombremetodo2 . "',
    '" . $titulos3 . "',  
    '" . $rangoinicio3 . "',
    '" . $rangofinal3 . "',
    '" . $contenidosem3 . "',
    '" . $nombreestrategia3 . "',
    '" . $nombremetodo3 . "',
    '" . $titulos4 . "',  
    '" . $rangoinicio4 . "',
    '" . $rangofinal4 . "',
    '" . $contenidosem4 . "',
    '" . $nombreestrategia4 . "',
    '" . $nombremetodo4 . "',
    '" . $titulos5 . "',  
    '" . $rangoinicio5 . "',
    '" . $rangofinal5 . "',
    '" . $contenidosem5 . "',
    '" . $nombreestrategia5 . "',
    '" . $nombremetodo5 . "',
    '" . $titulos6 . "',  
    '" . $rangoinicio6 . "',
    '" . $rangofinal6 . "',
    '" . $contenidosem6 . "',
    '" . $nombreestrategia6 . "',
    '" . $nombremetodo6 . "',
    '" . $titulos7 . "',  
    '" . $rangoinicio7 . "',
    '" . $rangofinal7 . "',
    '" . $contenidosem7 . "',
    '" . $nombreestrategia7 . "',
    '" . $nombremetodo7 . "',
    '" . $titulos8 . "',  
    '" . $rangoinicio8 . "',
    '" . $rangofinal8 . "',
    '" . $contenidosem8 . "',
    '" . $nombreestrategia8 . "',
    '" . $nombremetodo8 . "',
    '" . $titulos9 . "',  
    '" . $rangoinicio9 . "',
    '" . $rangofinal9 . "',
    '" . $contenidosem9 . "',
    '" . $nombreestrategia9 . "',
    '" . $nombremetodo9 . "',
    '" . $titulos10 . "',  
    '" . $rangoinicio10 . "',
    '" . $rangofinal10 . "',
    '" . $contenidosem10 . "',
    '" . $nombreestrategia10 . "',
    '" . $nombremetodo10 . "',
    '" . $titulos11 . "',  
    '" . $rangoinicio11 . "',
    '" . $rangofinal11 . "',
    '" . $contenidosem11 . "',
    '" . $nombreestrategia11 . "',
    '" . $nombremetodo11 . "',
    '" . $titulos12 . "',  
    '" . $rangoinicio12 . "',
    '" . $rangofinal12 . "',
    '" . $contenidosem12 . "',
    '" . $nombreestrategia12 . "',
    '" . $nombremetodo12 . "',
    '" . $titulos13 . "',  
    '" . $rangoinicio13 . "',
    '" . $rangofinal13 . "',
    '" . $contenidosem13 . "',
    '" . $nombreestrategia13 . "',
    '" . $nombremetodo13 . "',
    '" . $titulos14 . "',  
    '" . $rangoinicio14 . "',
    '" . $rangofinal14 . "',
    '" . $contenidosem14 . "',
    '" . $nombreestrategia14 . "',
    '" . $nombremetodo14 . "',
    '" . $titulos15 . "',  
    '" . $rangoinicio15 . "',
    '" . $rangofinal15 . "',
    '" . $contenidosem15 . "',
    '" . $nombreestrategia15 . "',
    '" . $nombremetodo15 . "',
    '" . $titulos16 . "',  
    '" . $rangoinicio16 . "',
    '" . $rangofinal16 . "',
    '" . $contenidosem16 . "',
    '" . $nombreestrategia16 . "',
    '" . $nombremetodo16 . "',
    '" . $titulos17 . "',  
    '" . $rangoinicio17 . "',
    '" . $rangofinal17 . "',
    '" . $contenidosem17 . "',
    '" . $nombreestrategia17 . "',
    '" . $nombremetodo17 . "',
    '" . $titulos18 . "',  
    '" . $rangoinicio18 . "',
    '" . $rangofinal18 . "',
    '" . $contenidosem18 . "',
    '" . $nombreestrategia18 . "',
    '" . $nombremetodo18 . "',
    '" . $titulos1p . "',  
    '" . $rangoinicio1p . "',
    '" . $rangofinal1p . "',
    '" . $contenidosem1p . "',
    '" . $nombreestrategia1p . "',
    '" . $nombremetodo1p . "',
    '" . $titulos2p . "',  
    '" . $rangoinicio2p . "',
    '" . $rangofinal2p . "',
    '" . $contenidosem2p . "',
    '" . $nombreestrategia2p . "',
    '" . $nombremetodo2p . "',
    '" . $titulos3p . "',  
    '" . $rangoinicio3p . "',
    '" . $rangofinal3p . "',
    '" . $contenidosem3p . "',
    '" . $nombreestrategia3p . "',
    '" . $nombremetodo3p . "',
    '" . $titulos4p . "',  
    '" . $rangoinicio4p . "',
    '" . $rangofinal4p . "',
    '" . $contenidosem4p . "',
    '" . $nombreestrategia4p . "',
    '" . $nombremetodo4p . "',
    '" . $titulos5p . "',  
    '" . $rangoinicio5p . "',
    '" . $rangofinal5p . "',
    '" . $contenidosem5p . "',
    '" . $nombreestrategia5p . "',
    '" . $nombremetodo5p . "',
    '" . $validador1 . "',
    '" . $validador2 . "'
)");
    $insertConsigna = pg_query($conexion, $QueryInsert);

    //insertar registro en tabla m3

    $QueryInsert_m3 = ("INSERT INTO $tablam3 (
    codigo_asignatura,
	nombre_asignatura,
	codigo_periodo,
	nombre_periodo,
	codigo_programa,
	nombre_programa,
    fecha_registro,
    semestre,
    grupo,
    codigo_docente,
	nombre_docente,
    s1_titulo,
	s1_rangoi,
	s1_rangof,
    s1_contenidos,
    s2_titulo,
	s2_rangoi,
	s2_rangof,
    s2_contenidos,
    s3_titulo,
	s3_rangoi,
	s3_rangof,
    s3_contenidos,
    s4_titulo,
	s4_rangoi,
	s4_rangof,
    s4_contenidos,
    s5_titulo,
	s5_rangoi,
	s5_rangof,
    s5_contenidos,
    s6_titulo,
	s6_rangoi,
	s6_rangof,
    s6_contenidos,
    s7_titulo,
	s7_rangoi,
	s7_rangof,
    s7_contenidos,
    s8_titulo,
	s8_rangoi,
	s8_rangof,
    s8_contenidos,
    s9_titulo,
	s9_rangoi,
	s9_rangof,
    s9_contenidos,
    s10_titulo,
	s10_rangoi,
	s10_rangof,
    s10_contenidos,
    s11_titulo,
	s11_rangoi,
	s11_rangof,
    s11_contenidos,
    s12_titulo,
	s12_rangoi,
	s12_rangof,
    s12_contenidos,
    s13_titulo,
	s13_rangoi,
	s13_rangof,
    s13_contenidos,
    s14_titulo,
	s14_rangoi,
	s14_rangof,
    s14_contenidos,
    s15_titulo,
	s15_rangoi,
	s15_rangof,
    s15_contenidos,
    s16_titulo,
	s16_rangoi,
	s16_rangof,
    s16_contenidos,
    s17_titulo,
	s17_rangoi,
	s17_rangof,
    s17_contenidos,
    s18_titulo,
	s18_rangoi,
	s18_rangof,
    s18_contenidos,
    s1_titulo_p,
	s1_rangoi_p,
	s1_rangof_p,
    s1_contenidos_p,
    s2_titulo_p,
	s2_rangoi_p,
	s2_rangof_p,
    s2_contenidos_p,
    s3_titulo_p,
	s3_rangoi_p,
	s3_rangof_p,
    s3_contenidos_p,
    s4_titulo_p,
	s4_rangoi_p,
	s4_rangof_p,
    s4_contenidos_p,
    s5_titulo_p,
	s5_rangoi_p,
	s5_rangof_p,
    s5_contenidos_p
)    
VALUES (   
    '" . $codigocurso . "',
    '" . $nombrecurso . "',
    '" . $codperiodo . "',
    '" . $nomperiodo . "',
    '" . $codigoprograma . "',
    '" . $nombreprograma . "',
    '" . $fechaconsigna . "',
    '" . $semestre . "',
    '" . $codigogrupo . "',
    '" . $codigodocente . "',
    '" . $nombredocente . "',
    '" . $titulos1 . "',  
    '" . $rangoinicio1 . "',
    '" . $rangofinal1 . "',
    '" . $contenidosem1 . "',
    '" . $titulos2 . "',  
    '" . $rangoinicio2 . "',
    '" . $rangofinal2 . "',
    '" . $contenidosem2 . "',
    '" . $titulos3 . "',  
    '" . $rangoinicio3 . "',
    '" . $rangofinal3 . "',
    '" . $contenidosem3 . "',
    '" . $titulos4 . "',  
    '" . $rangoinicio4 . "',
    '" . $rangofinal4 . "',
    '" . $contenidosem4 . "',
    '" . $titulos5 . "',  
    '" . $rangoinicio5 . "',
    '" . $rangofinal5 . "',
    '" . $contenidosem5 . "',
    '" . $titulos6 . "',  
    '" . $rangoinicio6 . "',
    '" . $rangofinal6 . "',
    '" . $contenidosem6 . "',
    '" . $titulos7 . "',  
    '" . $rangoinicio7 . "',
    '" . $rangofinal7 . "',
    '" . $contenidosem7 . "',
    '" . $titulos8 . "',  
    '" . $rangoinicio8 . "',
    '" . $rangofinal8 . "',
    '" . $contenidosem8 . "',
    '" . $titulos9 . "',  
    '" . $rangoinicio9 . "',
    '" . $rangofinal9 . "',
    '" . $contenidosem9 . "',
    '" . $titulos10 . "',  
    '" . $rangoinicio10 . "',
    '" . $rangofinal10 . "',
    '" . $contenidosem10 . "',
    '" . $titulos11 . "',  
    '" . $rangoinicio11 . "',
    '" . $rangofinal11 . "',
    '" . $contenidosem11 . "',
    '" . $titulos12 . "',  
    '" . $rangoinicio12 . "',
    '" . $rangofinal12 . "',
    '" . $contenidosem12 . "',
    '" . $titulos13 . "',  
    '" . $rangoinicio13 . "',
    '" . $rangofinal13 . "',
    '" . $contenidosem13 . "',
    '" . $titulos14 . "',  
    '" . $rangoinicio14 . "',
    '" . $rangofinal14 . "',
    '" . $contenidosem14 . "',
    '" . $titulos15 . "',  
    '" . $rangoinicio15 . "',
    '" . $rangofinal15 . "',
    '" . $contenidosem15 . "',
    '" . $titulos16 . "',  
    '" . $rangoinicio16 . "',
    '" . $rangofinal16 . "',
    '" . $contenidosem16 . "',
    '" . $titulos17 . "',  
    '" . $rangoinicio17 . "',
    '" . $rangofinal17 . "',
    '" . $contenidosem17 . "',
    '" . $titulos18 . "',  
    '" . $rangoinicio18 . "',
    '" . $rangofinal18 . "',
    '" . $contenidosem18 . "',
    '" . $titulos1p . "',  
    '" . $rangoinicio1p . "',
    '" . $rangofinal1p . "',
    '" . $contenidosem1p . "',
    '" . $titulos2p . "',  
    '" . $rangoinicio2p . "',
    '" . $rangofinal2p . "',
    '" . $contenidosem2p . "',
    '" . $titulos3p . "',  
    '" . $rangoinicio3p . "',
    '" . $rangofinal3p . "',
    '" . $contenidosem3p . "',
    '" . $titulos4p . "',  
    '" . $rangoinicio4p . "',
    '" . $rangofinal4p . "',
    '" . $contenidosem4p . "',
    '" . $titulos5p . "',  
    '" . $rangoinicio5p . "',
    '" . $rangofinal5p . "',
    '" . $contenidosem5p . "'
)");
    $insertRegistro = pg_query($conexion, $QueryInsert_m3);

    if ($insertConsigna && $insertRegistro) {
        //echo "registro insertado";
        echo '<script>
    Swal.fire({
     icon: "success",
     title: "Exito...",
     text: "¡Registro Guardado con Exito!",
     showConfirmButton: true,
     confirmButtonText: "Cerrar"
     }).then(function(result){
        if(result.value){                   
         window.location = "Consignador.php";
        }
     });
    </script>';
    } else {

        echo '<script>
    Swal.fire({
     icon: "error",
     title: "Oops...",
     text: "¡Ocurrio un error, el registro no se guardó!",
     showConfirmButton: true,
     confirmButtonText: "Cerrar"
     }).then(function(result){
        if(result.value){                   
         window.location = "Consignador.php";
        }
     });
    </script>';
    }
} else {
    echo '<script>
    Swal.fire({
     icon: "error",
     title: "Oops...",
     text: "¡La consignación de esta asignatura YA Existe, por favor ingrese por la opcion Editar para modificar o ingresar informacion a las respectivas semanas",
     showConfirmButton: true,
     confirmButtonText: "Cerrar"
     }).then(function(result){
        if(result.value){                   
         window.location = "Consignador.php";
        }
     });
    </script>';
}
