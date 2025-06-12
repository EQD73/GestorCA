
<?php
include('conexion.php');
$idRegistros = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];
$sede        = $_REQUEST['sede'];
$codigoc     = $_REQUEST['codigoc'];
$nombrec     = $_REQUEST['nombrec'];

$update = ("UPDATE sistema.programas 
	SET 
	nombre_programa  ='" . $nombre . "',
    codigo_sede ='" . $sede . "',
    codigo_coordinador ='" . $codigoc . "',
    nom_coordinador ='" . $nombrec . "'
	
WHERE codigo_programa='" . $idRegistros . "'
");
$result_update = pg_query($conexion, $update);

echo "<script type='text/javascript'>
        window.location='programas.php';
    </script>";

?>
