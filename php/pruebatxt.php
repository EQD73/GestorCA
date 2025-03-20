
<?php
	
include('conexion.php');

//m1

$query_m1 = "SELECT * FROM sistema.m1 ORDER BY id ASC";
$resultado_qm1 = pg_query($conexion, $query_m1);
$num1 = pg_num_rows($resultado_qm1);
echo $num1;
/* for ($i = 1; $i <= 649; $i++) {
    
    //echo $i;

    $querym1 = ("UPDATE sistema.m1 SET     id ='".$i."'");
} */

if (pg_num_rows($resultado_qm1) > 0) {
    $i = 1; 
    while($fila = pg_fetch_assoc($resultado_qm1)){
        $row=implode(pg_fetch_row($resultado_qm1));
        $querym1 = ("UPDATE sistema.m1 SET id ='".$i."' WHERE id = '".$row."'");
        pg_query($conexion, $querym1);
        $i= $i + 1;
} 
} else {
    die("Error: No hay datos en la tabla seleccionada");
}

?>	