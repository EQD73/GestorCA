<?php

require('conexion.php');

$sql="SELECT * FROM sistema.asignaturas WHERE prerequisito::varchar != 'null'";
$result=pg_query($conexion,$sql);

if ($result) { 
    while ($row1 = pg_fetch_assoc($result)){
       $prereq = $row1['prerequisito']; 
       $id= $row1['id'];
       $convert=json_decode($prereq); 
       //var_dump($convert);
    $sql2 = "UPDATE sistema.asignaturas SET prerequisito='$convert' WHERE id='$id'";
    $resultado2 = pg_query($conexion, $sql2); 
}
}