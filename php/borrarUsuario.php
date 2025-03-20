<?php

include('conexion2.php');
include("funciones.php");

if(isset($_POST["id_usuario"]))
{
	
	$stmt = $pdo->prepare(
		"DELETE FROM sistema.usuarios WHERE id = :id"
	);
	$resultado = $stmt->execute(
		array(
			':id'	=>	$_POST["id_usuario"]
		)
	);
	
	if(!empty($resultado))
	{
		echo 'Registro borrado';
	}
}



?>