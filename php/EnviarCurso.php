<?php
  
 // session_start();
 include('conexion.php'); 
  $codcurso = $_POST['codigocurso'];
  $grupo = $_POST['grupo'];
  $per= $_POST['per'];
  
  $sql="SELECT * FROM sistema.asignaturas WHERE codigo_asignatura='$codcurso' AND grupo='$grupo' AND periodo='$per'";
  $result= pg_query($conexion,$sql);
  $objConsulta=pg_fetch_object($result);
  //$array=array();

  $array=$objConsulta->prerequisito;
  //var_dump($array);
  print_r($array);

?>