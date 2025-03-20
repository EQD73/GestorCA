
<?php
include('conexion.php');
$idRegistros = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];
 

$update = ("UPDATE sistema.sedes 
	SET 
	nombre_sede  ='" .$nombre. "'
    
	
WHERE codigo_sede='" .$idRegistros. "'
");
$result_update = pg_query($conexion, $update);

echo "<script type='text/javascript'>
        window.location='sedes.php';
    </script>";

?>
