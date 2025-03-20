<?php

session_start();
$periodo=$_SESSION['codigo_periodo'];

include("conexion2.php");
include("funciones.php");

if (isset($_POST["id_asigna"])) {
    $salida = array();
    $stmt = $pdo->prepare("SELECT a.*, p.nombre_programa FROM sistema.asignaturas a INNER JOIN sistema.programas p  ON a.codigo_programa = p.codigo_programa WHERE a.id = '".$_POST["id_asigna"]."' AND a.periodo='$periodo' LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    foreach($resultado as $fila){
        $salida["codigo_asignatura"] = $fila["codigo_asignatura"];
        $salida["nombre_asignatura"] = $fila["nom_asignatura"];
        $salida["codigo_programa"] = $fila["codigo_programa"];
        $salida["nombre_programa"] = $fila["nombre_programa"];
        $salida["semestre"] = $fila["semestre"];
        $salida["grupo"] = $fila["grupo"];
        $salida["ihs"] = $fila["ihs"];
        $salida["creditos"] = $fila["creditos"];
        $salida["codigo_docente"] = $fila["codigo_docente"];
        $salida["nombre_docente"] = $fila["nombre_docente"];
        $salida["prerequisito"] = json_decode($fila["prerequisito"]);
      
    }

    echo json_encode($salida);
}