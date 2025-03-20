<?php

include('conexion2.php');
include("funciones.php");

session_start();

$tablam3=$_SESSION['tablam3'];
$codrol=$_SESSION['codigo_rol'];


if ($codrol=='1'){ 
if(isset($_POST["id_registro"]))
{
	
	$stmt = $pdo->prepare(
		"DELETE FROM $tablam3 WHERE id = :id"
	);
	$resultado = $stmt->execute(
		array(
			':id'	=>	$_POST["id_registro"]
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