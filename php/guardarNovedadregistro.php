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

echo $codregistro;

/* variables semanas */

if (isset($_POST['titulosem1'])) {
    //semana 1
    $s1fecharegistro = date("d-m-Y");
    $s1horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad1    = strval($_REQUEST['TipoActividad1']);
    $DescripcionActSem1         = strval($_REQUEST['DescripcionActSem1']);
    $justificasem1         = strval($_REQUEST['justificasem1']);
    if (!empty($_POST['fechanov1'])) {
        $fechanov1       = $_REQUEST['fechanov1'];
    } else {
        $fechanov1 = null;
    }
    $tiponov1 = strval($_REQUEST['TipoNovedad1']);
    if (isset($_POST['justificarsem1'])) {
        $justificarsem1        = strval($_REQUEST['justificarsem1']);
    } else {
        $justificarsem1 = "";
    }
    if (isset($_POST['s1fecharep1'])) {
        $s1fecharep1 = $_REQUEST['s1fecharep1'];
    } else {
        $s1fecharep1 = "";
    }
    if (isset($_POST['s1fecharep2'])) {
        $s1fecharep2 = $_REQUEST['s1fecharep2'];
    } else {
        $s1fecharep2 = "";
    }
    if ($tiponov1 == "Reprogramacion" || $tiponov1 == "Fueradefecha") {
        $estadoreg1 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg1 = "SIN DEFINIR";
    }
    if ($fechanov1 === null) {
        $QueryUpdate = ("UPDATE $tablam3
        SET    
           s1_fecharegistro= '" . $s1fecharegistro . "',
           s1_horaregistro= '" . $s1horaregistro . "', 
           s1_tipoactividad= '" . $tipoactividad1 . "',
           s1_descripcion= '" . $DescripcionActSem1 . "',
           s1_justifica_nov= '" . $justificasem1 . "',
           s1_fechanovedad= null,
           s1_tiponovedad= '" . $tiponov1 . "', 
           s1_justifica_reprog= '" . $justificarsem1 . "',
           s1_fechareprog1= '" . $s1fecharep1 . "',
           s1_fechareprog2= '" . $s1fecharep2 . "',
           s1_estadoregistro= '" . $estadoreg1 . "'
       WHERE id='" . $codregistro . "' 
       ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
     SET    
        s1_fecharegistro= '" . $s1fecharegistro . "',
        s1_horaregistro= '" . $s1horaregistro . "', 
        s1_tipoactividad= '" . $tipoactividad1 . "',
        s1_descripcion= '" . $DescripcionActSem1 . "',
        s1_justifica_nov= '" . $justificasem1 . "',
        s1_fechanovedad= '" . $fechanov1 . "',
        s1_tiponovedad= '" . $tiponov1 . "', 
        s1_justifica_reprog= '" . $justificarsem1 . "',
        s1_fechareprog1= '" . $s1fecharep1 . "',
        s1_fechareprog2= '" . $s1fecharep2 . "',
        s1_estadoregistro= '" . $estadoreg1 . "'
    WHERE id='" . $codregistro . "' 
    ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem2'])) {
    //semana 2
    $s2fecharegistro = date("d-m-Y");
    $s2horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad2    = strval($_REQUEST['TipoActividad2']);
    $DescripcionActSem2         = strval($_REQUEST['DescripcionActSem2']);
    $justificasem2         = strval($_REQUEST['justificasem2']);
    if (!empty($_POST['fechanov2'])) {
        $fechanov2       = $_REQUEST['fechanov2'];
    } else {
        $fechanov2 = null;
    }
    $tiponov2 = strval($_REQUEST['TipoNovedad2']);
    if (isset($_POST['justificarsem2'])) {
        $justificarsem2        = strval($_REQUEST['justificarsem2']);
    } else {
        $justificarsem2 = "";
    }
    if (isset($_POST['s2fecharep1'])) {
        $s2fecharep1 = $_REQUEST['s2fecharep1'];
    } else {
        $s2fecharep1 = "";
    }
    if (isset($_POST['s2fecharep2'])) {
        $s2fecharep2 = $_REQUEST['s2fecharep2'];
    } else {
        $s2fecharep2 = "";
    }
    if ($tiponov2 == "Reprogramacion" || $tiponov2 == "Fueradefecha") {
        $estadoreg2 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg2 = "SIN DEFINIR";
    }
    if ($fechanov2 === null) {
        $QueryUpdate = ("UPDATE $tablam3
        SET    
           s2_fecharegistro= '" . $s2fecharegistro . "',
           s2_horaregistro= '" . $s2horaregistro . "', 
           s2_tipoactividad= '" . $tipoactividad2 . "',
           s2_descripcion= '" . $DescripcionActSem2 . "',
           s2_justifica_nov= '" . $justificasem2 . "',
           s2_fechanovedad= null,
           s2_tiponovedad= '" . $tiponov2 . "', 
           s2_justifica_reprog= '" . $justificarsem2 . "',
           s2_fechareprog1= '" . $s2fecharep1 . "',
           s2_fechareprog2= '" . $s2fecharep2 . "',
           s2_estadoregistro= '" . $estadoreg2 . "'
       WHERE id='" . $codregistro . "' 
       ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
     SET    
        s2_fecharegistro= '" . $s2fecharegistro . "',
        s2_horaregistro= '" . $s2horaregistro . "', 
        s2_tipoactividad= '" . $tipoactividad2 . "',
        s2_descripcion= '" . $DescripcionActSem2 . "',
        s2_justifica_nov= '" . $justificasem2 . "',
        s2_fechanovedad= '" . $fechanov2 . "',
        s2_tiponovedad= '" . $tiponov2 . "', 
        s2_justifica_reprog= '" . $justificarsem2 . "',
        s2_fechareprog1= '" . $s2fecharep1 . "',
        s2_fechareprog2= '" . $s2fecharep2 . "',
        s2_estadoregistro= '" . $estadoreg2 . "'
    WHERE id='" . $codregistro . "' 
    ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem3'])) {
    //semana 3
    $s3fecharegistro = date("d-m-Y");
    $s3horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad3    = strval($_REQUEST['TipoActividad3']);
    $DescripcionActSem3         = strval($_REQUEST['DescripcionActSem3']);
    $justificasem3         = strval($_REQUEST['justificasem3']);
    if (!empty($_POST['fechanov3'])) {
        $fechanov3       = $_REQUEST['fechanov3'];
    } else {
        $fechanov3 = null;
    }
    $tiponov3 = strval($_REQUEST['TipoNovedad3']);
    if (isset($_POST['justificarsem3'])) {
        $justificarsem3        = strval($_REQUEST['justificarsem3']);
    } else {
        $justificarsem3 = "";
    }
    if (isset($_POST['s3fecharep1'])) {
        $s3fecharep1 = $_REQUEST['s3fecharep1'];
    } else {
        $s3fecharep1 = "";
    }
    if (isset($_POST['s3fecharep2'])) {
        $s3fecharep2 = $_REQUEST['s3fecharep2'];
    } else {
        $s3fecharep2 = "";
    }
    if ($tiponov3 == "Reprogramacion" || $tiponov3 == "Fueradefecha") {
        $estadoreg3 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg3 = "SIN DEFINIR";
    }
    if ($fechanov3 === null) {
        $QueryUpdate = ("UPDATE $tablam3
        SET    
           s3_fecharegistro= '" . $s3fecharegistro . "',
           s3_horaregistro= '" . $s3horaregistro . "', 
           s3_tipoactividad= '" . $tipoactividad3 . "',
           s3_descripcion= '" . $DescripcionActSem3 . "',
           s3_justifica_nov= '" . $justificasem3 . "',
           s3_fechanovedad= null,
           s3_tiponovedad= '" . $tiponov3 . "', 
           s3_justifica_reprog= '" . $justificarsem3 . "',
           s3_fechareprog1= '" . $s3fecharep1 . "',
           s3_fechareprog2= '" . $s3fecharep2 . "',
           s3_estadoregistro= '" . $estadoreg3 . "'
       WHERE id='" . $codregistro . "' 
       ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
     SET    
        s3_fecharegistro= '" . $s3fecharegistro . "',
        s3_horaregistro= '" . $s3horaregistro . "', 
        s3_tipoactividad= '" . $tipoactividad3 . "',
        s3_descripcion= '" . $DescripcionActSem3 . "',
        s3_justifica_nov= '" . $justificasem3 . "',
        s3_fechanovedad= '" . $fechanov3 . "',
        s3_tiponovedad= '" . $tiponov3 . "', 
        s3_justifica_reprog= '" . $justificarsem3 . "',
        s3_fechareprog1= '" . $s3fecharep1 . "',
        s3_fechareprog2= '" . $s3fecharep2 . "',
        s3_estadoregistro= '" . $estadoreg3 . "'
    WHERE id='" . $codregistro . "' 
    ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem4'])) {
    //semana 4
    $s4fecharegistro = date("d-m-Y");
    $s4horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad4    = strval($_REQUEST['TipoActividad4']);
    $DescripcionActSem4         = strval($_REQUEST['DescripcionActSem4']);
    $justificasem4         = strval($_REQUEST['justificasem4']);
    if (!empty($_POST['fechanov4'])) {
        $fechanov4       = $_REQUEST['fechanov4'];
    } else {
        $fechanov4 = null;
    }
    $tiponov4 = strval($_REQUEST['TipoNovedad4']);
    if (isset($_POST['justificarsem4'])) {
        $justificarsem4        = strval($_REQUEST['justificarsem4']);
    } else {
        $justificarsem4 = "";
    }
    if (isset($_POST['s4fecharep1'])) {
        $s4fecharep1 = $_REQUEST['s4fecharep1'];
    } else {
        $s4fecharep1 = "";
    }
    if (isset($_POST['s4fecharep2'])) {
        $s4fecharep2 = $_REQUEST['s4fecharep2'];
    } else {
        $s4fecharep2 = "";
    }
    if ($tiponov4 == "Reprogramacion" || $tiponov4 == "Fueradefecha") {
        $estadoreg4 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg4 = "SIN DEFINIR";
    }
    if ($fechanov4 === null) {
        $QueryUpdate = ("UPDATE $tablam3
            SET    
               s4_fecharegistro= '" . $s4fecharegistro . "',
               s4_horaregistro= '" . $s4horaregistro . "', 
               s4_tipoactividad= '" . $tipoactividad4 . "',
               s4_descripcion= '" . $DescripcionActSem4 . "',
               s4_justifica_nov= '" . $justificasem4 . "',
               s4_fechanovedad= null,
               s4_tiponovedad= '" . $tiponov4 . "', 
               s4_justifica_reprog= '" . $justificarsem4 . "',
               s4_fechareprog1= '" . $s4fecharep1 . "',
               s4_fechareprog2= '" . $s4fecharep2 . "',
               s4_estadoregistro= '" . $estadoreg4 . "'
           WHERE id='" . $codregistro . "' 
           ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
         SET    
            s4_fecharegistro= '" . $s4fecharegistro . "',
            s4_horaregistro= '" . $s4horaregistro . "', 
            s4_tipoactividad= '" . $tipoactividad4 . "',
            s4_descripcion= '" . $DescripcionActSem4 . "',
            s4_justifica_nov= '" . $justificasem4 . "',
            s4_fechanovedad= '" . $fechanov4 . "',
            s4_tiponovedad= '" . $tiponov4 . "', 
            s4_justifica_reprog= '" . $justificarsem4 . "',
            s4_fechareprog1= '" . $s4fecharep1 . "',
            s4_fechareprog2= '" . $s4fecharep2 . "',
            s4_estadoregistro= '" . $estadoreg4 . "'
        WHERE id='" . $codregistro . "' 
        ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem5'])) {
    //semana 5
    $s5fecharegistro = date("d-m-Y");
    $s5horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad5    = strval($_REQUEST['TipoActividad5']);
    $DescripcionActSem5         = strval($_REQUEST['DescripcionActSem5']);
    $justificasem5         = strval($_REQUEST['justificasem5']);
    if (!empty($_POST['fechanov5'])) {
        $fechanov5       = $_REQUEST['fechanov5'];
    } else {
        $fechanov5 = null;
    }
    $tiponov5 = strval($_REQUEST['TipoNovedad5']);
    if (isset($_POST['justificarsem5'])) {
        $justificarsem5        = strval($_REQUEST['justificarsem5']);
    } else {
        $justificarsem5 = "";
    }
    if (isset($_POST['s5fecharep1'])) {
        $s5fecharep1 = $_REQUEST['s5fecharep1'];
    } else {
        $s5fecharep1 = "";
    }
    if (isset($_POST['s5fecharep2'])) {
        $s5fecharep2 = $_REQUEST['s5fecharep2'];
    } else {
        $s5fecharep2 = "";
    }
    if ($tiponov5 == "Reprogramacion" || $tiponov5 == "Fueradefecha") {
        $estadoreg5 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg5 = "SIN DEFINIR";
    }
    if ($fechanov5 === null) {
        $QueryUpdate = ("UPDATE $tablam3
        SET    
           s5_fecharegistro= '" . $s5fecharegistro . "',
           s5_horaregistro= '" . $s5horaregistro . "', 
           s5_tipoactividad= '" . $tipoactividad5 . "',
           s5_descripcion= '" . $DescripcionActSem5 . "',
           s5_justifica_nov= '" . $justificasem5 . "',
           s5_fechanovedad= null,
           s5_tiponovedad= '" . $tiponov5 . "', 
           s5_justifica_reprog= '" . $justificarsem5 . "',
           s5_fechareprog1= '" . $s5fecharep1 . "',
           s5_fechareprog2= '" . $s5fecharep2 . "',
           s5_estadoregistro= '" . $estadoreg5 . "'
       WHERE id='" . $codregistro . "' 
       ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
     SET    
        s5_fecharegistro= '" . $s5fecharegistro . "',
        s5_horaregistro= '" . $s5horaregistro . "', 
        s5_tipoactividad= '" . $tipoactividad5 . "',
        s5_descripcion= '" . $DescripcionActSem5 . "',
        s5_justifica_nov= '" . $justificasem5 . "',
        s5_fechanovedad= '" . $fechanov5 . "',
        s5_tiponovedad= '" . $tiponov5 . "', 
        s5_justifica_reprog= '" . $justificarsem5 . "',
        s5_fechareprog1= '" . $s5fecharep1 . "',
        s5_fechareprog2= '" . $s5fecharep2 . "',
        s5_estadoregistro= '" . $estadoreg5 . "'
    WHERE id='" . $codregistro . "' 
    ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem6'])) {
    //semana 6
    $s6fecharegistro = date("d-m-Y");
    $s6horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad6    = strval($_REQUEST['TipoActividad6']);
    $DescripcionActSem6         = strval($_REQUEST['DescripcionActSem6']);
    $justificasem6         = strval($_REQUEST['justificasem6']);
    if (!empty($_POST['fechanov6'])) {
        $fechanov6       = $_REQUEST['fechanov6'];
    } else {
        $fechanov6 = null;
    }
    $tiponov6 = strval($_REQUEST['TipoNovedad6']);
    if (isset($_POST['justificarsem6'])) {
        $justificarsem6        = strval($_REQUEST['justificarsem6']);
    } else {
        $justificarsem6 = "";
    }
    if (isset($_POST['s6fecharep1'])) {
        $s6fecharep1 = $_REQUEST['s6fecharep1'];
    } else {
        $s6fecharep1 = "";
    }
    if (isset($_POST['s6fecharep2'])) {
        $s6fecharep2 = $_REQUEST['s6fecharep2'];
    } else {
        $s6fecharep2 = "";
    }
    if ($tiponov6 == "Reprogramacion" || $tiponov6 == "Fueradefecha") {
        $estadoreg6 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg6 = "SIN DEFINIR";
    }
    if ($fechanov6 === null) {
        $QueryUpdate = ("UPDATE $tablam3
            SET    
               s6_fecharegistro= '" . $s6fecharegistro . "',
               s6_horaregistro= '" . $s6horaregistro . "', 
               s6_tipoactividad= '" . $tipoactividad6 . "',
               s6_descripcion= '" . $DescripcionActSem6 . "',
               s6_justifica_nov= '" . $justificasem6 . "',
               s6_fechanovedad= null,
               s6_tiponovedad= '" . $tiponov6 . "', 
               s6_justifica_reprog= '" . $justificarsem6 . "',
               s6_fechareprog1= '" . $s6fecharep1 . "',
               s6_fechareprog2= '" . $s6fecharep2 . "',
               s6_estadoregistro= '" . $estadoreg6 . "'
           WHERE id='" . $codregistro . "' 
           ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
         SET    
            s6_fecharegistro= '" . $s6fecharegistro . "',
            s6_horaregistro= '" . $s6horaregistro . "', 
            s6_tipoactividad= '" . $tipoactividad6 . "',
            s6_descripcion= '" . $DescripcionActSem6 . "',
            s6_justifica_nov= '" . $justificasem6 . "',
            s6_fechanovedad= '" . $fechanov6 . "',
            s6_tiponovedad= '" . $tiponov6 . "', 
            s6_justifica_reprog= '" . $justificarsem6 . "',
            s6_fechareprog1= '" . $s6fecharep1 . "',
            s6_fechareprog2= '" . $s6fecharep2 . "',
            s6_estadoregistro= '" . $estadoreg6 . "'
        WHERE id='" . $codregistro . "' 
        ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem7'])) {
    //semana 7
    $s7fecharegistro = date("d-m-Y");
    $s7horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad7    = strval($_REQUEST['TipoActividad7']);
    $DescripcionActSem7         = strval($_REQUEST['DescripcionActSem7']);
    $justificasem7         = strval($_REQUEST['justificasem7']);
    if (!empty($_POST['fechanov7'])) {
        $fechanov7       = $_REQUEST['fechanov7'];
    } else {
        $fechanov7 = null;
    }
    $tiponov7 = strval($_REQUEST['TipoNovedad7']);
    if (isset($_POST['justificarsem7'])) {
        $justificarsem7        = strval($_REQUEST['justificarsem7']);
    } else {
        $justificarsem7 = "";
    }
    if (isset($_POST['s7fecharep1'])) {
        $s7fecharep1 = $_REQUEST['s7fecharep1'];
    } else {
        $s7fecharep1 = "";
    }
    if (isset($_POST['s7fecharep2'])) {
        $s7fecharep2 = $_REQUEST['s7fecharep2'];
    } else {
        $s7fecharep2 = "";
    }
    if ($tiponov7 == "Reprogramacion" || $tiponov7 == "Fueradefecha") {
        $estadoreg7 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg7 = "SIN DEFINIR";
    }
    if ($fechanov7 === null) {
        $QueryUpdate = ("UPDATE $tablam3
                SET    
                   s7_fecharegistro= '" . $s7fecharegistro . "',
                   s7_horaregistro= '" . $s7horaregistro . "', 
                   s7_tipoactividad= '" . $tipoactividad7 . "',
                   s7_descripcion= '" . $DescripcionActSem7 . "',
                   s7_justifica_nov= '" . $justificasem7 . "',
                   s7_fechanovedad= null,
                   s7_tiponovedad= '" . $tiponov7 . "', 
                   s7_justifica_reprog= '" . $justificarsem7 . "',
                   s7_fechareprog1= '" . $s7fecharep1 . "',
                   s7_fechareprog2= '" . $s7fecharep2 . "',
                   s7_estadoregistro= '" . $estadoreg7 . "'
               WHERE id='" . $codregistro . "' 
               ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
             SET    
                s7_fecharegistro= '" . $s7fecharegistro . "',
                s7_horaregistro= '" . $s7horaregistro . "', 
                s7_tipoactividad= '" . $tipoactividad7 . "',
                s7_descripcion= '" . $DescripcionActSem7 . "',
                s7_justifica_nov= '" . $justificasem7 . "',
                s7_fechanovedad= '" . $fechanov7 . "',
                s7_tiponovedad= '" . $tiponov7 . "', 
                s7_justifica_reprog= '" . $justificarsem7 . "',
                s7_fechareprog1= '" . $s7fecharep1 . "',
                s7_fechareprog2= '" . $s7fecharep2 . "',
                s7_estadoregistro= '" . $estadoreg7 . "'
            WHERE id='" . $codregistro . "' 
            ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem8'])) {
    //semana 8
    $s8fecharegistro = date("d-m-Y");
    $s8horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad8    = strval($_REQUEST['TipoActividad8']);
    $DescripcionActSem8         = strval($_REQUEST['DescripcionActSem8']);
    $justificasem8         = strval($_REQUEST['justificasem8']);
    if (!empty($_POST['fechanov8'])) {
        $fechanov8       = $_REQUEST['fechanov8'];
    } else {
        $fechanov8 = null;
    }
    $tiponov8 = strval($_REQUEST['TipoNovedad8']);
    if (isset($_POST['justificarsem8'])) {
        $justificarsem8        = strval($_REQUEST['justificarsem8']);
    } else {
        $justificarsem8 = "";
    }
    if (isset($_POST['s8fecharep1'])) {
        $s8fecharep1 = $_REQUEST['s8fecharep1'];
    } else {
        $s8fecharep1 = "";
    }
    if (isset($_POST['s8fecharep2'])) {
        $s8fecharep2 = $_REQUEST['s8fecharep2'];
    } else {
        $s8fecharep2 = "";
    }
    if ($tiponov8 == "Reprogramacion" || $tiponov8 == "Fueradefecha") {
        $estadoreg8 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg8 = "SIN DEFINIR";
    }
    if ($fechanov8 === null) {
        $QueryUpdate = ("UPDATE $tablam3
                    SET    
                       s8_fecharegistro= '" . $s8fecharegistro . "',
                       s8_horaregistro= '" . $s8horaregistro . "', 
                       s8_tipoactividad= '" . $tipoactividad8 . "',
                       s8_descripcion= '" . $DescripcionActSem8 . "',
                       s8_justifica_nov= '" . $justificasem8 . "',
                       s8_fechanovedad= null,
                       s8_tiponovedad= '" . $tiponov8 . "', 
                       s8_justifica_reprog= '" . $justificarsem8 . "',
                       s8_fechareprog1= '" . $s8fecharep1 . "',
                       s8_fechareprog2= '" . $s8fecharep2 . "',
                       s8_estadoregistro= '" . $estadoreg8 . "'
                   WHERE id='" . $codregistro . "' 
                   ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
                 SET    
                    s8_fecharegistro= '" . $s8fecharegistro . "',
                    s8_horaregistro= '" . $s8horaregistro . "', 
                    s8_tipoactividad= '" . $tipoactividad8 . "',
                    s8_descripcion= '" . $DescripcionActSem8 . "',
                    s8_justifica_nov= '" . $justificasem8 . "',
                    s8_fechanovedad= '" . $fechanov8 . "',
                    s8_tiponovedad= '" . $tiponov8 . "', 
                    s8_justifica_reprog= '" . $justificarsem8 . "',
                    s8_fechareprog1= '" . $s8fecharep1 . "',
                    s8_fechareprog2= '" . $s8fecharep2 . "',
                    s8_estadoregistro= '" . $estadoreg8 . "'
                WHERE id='" . $codregistro . "' 
                ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem9'])) {
    //semana 9
    $s9fecharegistro = date("d-m-Y");
    $s9horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad9    = strval($_REQUEST['TipoActividad9']);
    $DescripcionActSem9         = strval($_REQUEST['DescripcionActSem9']);
    $justificasem9         = strval($_REQUEST['justificasem9']);
    if (!empty($_POST['fechanov9'])) {
        $fechanov9       = $_REQUEST['fechanov9'];
    } else {
        $fechanov9 = null;
    }
    $tiponov9 = strval($_REQUEST['TipoNovedad9']);
    if (isset($_POST['justificarsem9'])) {
        $justificarsem9        = strval($_REQUEST['justificarsem9']);
    } else {
        $justificarsem9 = "";
    }
    if (isset($_POST['s9fecharep1'])) {
        $s9fecharep1 = $_REQUEST['s9fecharep1'];
    } else {
        $s9fecharep1 = "";
    }
    if (isset($_POST['s9fecharep2'])) {
        $s9fecharep2 = $_REQUEST['s9fecharep2'];
    } else {
        $s9fecharep2 = "";
    }
    if ($tiponov9 == "Reprogramacion" || $tiponov9 == "Fueradefecha") {
        $estadoreg9 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg9 = "SIN DEFINIR";
    }
    if ($fechanov9 === null) {
        $QueryUpdate = ("UPDATE $tablam3
                        SET    
                           s9_fecharegistro= '" . $s9fecharegistro . "',
                           s9_horaregistro= '" . $s9horaregistro . "', 
                           s9_tipoactividad= '" . $tipoactividad9 . "',
                           s9_descripcion= '" . $DescripcionActSem9 . "',
                           s9_justifica_nov= '" . $justificasem9 . "',
                           s9_fechanovedad= null,
                           s9_tiponovedad= '" . $tiponov9 . "', 
                           s9_justifica_reprog= '" . $justificarsem9 . "',
                           s9_fechareprog1= '" . $s9fecharep1 . "',
                           s9_fechareprog2= '" . $s9fecharep2 . "',
                           s9_estadoregistro= '" . $estadoreg9 . "'
                       WHERE id='" . $codregistro . "' 
                       ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
                     SET    
                        s9_fecharegistro= '" . $s9fecharegistro . "',
                        s9_horaregistro= '" . $s9horaregistro . "', 
                        s9_tipoactividad= '" . $tipoactividad9 . "',
                        s9_descripcion= '" . $DescripcionActSem9 . "',
                        s9_justifica_nov= '" . $justificasem9 . "',
                        s9_fechanovedad= '" . $fechanov9 . "',
                        s9_tiponovedad= '" . $tiponov9 . "', 
                        s9_justifica_reprog= '" . $justificarsem9 . "',
                        s9_fechareprog1= '" . $s9fecharep1 . "',
                        s9_fechareprog2= '" . $s9fecharep2 . "',
                        s9_estadoregistro= '" . $estadoreg9 . "'
                    WHERE id='" . $codregistro . "' 
                    ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem10'])) {
    //semana 10
    $s10fecharegistro = date("d-m-Y");
    $s10horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad10    = strval($_REQUEST['TipoActividad10']);
    $DescripcionActSem10         = strval($_REQUEST['DescripcionActSem10']);
    $justificasem10         = strval($_REQUEST['justificasem10']);
    if (!empty($_POST['fechanov10'])) {
        $fechanov10       = $_REQUEST['fechanov10'];
    } else {
        $fechanov10 = null;
    }
    $tiponov10 = strval($_REQUEST['TipoNovedad10']);
    if (isset($_POST['justificarsem10'])) {
        $justificarsem10        = strval($_REQUEST['justificarsem10']);
    } else {
        $justificarsem10 = "";
    }
    if (isset($_POST['s10fecharep1'])) {
        $s10fecharep1 = $_REQUEST['s10fecharep1'];
    } else {
        $s10fecharep1 = "";
    }
    if (isset($_POST['s10fecharep2'])) {
        $s10fecharep2 = $_REQUEST['s10fecharep2'];
    } else {
        $s10fecharep2 = "";
    }
    if ($tiponov10 == "Reprogramacion" || $tiponov10 == "Fueradefecha") {
        $estadoreg10 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg10 = "SIN DEFINIR";
    }
    if ($fechanov10 === null) {
        $QueryUpdate = ("UPDATE $tablam3
                            SET    
                               s10_fecharegistro= '" . $s10fecharegistro . "',
                               s10_horaregistro= '" . $s10horaregistro . "', 
                               s10_tipoactividad= '" . $tipoactividad10 . "',
                               s10_descripcion= '" . $DescripcionActSem10 . "',
                               s10_justifica_nov= '" . $justificasem10 . "',
                               s10_fechanovedad= null,
                               s10_tiponovedad= '" . $tiponov10 . "', 
                               s10_justifica_reprog= '" . $justificarsem10 . "',
                               s10_fechareprog1= '" . $s10fecharep1 . "',
                               s10_fechareprog2= '" . $s10fecharep2 . "',
                               s10_estadoregistro= '" . $estadoreg10 . "'
                           WHERE id='" . $codregistro . "' 
                           ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
                         SET    
                            s10_fecharegistro= '" . $s10fecharegistro . "',
                            s10_horaregistro= '" . $s10horaregistro . "', 
                            s10_tipoactividad= '" . $tipoactividad10 . "',
                            s10_descripcion= '" . $DescripcionActSem10 . "',
                            s10_justifica_nov= '" . $justificasem10 . "',
                            s10_fechanovedad= '" . $fechanov10 . "',
                            s10_tiponovedad= '" . $tiponov10 . "', 
                            s10_justifica_reprog= '" . $justificarsem10 . "',
                            s10_fechareprog1= '" . $s10fecharep1 . "',
                            s10_fechareprog2= '" . $s10fecharep2 . "',
                            s10_estadoregistro= '" . $estadoreg10 . "'
                        WHERE id='" . $codregistro . "' 
                        ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem11'])) {
    //semana 11
    $s11fecharegistro = date("d-m-Y");
    $s11horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad11    = strval($_REQUEST['TipoActividad11']);
    $DescripcionActSem11         = strval($_REQUEST['DescripcionActSem11']);
    $justificasem11        = strval($_REQUEST['justificasem11']);
    if (!empty($_POST['fechanov11'])) {
        $fechanov11       = $_REQUEST['fechanov11'];
    } else {
        $fechanov11 = null;
    }
    $tiponov11 = strval($_REQUEST['TipoNovedad11']);
    if (isset($_POST['justificarsem11'])) {
        $justificarsem11        = strval($_REQUEST['justificarsem11']);
    } else {
        $justificarsem11 = "";
    }
    if (isset($_POST['s11fecharep1'])) {
        $s11fecharep1 = $_REQUEST['s11fecharep1'];
    } else {
        $s11fecharep1 = "";
    }
    if (isset($_POST['s11fecharep2'])) {
        $s11fecharep2 = $_REQUEST['s11fecharep2'];
    } else {
        $s11fecharep2 = "";
    }
    if ($tiponov11 == "Reprogramacion" || $tiponov11 == "Fueradefecha") {
        $estadoreg11 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg11 = "SIN DEFINIR";
    }
    if ($fechanov11 === null) {
        $QueryUpdate = ("UPDATE $tablam3
                            SET    
                               s11_fecharegistro= '" . $s11fecharegistro . "',
                               s11_horaregistro= '" . $s11horaregistro . "', 
                               s11_tipoactividad= '" . $tipoactividad11 . "',
                               s11_descripcion= '" . $DescripcionActSem11 . "',
                               s11_justifica_nov= '" . $justificasem11 . "',
                               s11_fechanovedad= null,
                               s11_tiponovedad= '" . $tiponov11 . "', 
                               s11_justifica_reprog= '" . $justificarsem11 . "',
                               s11_fechareprog1= '" . $s11fecharep1 . "',
                               s11_fechareprog2= '" . $s11fecharep2 . "',
                               s11_estadoregistro= '" . $estadoreg11 . "'
                           WHERE id='" . $codregistro . "' 
                           ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
                         SET    
                            s11_fecharegistro= '" . $s11fecharegistro . "',
                            s11_horaregistro= '" . $s11horaregistro . "', 
                            s11_tipoactividad= '" . $tipoactividad11 . "',
                            s11_descripcion= '" . $DescripcionActSem11 . "',
                            s11_justifica_nov= '" . $justificasem11 . "',
                            s11_fechanovedad= '" . $fechanov11 . "',
                            s11_tiponovedad= '" . $tiponov11 . "', 
                            s11_justifica_reprog= '" . $justificarsem11 . "',
                            s11_fechareprog1= '" . $s11fecharep1 . "',
                            s11_fechareprog2= '" . $s11fecharep2 . "',
                            s11_estadoregistro= '" . $estadoreg11 . "'
                        WHERE id='" . $codregistro . "' 
                        ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem12'])) {
    //semana 12
    $s12fecharegistro = date("d-m-Y");
    $s12horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad12    = strval($_REQUEST['TipoActividad12']);
    $DescripcionActSem12         = strval($_REQUEST['DescripcionActSem12']);
    $justificasem12         = strval($_REQUEST['justificasem12']);
    if (!empty($_POST['fechanov12'])) {
        $fechanov12       = $_REQUEST['fechanov12'];
    } else {
        $fechanov12 = null;
    }
    $tiponov12 = strval($_REQUEST['TipoNovedad12']);
    if (isset($_POST['justificarsem12'])) {
        $justificarsem12        = strval($_REQUEST['justificarsem12']);
    } else {
        $justificarsem12 = "";
    }
    if (isset($_POST['s12fecharep1'])) {
        $s12fecharep1 = $_REQUEST['s12fecharep1'];
    } else {
        $s12fecharep1 = "";
    }
    if (isset($_POST['s12fecharep2'])) {
        $s12fecharep2 = $_REQUEST['s12fecharep2'];
    } else {
        $s12fecharep2 = "";
    }
    if ($tiponov12 == "Reprogramacion" || $tiponov12 == "Fueradefecha") {
        $estadoreg12 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg12 = "SIN DEFINIR";
    }
    if ($fechanov12 === null) {
        $QueryUpdate = ("UPDATE $tablam3
        SET    
           s12_fecharegistro= '" . $s12fecharegistro . "',
           s12_horaregistro= '" . $s12horaregistro . "', 
           s12_tipoactividad= '" . $tipoactividad12 . "',
           s12_descripcion= '" . $DescripcionActSem12 . "',
           s12_justifica_nov= '" . $justificasem12 . "',
           s12_fechanovedad= null,
           s12_tiponovedad= '" . $tiponov12 . "', 
           s12_justifica_reprog= '" . $justificarsem12 . "',
           s12_fechareprog1= '" . $s12fecharep1 . "',
           s12_fechareprog2= '" . $s12fecharep2 . "',
           s12_estadoregistro= '" . $estadoreg12 . "'
       WHERE id='" . $codregistro . "' 
       ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
     SET    
        s12_fecharegistro= '" . $s12fecharegistro . "',
        s12_horaregistro= '" . $s12horaregistro . "', 
        s12_tipoactividad= '" . $tipoactividad12 . "',
        s12_descripcion= '" . $DescripcionActSem12 . "',
        s12_justifica_nov= '" . $justificasem12 . "',
        s12_fechanovedad= '" . $fechanov12 . "',
        s12_tiponovedad= '" . $tiponov12 . "', 
        s12_justifica_reprog= '" . $justificarsem12 . "',
        s12_fechareprog1= '" . $s12fecharep1 . "',
        s12_fechareprog2= '" . $s12fecharep2 . "',
        s12_estadoregistro= '" . $estadoreg12 . "'
    WHERE id='" . $codregistro . "' 
    ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem13'])) {
    //semana 13
    $s13fecharegistro = date("d-m-Y");
    $s13horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad13    = strval($_REQUEST['TipoActividad13']);
    $DescripcionActSem13         = strval($_REQUEST['DescripcionActSem13']);
    $justificasem13         = strval($_REQUEST['justificasem13']);
    if (!empty($_POST['fechanov13'])) {
        $fechanov13       = $_REQUEST['fechanov13'];
    } else {
        $fechanov13 = null;
    }
    $tiponov13 = strval($_REQUEST['TipoNovedad13']);
    if (isset($_POST['justificarsem13'])) {
        $justificarsem13        = strval($_REQUEST['justificarsem13']);
    } else {
        $justificarsem13 = "";
    }
    if (isset($_POST['s13fecharep1'])) {
        $s13fecharep1 = $_REQUEST['s13fecharep1'];
    } else {
        $s13fecharep1 = "";
    }
    if (isset($_POST['s13fecharep2'])) {
        $s13fecharep2 = $_REQUEST['s13fecharep2'];
    } else {
        $s13fecharep2 = "";
    }
    if ($tiponov13 == "Reprogramacion" || $tiponov13 == "Fueradefecha") {
        $estadoreg13 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg13 = "SIN DEFINIR";
    }
    if ($fechanov13 === null) {
        $QueryUpdate = ("UPDATE $tablam3
            SET    
               s13_fecharegistro= '" . $s13fecharegistro . "',
               s13_horaregistro= '" . $s13horaregistro . "', 
               s13_tipoactividad= '" . $tipoactividad13 . "',
               s13_descripcion= '" . $DescripcionActSem13 . "',
               s13_justifica_nov= '" . $justificasem13 . "',
               s13_fechanovedad= null,
               s13_tiponovedad= '" . $tiponov13 . "', 
               s13_justifica_reprog= '" . $justificarsem13 . "',
               s13_fechareprog1= '" . $s13fecharep1 . "',
               s13_fechareprog2= '" . $s13fecharep2 . "',
               s13_estadoregistro= '" . $estadoreg13 . "'
           WHERE id='" . $codregistro . "' 
           ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
         SET    
            s13_fecharegistro= '" . $s13fecharegistro . "',
            s13_horaregistro= '" . $s13horaregistro . "', 
            s13_tipoactividad= '" . $tipoactividad13 . "',
            s13_descripcion= '" . $DescripcionActSem13 . "',
            s13_justifica_nov= '" . $justificasem13 . "',
            s13_fechanovedad= '" . $fechanov13 . "',
            s13_tiponovedad= '" . $tiponov13 . "', 
            s13_justifica_reprog= '" . $justificarsem13 . "',
            s13_fechareprog1= '" . $s13fecharep1 . "',
            s13_fechareprog2= '" . $s13fecharep2 . "',
            s13_estadoregistro= '" . $estadoreg13 . "'
        WHERE id='" . $codregistro . "' 
        ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem14'])) {
    //semana 14
    $s14fecharegistro = date("d-m-Y");
    $s14horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad14    = strval($_REQUEST['TipoActividad14']);
    $DescripcionActSem14         = strval($_REQUEST['DescripcionActSem14']);
    $justificasem14         = strval($_REQUEST['justificasem14']);
    if (!empty($_POST['fechanov14'])) {
        $fechanov14       = $_REQUEST['fechanov14'];
    } else {
        $fechanov14 = null;
    }
    $tiponov14 = strval($_REQUEST['TipoNovedad14']);
    if (isset($_POST['justificarsem14'])) {
        $justificarsem14        = strval($_REQUEST['justificarsem14']);
    } else {
        $justificarsem14 = "";
    }
    if (isset($_POST['s14fecharep1'])) {
        $s14fecharep1 = $_REQUEST['s14fecharep1'];
    } else {
        $s14fecharep1 = "";
    }
    if (isset($_POST['s14fecharep2'])) {
        $s14fecharep2 = $_REQUEST['s14fecharep2'];
    } else {
        $s14fecharep2 = "";
    }
    if ($tiponov14 == "Reprogramacion" || $tiponov14 == "Fueradefecha") {
        $estadoreg14 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg14 = "SIN DEFINIR";
    }
    if ($fechanov14 === null) {
        $QueryUpdate = ("UPDATE $tablam3
                SET    
                   s14_fecharegistro= '" . $s14fecharegistro . "',
                   s14_horaregistro= '" . $s14horaregistro . "', 
                   s14_tipoactividad= '" . $tipoactividad14 . "',
                   s14_descripcion= '" . $DescripcionActSem14 . "',
                   s14_justifica_nov= '" . $justificasem14 . "',
                   s14_fechanovedad= null,
                   s14_tiponovedad= '" . $tiponov14 . "', 
                   s14_justifica_reprog= '" . $justificarsem14 . "',
                   s14_fechareprog1= '" . $s14fecharep1 . "',
                   s14_fechareprog2= '" . $s14fecharep2 . "',
                   s14_estadoregistro= '" . $estadoreg14 . "'
               WHERE id='" . $codregistro . "' 
               ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
             SET    
                s14_fecharegistro= '" . $s14fecharegistro . "',
                s14_horaregistro= '" . $s14horaregistro . "', 
                s14_tipoactividad= '" . $tipoactividad14 . "',
                s14_descripcion= '" . $DescripcionActSem14 . "',
                s14_justifica_nov= '" . $justificasem14 . "',
                s14_fechanovedad= '" . $fechanov14 . "',
                s14_tiponovedad= '" . $tiponov14 . "', 
                s14_justifica_reprog= '" . $justificarsem14 . "',
                s14_fechareprog1= '" . $s14fecharep1 . "',
                s14_fechareprog2= '" . $s14fecharep2 . "',
                s14_estadoregistro= '" . $estadoreg14 . "'
            WHERE id='" . $codregistro . "' 
            ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem15'])) {
    //semana 15
    $s15fecharegistro = date("d-m-Y");
    $s15horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad15    = strval($_REQUEST['TipoActividad15']);
    $DescripcionActSem15         = strval($_REQUEST['DescripcionActSem15']);
    $justificasem15         = strval($_REQUEST['justificasem15']);
    if (!empty($_POST['fechanov15'])) {
        $fechanov15       = $_REQUEST['fechanov15'];
    } else {
        $fechanov15 = null;
    }
    $tiponov15 = strval($_REQUEST['TipoNovedad15']);
    if (isset($_POST['justificarsem15'])) {
        $justificarsem15        = strval($_REQUEST['justificarsem15']);
    } else {
        $justificarsem15 = "";
    }
    if (isset($_POST['s15fecharep1'])) {
        $s15fecharep1 = $_REQUEST['s15fecharep1'];
    } else {
        $s15fecharep1 = "";
    }
    if (isset($_POST['s15fecharep2'])) {
        $s15fecharep2 = $_REQUEST['s15fecharep2'];
    } else {
        $s15fecharep2 = "";
    }
    if ($tiponov15 == "Reprogramacion" || $tiponov15 == "Fueradefecha") {
        $estadoreg15 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg15 = "SIN DEFINIR";
    }
    if ($fechanov15 === null) {
        $QueryUpdate = ("UPDATE $tablam3
                    SET    
                       s15_fecharegistro= '" . $s15fecharegistro . "',
                       s15_horaregistro= '" . $s15horaregistro . "', 
                       s15_tipoactividad= '" . $tipoactividad15 . "',
                       s15_descripcion= '" . $DescripcionActSem15 . "',
                       s15_justifica_nov= '" . $justificasem15 . "',
                       s15_fechanovedad= null,
                       s15_tiponovedad= '" . $tiponov15 . "', 
                       s15_justifica_reprog= '" . $justificarsem15 . "',
                       s15_fechareprog1= '" . $s15fecharep1 . "',
                       s15_fechareprog2= '" . $s15fecharep2 . "',
                       s15_estadoregistro= '" . $estadoreg15 . "'
                   WHERE id='" . $codregistro . "' 
                   ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
                 SET    
                    s15_fecharegistro= '" . $s15fecharegistro . "',
                    s15_horaregistro= '" . $s15horaregistro . "', 
                    s15_tipoactividad= '" . $tipoactividad15 . "',
                    s15_descripcion= '" . $DescripcionActSem15 . "',
                    s15_justifica_nov= '" . $justificasem15 . "',
                    s15_fechanovedad= '" . $fechanov15 . "',
                    s15_tiponovedad= '" . $tiponov15 . "', 
                    s15_justifica_reprog= '" . $justificarsem15 . "',
                    s15_fechareprog1= '" . $s15fecharep1 . "',
                    s15_fechareprog2= '" . $s15fecharep2 . "',
                    s15_estadoregistro= '" . $estadoreg15 . "'
                WHERE id='" . $codregistro . "' 
                ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem16'])) {
    //semana 16
    $s16fecharegistro = date("d-m-Y");
    $s16horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad16    = strval($_REQUEST['TipoActividad16']);
    $DescripcionActSem16         = strval($_REQUEST['DescripcionActSem16']);
    $justificasem16         = strval($_REQUEST['justificasem16']);
    if (!empty($_POST['fechanov16'])) {
        $fechanov16       = $_REQUEST['fechanov16'];
    } else {
        $fechanov16 = null;
    }
    $tiponov16 = strval($_REQUEST['TipoNovedad16']);
    if (isset($_POST['justificarsem16'])) {
        $justificarsem16        = strval($_REQUEST['justificarsem16']);
    } else {
        $justificarsem16 = "";
    }
    if (isset($_POST['s16fecharep1'])) {
        $s16fecharep1 = $_REQUEST['s16fecharep1'];
    } else {
        $s16fecharep1 = "";
    }
    if (isset($_POST['s16fecharep2'])) {
        $s16fecharep2 = $_REQUEST['s16fecharep2'];
    } else {
        $s16fecharep2 = "";
    }
    if ($tiponov16 == "Reprogramacion" || $tiponov16 == "Fueradefecha") {
        $estadoreg16 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg16 = "SIN DEFINIR";
    }
    if ($fechanov16 === null) {
        $QueryUpdate = ("UPDATE $tablam3
                        SET    
                           s16_fecharegistro= '" . $s16fecharegistro . "',
                           s16_horaregistro= '" . $s16horaregistro . "', 
                           s16_tipoactividad= '" . $tipoactividad16 . "',
                           s16_descripcion= '" . $DescripcionActSem16 . "',
                           s16_justifica_nov= '" . $justificasem16 . "',
                           s16_fechanovedad= null,
                           s16_tiponovedad= '" . $tiponov16 . "', 
                           s16_justifica_reprog= '" . $justificarsem16 . "',
                           s16_fechareprog1= '" . $s16fecharep1 . "',
                           s16_fechareprog2= '" . $s16fecharep2 . "',
                           s16_estadoregistro= '" . $estadoreg16 . "'
                       WHERE id='" . $codregistro . "' 
                       ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
                     SET    
                        s16_fecharegistro= '" . $s16fecharegistro . "',
                        s16_horaregistro= '" . $s16horaregistro . "', 
                        s16_tipoactividad= '" . $tipoactividad16 . "',
                        s16_descripcion= '" . $DescripcionActSem16 . "',
                        s16_justifica_nov= '" . $justificasem16 . "',
                        s16_fechanovedad= '" . $fechanov16 . "',
                        s16_tiponovedad= '" . $tiponov16 . "', 
                        s16_justifica_reprog= '" . $justificarsem16 . "',
                        s16_fechareprog1= '" . $s16fecharep1 . "',
                        s16_fechareprog2= '" . $s16fecharep2 . "',
                        s16_estadoregistro= '" . $estadoreg16 . "'
                    WHERE id='" . $codregistro . "' 
                    ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem17'])) {
    //semana 17
    $s17fecharegistro = date("d-m-Y");
    $s17horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad17    = strval($_REQUEST['TipoActividad17']);
    $DescripcionActSem17         = strval($_REQUEST['DescripcionActSem17']);
    $justificasem17         = strval($_REQUEST['justificasem17']);
    if (!empty($_POST['fechanov17'])) {
        $fechanov17       = $_REQUEST['fechanov17'];
    } else {
        $fechanov17 = null;
    }
    $tiponov17 = strval($_REQUEST['TipoNovedad17']);
    if (isset($_POST['justificarsem17'])) {
        $justificarsem17        = strval($_REQUEST['justificarsem17']);
    } else {
        $justificarsem17 = "";
    }
    if (isset($_POST['s17fecharep1'])) {
        $s17fecharep1 = $_REQUEST['s17fecharep1'];
    } else {
        $s17fecharep1 = "";
    }
    if (isset($_POST['s17fecharep2'])) {
        $s17fecharep2 = $_REQUEST['s17fecharep2'];
    } else {
        $s17fecharep2 = "";
    }
    if ($tiponov17 == "Reprogramacion" || $tiponov17 == "Fueradefecha") {
        $estadoreg17 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg17 = "SIN DEFINIR";
    }
    if ($fechanov17 === null) {
        $QueryUpdate = ("UPDATE $tablam3
                            SET    
                               s17_fecharegistro= '" . $s17fecharegistro . "',
                               s17_horaregistro= '" . $s17horaregistro . "', 
                               s17_tipoactividad= '" . $tipoactividad17 . "',
                               s17_descripcion= '" . $DescripcionActSem17 . "',
                               s17_justifica_nov= '" . $justificasem17 . "',
                               s17_fechanovedad= null,
                               s17_tiponovedad= '" . $tiponov17 . "', 
                               s17_justifica_reprog= '" . $justificarsem17 . "',
                               s17_fechareprog1= '" . $s17fecharep1 . "',
                               s17_fechareprog2= '" . $s17fecharep2 . "',
                               s17_estadoregistro= '" . $estadoreg17 . "'
                           WHERE id='" . $codregistro . "' 
                           ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
                         SET    
                            s17_fecharegistro= '" . $s17fecharegistro . "',
                            s17_horaregistro= '" . $s17horaregistro . "', 
                            s17_tipoactividad= '" . $tipoactividad17 . "',
                            s17_descripcion= '" . $DescripcionActSem17 . "',
                            s17_justifica_nov= '" . $justificasem17 . "',
                            s17_fechanovedad= '" . $fechanov17 . "',
                            s17_tiponovedad= '" . $tiponov17 . "', 
                            s17_justifica_reprog= '" . $justificarsem17 . "',
                            s17_fechareprog1= '" . $s17fecharep1 . "',
                            s17_fechareprog2= '" . $s17fecharep2 . "',
                            s17_estadoregistro= '" . $estadoreg17 . "'
                        WHERE id='" . $codregistro . "' 
                        ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem18'])) {
    //semana 18
    $s18fecharegistro = date("d-m-Y");
    $s18horaregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad18    = strval($_REQUEST['TipoActividad18']);
    $DescripcionActSem18         = strval($_REQUEST['DescripcionActSem18']);
    $justificasem18         = strval($_REQUEST['justificasem18']);
    if (!empty($_POST['fechanov18'])) {
        $fechanov18       = $_REQUEST['fechanov18'];
    } else {
        $fechanov18 = null;
    }
    $tiponov18 = strval($_REQUEST['TipoNovedad18']);
    if (isset($_POST['justificarsem18'])) {
        $justificarsem18        = strval($_REQUEST['justificarsem18']);
    } else {
        $justificarsem18 = "";
    }
    if (isset($_POST['s18fecharep1'])) {
        $s18fecharep1 = $_REQUEST['s18fecharep1'];
    } else {
        $s18fecharep1 = "";
    }
    if (isset($_POST['s18fecharep2'])) {
        $s18fecharep2 = $_REQUEST['s18fecharep2'];
    } else {
        $s18fecharep2 = "";
    }
    if ($tiponov18 == "Reprogramacion" || $tiponov18 == "Fueradefecha") {
        $estadoreg18 = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg18 = "SIN DEFINIR";
    }
    if ($fechanov18 === null) {
        $QueryUpdate = ("UPDATE $tablam3
                                SET    
                                   s18_fecharegistro= '" . $s18fecharegistro . "',
                                   s18_horaregistro= '" . $s18horaregistro . "', 
                                   s18_tipoactividad= '" . $tipoactividad18 . "',
                                   s18_descripcion= '" . $DescripcionActSem18 . "',
                                   s18_justifica_nov= '" . $justificasem18 . "',
                                   s18_fechanovedad= null,
                                   s18_tiponovedad= '" . $tiponov18 . "', 
                                   s18_justifica_reprog= '" . $justificarsem18 . "',
                                   s18_fechareprog1= '" . $s18fecharep1 . "',
                                   s18_fechareprog2= '" . $s18fecharep2 . "',
                                   s18_estadoregistro= '" . $estadoreg18 . "'
                               WHERE id='" . $codregistro . "' 
                               ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
                             SET    
                                s18_fecharegistro= '" . $s18fecharegistro . "',
                                s18_horaregistro= '" . $s18horaregistro . "', 
                                s18_tipoactividad= '" . $tipoactividad18 . "',
                                s18_descripcion= '" . $DescripcionActSem18 . "',
                                s18_justifica_nov= '" . $justificasem18 . "',
                                s18_fechanovedad= '" . $fechanov18 . "',
                                s18_tiponovedad= '" . $tiponov18 . "', 
                                s18_justifica_reprog= '" . $justificarsem18 . "',
                                s18_fechareprog1= '" . $s18fecharep1 . "',
                                s18_fechareprog2= '" . $s18fecharep2 . "',
                                s18_estadoregistro= '" . $estadoreg18 . "'
                            WHERE id='" . $codregistro . "' 
                            ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//**********
if (isset($_POST['titulosem1p'])) {
    //semana1 postgrado
    $s1pfecharegistro = date("d-m-Y");
    $s1phoraregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad1p    = strval($_REQUEST['TipoActividad1p']);
    $DescripcionActSem1p         = strval($_REQUEST['DescripcionActSem1p']);
    $justificasem1p         = strval($_REQUEST['justificasem1p']);
    if (!empty($_POST['fechanov1p'])) {
        $fechanov1p       = $_REQUEST['fechanov1p'];
    } else {
        $fechanov1p = null;
    }
    $tiponov1p = strval($_REQUEST['TipoNovedad1p']);
    if (isset($_POST['justificarsem1p'])) {
        $justificarsem1p        = strval($_REQUEST['justificarsem1p']);
    } else {
        $justificarsem1p = "";
    }
    if (isset($_POST['s1pfecharep1'])) {
        $s1pfecharep1 = $_REQUEST['s1pfecharep1'];
    } else {
        $s1pfecharep1 = "";
    }
    if (isset($_POST['s1pfecharep2'])) {
        $s1pfecharep2 = $_REQUEST['s1pfecharep2'];
    } else {
        $s1pfecharep2 = "";
    }
    if ($tiponov1p == "Reprogramacion" || $tiponov1p == "Fueradefecha") {
        $estadoreg1p = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg1p = "SIN DEFINIR";
    }
    if ($fechanov1p === null) {
        $QueryUpdate = ("UPDATE $tablam3
        SET    
           s1_fecharegistro_p= '" . $s1pfecharegistro . "',
           s1_horaregistro_p= '" . $s1phoraregistro . "', 
           s1_tipoactividad_p= '" . $tipoactividad1p . "',
           s1_descripcion_p= '" . $DescripcionActSem1p . "',
           s1_justifica_nov_p= '" . $justificasem1p . "',
           s1_fechanovedad_p= null,
           s1_tiponovedad_p= '" . $tiponov1p . "', 
           s1_justifica_reprog_p= '" . $justificarsem1p . "',
           s1_fechareprog1_p= '" . $s1pfecharep1 . "',
           s1_fechareprog2_p= '" . $s1pfecharep2 . "',
           s1_estadoregistro_p= '" . $estadoreg1p . "'
       WHERE id='" . $codregistro . "' 
       ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
     SET    
        s1_fecharegistro_p= '" . $s1pfecharegistro . "',
        s1_horaregistro_p= '" . $s1phoraregistro . "', 
        s1_tipoactividad_p= '" . $tipoactividad1p . "',
        s1_descripcion_p= '" . $DescripcionActSem1p . "',
        s1_justifica_nov_p= '" . $justificasem1p . "',
        s1_fechanovedad_p= '" . $fechanov1p . "',
        s1_tiponovedad_p= '" . $tiponov1p . "', 
        s1_justifica_reprog_p= '" . $justificarsem1p . "',
        s1_fechareprog1_p= '" . $s1pfecharep1 . "',
        s1_fechareprog2_p= '" . $s1pfecharep2 . "',
        s1_estadoregistro_p= '" . $estadoreg1p . "'
    WHERE id='" . $codregistro . "' 
    ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem2p'])) {
    //semana2 postgrado
    $s2pfecharegistro = date("d-m-Y");
    $s2phoraregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad2p    = strval($_REQUEST['TipoActividad2p']);
    $DescripcionActSem2p         = strval($_REQUEST['DescripcionActSem2p']);
    $justificasem2p         = strval($_REQUEST['justificasem2p']);
    if (!empty($_POST['fechanov2p'])) {
        $fechanov2p       = $_REQUEST['fechanov2p'];
    } else {
        $fechanov2p = null;
    }
    $tiponov2p = strval($_REQUEST['TipoNovedad2p']);
    if (isset($_POST['justificarsem2p'])) {
        $justificarsem2p        = strval($_REQUEST['justificarsem2p']);
    } else {
        $justificarsem2p = "";
    }
    if (isset($_POST['s2pfecharep1'])) {
        $s2pfecharep1 = $_REQUEST['s2pfecharep1'];
    } else {
        $s2pfecharep1 = "";
    }
    if (isset($_POST['s2pfecharep2'])) {
        $s2pfecharep2 = $_REQUEST['s2pfecharep2'];
    } else {
        $s2pfecharep2 = "";
    }
    if ($tiponov2p == "Reprogramacion" || $tiponov2p == "Fueradefecha") {
        $estadoreg2p = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg2p = "SIN DEFINIR";
    }
    if ($fechanov2p === null) {
        $QueryUpdate = ("UPDATE $tablam3
            SET    
               s2_fecharegistro_p= '" . $s2pfecharegistro . "',
               s2_horaregistro_p= '" . $s2phoraregistro . "', 
               s2_tipoactividad_p= '" . $tipoactividad2p . "',
               s2_descripcion_p= '" . $DescripcionActSem2p . "',
               s2_justifica_nov_p= '" . $justificasem2p . "',
               s2_fechanovedad_p= null,
               s2_tiponovedad_p= '" . $tiponov2p . "', 
               s2_justifica_reprog_p= '" . $justificarsem2p . "',
               s2_fechareprog1_p= '" . $s2pfecharep1 . "',
               s2_fechareprog2_p= '" . $s2pfecharep2 . "',
               s2_estadoregistro_p= '" . $estadoreg2p . "'
           WHERE id='" . $codregistro . "' 
           ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
         SET    
            s2_fecharegistro_p= '" . $s2pfecharegistro . "',
            s2_horaregistro_p= '" . $s2phoraregistro . "', 
            s2_tipoactividad_p= '" . $tipoactividad2p . "',
            s2_descripcion_p= '" . $DescripcionActSem2p . "',
            s2_justifica_nov_p= '" . $justificasem2p . "',
            s2_fechanovedad_p= '" . $fechanov2p . "',
            s2_tiponovedad_p= '" . $tiponov2p . "', 
            s2_justifica_reprog_p= '" . $justificarsem2p . "',
            s2_fechareprog1_p= '" . $s2pfecharep1 . "',
            s2_fechareprog2_p= '" . $s2pfecharep2 . "',
            s2_estadoregistro_p= '" . $estadoreg2p . "'
        WHERE id='" . $codregistro . "' 
        ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem3p'])) {
    //semana3 postgrado
    $s3pfecharegistro = date("d-m-Y");
    $s3phoraregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad3p    = strval($_REQUEST['TipoActividad3p']);
    $DescripcionActSem3p         = strval($_REQUEST['DescripcionActSem3p']);
    $justificasem3p         = strval($_REQUEST['justificasem3p']);
    if (!empty($_POST['fechanov3p'])) {
        $fechanov3p       = $_REQUEST['fechanov3p'];
    } else {
        $fechanov3p = null;
    }
    $tiponov3p = strval($_REQUEST['TipoNovedad3p']);
    if (isset($_POST['justificarsem3p'])) {
        $justificarsem3p        = strval($_REQUEST['justificarsem3p']);
    } else {
        $justificarsem3p = "";
    }
    if (isset($_POST['s3pfecharep1'])) {
        $s3pfecharep1 = $_REQUEST['s3pfecharep1'];
    } else {
        $s3pfecharep1 = "";
    }
    if (isset($_POST['s3pfecharep2'])) {
        $s3pfecharep2 = $_REQUEST['s3pfecharep2'];
    } else {
        $s3pfecharep2 = "";
    }
    if ($tiponov3p == "Reprogramacion" || $tiponov3p == "Fueradefecha") {
        $estadoreg3p = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg3p = "SIN DEFINIR";
    }
    if ($fechanov3p === null) {
        $QueryUpdate = ("UPDATE $tablam3
                SET    
                   s3_fecharegistro_p= '" . $s3pfecharegistro . "',
                   s3_horaregistro_p= '" . $s3phoraregistro . "', 
                   s3_tipoactividad_p= '" . $tipoactividad3p . "',
                   s3_descripcion_p= '" . $DescripcionActSem3p . "',
                   s3_justifica_nov_p= '" . $justificasem3p . "',
                   s3_fechanovedad_p= null,
                   s3_tiponovedad_p= '" . $tiponov3p . "', 
                   s3_justifica_reprog_p= '" . $justificarsem3p . "',
                   s3_fechareprog1_p= '" . $s3pfecharep1 . "',
                   s3_fechareprog2_p= '" . $s3pfecharep2 . "',
                   s3_estadoregistro_p= '" . $estadoreg3p . "'
               WHERE id='" . $codregistro . "' 
               ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
             SET    
                s3_fecharegistro_p= '" . $s3pfecharegistro . "',
                s3_horaregistro_p= '" . $s3phoraregistro . "', 
                s3_tipoactividad_p= '" . $tipoactividad3p . "',
                s3_descripcion_p= '" . $DescripcionActSem3p . "',
                s3_justifica_nov_p= '" . $justificasem3p . "',
                s3_fechanovedad_p= '" . $fechanov3p . "',
                s3_tiponovedad_p= '" . $tiponov3p . "', 
                s3_justifica_reprog_p= '" . $justificarsem3p . "',
                s3_fechareprog1_p= '" . $s3pfecharep1 . "',
                s3_fechareprog2_p= '" . $s3pfecharep2 . "',
                s3_estadoregistro_p= '" . $estadoreg3p . "'
            WHERE id='" . $codregistro . "' 
            ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem4p'])) {
    //semana4 postgrado
    $s4pfecharegistro = date("d-m-Y");
    $s4phoraregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad4p    = strval($_REQUEST['TipoActividad4p']);
    $DescripcionActSem4p         = strval($_REQUEST['DescripcionActSem4p']);
    $justificasem4p         = strval($_REQUEST['justificasem4p']);
    if (!empty($_POST['fechanov4p'])) {
        $fechanov4p       = $_REQUEST['fechanov4p'];
    } else {
        $fechanov4p = null;
    }
    $tiponov4p = strval($_REQUEST['TipoNovedad4p']);
    if (isset($_POST['justificarsem4p'])) {
        $justificarsem4p        = strval($_REQUEST['justificarsem4p']);
    } else {
        $justificarsem4p = "";
    }
    if (isset($_POST['s4pfecharep1'])) {
        $s4pfecharep1 = $_REQUEST['s4pfecharep1'];
    } else {
        $s4pfecharep1 = "";
    }
    if (isset($_POST['s4pfecharep2'])) {
        $s4pfecharep2 = $_REQUEST['s4pfecharep2'];
    } else {
        $s4pfecharep2 = "";
    }
    if ($tiponov4p == "Reprogramacion" || $tiponov4p == "Fueradefecha") {
        $estadoreg4p = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg4p = "SIN DEFINIR";
    }
    if ($fechanov4p === null) {
        $QueryUpdate = ("UPDATE $tablam3
        SET    
           s4_fecharegistro_p= '" . $s4pfecharegistro . "',
           s4_horaregistro_p= '" . $s4phoraregistro . "', 
           s4_tipoactividad_p= '" . $tipoactividad4p . "',
           s4_descripcion_p= '" . $DescripcionActSem4p . "',
           s4_justifica_nov_p= '" . $justificasem4p . "',
           s4_fechanovedad_p= null,
           s4_tiponovedad_p= '" . $tiponov4p . "', 
           s4_justifica_reprog_p= '" . $justificarsem4p . "',
           s4_fechareprog1_p= '" . $s4pfecharep1 . "',
           s4_fechareprog2_p= '" . $s4pfecharep2 . "',
           s4_estadoregistro_p= '" . $estadoreg4p . "'
       WHERE id='" . $codregistro . "' 
       ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
     SET    
        s4_fecharegistro_p= '" . $s4pfecharegistro . "',
        s4_horaregistro_p= '" . $s4phoraregistro . "', 
        s4_tipoactividad_p= '" . $tipoactividad4p . "',
        s4_descripcion_p= '" . $DescripcionActSem4p . "',
        s4_justifica_nov_p= '" . $justificasem4p . "',
        s4_fechanovedad_p= '" . $fechanov4p . "',
        s4_tiponovedad_p= '" . $tiponov4p . "', 
        s4_justifica_reprog_p= '" . $justificarsem4p . "',
        s4_fechareprog1_p= '" . $s4pfecharep1 . "',
        s4_fechareprog2_p= '" . $s4pfecharep2 . "',
        s4_estadoregistro_p= '" . $estadoreg4p . "'
    WHERE id='" . $codregistro . "' 
    ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if (isset($_POST['titulosem5p'])) {
    //semana5 postgrado
    $s5pfecharegistro = date("d-m-Y");
    $s5phoraregistro  = date('H:i:s');
    //Otros campos
    $tipoactividad5p    = strval($_REQUEST['TipoActividad5p']);
    $DescripcionActSem5p         = strval($_REQUEST['DescripcionActSem5p']);
    $justificasem5p         = strval($_REQUEST['justificasem5p']);
    if (!empty($_POST['fechanov5p'])) {
        $fechanov5p       = $_REQUEST['fechanov5p'];
    } else {
        $fechanov5p = null;
    }
    $tiponov5p = strval($_REQUEST['TipoNovedad5p']);
    if (isset($_POST['justificarsem5p'])) {
        $justificarsem5p        = strval($_REQUEST['justificarsem5p']);
    } else {
        $justificarsem5p = "";
    }
    if (isset($_POST['s5pfecharep1'])) {
        $s5pfecharep1 = $_REQUEST['s5pfecharep1'];
    } else {
        $s5pfecharep1 = "";
    }
    if (isset($_POST['s5pfecharep2'])) {
        $s5pfecharep2 = $_REQUEST['s5pfecharep2'];
    } else {
        $s5pfecharep2 = "";
    }
    if ($tiponov5p == "Reprogramacion" || $tiponov5p == "Fueradefecha") {
        $estadoreg5p = "REGISTRO CON NOVEDAD";
    } else {
        $estadoreg5p = "SIN DEFINIR";
    }
    if ($fechanov5p === null) {
        $QueryUpdate = ("UPDATE $tablam3
            SET    
               s5_fecharegistro_p= '" . $s5pfecharegistro . "',
               s5_horaregistro_p= '" . $s5phoraregistro . "', 
               s5_tipoactividad_p= '" . $tipoactividad5p . "',
               s5_descripcion_p= '" . $DescripcionActSem5p . "',
               s5_justifica_nov_p= '" . $justificasem5p . "',
               s5_fechanovedad_p= null,
               s5_tiponovedad_p= '" . $tiponov5p . "', 
               s5_justifica_reprog_p= '" . $justificarsem5p . "',
               s5_fechareprog1_p= '" . $s5pfecharep1 . "',
               s5_fechareprog2_p= '" . $s5pfecharep2 . "',
               s5_estadoregistro_p= '" . $estadoreg5p . "'
           WHERE id='" . $codregistro . "' 
           ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else {
        $QueryUpdate = ("UPDATE $tablam3
         SET    
            s5_fecharegistro_p= '" . $s5pfecharegistro . "',
            s5_horaregistro_p= '" . $s5phoraregistro . "', 
            s5_tipoactividad_p= '" . $tipoactividad5p . "',
            s5_descripcion_p= '" . $DescripcionActSem5p . "',
            s5_justifica_nov_p= '" . $justificasem5p . "',
            s5_fechanovedad_p= '" . $fechanov5p . "',
            s5_tiponovedad_p= '" . $tiponov5p . "', 
            s5_justifica_reprog_p= '" . $justificarsem5p . "',
            s5_fechareprog1_p= '" . $s5pfecharep1 . "',
            s5_fechareprog2_p= '" . $s5pfecharep2 . "',
            s5_estadoregistro_p= '" . $estadoreg5p . "'
        WHERE id='" . $codregistro . "' 
        ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    }
}
//
if ($updateRegistro) {
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
} else {

    echo '<script>
    Swal.fire({
     icon: "error",
     title: "Oops...",
     text: "¡Ocurrio un error, el registro no se pudo actualizar!",
     showConfirmButton: true,
     confirmButtonText: "Cerrar"
     }).then(function(result){
        if(result.value){                   
         window.location = "Registro.php";
        }
     });
    </script>';
}
