<?php
include('conexion.php');
$idRegistros = $_REQUEST['id'];

$DeleteRegistro = ("DELETE FROM sistema.evaluacion WHERE id= '".$idRegistros."' ");
pg_query($conexion, $DeleteRegistro);
?>