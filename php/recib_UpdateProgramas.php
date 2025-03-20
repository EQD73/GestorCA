
<?php
include('conexion.php');
$idRegistros = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];


$update = ("UPDATE sistema.programas 
	SET 
	nombre_programa  ='" .$nombre. "'
	
WHERE codigo_programa='" .$idRegistros. "'
");
$result_update = pg_query($conexion, $update);

echo "<script type='text/javascript'>
        window.location='programas.php';
    </script>";

?>
