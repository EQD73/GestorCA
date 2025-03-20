<?php
include('conexion.php');
$codigo 	 = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];
$estado        = $_REQUEST['estado'];

$QueryInsert = ("INSERT INTO sistema.roles(
    codigo_rol,
    nombre_rol,
    estado
)
VALUES (
    '".$codigo. "',
    '".$nombre. "',
    '".$estado. "'
)");
$insertPeriodo = pg_query($conexion, $QueryInsert);

header("location:roles.php");
?>
