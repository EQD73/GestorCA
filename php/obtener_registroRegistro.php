<?php

include('conexion.php'); 
  $idvalor = $_POST['id_registro'];
  echo $value;
  
  $sqlvalue="UPDATE sistema.temporal SET valor2 ='".$idvalor."' WHERE id='1'";
  $resultvalue= pg_query($conexion,$sqlvalue);
   ?>