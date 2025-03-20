
<?php
include('conexion.php');
$idRegistros = $_REQUEST['codigo'];
$momento      = $_REQUEST['momento'];
$poract      = $_REQUEST['poract'];
$poractfinal      = $_REQUEST['poractfinal'];
$porcorte      = $_REQUEST['porcorte'];


$update = ("UPDATE sistema.evaluacion 
	SET 
	momento  ='" .$momento. "',
	por_actividades  ='" .$poract. "',
    por_actfinal  ='" .$poractfinal. "',
    por_corte  ='" .$porcorte. "'

WHERE id='" .$idRegistros. "'
");
$result_update = pg_query($conexion, $update);

echo "<script type='text/javascript'>
        window.location='evaluacion.php';
    </script>";

?>
