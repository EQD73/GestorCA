<?php
include('conexion.php');
$idRegistros = $_REQUEST['id'];

$DeleteRegistro = ("DELETE FROM sistema.periodos WHERE codigo_periodo= '".$idRegistros."' ");
pg_query($conexion, $DeleteRegistro);
?>