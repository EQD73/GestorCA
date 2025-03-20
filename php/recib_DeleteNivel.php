<?php
include('conexion.php');
$idRegistros = $_REQUEST['id'];

$DeleteRegistro = ("DELETE FROM sistema.nivel WHERE id= '".$idRegistros."' ");
pg_query($conexion, $DeleteRegistro);
?>