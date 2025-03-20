<?php

include('conexion.php'); 
  $idvalor = $_POST['id_consigna'];
  echo $value;
  
  $sqlvalue="UPDATE sistema.temporal SET valor3 ='".$idvalor."' WHERE id='1'";
  $resultvalue= pg_query($conexion,$sqlvalue);
   ?>