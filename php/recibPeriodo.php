<?php
include('conexion.php');
$codigo      = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];
$totals      = $_REQUEST['totalsem'];
$fechai      = $_REQUEST['fechainicio'];
$fechaf      = $_REQUEST['fechafinal'];
$activo      = $_REQUEST['estado'];
$anio        = substr($codigo, 0, 4);
$ultimo      = substr($codigo, -1);       // Obtiene el último carácter
$descrip     = $anio . '-' . $ultimo;

$QueryInsert = ("INSERT INTO sistema.periodos(
    codigo_periodo,
    nombre_periodo,
    total_semanas,
    fecha_inicio,
    fecha_fin,
    anio,
    descripcion,
    estado
)
VALUES (
    '" . $codigo . "',
    '" . $nombre . "',
    '" . $totals . "',
    '" . $fechai . "',
    '" . $fechaf . "',
    '" . $anio . "',
    '" . $descrip . "',
    '" . $activo . "'
)");
$insertPeriodo = pg_query($conexion, $QueryInsert);

header("location:periodo.php");
