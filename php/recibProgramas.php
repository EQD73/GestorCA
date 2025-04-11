<?php
include('conexion.php');
$codigo      = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];
$sede        = $_REQUEST['sede'];
$codigoc     = $_REQUEST['codigoc'];
$nombrec     = $_REQUEST['nombrecompleto'];

$QueryInsert = ("INSERT INTO sistema.programas(
    codigo_programa,
    nombre_programa,
    codigo_sede,
    codigo_coordinador,
    nom_coordinador
)
VALUES (
    '" . $codigo . "',
    '" . $nombre . "',
    '" . $sede . "',
    '" . $codigoc . "',
    '" . $nombrec . "'
)");
$insertPeriodo = pg_query($conexion, $QueryInsert);

header("location:programas.php");
