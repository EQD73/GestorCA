<?php
  
 // session_start();
 include('conexion.php'); 
  $value = $_POST['variable'];
  echo $value;
  
  $sqlvalue="UPDATE sistema.temporal SET valor1 ='".$value."' WHERE id='1'";
  $resultvalue= pg_query($conexion,$sqlvalue);
   ?>