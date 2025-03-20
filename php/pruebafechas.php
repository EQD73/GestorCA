<?php

date_default_timezone_set("America/Bogota");
//$fechahoy=strtotime(date("08-08-2022"));
//$fechahoy= date("d-m-Y",strtotime($fechahoy));
 //echo $fechahoy;
 //$fechai1="27-02-2023";
  //$fechai1= strtotime(date("06-08-2022"));
 //echo $fechai1;
 //$fechaf1="03-03-2023";
  $fechaf1= date("d-m-Y",strtotime("07-08-2022" ."+1 days"));
  echo $fechaf1;
  //$fechaf1=strtotime($fechaf1);
 echo "<br>";
//$fecha=date("d-m-Y");
//echo $fecha;
  $hora=date('h:i:s');
  echo $hora;

 /* if ($fechahoy >= $fechai1 &&  $fechahoy <= $fechaf1 ) {
    echo 'esta dentro del rango';
 }else{
    echo 'NO esta dentro del rango';
 } */
 
?>