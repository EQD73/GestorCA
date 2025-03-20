
<?php
include('conexion.php');
$idRegistros = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];
$codigof      = $_REQUEST['codigof'];
$version      = $_REQUEST['version'];
$fecha      = $_REQUEST['fecha'];


$update = ("UPDATE sistema.version_formato
	SET 
	nombre_formato  ='" .$nombre. "',
    codigo  ='" .$codigof. "',
    version  ='" .$version. "',
	fecha  ='" .$fecha. "'
WHERE codigo_formato='" .$idRegistros. "'
");
$result_update = pg_query($conexion, $update);

echo "<script type='text/javascript'>
        window.location='revisionf.php';
    </script>";

?>
