<?php
include('conexion.php');
$idRegistros = $_REQUEST['id'];

$DeleteRegistro = ("DELETE FROM sistema.programas WHERE codigo_programa= '".$idRegistros."' ");
pg_query($conexion, $DeleteRegistro);
?>