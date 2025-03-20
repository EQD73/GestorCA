<?php
include('conexion.php');
$codeliminar = $_REQUEST['CodigoEliminarCurso'];

$DeleteRegistro = ("DELETE FROM sistema.pr2022_m1 WHERE codigo_asignaturacurso= '".$codeliminar."' ");
pg_query($conexion, $DeleteRegistro);

header("location: consultar_micro.php");
?>