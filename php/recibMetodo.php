<?php
include('conexion.php');
$codigo 	 = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];

$QueryInsert = ("INSERT INTO sistema.met_evaluacion(
    codigo_metodo,
    nombre_metodo
    
)
VALUES (
    '".$codigo. "',
    '".$nombre. "'
    
)");
$insertPeriodo = pg_query($conexion, $QueryInsert);

header("location:met_evaluacion.php");
?>
