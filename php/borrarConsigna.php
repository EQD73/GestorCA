<?php

include('conexion2.php');
include("funciones.php");

session_start();

$tablam2=$_SESSION['tablam2'];
$codrol=$_SESSION['codigo_rol'];


if ($codrol=='1'){ 
if(isset($_POST["id_consigna"]))
{
	
	$stmt = $pdo->prepare(
		"DELETE FROM $tablam2 WHERE id = :id"
	);
	$resultado = $stmt->execute(
		array(
			':id'	=>	$_POST["id_consigna"]
		)
	);
	
	if(!empty($resultado))
	{
		echo 'Registro borrado';
	}

}
}else{
echo "No tienes los permisos para eliminar registros";
}




?>