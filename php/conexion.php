<?php

$conexion = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=postgres options='--search_path=sistema'");

/* if($conexion){

		echo 'Conexion Exitosa';
	
	}else {
		echo 'No se pudo conectar';
	} */
