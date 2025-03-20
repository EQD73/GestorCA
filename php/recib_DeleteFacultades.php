<?php
include('conexion.php');
$idRegistros = $_REQUEST['id'];

$DeleteRegistro = ("DELETE FROM sistema.facultades WHERE codigo_facultad= '".$idRegistros."' ");
pg_query($conexion, $DeleteRegistro);
?>