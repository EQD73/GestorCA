<?php
include('conexion.php');
$codigo 	 = $_REQUEST['codigo'];
$nivel1      = $_REQUEST['nivel1'];
$nivel2      = $_REQUEST['nivel2'];
$nivel3      = $_REQUEST['nivel3'];
$nivel4      = $_REQUEST['nivel4'];

$QueryInsert = ("INSERT INTO sistema.sedes(
    id,
    nivel1,
    nivel2,
    nivel3,
    nivel4
VALUES (
    '".$codigo. "',
    '".$nivel1. "',
    '".$nivel2. "',
    '".$nivel3. "',
    '".$nivel4. "'
)");
$insertPeriodo = pg_query($conexion, $QueryInsert);

header("location:nivel.php");
?>
