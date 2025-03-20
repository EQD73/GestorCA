<?php

include('conexion.php');

//consulta a tabla asignatura
/* $sql = "SELECT codigo_asignatura, id FROM sistema.asignaturas";
//where periodo='20231'";
$resultado1 = pg_query($conexion, $sql); */

//consulta a tabla $tablam1
$sql = "SELECT codigo_asignaturacurso, id FROM sistema.m1";
//where periodo='20231'";
$resultado1 = pg_query($conexion, $sql);

//para recorrer una consulta
if ($resultado1) {
    while ($row1 = pg_fetch_assoc($resultado1)) {
        $codigo_asigna = $row1['codigo_asignaturacurso'];
        $id = $row1['id'];
        
        $sql2 = "SELECT * FROM sistema.prerequisitos WHERE codigo_asignatura='$codigo_asigna'";
        $resultado2 = pg_query($conexion, $sql2);

        if ($resultado2) {
            $fila = array();
            while ($row2 = pg_fetch_assoc($resultado2)) {
                $fila[] = $row2['codigo_prerequisito'] . "-" . $row2['nombre_prerequisito'];
            }
        }
        //$convert=json_encode($fila);
        var_dump($fila);

        
        //funcion
        $valor=0;
        $result=array();
        $result=null;
        foreach ($fila as $t) {
            $t = str_replace('"', '\\"', $t); // escape double quote
            if (!is_numeric($t)) // quote only non-numeric values
                            $t = '"' . $t . '"';
            $result[] = $t;
        }

        $valor = '{' . implode(",", $result) . '}'; // format

        var_dump($valor);


        //update tabla asignaturas
      /*   $sql3 = "UPDATE sistema.asignaturas SET prerequisito='$valor' WHERE id='$id'";
        $resultado3 = pg_query($conexion, $sql3); */

        //update tabla m1
        $sql3 = "UPDATE sistema.m1 SET requisitos='$valor' WHERE id='$id'";
        $resultado3 = pg_query($conexion, $sql3);
        
        
        if (!empty($resultado3)) {
            echo 'Registro actualizado';
            
        } else {
            echo 'Registro no Actualizado';
        }
    }
}
