do<?php
include('conexion.php');
$idRegistros = $_REQUEST['id'];

$DeleteRegistro = ("DELETE FROM sistema.met_evaluacion WHERE codigo_metodo= '".$idRegistros."' ");
pg_query($conexion, $DeleteRegistro);
?>