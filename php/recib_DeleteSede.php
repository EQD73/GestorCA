<?php
include('conexion.php');
$idRegistros = $_REQUEST['id'];

$DeleteRegistro = ("DELETE FROM sistema.sedes WHERE codigo_sede= '".$idRegistros."' ");
pg_query($conexion, $DeleteRegistro);
?>