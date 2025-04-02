
<?php
include('conexion.php');
$idRegistros = $_REQUEST['codigo'];
$nombre      = $_REQUEST['nombre'];
$totalsem    = $_REQUEST['totalsem'];
$finicio     = $_REQUEST['fechainicio'];
$ffinal      = $_REQUEST['fechafinal'];
$estado      = $_REQUEST['estado'];

$update = ("UPDATE sistema.periodos 
	SET 
	nombre_periodo  ='" . $nombre . "',
    total_semanas   ='" . $totalsem . "',
    fecha_inicio    ='" . $finicio . "',
    fecha_fin       ='" . $ffinal . "',
    estado          ='" . $estado . "'	
WHERE codigo_periodo='" . $idRegistros . "'
");
$result_update = pg_query($conexion, $update);

echo "<script type='text/javascript'>
        window.location='periodo.php';
    </script>";

?>
