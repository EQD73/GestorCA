<?php
session_start();

include ('conexion.php');
$tablam1=$_SESSION['tablam1'];
$anio=strval($_SESSION['anio']);
$codcurso=$_REQUEST['codasig'];
$codgrupo=$_REQUEST['codgrup'];


$sql="SELECT * FROM $tablam1 WHERE codigo_asignaturacurso='$codcurso' AND grupo='$codgrupo' AND ano_micro='$anio'";
$query=pg_query($conexion,$sql);
$numrow=pg_num_rows($query);



if($numrow>0){
    
    $data=null;
    
}
print json_encode($data);
?>