<?php
include('conexion.php');
$momento 	 = $_REQUEST['momento'];
$poract      = $_REQUEST['poract'];
$poractfin        = $_REQUEST['poractfinal'];
$porcorte        = $_REQUEST['porcorte'];

$QueryInsert = ("INSERT INTO sistema.evaluacion(
    momento,
    por_actividades,
    por_actfinal,
    por_corte
)
VALUES (
    '".$momento. "',
    '".$poract. "',
    '".$poractfin. "',
    '".$porcorte. "'
)");
$insertPeriodo = pg_query($conexion, $QueryInsert);

header("location:evaluacion.php");
?>
