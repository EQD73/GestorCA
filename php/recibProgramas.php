<?php
include('conexion.php');
$codigo 	 = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];
$sede        = $_REQUEST['sede'];

$QueryInsert = ("INSERT INTO sistema.programas(
    codigo_programa,
    nombre_programa,
    codigo_sede
)
VALUES (
    '".$codigo. "',
    '".$nombre. "',
    '".$sede. "'
)");
$insertPeriodo = pg_query($conexion, $QueryInsert);

header("location:programas.php");
?>
