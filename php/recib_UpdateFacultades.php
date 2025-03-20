
<?php
include('conexion.php');
$idRegistros = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];
$estado      = $_REQUEST['estado'];

$update = ("UPDATE sistema.facultades 
	SET 
	nombre_facultad  ='" .$nombre. "',
	estado  ='" .$estado. "'
WHERE codigo_facultad='" .$idRegistros. "'
");
$result_update = pg_query($conexion, $update);

echo "<script type='text/javascript'>
        window.location='facultades.php';
    </script>";

?>
