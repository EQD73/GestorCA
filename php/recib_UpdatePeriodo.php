
<?php
include('conexion.php');
$idRegistros = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];


$update = ("UPDATE sistema.periodos 
	SET 
	nombre_periodo  ='" .$nombre. "'
	
WHERE codigo_periodo='" .$idRegistros. "'
");
$result_update = pg_query($conexion, $update);

echo "<script type='text/javascript'>
        window.location='periodo.php';
    </script>";

?>
