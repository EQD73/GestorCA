<?php

include('conexion2.php');
include("funciones.php");

if(isset($_POST["id_asigna"]))
{
	
	$stmt = $pdo->prepare(
		"DELETE FROM sistema.asignaturas WHERE id = :id"
	);
	$resultado = $stmt->execute(
		array(
			':id'	=>	$_POST["id_asigna"]
		)
	);
	
	if(!empty($resultado))
	{
		echo 'Registro borrado';
	}
}



?>