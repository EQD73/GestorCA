<?php

    /* function subir_imagen(){
        if (isset($_FILES["imagen_usuario"])) {
            
            $extension = explode('.', $_FILES["imagen_usuario"]['name']);
            $nuevo_nombre = rand() . '.' . $extension[1];
            $ubicacion = './img/' . $nuevo_nombre;
            move_uploaded_file($_FILES["imagen_usuario"]['tmp_name'], $ubicacion);
            return $nuevo_nombre;
        }
    }
 */
    /* function obtener_nombre_imagen($id_usuario){
        include('conexion2.php');
        $stmt = $conexion->prepare("SELECT imagen FROM usuarios WHERE id = '$id_usuario'");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        foreach($resultado as $fila){
            return $fila["imagen"];
        }
    } */

    function obtener_todos_registros_usuarios(){
        include('conexion2.php');
        $stmt = $pdo->prepare("SELECT * FROM sistema.usuarios");
        $stmt->execute();
        $resultado = $stmt->fetchAll(); 
        return $stmt->rowCount();       
    }