<?php

include("conexion3.php");
//include("funciones.php");

if (isset($_POST["id_usuario"])) {
    $salida = array();
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = '".$_POST["id_usuario"]."' LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    foreach($resultado as $fila){
        $salida["codigo_usuario"] = $fila["codigo_usuario"];
        $salida["nombres"] = $fila["nombres"];
        $salida["apellidos"] = $fila["apellidos"];
        $salida["Celular"] = $fila["Celular"];
        $salida["email"] = $fila["email_institucional"];
        $salida["estado"] = $fila["estado"];
        $salida["rol"] = $fila["codigo_rol"];
    }

    echo json_encode($salida);
}