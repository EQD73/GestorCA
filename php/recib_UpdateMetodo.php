
<?php
include('conexion.php');
$idRegistros = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];


$update = ("UPDATE sistema.met_evaluacion 
	SET 
	nombre_metodo  ='" .$nombre. "'
	
WHERE codigo_metodo='" .$idRegistros. "'
");
$result_update = pg_query($conexion, $update);

echo "<script type='text/javascript'>
        window.location='met_evaluacion.php';
    </script>";

?>
