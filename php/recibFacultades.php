<?php
include('conexion.php');
$codigo 	 = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];
$estado      = $_REQUEST['estado'];

$QueryInsert = ("INSERT INTO sistema.facultades(
    codigo_facultad,
    nombre_facultad,
    estado
)
VALUES (
    '".$codigo. "',
    '".$nombre. "',
    '".$estado. "'
)");
$insertPeriodo = pg_query($conexion, $QueryInsert);

header("location:facultades.php");
?>
