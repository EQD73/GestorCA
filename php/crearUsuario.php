<?php

include("conexion3.php");
//include("funciones.php");

if ($_POST["operacion"] == "Crear") {

    $dominio="@unicorsalud.edu.co";   
    $stmt = $conn->prepare('INSERT INTO usuarios(codigo_usuario, password, nombres, apellidos, nomcompleto, "Celular", email_institucional, estado, codigo_rol)VALUES(:codigo_usuario, :pass, :nombre, :apellidos, :nomcompleto, :Celular, :email, :estado, :rol)');

    $resultado = $stmt->execute(
        array(
            ':codigo_usuario' =>$_POST["codigo"],
            ':pass' =>MD5(substr($_POST["codigo"],-4)),
            ':nombre'    => strtoupper($_POST["nombres"]),
            ':apellidos'    => strtoupper($_POST["apellidos"]),
            ':nomcompleto' => strtoupper($_POST['nombres']) ." ". strtoupper($_POST['apellidos']),
            ':Celular'    => $_POST["Celular"],
            ':email'    => trim($_POST["email"]).$dominio,
            ':estado'    => $_POST["estado"],
            ':rol'    => $_POST["rol"]            
        )
    );

 

    if (!empty($resultado)) {
        echo 'Registro de Usuario creado';
        
    }else{
        echo 'Registro de Usuario no creado';
    }
}



if ($_POST["operacion"] == "Editar") {
    
    $stmt = $conn->prepare('UPDATE usuarios SET codigo_usuario=:codigo_usuario, nombres=:nombre, apellidos=:apellidos, nomcompleto=:nom_completo, "Celular"=:Celular, email_institucional=:email, estado=:estado, codigo_rol=:rol WHERE id = :id');
    
    $resultado = $stmt->execute(
        array(
            ':codigo_usuario' =>$_POST["codigo"],
            ':nombre'    => $_POST["nombres"],
            ':apellidos'    => $_POST["apellidos"],
            ':nom_completo' => $_POST['nombres'] ." ". $_POST['apellidos'],
            ':Celular'    => $_POST["Celular"],
            ':email'    => $_POST["email"],
            ':estado'    => $_POST["estado"],
            ':rol'    => $_POST["rol"],
            ':id'    => $_POST["id_usuario"]
        )
    );
    
    if (!empty($resultado)) {
        echo 'Registro actualizado';
    }else{
        echo 'Registro no Actualizado';
    }
}