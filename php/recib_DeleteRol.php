<?php
include('conexion.php');
$idRegistros = $_REQUEST['id'];

$DeleteRegistro = ("DELETE FROM sistema.roles WHERE codigo_rol= '".$idRegistros."' ");
pg_query($conexion, $DeleteRegistro);
?>