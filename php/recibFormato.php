<?php
include('conexion.php');
$codigo 	 = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];
$codigof        = $_REQUEST['codigof'];
$version        = $_REQUEST['version'];
$fecha       = $_REQUEST['fecha'];

$QueryInsert = ("INSERT INTO sistema.version_formato(
    codigo_formato,
    nombre_formato,
    codigo,
    version,
    fecha
)
VALUES (
    '".$codigo. "',
    '".$nombre. "',
    '".$codigof. "',
    '".$version. "',
    '".$fecha. "'
)");
$insertPeriodo = pg_query($conexion, $QueryInsert);

header("location:revisionf.php");
?>
