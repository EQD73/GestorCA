<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol']; 
$tablam1=$_SESSION['tablam1'];



include('conexion.php');

$codigoConsultacurso     = $_REQUEST['CodigoConsultaCurso'];
//echo $codigoConsultacurso;

///consulta de tabla asignatura

$query_micro = "SELECT * FROM sistema.pr2022_m1 WHERE codigo_asignaturacurso= '$codigoConsultacurso'";
$resultado_qm = pg_query($conexion, $query_micro);
$objConsulta=pg_fetch_object($resultado_qm);


if($resultado_qm){ 

}

//header("location: consultar_micro.php");
?>