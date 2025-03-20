<?php

date_default_timezone_set("America/Bogota");
session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];
$tablam3 = $_SESSION['tablam3'];
$codperiodo = $_SESSION['codigo_periodo'];
$nomperiodo = $_SESSION['nombre_periodo'];


include('conexion.php');
include('scriptsweet.php');

$codregistro       = $_REQUEST['id_registro'];

/* variables semanas */
//fecha registro //

//semana 1
if (isset($_POST['titulosem1'])) {
if (isset($_POST['DescripcionActSem1'])) {
    $DescripcionActSem1         = strval($_REQUEST['DescripcionActSem1']);
} else {
    $DescripcionActSem1     = "";
}
$QueryUpdate = ("UPDATE $tablam3
 SET 
    s1_descripcion= '" . $DescripcionActSem1 . "'   
WHERE id='" .$codregistro. "' 
");    
$updateRegistro = pg_query($conexion, $QueryUpdate);    
}

//semana 2
if (isset($_POST['titulosem2'])) {
    if (isset($_POST['DescripcionActSem2'])) {
        $DescripcionActSem2         = strval($_REQUEST['DescripcionActSem2']);
    } else {
        $DescripcionActSem2     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s2_descripcion= '" . $DescripcionActSem2 . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana 3
if (isset($_POST['titulosem3'])) {
    if (isset($_POST['DescripcionActSem3'])) {
        $DescripcionActSem3         = strval($_REQUEST['DescripcionActSem3']);
    } else {
        $DescripcionActSem3     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s3_descripcion= '" . $DescripcionActSem3 . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana 4
if (isset($_POST['titulosem4'])) {
    if (isset($_POST['DescripcionActSem4'])) {
        $DescripcionActSem4         = strval($_REQUEST['DescripcionActSem4']);
    } else {
        $DescripcionActSem4     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s4_descripcion= '" . $DescripcionActSem4 . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana 5
if (isset($_POST['titulosem5'])) {
    if (isset($_POST['DescripcionActSem5'])) {
        $DescripcionActSem5         = strval($_REQUEST['DescripcionActSem5']);
    } else {
        $DescripcionActSem5     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s5_descripcion= '" . $DescripcionActSem5 . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana 6
if (isset($_POST['titulosem6'])) {
    if (isset($_POST['DescripcionActSem6'])) {
        $DescripcionActSem6         = strval($_REQUEST['DescripcionActSem6']);
    } else {
        $DescripcionActSem6     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s6_descripcion= '" . $DescripcionActSem6 . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana 7
if (isset($_POST['titulosem7'])) {
    if (isset($_POST['DescripcionActSem7'])) {
        $DescripcionActSem7         = strval($_REQUEST['DescripcionActSem7']);
    } else {
        $DescripcionActSem7     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s7_descripcion= '" . $DescripcionActSem7 . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana 8
if (isset($_POST['titulosem8'])) {
    if (isset($_POST['DescripcionActSem8'])) {
        $DescripcionActSem8 = strval($_REQUEST['DescripcionActSem8']);
    } else {
        $DescripcionActSem8 = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s8_descripcion= '" . $DescripcionActSem8 . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana 9
if (isset($_POST['titulosem9'])) {
    if (isset($_POST['DescripcionActSem9'])) {
        $DescripcionActSem9         = strval($_REQUEST['DescripcionActSem9']);
    } else {
        $DescripcionActSem9     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s9_descripcion= '" . $DescripcionActSem9 . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana 10
if (isset($_POST['titulosem10'])) {
    if (isset($_POST['DescripcionActSem10'])) {
        $DescripcionActSem10         = strval($_REQUEST['DescripcionActSem10']);
    } else {
        $DescripcionActSem10     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s10_descripcion= '" . $DescripcionActSem10 . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana 11
if (isset($_POST['titulosem11'])) {
    if (isset($_POST['DescripcionActSem11'])) {
        $DescripcionActSem11         = strval($_REQUEST['DescripcionActSem11']);
    } else {
        $DescripcionActSem11     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s11_descripcion= '" . $DescripcionActSem11 . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana 12
if (isset($_POST['titulosem12'])) {
    if (isset($_POST['DescripcionActSem12'])) {
        $DescripcionActSem12         = strval($_REQUEST['DescripcionActSem12']);
    } else {
        $DescripcionActSem12     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s12_descripcion= '" . $DescripcionActSem12 . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana 13
if (isset($_POST['titulosem13'])) {
    if (isset($_POST['DescripcionActSem13'])) {
        $DescripcionActSem13         = strval($_REQUEST['DescripcionActSem13']);
    } else {
        $DescripcionActSem13     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s13_descripcion= '" . $DescripcionActSem13 . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana 14
if (isset($_POST['titulosem14'])) {
    if (isset($_POST['DescripcionActSem14'])) {
        $DescripcionActSem14         = strval($_REQUEST['DescripcionActSem14']);
    } else {
        $DescripcionActSem14     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s14_descripcion= '" . $DescripcionActSem14 . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana 15
if (isset($_POST['titulosem15'])) {
    if (isset($_POST['DescripcionActSem15'])) {
        $DescripcionActSem15         = strval($_REQUEST['DescripcionActSem15']);
    } else {
        $DescripcionActSem15     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s15_descripcion= '" . $DescripcionActSem15 . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana 16
if (isset($_POST['titulosem16'])) {
    if (isset($_POST['DescripcionActSem16'])) {
        $DescripcionActSem16         = strval($_REQUEST['DescripcionActSem16']);
    } else {
        $DescripcionActSem16     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s16_descripcion= '" . $DescripcionActSem16 . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana1 postgrado
if (isset($_POST['titulosem1p'])) {
    if (isset($_POST['DescripcionActSem1p'])) {
        $DescripcionActSem1p         = strval($_REQUEST['DescripcionActSem1p']);
    } else {
        $DescripcionActSem1p     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s1_descripcion_p= '" . $DescripcionActSem1p . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana2 postgrado
if (isset($_POST['titulosem2p'])) {
    if (isset($_POST['DescripcionActSem2p'])) {
        $DescripcionActSem2p         = strval($_REQUEST['DescripcionActSem2p']);
    } else {
        $DescripcionActSem2p     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s2_descripcion_p= '" . $DescripcionActSem2p . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana3 postgrado
if (isset($_POST['titulosem3p'])) {
    if (isset($_POST['DescripcionActSem3p'])) {
        $DescripcionActSem3p         = strval($_REQUEST['DescripcionActSem3p']);
    } else {
        $DescripcionActSem3p     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s3_descripcion_p= '" . $DescripcionActSem3p . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana4 postgrado
if (isset($_POST['titulosem4p'])) {
    if (isset($_POST['DescripcionActSem4p'])) {
        $DescripcionActSem4p         = strval($_REQUEST['DescripcionActSem4p']);
    } else {
        $DescripcionActSem4p     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s4_descripcion_p= '" . $DescripcionActSem4p . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//semana5 postgrado
if (isset($_POST['titulosem5p'])) {
    if (isset($_POST['DescripcionActSem5p'])) {
        $DescripcionActSem5p         = strval($_REQUEST['DescripcionActSem5p']);
    } else {
        $DescripcionActSem5p     = "";
    }
    $QueryUpdate = ("UPDATE $tablam3
     SET 
        s5_descripcion_p= '" . $DescripcionActSem5p . "'   
    WHERE id='" .$codregistro. "' 
    ");    
    $updateRegistro = pg_query($conexion, $QueryUpdate);    
    }
//
if ($updateRegistro){
    //echo "registro insertado";
    echo '<script>
    Swal.fire({
     icon: "success",
     title: "Exito...",
     text: "¡Registro Actualizado con Exito!",
     showConfirmButton: true,
     confirmButtonText: "Cerrar"
     }).then(function(result){
        if(result.value){                   
         window.location = "Registro.php";
        }
     });
    </script>';
}else{
    
    echo '<script>
    Swal.fire({
     icon: "error",
     title: "Oops...",
     text: "¡El registro regular, no se pudo actualizar!",
     showConfirmButton: true,
     confirmButtonText: "Cerrar"
     }).then(function(result){
        if(result.value){                   
         window.location = "Registro.php";
        }
     });
    </script>';
    
}
