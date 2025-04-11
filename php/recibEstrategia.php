<?php
include('conexion.php');
$codigo      = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];

$QueryInsert = ("INSERT INTO sistema.estrategias_met(
    codigo_estrategia,
    nombre_estrategia
    
)
VALUES (
    '" . $codigo . "',
    '" . $nombre . "'
    
)");
$insertPeriodo = pg_query($conexion, $QueryInsert);

header("location:estrategia.php");
