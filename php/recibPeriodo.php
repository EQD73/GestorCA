<?php
include('conexion.php');
$codigo 	 = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];
$totals      = $_REQUEST['totalsem'];
$fechai      = $_REQUEST['fechainicio'];
$fechaf      = $_REQUEST['fechafinal'];
$activo      = $_REQUEST['estado'];

$QueryInsert = ("INSERT INTO sistema.periodos(
    codigo_periodo,
    nombre_periodo,
    total_semanas,
    fecha_inicio,
    fecha_fin,
    estado
)
VALUES (
    '".$codigo. "',
    '".$nombre. "',
    '".$totals. "',
    '".$fechai. "',
    '".$fechaf. "',
    '".$activo. "'
)");
$insertPeriodo = pg_query($conexion, $QueryInsert);

header("location:periodo.php");
?>
