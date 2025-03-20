<?php
$fecha = date_create("2022-08-15");
date_add($fecha, date_interval_create_from_date_string("16 weeks"));
echo date_format($fecha,"d-m-Y");

$obj = pg_fetch_object($resultado_qper);
$fecha1= $obj->fecha_inicio;



echo date("d-m-Y",strtotime($fecha_actual."+ 1 week")); ?>

<!--creacion de semanas-->
                <?php
                $obj = pg_fetch_object($resultado_qper);
                $fecha1= date("d-m-Y",strtotime($obj->fecha_inicio));
                $semanas=1;
                while ($semanas <> $sem) { 
                   $fecha2=date("d-m-Y",strtotime($fecha1."+ 5 days")); 
                   $rango_sem= "Del ".$fecha1." Hasta ".$fecha2; 
                   $rango_sem.$semanas=$rango_sem;
                   $fecha1=date("d-m-Y",strtotime($fecha1."+ 1 weeks"));
                   $semanas = $semanas + 1;
                }?>

                