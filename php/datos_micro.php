<?php
session_start();
require ("conexion.php");
$tablam1=$_SESSION['tablam1'];
$codusuario=$_SESSION['codigo_usuario'];

$sql = "SELECT * FROM $tablam1 WHERE codigo_docente=$codusuario::varchar";
$resultado = pg_query($conexion, $sql);

//si no hay reultado imprimimos que diga error 
if (!$resultado) {
    die('Error no hay datos');
}else{
    while ($data = pg_fetch_assoc($resultado)) {
        $arreglo["data"][]=$data;            
    }
//pasamos los datos json
    echo json_encode($arreglo);
}
