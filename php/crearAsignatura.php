<?php

include("conexion2.php");
include("funciones.php");

if ($_POST["operacion"] == 'Crear') {
   
    $stmt = $pdo->prepare('INSERT INTO sistema.asignaturas(codigo_asignatura, nom_asignatura, codigo_programa, semestre, grupo, ihs, creditos, codigo_docente, nombre_docente, periodo, prerequisito)VALUES(:codigo_asignatura, :nombre_asignatura, :codigo_programa, :semestre, :grupo, :ihs, :creditos, :codigo_docente, :nombre_docente, :periodo, :prerequisito)');

    $resultado = $stmt->execute(
        array(
            ':codigo_asignatura' =>$_POST["codigo_asigna"],
            ':nombre_asignatura'=> strtoupper($_POST["nom_asigna"]),
            ':codigo_programa' =>$_POST["CodProg"],
            ':semestre'    => $_POST["semestre"],
            ':grupo' =>   $_POST["grupo"],
            ':ihs'    => $_POST["ihs"],
            ':creditos' =>   $_POST["creditos"],
            ':codigo_docente' => $_POST["cod_docente"],
            ':nombre_docente' => strtoupper($_POST["nom_docente"]),  
            ':periodo' =>   $_POST["periodo"],
            ':prerequisito' =>   json_encode($_POST["requisitos"]),


        )
    );

    if (!empty($resultado)) {
        echo 'Registro creado';
        
    }else{
        echo 'Registro no creado';
    }
}



if ($_POST["operacion"] == "Editar") {
    
    $stmt = $pdo->prepare('UPDATE sistema.asignaturas SET codigo_asignatura=:codigo_asignatura, nom_asignatura=:nombre_asignatura, codigo_programa=:codigo_programa, semestre=:semestre, grupo=:grupo, ihs=:ihs, creditos=:creditos, codigo_docente=:codigo_docente, nombre_docente=:nombre_docente, periodo=:periodo, prerequisito=:prerequisito WHERE id = :id');
    
    $resultado = $stmt->execute(
        array(
            ':codigo_asignatura' =>$_POST["codigo_asigna"],
            ':nombre_asignatura'=> strtoupper($_POST["nom_asigna"]),
            ':codigo_programa' =>$_POST["CodProg"],
            ':semestre'    => $_POST["semestre"],
            ':grupo' =>   $_POST["grupo"],
            ':ihs'    => $_POST["ihs"],
            ':creditos' =>   $_POST["creditos"],
            ':codigo_docente' => $_POST["cod_docente"],
            ':nombre_docente' => strtoupper($_POST["nom_docente"]),  
            ':periodo' =>   $_POST["periodo"],
            ':prerequisito' =>   json_encode($_POST["requisitos"]),
            ':id' => $_POST['id_asigna']
        )
    );
    
    if (!empty($resultado)) {
        echo 'Registro actualizado';
    }else{
        echo 'Registro no Actualizado';
    }
}