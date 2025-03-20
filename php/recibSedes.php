<?php
include('conexion.php');
$codigo 	 = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];


$QueryInsert = ("INSERT INTO sistema.sedes(
    codigo_sede,
    nombre_sede
)
VALUES (
    '".$codigo. "',
    '".$nombre. "'
)");
$insertPeriodo = pg_query($conexion, $QueryInsert);

header("location:sedes.php");
?>
