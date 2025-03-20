<?php
include('conexion.php');
$idRegistros = $_REQUEST['id'];

$DeleteRegistro = ("DELETE FROM sistema.version_formato WHERE codigo_formato= '".$idRegistros."' ");
pg_query($conexion, $DeleteRegistro);
?>