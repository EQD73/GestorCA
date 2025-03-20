
<?php
include('conexion.php');
$idRegistros = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];
$estado      = $_REQUEST['estado'];  

$update = ("UPDATE sistema.roles 
	SET 
	nombre_rol  ='" .$nombre. "',
    estado ='" .$estado. "'
	
WHERE codigo_rol='" .$idRegistros. "'
");
$result_update = pg_query($conexion, $update);

echo "<script type='text/javascript'>
        window.location='roles.php';
    </script>";

?>
