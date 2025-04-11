
<?php
include('conexion.php');
$idRegistros = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];


$update = ("UPDATE sistema.estrategias_met
	SET 
	nombre_estrategia  ='" . $nombre . "'
	
WHERE codigo_estrategia='" . $idRegistros . "'
");
$result_update = pg_query($conexion, $update);

echo "<script type='text/javascript'>
        window.location='estrategia.php';
    </script>";

?>
