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
if (isset($_POST['titulosem1'])) {
//semana 1
$s1fecharegistro =date("d-m-Y");
$s1horaregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad1'])) {
    $tipoactividad1    = strval($_REQUEST['TipoActividad1']);
} else {
    $tipoactividad1 = "";
}
if (isset($_POST['DescripcionActSem1'])) {
    $DescripcionActSem1         = strval($_REQUEST['DescripcionActSem1']);
} else {
    $DescripcionActSem1     = "";
}
if (isset($_POST['justificasem1'])) {
    $justificasem1         = strval($_REQUEST['justificasem1']);
} else {
    $justificasem1 = "";
}
if (isset($_POST['fechanov1'])) {
    $fechanov1       = $_REQUEST['fechanov1'];
} else {
    $fechanov1 = '';
}
if (isset($_POST['TipoNovedad1'])) {
    $tiponov1= strval($_REQUEST['TipoNovedad1']);
} else {
    $tiponov1 = "";
}
if (isset($_POST['fecharepinicio1'])) {
    $fecharepi1= $_REQUEST['fecharepinicio1'];
} else {
    $fecharepi1 = "";
}
if (isset($_POST['fecharepfinal1'])) {
    $fecharepf1= $_REQUEST['fecharepfinal1'];
} else {
    $fecharepf1 = "";
}
if($tipoactividad1 =="Regular"){
  $estadoreg1="REGISTRO VALIDO";
}else if ($tipoactividad1 =="Novedad"){
    $estadoreg1="REGISTRO CON MOVEDAD";
}else if ($tipoactividad1 ==""){
    $estadoreg1="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET    
    s1_fecharegistro= '" . $s1fecharegistro . "',
	s1_horaregistro= '" . $s1horaregistro . "', 
    s1_tipoactividad= '" . $tipoactividad1 . "',
    s1_descripcion= '" . $DescripcionActSem1 . "',
    s1_justifica_nov= '" . $justificasem1 . "',
    s1_fechanovedad= '" . $fechanov1 . "',
    s1_tiponovedad= '" . $tiponov1 . "', 
    s1_fechareproginicial= '" . $fecharepi1 . "',
    s1_fechareprogfinal= '" . $fecharepf1 . "',
    s1_estadoregistro= '" . $estadoreg1 . "'
WHERE id='" .$codregistro. "' 
");
    
$updateRegistro = pg_query($conexion, $QueryUpdate);    
}

if (isset($_POST['titulosem2'])) {
//semana 2
$s2fecharegistro =date("d-m-Y");
$s2horaregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad2'])) {
    $tipoactividad2    = strval($_REQUEST['TipoActividad2']);
} else {
    $tipoactividad2 = "";
}
if (isset($_POST['DescripcionActSem2'])) {
    $DescripcionActSem2         = strval($_REQUEST['DescripcionActSem2']);
} else {
    $DescripcionActSem2     = "";
}
if (isset($_POST['justificasem2'])) {
    $justificasem2         = strval($_REQUEST['justificasem2']);
} else {
    $justificasem2 = "";
}
if (isset($_POST['fechanov2'])) {
    $fechanov2       = $_REQUEST['fechanov2'];
} else {
    $fechanov2 = "";
}
if (isset($_POST['TipoNovedad2'])) {
    $tiponov2= strval($_REQUEST['TipoNovedad2']);
} else {
    $tiponov2 = "";
}
if (isset($_POST['fecharepinicio2'])) {
    $fecharepi2= $_REQUEST['fecharepinicio2'];
} else {
    $fecharepi2 = "";
}
if (isset($_POST['fecharepfinal2'])) {
    $fecharepf2= $_REQUEST['fecharepfinal2'];
} else {
    $fecharepf2 = "";
}
if($tipoactividad2 =="Regular"){
  $estadoreg2="REGISTRO VALIDO";
}else if ($tipoactividad2 =="Novedad"){
    $estadoreg2="REGISTRO CON MOVEDAD";
}else if ($tipoactividad2 ==""){
    $estadoreg2="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET    
    s2_fecharegistro= '" . $s2fecharegistro . "',
	s2_horaregistro= '" . $s2horaregistro . "', 
    s2_tipoactividad= '" . $tipoactividad2 . "',
    s2_descripcion= '" . $DescripcionActSem2 . "',
    s2_justifica_nov= '" . $justificasem2 . "',
    s2_fechanovedad= '" . $fechanov2 . "',
    s2_tiponovedad= '" . $tiponov2 . "', 
    s2_fechareproginicial= '" . $fecharepi2 . "',
    s2_fechareprogfinal= '" . $fecharepf2 . "',
    s2_estadoregistro= '" . $estadoreg2 . "'
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);    
}
//
if (isset($_POST['titulosem3'])) {
//semana 3
$s3fecharegistro =date("d-m-Y");
$s3horaregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad3'])) {
    $tipoactividad3    = strval($_REQUEST['TipoActividad3']);
} else {
    $tipoactividad3 = "";
}
if (isset($_POST['DescripcionActSem3'])) {
    $DescripcionActSem3         = strval($_REQUEST['DescripcionActSem3']);
} else {
    $DescripcionActSem3     = "";
}
if (isset($_POST['justificasem3'])) {
    $justificasem3         = strval($_REQUEST['justificasem3']);
} else {
    $justificasem3 = "";
}
if (isset($_POST['fechanov3'])) {
    $fechanov3       = $_REQUEST['fechanov3'];
} else {
    $fechanov3 = "";
}
if (isset($_POST['TipoNovedad3'])) {
    $tiponov3= strval($_REQUEST['TipoNovedad3']);
} else {
    $tiponov3 = "";
}
if (isset($_POST['fecharepinicio3'])) {
    $fecharepi3= strval($_REQUEST['fecharepinicio3']);
} else {
    $fecharepi3 = "";
}
if (isset($_POST['fecharepfinal3'])) {
    $fecharepf3= $_REQUEST['fecharepfinal3'];
} else {
    $fecharepf3 = "";
}
if($tipoactividad3 =="Regular"){
  $estadoreg3="REGISTRO VALIDO";
}else if ($tipoactividad3 =="Novedad"){
    $estadoreg3="REGISTRO CON MOVEDAD";
}else if ($tipoactividad3 ==""){
    $estadoreg3="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET    
    s3_fecharegistro= '" . $s3fecharegistro . "',
	s3_horaregistro= '" . $s3horaregistro . "', 
    s3_tipoactividad= '" . $tipoactividad3 . "',
    s3_descripcion= '" . $DescripcionActSem3 . "',
    s3_justifica_nov= '" . $justificasem3 . "',
    s3_fechanovedad= '" . $fechanov3 . "',
    s3_tiponovedad= '" . $tiponov3 . "', 
    s3_fechareproginicial= '" . $fecharepi3 . "',
    s3_fechareprogfinal= '" . $fecharepf3 . "',
    s3_estadoregistro= '" . $estadoreg3 . "'
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);    
}
if (isset($_POST['titulosem4'])) {
//semana 4
$s4fecharegistro =date("d-m-Y");
$s4horaregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad4'])) {
    $tipoactividad4    = strval($_REQUEST['TipoActividad4']);
} else {
    $tipoactividad4 = "";
}
if (isset($_POST['DescripcionActSem4'])) {
    $DescripcionActSem4         = strval($_REQUEST['DescripcionActSem4']);
} else {
    $DescripcionActSem4     = "";
}
if (isset($_POST['justificasem4'])) {
    $justificasem4         = strval($_REQUEST['justificasem4']);
} else {
    $justificasem4 = "";
}
if (isset($_POST['fechanov4'])) {
    $fechanov4       = $_REQUEST['fechanov4'];
} else {
    $fechanov4 = "";
}
if (isset($_POST['TipoNovedad4'])) {
    $tiponov4= strval($_REQUEST['TipoNovedad4']);
} else {
    $tiponov4 = "";
}
if (isset($_POST['fecharepinicio4'])) {
    $fecharepi4= strval($_REQUEST['fecharepinicio4']);
} else {
    $fecharepi4 = "";
}
if (isset($_POST['fecharepfinal4'])) {
    $fecharepf4= $_REQUEST['fecharepfinal4'];
} else {
    $fecharepf4 = "";
}
if($tipoactividad4 =="Regular"){
  $estadoreg4="REGISTRO VALIDO";
}else if ($tipoactividad4 =="Novedad"){
    $estadoreg4="REGISTRO CON MOVEDAD";
}else if ($tipoactividad4 ==""){
    $estadoreg4="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET    
    s4_fecharegistro= '" . $s4fecharegistro . "',
	s4_horaregistro= '" . $s4horaregistro . "', 
    s4_tipoactividad= '" . $tipoactividad4 . "',
    s4_descripcion= '" . $DescripcionActSem4 . "',
    s4_justifica_nov= '" . $justificasem4 . "',
    s4_fechanovedad= '" . $fechanov4 . "',
    s4_tiponovedad= '" . $tiponov4 . "', 
    s4_fechareproginicial= '" . $fecharepi4 . "',
    s4_fechareprogfinal= '" . $fecharepf4 . "',
    s4_estadoregistro= '" . $estadoreg4 . "'
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);    
}

if (isset($_POST['titulosem5'])) {
//semana 5
$s5fecharegistro =date("d-m-Y");
$s5horaregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad5'])) {
    $tipoactividad5    = strval($_REQUEST['TipoActividad5']);
} else {
    $tipoactividad5 = "";
}
if (isset($_POST['DescripcionActSem5'])) {
    $DescripcionActSem5         = strval($_REQUEST['DescripcionActSem5']);
} else {
    $DescripcionActSem5     = "";
}
if (isset($_POST['justificasem5'])) {
    $justificasem5         = strval($_REQUEST['justificasem5']);
} else {
    $justificasem5 = "";
}
if (isset($_POST['fechanov5'])) {
    $fechanov5       = $_REQUEST['fechanov5'];
} else {
    $fechanov5 = "";
}
if (isset($_POST['TipoNovedad5'])) {
    $tiponov5= strval($_REQUEST['TipoNovedad5']);
} else {
    $tiponov5 = "";
}
if (isset($_POST['fecharepinicio5'])) {
    $fecharepi5= strval($_REQUEST['fecharepinicio5']);
} else {
    $fecharepi5 = "";
}
if (isset($_POST['fecharepfinal5'])) {
    $fecharepf5= $_REQUEST['fecharepfinal5'];
} else {
    $fecharepf5 = "";
}
if($tipoactividad5 =="Regular"){
  $estadoreg5="REGISTRO VALIDO";
}else if ($tipoactividad5 =="Novedad"){
    $estadoreg5="REGISTRO CON MOVEDAD";
}else if ($tipoactividad5 ==""){
    $estadoreg5="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET    
    s5_fecharegistro= '" . $s5fecharegistro . "',
	s5_horaregistro= '" . $s5horaregistro . "', 
    s5_tipoactividad= '" . $tipoactividad5 . "',
    s5_descripcion= '" . $DescripcionActSem5 . "',
    s5_justifica_nov= '" . $justificasem5 . "',
    s5_fechanovedad= '" . $fechanov5 . "',
    s5_tiponovedad= '" . $tiponov5 . "', 
    s5_fechareproginicial= '" . $fecharepi5 . "',
    s5_fechareprogfinal= '" . $fecharepf5 . "',
    s5_estadoregistro= '" . $estadoreg5 . "'
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);    
}
if (isset($_POST['titulosem6'])) {
//semana 6
$s6fecharegistro =date("d-m-Y");
$s6horaregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad6'])) {
    $tipoactividad6    = strval($_REQUEST['TipoActividad6']);
} else {
    $tipoactividad6 = "";
}
if (isset($_POST['DescripcionActSem6'])) {
    $DescripcionActSem6         = strval($_REQUEST['DescripcionActSem6']);
} else {
    $DescripcionActSem6     = "";
}
if (isset($_POST['justificasem6'])) {
    $justificasem6         = strval($_REQUEST['justificasem6']);
} else {
    $justificasem6 = "";
}
if (isset($_POST['fechanov6'])) {
    $fechanov6       = $_REQUEST['fechanov6'];
} else {
    $fechanov6 = "";
}
if (isset($_POST['TipoNovedad6'])) {
    $tiponov6= strval($_REQUEST['TipoNovedad6']);
} else {
    $tiponov6 = "";
}
if (isset($_POST['fecharepinicio6'])) {
    $fecharepi6= strval($_REQUEST['fecharepinicio6']);
} else {
    $fecharepi6 = "";
}
if (isset($_POST['fecharepfinal6'])) {
    $fecharepf6= $_REQUEST['fecharepfinal6'];
} else {
    $fecharepf6 = "";
}
if($tipoactividad6 =="Regular"){
  $estadoreg6="REGISTRO VALIDO";
}else if ($tipoactividad6 =="Novedad"){
    $estadoreg6="REGISTRO CON MOVEDAD";
}else if ($tipoactividad6 ==""){
    $estadoreg6="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET    
    s6_fecharegistro= '" . $s6fecharegistro . "',
	s6_horaregistro= '" . $s6horaregistro . "', 
    s6_tipoactividad= '" . $tipoactividad6 . "',
    s6_descripcion= '" . $DescripcionActSem6 . "',
    s6_justifica_nov= '" . $justificasem6 . "',
    s6_fechanovedad= '" . $fechanov6 . "',
    s6_tiponovedad= '" . $tiponov6 . "', 
    s6_fechareproginicial= '" . $fecharepi6 . "',
    s6_fechareprogfinal= '" . $fecharepf6 . "',
    s6_estadoregistro= '" . $estadoreg6 . "'
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);    
}
if (isset($_POST['titulosem7'])) {
//semana 7
$s7fecharegistro =date("d-m-Y");
$s7horaregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad7'])) {
    $tipoactividad7    = strval($_REQUEST['TipoActividad7']);
} else {
    $tipoactividad7 = "";
}
if (isset($_POST['DescripcionActSem7'])) {
    $DescripcionActSem7         = strval($_REQUEST['DescripcionActSem7']);
} else {
    $DescripcionActSem7     = "";
}
if (isset($_POST['justificasem7'])) {
    $justificasem7         = strval($_REQUEST['justificasem7']);
} else {
    $justificasem7 = "";
}
if (isset($_POST['fechanov7'])) {
    $fechanov7       = $_REQUEST['fechanov7'];
} else {
    $fechanov7 = "";
}
if (isset($_POST['TipoNovedad7'])) {
    $tiponov7= strval($_REQUEST['TipoNovedad7']);
} else {
    $tiponov7 = "";
}
if (isset($_POST['fecharepinicio7'])) {
    $fecharepi7= strval($_REQUEST['fecharepinicio7']);
} else {
    $fecharepi7 = "";
}
if (isset($_POST['fecharepfinal7'])) {
    $fecharepf7= $_REQUEST['fecharepfinal7'];
} else {
    $fecharepf7 = "";
}
if($tipoactividad7 =="Regular"){
  $estadoreg7="REGISTRO VALIDO";
}else if ($tipoactividad7 =="Novedad"){
    $estadoreg7="REGISTRO CON MOVEDAD";
}else if ($tipoactividad7 ==""){
    $estadoreg7="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET    
    s7_fecharegistro= '" . $s7fecharegistro . "',
	s7_horaregistro= '" . $s7horaregistro . "', 
    s7_tipoactividad= '" . $tipoactividad7 . "',
    s7_descripcion= '" . $DescripcionActSem7 . "',
    s7_justifica_nov= '" . $justificasem7 . "',
    s7_fechanovedad= '" . $fechanov7 . "',
    s7_tiponovedad= '" . $tiponov7 . "', 
    s7_fechareproginicial= '" . $fecharepi7 . "',
    s7_fechareprogfinal= '" . $fecharepf7 . "',
    s7_estadoregistro= '" . $estadoreg7 . "'
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);    
}
if (isset($_POST['titulosem8'])) {
//semana 8
$s8fecharegistro =date("d-m-Y");
$s8horaregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad8'])) {
    $tipoactividad8    = strval($_REQUEST['TipoActividad8']);
} else {
    $tipoactividad8 = "";
}
if (isset($_POST['DescripcionActSem8'])) {
    $DescripcionActSem8         = strval($_REQUEST['DescripcionActSem8']);
} else {
    $DescripcionActSem8     = "";
}
if (isset($_POST['justificasem8'])) {
    $justificasem8         = strval($_REQUEST['justificasem8']);
} else {
    $justificasem8 = "";
}
if (isset($_POST['fechanov8'])) {
    $fechanov8       = $_REQUEST['fechanov8'];
} else {
    $fechanov8 = "";
}
if (isset($_POST['TipoNovedad8'])) {
    $tiponov8= strval($_REQUEST['TipoNovedad8']);
} else {
    $tiponov8 = "";
}
if (isset($_POST['fecharepinicio8'])) {
    $fecharepi8= strval($_REQUEST['fecharepinicio8']);
} else {
    $fecharepi8 = "";
}
if (isset($_POST['fecharepfinal8'])) {
    $fecharepf8= $_REQUEST['fecharepfinal8'];
} else {
    $fecharepf8 = "";
}
if($tipoactividad8 =="Regular"){
  $estadoreg8="REGISTRO VALIDO";
}else if ($tipoactividad8 =="Novedad"){
    $estadoreg8="REGISTRO CON MOVEDAD";
}else if ($tipoactividad8 ==""){
    $estadoreg8="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET    
    s8_fecharegistro= '" . $s8fecharegistro . "',
	s8_horaregistro= '" . $s8horaregistro . "', 
    s8_tipoactividad= '" . $tipoactividad8 . "',
    s8_descripcion= '" . $DescripcionActSem8 . "',
    s8_justifica_nov= '" . $justificasem8 . "',
    s8_fechanovedad= '" . $fechanov8 . "',
    s8_tiponovedad= '" . $tiponov8 . "', 
    s8_fechareproginicial= '" . $fecharepi8 . "',
    s8_fechareprogfinal= '" . $fecharepf8 . "',
    s8_estadoregistro= '" . $estadoreg8 . "'
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);    
}
if (isset($_POST['titulosem9'])) {
//semana 9
$s9fecharegistro =date("d-m-Y");
$s9horaregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad9'])) {
    $tipoactividad9    = strval($_REQUEST['TipoActividad9']);
} else {
    $tipoactividad9 = "";
}
if (isset($_POST['DescripcionActSem9'])) {
    $DescripcionActSem9         = strval($_REQUEST['DescripcionActSem9']);
} else {
    $DescripcionActSem9     = "";
}
if (isset($_POST['justificasem9'])) {
    $justificasem9         = strval($_REQUEST['justificasem9']);
} else {
    $justificasem9 = "";
}
if (isset($_POST['fechanov9'])) {
    $fechanov9       = $_REQUEST['fechanov9'];
} else {
    $fechanov9 = "";
}
if (isset($_POST['TipoNovedad9'])) {
    $tiponov9= strval($_REQUEST['TipoNovedad9']);
} else {
    $tiponov9 = "";
}
if (isset($_POST['fecharepinicio9'])) {
    $fecharepi9= strval($_REQUEST['fecharepinicio9']);
} else {
    $fecharepi9 = "";
}
if (isset($_POST['fecharepfinal9'])) {
    $fecharepf9= $_REQUEST['fecharepfinal9'];
} else {
    $fecharepf9 = "";
}
if($tipoactividad9 =="Regular"){
  $estadoreg9="REGISTRO VALIDO";
}else if ($tipoactividad9 =="Novedad"){
    $estadoreg9="REGISTRO CON MOVEDAD";
}else if ($tipoactividad9 ==""){
    $estadoreg9="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET    
    s9_fecharegistro= '" . $s9fecharegistro . "',
	s9_horaregistro= '" . $s9horaregistro . "', 
    s9_tipoactividad= '" . $tipoactividad9 . "',
    s9_descripcion= '" . $DescripcionActSem9 . "',
    s9_justifica_nov= '" . $justificasem9 . "',
    s9_fechanovedad= '" . $fechanov9 . "',
    s9_tiponovedad= '" . $tiponov9 . "', 
    s9_fechareproginicial= '" . $fecharepi9 . "',
    s9_fechareprogfinal= '" . $fecharepf9 . "',
    s9_estadoregistro= '" . $estadoreg9 . "'
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);
}
if (isset($_POST['titulosem10'])) {
//semana 10
$s10fecharegistro =date("d-m-Y");
$s10horaregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad10'])) {
    $tipoactividad10    = strval($_REQUEST['TipoActividad10']);
} else {
    $tipoactividad10 = "";
}
if (isset($_POST['DescripcionActSem10'])) {
    $DescripcionActSem10         = strval($_REQUEST['DescripcionActSem10']);
} else {
    $DescripcionActSem10     = "";
}
if (isset($_POST['justificasem10'])) {
    $justificasem10         = strval($_REQUEST['justificasem10']);
} else {
    $justificasem10 = "";
}
if (isset($_POST['fechanov10'])) {
    $fechanov10       = $_REQUEST['fechanov10'];
} else {
    $fechanov10 = "";
}
if (isset($_POST['TipoNovedad10'])) {
    $tiponov10= strval($_REQUEST['TipoNovedad10']);
} else {
    $tiponov10 = "";
}
if (isset($_POST['fecharepinicio10'])) {
    $fecharepi10= strval($_REQUEST['fecharepinicio10']);
} else {
    $fecharepi10 = "";
}
if (isset($_POST['fecharepfinal10'])) {
    $fecharepf10= $_REQUEST['fecharepfinal10'];
} else {
    $fecharepf10 = "";
}
if($tipoactividad10 =="Regular"){
  $estadoreg10="REGISTRO VALIDO";
}else if ($tipoactividad10 =="Novedad"){
    $estadoreg10="REGISTRO CON MOVEDAD";
}else if ($tipoactividad10 ==""){
    $estadoreg10="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET    
    s10_fecharegistro= '" . $s10fecharegistro . "',
	s10_horaregistro= '" . $s10horaregistro . "', 
    s10_tipoactividad= '" . $tipoactividad10 . "',
    s10_descripcion= '" . $DescripcionActSem10 . "',
    s10_justifica_nov= '" . $justificasem10 . "',
    s10_fechanovedad= '" . $fechanov10 . "',
    s10_tiponovedad= '" . $tiponov10 . "', 
    s10_fechareproginicial= '" . $fecharepi10 . "',
    s10_fechareprogfinal= '" . $fecharepf10 . "',
    s10_estadoregistro= '" . $estadoreg10 . "'
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);
}
if (isset($_POST['titulosem11'])) {
//semana 11
$s11fecharegistro =date("d-m-Y");
$s11horaregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad11'])) {
    $tipoactividad11    = strval($_REQUEST['TipoActividad11']);
} else {
    $tipoactividad11 = "";
}
if (isset($_POST['DescripcionActSem11'])) {
    $DescripcionActSem11         = strval($_REQUEST['DescripcionActSem11']);
} else {
    $DescripcionActSem11     = "";
}
if (isset($_POST['justificasem11'])) {
    $justificasem11         = strval($_REQUEST['justificasem11']);
} else {
    $justificasem11 = "";
}
if (isset($_POST['fechanov11'])) {
    $fechanov11       = $_REQUEST['fechanov11'];
} else {
    $fechanov11 = "";
}
if (isset($_POST['TipoNovedad11'])) {
    $tiponov11= strval($_REQUEST['TipoNovedad11']);
} else {
    $tiponov11 = "";
}
if (isset($_POST['fecharepinicio11'])) {
    $fecharepi11= strval($_REQUEST['fecharepinicio11']);
} else {
    $fecharepi11 = "";
}
if (isset($_POST['fecharepfinal11'])) {
    $fecharepf11= $_REQUEST['fecharepfinal11'];
} else {
    $fecharepf11 = "";
}
if($tipoactividad11 =="Regular"){
  $estadoreg11="REGISTRO VALIDO";
}else if ($tipoactividad11 =="Novedad"){
    $estadoreg11="REGISTRO CON MOVEDAD";
}else if ($tipoactividad11 ==""){
    $estadoreg11="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET    
    s11_fecharegistro= '" . $s11fecharegistro . "',
	s11_horaregistro= '" . $s11horaregistro . "', 
    s11_tipoactividad= '" . $tipoactividad11 . "',
    s11_descripcion= '" . $DescripcionActSem11 . "',
    s11_justifica_nov= '" . $justificasem11 . "',
    s11_fechanovedad= '" . $fechanov11 . "',
    s11_tiponovedad= '" . $tiponov11 . "', 
    s11_fechareproginicial= '" . $fecharepi11 . "',
    s11_fechareprogfinal= '" . $fecharepf11 . "',
    s11_estadoregistro= '" . $estadoreg11 . "'
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);
}
if (isset($_POST['titulosem12'])) {
//semana 12
$s12fecharegistro =date("d-m-Y");
$s12horaregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad12'])) {
    $tipoactividad12    = strval($_REQUEST['TipoActividad12']);
} else {
    $tipoactividad12 = "";
}
if (isset($_POST['DescripcionActSem12'])) {
    $DescripcionActSem12         = strval($_REQUEST['DescripcionActSem12']);
} else {
    $DescripcionActSem12     = "";
}
if (isset($_POST['justificasem12'])) {
    $justificasem12         = strval($_REQUEST['justificasem12']);
} else {
    $justificasem12 = "";
}
if (isset($_POST['fechanov12'])) {
    $fechanov12       = $_REQUEST['fechanov12'];
} else {
    $fechanov12 = "";
}
if (isset($_POST['TipoNovedad12'])) {
    $tiponov12= strval($_REQUEST['TipoNovedad12']);
} else {
    $tiponov12 = "";
}
if (isset($_POST['fecharepinicio12'])) {
    $fecharepi12= strval($_REQUEST['fecharepinicio12']);
} else {
    $fecharepi12 = "";
}
if (isset($_POST['fecharepfinal12'])) {
    $fecharepf12= $_REQUEST['fecharepfinal12'];
} else {
    $fecharepf12 = "";
}
if($tipoactividad12 =="Regular"){
  $estadoreg12="REGISTRO VALIDO";
}else if ($tipoactividad12 =="Novedad"){
    $estadoreg12="REGISTRO CON MOVEDAD";
}else if ($tipoactividad12 ==""){
    $estadoreg12="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET    
    s12_fecharegistro= '" . $s12fecharegistro . "',
	s12_horaregistro= '" . $s12horaregistro . "', 
    s12_tipoactividad= '" . $tipoactividad12 . "',
    s12_descripcion= '" . $DescripcionActSem12 . "',
    s12_justifica_nov= '" . $justificasem12 . "',
    s12_fechanovedad= '" . $fechanov12 . "',
    s12_tiponovedad= '" . $tiponov12 . "', 
    s12_fechareproginicial= '" . $fecharepi12 . "',
    s12_fechareprogfinal= '" . $fecharepf12 . "',
    s12_estadoregistro= '" . $estadoreg12 . "'
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);
}
if (isset($_POST['titulosem13'])) {
//semana 13
$s13fecharegistro =date("d-m-Y");
$s13horaregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad13'])) {
    $tipoactividad13    = strval($_REQUEST['TipoActividad13']);
} else {
    $tipoactividad13 = "";
}
if (isset($_POST['DescripcionActSem13'])) {
    $DescripcionActSem13         = strval($_REQUEST['DescripcionActSem13']);
} else {
    $DescripcionActSem13     = "";
}
if (isset($_POST['justificasem13'])) {
    $justificasem13         = strval($_REQUEST['justificasem13']);
} else {
    $justificasem13 = "";
}
if (isset($_POST['fechanov13'])) {
    $fechanov13       = $_REQUEST['fechanov13'];
} else {
    $fechanov13 = "";
}
if (isset($_POST['TipoNovedad13'])) {
    $tiponov13= strval($_REQUEST['TipoNovedad13']);
} else {
    $tiponov13 = "";
}
if (isset($_POST['fecharepinicio13'])) {
    $fecharepi13= strval($_REQUEST['fecharepinicio13']);
} else {
    $fecharepi13 = "";
}
if (isset($_POST['fecharepfinal13'])) {
    $fecharepf13= $_REQUEST['fecharepfinal13'];
} else {
    $fecharepf13 = "";
}
if($tipoactividad13 =="Regular"){
  $estadoreg13="REGISTRO VALIDO";
}else if ($tipoactividad13 =="Novedad"){
    $estadoreg13="REGISTRO CON MOVEDAD";
}else if ($tipoactividad13 ==""){
    $estadoreg13="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET    
    s13_fecharegistro= '" . $s13fecharegistro . "',
	s13_horaregistro= '" . $s13horaregistro . "', 
    s13_tipoactividad= '" . $tipoactividad13 . "',
    s13_descripcion= '" . $DescripcionActSem13 . "',
    s13_justifica_nov= '" . $justificasem13 . "',
    s13_fechanovedad= '" . $fechanov13 . "',
    s13_tiponovedad= '" . $tiponov13 . "', 
    s13_fechareproginicial= '" . $fecharepi13 . "',
    s13_fechareprogfinal= '" . $fecharepf13 . "',
    s13_estadoregistro= '" . $estadoreg13 . "'
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);
}
if (isset($_POST['titulosem14'])) {
//semana 14
$s14fecharegistro =date("d-m-Y");
$s14horaregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad14'])) {
    $tipoactividad14    = strval($_REQUEST['TipoActividad14']);
} else {
    $tipoactividad14 = "";
}
if (isset($_POST['DescripcionActSem14'])) {
    $DescripcionActSem14         = strval($_REQUEST['DescripcionActSem14']);
} else {
    $DescripcionActSem14     = "";
}
if (isset($_POST['justificasem14'])) {
    $justificasem14         = strval($_REQUEST['justificasem14']);
} else {
    $justificasem14 = "";
}
if (isset($_POST['fechanov14'])) {
    $fechanov14       = $_REQUEST['fechanov14'];
} else {
    $fechanov14 = "";
}
if (isset($_POST['TipoNovedad14'])) {
    $tiponov14= strval($_REQUEST['TipoNovedad14']);
} else {
    $tiponov14 = "";
}
if (isset($_POST['fecharepinicio14'])) {
    $fecharepi14= strval($_REQUEST['fecharepinicio14']);
} else {
    $fecharepi14 = "";
}
if (isset($_POST['fecharepfinal14'])) {
    $fecharepf14= $_REQUEST['fecharepfinal14'];
} else {
    $fecharepf14 = "";
}
if($tipoactividad14 =="Regular"){
  $estadoreg14="REGISTRO VALIDO";
}else if ($tipoactividad14 =="Novedad"){
    $estadoreg14="REGISTRO CON MOVEDAD";
}else if ($tipoactividad14 ==""){
    $estadoreg14="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET    
    s14_fecharegistro= '" . $s14fecharegistro . "',
	s14_horaregistro= '" . $s14horaregistro . "', 
    s14_tipoactividad= '" . $tipoactividad14 . "',
    s14_descripcion= '" . $DescripcionActSem14 . "',
    s14_justifica_nov= '" . $justificasem14 . "',
    s14_fechanovedad= '" . $fechanov14 . "',
    s14_tiponovedad= '" . $tiponov14 . "', 
    s14_fechareproginicial= '" . $fecharepi14 . "',
    s14_fechareprogfinal= '" . $fecharepf14 . "',
    s14_estadoregistro= '" . $estadoreg14 . "'
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);
}
if (isset($_POST['titulosem15'])) {
//semana 15
$s15fecharegistro =date("d-m-Y");
$s15horaregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad15'])) {
    $tipoactividad15    = strval($_REQUEST['TipoActividad15']);
} else {
    $tipoactividad15 = "";
}
if (isset($_POST['DescripcionActSem15'])) {
    $DescripcionActSem15         = strval($_REQUEST['DescripcionActSem15']);
} else {
    $DescripcionActSem15     = "";
}
if (isset($_POST['justificasem15'])) {
    $justificasem15         = strval($_REQUEST['justificasem15']);
} else {
    $justificasem15 = "";
}
if (isset($_POST['fechanov15'])) {
    $fechanov15       = $_REQUEST['fechanov15'];
} else {
    $fechanov15 = "";
}
if (isset($_POST['TipoNovedad15'])) {
    $tiponov15= strval($_REQUEST['TipoNovedad15']);
} else {
    $tiponov15 = "";
}
if (isset($_POST['fecharepinicio15'])) {
    $fecharepi15= strval($_REQUEST['fecharepinicio15']);
} else {
    $fecharepi15 = "";
}
if (isset($_POST['fecharepfinal15'])) {
    $fecharepf15= $_REQUEST['fecharepfinal15'];
} else {
    $fecharepf15 = "";
}
if($tipoactividad15 =="Regular"){
  $estadoreg15="REGISTRO VALIDO";
}else if ($tipoactividad15 =="Novedad"){
    $estadoreg15="REGISTRO CON MOVEDAD";
}else if ($tipoactividad15 ==""){
    $estadoreg15="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET    
    s15_fecharegistro= '" . $s15fecharegistro . "',
    s15_horaregistro= '" . $s15horaregistro . "',
	s15_tipoactividad= '" . $tipoactividad15 . "',
    s15_descripcion= '" . $DescripcionActSem15 . "',
    s15_justifica_nov= '" . $justificasem15 . "',
    s15_fechanovedad= '" . $fechanov15 . "',
    s15_tiponovedad= '" . $tiponov15 . "', 
    s15_fechareproginicial= '" . $fecharepi15 . "',
    s15_fechareprogfinal= '" . $fecharepf15 . "',
    s15_estadoregistro= '" . $estadoreg15 . "'
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);
}
if (isset($_POST['titulosem16'])) {
//semana 16
$s16fecharegistro =date("d-m-Y");
$s16horaregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad16'])) {
    $tipoactividad16    = strval($_REQUEST['TipoActividad16']);
} else {
    $tipoactividad16 = "";
}
if (isset($_POST['DescripcionActSem16'])) {
    $DescripcionActSem16         = strval($_REQUEST['DescripcionActSem16']);
} else {
    $DescripcionActSem16     = "";
}
if (isset($_POST['justificasem16'])) {
    $justificasem16         = strval($_REQUEST['justificasem16']);
} else {
    $justificasem16 = "";
}
if (isset($_POST['fechanov16'])) {
    $fechanov16       = $_REQUEST['fechanov16'];
} else {
    $fechanov16 = "";
}
if (isset($_POST['TipoNovedad16'])) {
    $tiponov16= strval($_REQUEST['TipoNovedad16']);
} else {
    $tiponov16 = "";
}
if (isset($_POST['fecharepinicio16'])) {
    $fecharepi16= strval($_REQUEST['fecharepinicio16']);
} else {
    $fecharepi16 = "";
}
if (isset($_POST['fecharepfinal16'])) {
    $fecharepf16= $_REQUEST['fecharepfinal16'];
} else {
    $fecharepf16 = "";
}
if($tipoactividad16 =="Regular"){
  $estadoreg16="REGISTRO VALIDO";
}else if ($tipoactividad16 =="Novedad"){
    $estadoreg16="REGISTRO CON MOVEDAD";
}else if ($tipoactividad16 ==""){
    $estadoreg16="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET    
    s16_fecharegistro= '" . $s16fecharegistro . "',
    s16_horaregistro= '" . $s16horaregistro . "',
	s16_tipoactividad= '" . $tipoactividad16 . "',
    s16_descripcion= '" . $DescripcionActSem16 . "',
    s16_justifica_nov= '" . $justificasem16 . "',
    s16_fechanovedad= '" . $fechanov16 . "',
    s16_tiponovedad= '" . $tiponov16 . "', 
    s16_fechareproginicial= '" . $fecharepi16 . "',
    s16_fechareprogfinal= '" . $fecharepf16 . "',
    s16_estadoregistro= '" . $estadoreg16 . "'
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);
}
if (isset($_POST['titulosem1p'])) {
//semana1 postgrado
$s1pfecharegistro =date("d-m-Y");
$s1phoraregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad1p'])) {
    $tipoactividad1p    = strval($_REQUEST['TipoActividad1p']);
} else {
    $tipoactividad1p = "";
}
if (isset($_POST['DescripcionActSem1p'])) {
    $DescripcionActSem1p         = strval($_REQUEST['DescripcionActSem1p']);
} else {
    $DescripcionActSem1p     = "";
}
if (isset($_POST['justificasem1p'])) {
    $justificasem1p         = strval($_REQUEST['justificasem1p']);
} else {
    $justificasem1p = "";
}
if (isset($_POST['fechanov1p'])) {
    $fechanov1p       = $_REQUEST['fechanov1p'];
} else {
    $fechanov1p = "";
}
if (isset($_POST['TipoNovedad1p'])) {
    $tiponov1p= strval($_REQUEST['TipoNovedad1p']);
} else {
    $tiponov1p = "";
}
if (isset($_POST['fecharepinicio1p'])) {
    $fecharepi1p= $_REQUEST['fecharepinicio1p'];
} else {
    $fecharepi1p = "";
}
if (isset($_POST['fecharepfinal1p'])) {
    $fecharepf1p= $_REQUEST['fecharepfinal1p'];
} else {
    $fecharepf1p = "";
}
if($tipoactividad1p =="Regular"){
  $estadoreg1p="REGISTRO VALIDO";
}else if ($tipoactividad1p =="Novedad"){
    $estadoreg1p="REGISTRO CON MOVEDAD";
}else if ($tipoactividad1p ==""){
    $estadoreg1p="CONSIGNADOR SIN DEFINIR";
    $s1pfecharegistro ="";
    $s1phoraregistro  ="";
}
$QueryUpdate = ("UPDATE $tablam3
 SET
    s1_fecharegistro_p= '" . $s1pfecharegistro . "',
	s1_horaregistro_p= '" . $s1phoraregistro . "', 
    s1_tipoactividad_p= '" . $tipoactividad1p . "',
    s1_descripcion_p= '" . $DescripcionActSem1p . "',
    s1_justifica_nov_p= '" . $justificasem1p . "',
    s1_fechanovedad_p= '" . $fechanov1p . "',
    s1_tiponovedad_p= '" . $tiponov1p . "', 
    s1_fechareproginicial_p= '" . $fecharepi1p . "',
    s1_fechareprogfinal_p= '" . $fecharepf1p . "',
    s1_estadoregistro_p= '" . $estadoreg1p . "'  
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);
}
if (isset($_POST['titulosem2p'])) {
//semana2 postgrado
$s2pfecharegistro =date("d-m-Y");
$s2phoraregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad2p'])) {
    $tipoactividad2p    = strval($_REQUEST['TipoActividad2p']);
} else {
    $tipoactividad2p = "";
}
if (isset($_POST['DescripcionActSem2p'])) {
    $DescripcionActSem2p         = strval($_REQUEST['DescripcionActSem2p']);
} else {
    $DescripcionActSem2p     = "";
}
if (isset($_POST['justificasem2p'])) {
    $justificasem2p         = strval($_REQUEST['justificasem2p']);
} else {
    $justificasem2p = "";
}
if (isset($_POST['fechanov2p'])) {
    $fechanov2p       = $_REQUEST['fechanov2p'];
} else {
    $fechanov2p = "";
}
if (isset($_POST['TipoNovedad2p'])) {
    $tiponov2p= strval($_REQUEST['TipoNovedad2p']);
} else {
    $tiponov2p = "";
}
if (isset($_POST['fecharepinicio2p'])) {
    $fecharepi2p= $_REQUEST['fecharepinicio2p'];
} else {
    $fecharepi2p = "";
}
if (isset($_POST['fecharepfinal2p'])) {
    $fecharepf2p= $_REQUEST['fecharepfinal2p'];
} else {
    $fecharepf2p = "";
}
if($tipoactividad2p =="Regular"){
  $estadoreg2p="REGISTRO VALIDO";
}else if ($tipoactividad2p =="Novedad"){
    $estadoreg2p="REGISTRO CON MOVEDAD";
}else if ($tipoactividad2p ==""){
    $estadoreg2p="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET
    s2_fecharegistro_p= '" . $s2pfecharegistro . "',
	s2_horaregistro_p= '" . $s2phoraregistro . "', 
    s2_tipoactividad_p= '" . $tipoactividad2p . "',
    s2_descripcion_p= '" . $DescripcionActSem2p . "',
    s2_justifica_nov_p= '" . $justificasem2p . "',
    s2_fechanovedad_p= '" . $fechanov2p . "',
    s2_tiponovedad_p= '" . $tiponov2p . "', 
    s2_fechareproginicial_p= '" . $fecharepi2p . "',
    s2_fechareprogfinal_p= '" . $fecharepf2p . "',
    s2_estadoregistro_p= '" . $estadoreg2p . "'  
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);
}
if (isset($_POST['titulosem3p'])) {
//semana3 postgrado
$s3pfecharegistro =date("d-m-Y");
$s3phoraregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad3p'])) {
    $tipoactividad3p    = strval($_REQUEST['TipoActividad3p']);
} else {
    $tipoactividad3p = "";
}
if (isset($_POST['DescripcionActSem3p'])) {
    $DescripcionActSem3p         = strval($_REQUEST['DescripcionActSem3p']);
} else {
    $DescripcionActSem3p     = "";
}
if (isset($_POST['justificasem3p'])) {
    $justificasem3p         = strval($_REQUEST['justificasem3p']);
} else {
    $justificasem3p = "";
}
if (isset($_POST['fechanov3p'])) {
    $fechanov3p       = $_REQUEST['fechanov3p'];
} else {
    $fechanov3p = "";
}
if (isset($_POST['TipoNovedad3p'])) {
    $tiponov3p= strval($_REQUEST['TipoNovedad3p']);
} else {
    $tiponov3p = "";
}
if (isset($_POST['fecharepinicio3p'])) {
    $fecharepi3p= $_REQUEST['fecharepinicio3p'];
} else {
    $fecharepi3p = "";
}
if (isset($_POST['fecharepfinal3p'])) {
    $fecharepf3p= $_REQUEST['fecharepfinal3p'];
} else {
    $fecharepf3p = "";
}
if($tipoactividad3p =="Regular"){
  $estadoreg3p="REGISTRO VALIDO";
}else if ($tipoactividad3p =="Novedad"){
    $estadoreg3p="REGISTRO CON MOVEDAD";
}else if ($tipoactividad3p ==""){
    $estadoreg3p="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET
    s3_fecharegistro_p= '" . $s3pfecharegistro . "',
	s3_horaregistro_p= '" . $s3phoraregistro . "', 
    s3_tipoactividad_p= '" . $tipoactividad3p . "',
    s3_descripcion_p= '" . $DescripcionActSem3p . "',
    s3_justifica_nov_p= '" . $justificasem3p . "',
    s3_fechanovedad_p= '" . $fechanov3p . "',
    s3_tiponovedad_p= '" . $tiponov3p . "', 
    s3_fechareproginicial_p= '" . $fecharepi3p . "',
    s3_fechareprogfinal_p= '" . $fecharepf3p . "',
    s3_estadoregistro_p= '" . $estadoreg3p . "'  
WHERE id='" .$codregistro. "' 
");
$updateRegistro = pg_query($conexion, $QueryUpdate);
}
//semana4 postgrado
if (isset($_POST['titulosem4p'])) {

$s4pfecharegistro =date("d-m-Y");
$s4phoraregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad4p'])) {
    $tipoactividad4p    = strval($_REQUEST['TipoActividad4p']);
} else {
    $tipoactividad4p = "";
}
if (isset($_POST['DescripcionActSem4p'])) {
    $DescripcionActSem4p         = strval($_REQUEST['DescripcionActSem4p']);
} else {
    $DescripcionActSem4p     = "";
}
if (isset($_POST['justificasem4p'])) {
    $justificasem4p         = strval($_REQUEST['justificasem4p']);
} else {
    $justificasem4p = "";
}
if (isset($_POST['fechanov4p'])) {
    $fechanov4p       = $_REQUEST['fechanov4p'];
} else {
    $fechanov4p = "";
}
if (isset($_POST['TipoNovedad4p'])) {
    $tiponov4p= strval($_REQUEST['TipoNovedad4p']);
} else {
    $tiponov4p = "";
}
if (isset($_POST['fecharepinicio4p'])) {
    $fecharepi4p= $_REQUEST['fecharepinicio4p'];
} else {
    $fecharepi4p = "";
}
if (isset($_POST['fecharepfinal4p'])) {
    $fecharepf4p= $_REQUEST['fecharepfinal4p'];
} else {
    $fecharepf4p = "";
}
if($tipoactividad4p =="Regular"){
  $estadoreg4p="REGISTRO VALIDO";
}else if ($tipoactividad4p =="Novedad"){
    $estadoreg4p="REGISTRO CON MOVEDAD";
}else if ($tipoactividad4p ==""){
    $estadoreg4p="CONSIGNADOR SIN DEFINIR";
    $s4pfecharegistro ="";
    $s4phoraregistro  ="";
}
$QueryUpdate = ("UPDATE $tablam3
 SET
    s4_fecharegistro_p= '" . $s4pfecharegistro . "',
	s4_horaregistro_p= '" . $s4phoraregistro . "', 
    s4_tipoactividad_p= '" . $tipoactividad4p . "',
    s4_descripcion_p= '" . $DescripcionActSem4p . "',
    s4_justifica_nov_p= '" . $justificasem4p . "',
    s4_fechanovedad_p= '" . $fechanov4p . "',
    s4_tiponovedad_p= '" . $tiponov4p . "', 
    s4_fechareproginicial_p= '" . $fecharepi4p . "',
    s4_fechareprogfinal_p= '" . $fecharepf4p . "',
    s4_estadoregistro_p= '" . $estadoreg4p . "'
WHERE id='" .$codregistro. "' 
");
        
$updateRegistro = pg_query($conexion, $QueryUpdate);        
}
if (isset($_POST['titulosem5p'])) {
//semana5 postgrado
$s5pfecharegistro =date("d-m-Y");
$s5phoraregistro  =date('H:i:s');
//Otros campos
if (isset($_POST['TipoActividad5p'])) {
    $tipoactividad5p    = strval($_REQUEST['TipoActividad5p']);
} else {
    $tipoactividad5p = "";
}
if (isset($_POST['DescripcionActSem5p'])) {
    $DescripcionActSem5p         = strval($_REQUEST['DescripcionActSem5p']);
} else {
    $DescripcionActSem5p     = "";
}
if (isset($_POST['justificasem5p'])) {
    $justificasem5p         = strval($_REQUEST['justificasem5p']);
} else {
    $justificasem5p = "";
}
if (isset($_POST['fechanov5p'])) {
    $fechanov5p       = $_REQUEST['fechanov5p'];
} else {
    $fechanov5p = "";
}
if (isset($_POST['TipoNovedad5p'])) {
    $tiponov5p= strval($_REQUEST['TipoNovedad5p']);
} else {
    $tiponov5p = "";
}
if (isset($_POST['fecharepinicio5p'])) {
    $fecharepi5p= $_REQUEST['fecharepinicio5p'];
} else {
    $fecharepi5p = "";
}
if (isset($_POST['fecharepfinal5p'])) {
    $fecharepf5p= $_REQUEST['fecharepfinal5p'];
} else {
    $fecharepf5p = "";
}
if($tipoactividad5p =="Regular"){
  $estadoreg5p="REGISTRO VALIDO";
}else if ($tipoactividad5p =="Novedad"){
    $estadoreg5p="REGISTRO CON MOVEDAD";
}else if ($tipoactividad5p ==""){
    $estadoreg5p="CONSIGNADOR SIN DEFINIR";
}
$QueryUpdate = ("UPDATE $tablam3
 SET
    s5_fecharegistro_p= '" . $s5pfecharegistro . "',
	s5_horaregistro_p= '" . $s5phoraregistro . "', 
    s5_tipoactividad_p= '" . $tipoactividad5p . "',
    s5_descripcion_p= '" . $DescripcionActSem5p . "',
    s5_justifica_nov_p= '" . $justificasem5p . "',
    s5_fechanovedad_p= '" . $fechanov5p . "',
    s5_tiponovedad_p= '" . $tiponov5p . "', 
    s5_fechareproginicial_p= '" . $fecharepi5p . "',
    s5_fechareprogfinal_p= '" . $fecharepf5p . "',
    s5_estadoregistro_p= '" . $estadoreg5p . "'
WHERE id='" .$codregistro. "' 
");
        
$updateRegistro = pg_query($conexion, $QueryUpdate);
}
/* //sql de actualizacion de tabla
$QueryUpdate = ("UPDATE $tablam3
 SET
    
    s1_fecharegistro= '" . $s1fecharegistro . "',
	s1_horaregistro= '" . $s1horaregistro . "', 
    s1_tipoactividad= '" . $tipoactividad1 . "',
    s1_descripcion= '" . $DescripcionActSem1 . "',
    s1_justifica_nov= '" . $justificasem1 . "',
    s1_fechanovedad= '" . $fechanov1 . "',
    s1_tiponovedad= '" . $tiponov1 . "', 
    s1_fechareproginicial= '" . $fecharepi1 . "',
    s1_fechareprogfinal= '" . $fecharepf1 . "',
    s1_estadoregistro= '" . $estadoreg1 . "',
    s2_fecharegistro= '" . $s2fecharegistro . "',
	s2_horaregistro= '" . $s2horaregistro . "', 
    s2_tipoactividad= '" . $tipoactividad2 . "',
    s2_descripcion= '" . $DescripcionActSem2 . "',
    s2_justifica_nov= '" . $justificasem2 . "',
    s2_fechanovedad= '" . $fechanov2 . "',
    s2_tiponovedad= '" . $tiponov2 . "', 
    s2_fechareproginicial= '" . $fecharepi2 . "',
    s2_fechareprogfinal= '" . $fecharepf2 . "',
    s2_estadoregistro= '" . $estadoreg2 . "',
    s3_fecharegistro= '" . $s3fecharegistro . "',
	s3_horaregistro= '" . $s3horaregistro . "', 
    s3_tipoactividad= '" . $tipoactividad3 . "',
    s3_descripcion= '" . $DescripcionActSem3 . "',
    s3_justifica_nov= '" . $justificasem3 . "',
    s3_fechanovedad= '" . $fechanov3 . "',
    s3_tiponovedad= '" . $tiponov3 . "', 
    s3_fechareproginicial= '" . $fecharepi3 . "',
    s3_fechareprogfinal= '" . $fecharepf3 . "',
    s3_estadoregistro= '" . $estadoreg3 . "',
    s4_fecharegistro= '" . $s4fecharegistro . "',
	s4_horaregistro= '" . $s4horaregistro . "', 
    s4_tipoactividad= '" . $tipoactividad4 . "',
    s4_descripcion= '" . $DescripcionActSem4 . "',
    s4_justifica_nov= '" . $justificasem4 . "',
    s4_fechanovedad= '" . $fechanov4 . "',
    s4_tiponovedad= '" . $tiponov4 . "', 
    s4_fechareproginicial= '" . $fecharepi4 . "',
    s4_fechareprogfinal= '" . $fecharepf4 . "',
    s4_estadoregistro= '" . $estadoreg4 . "',
    s5_fecharegistro= '" . $s5fecharegistro . "',
	s5_horaregistro= '" . $s5horaregistro . "', 
    s5_tipoactividad= '" . $tipoactividad5 . "',
    s5_descripcion= '" . $DescripcionActSem5 . "',
    s5_justifica_nov= '" . $justificasem5 . "',
    s5_fechanovedad= '" . $fechanov5 . "',
    s5_tiponovedad= '" . $tiponov5 . "', 
    s5_fechareproginicial= '" . $fecharepi5 . "',
    s5_fechareprogfinal= '" . $fecharepf5 . "',
    s5_estadoregistro= '" . $estadoreg5 . "',
    s6_fecharegistro= '" . $s6fecharegistro . "',
	s6_horaregistro= '" . $s6horaregistro . "', 
    s6_tipoactividad= '" . $tipoactividad6 . "',
    s6_descripcion= '" . $DescripcionActSem6 . "',
    s6_justifica_nov= '" . $justificasem6 . "',
    s6_fechanovedad= '" . $fechanov6 . "',
    s6_tiponovedad= '" . $tiponov6 . "', 
    s6_fechareproginicial= '" . $fecharepi6 . "',
    s6_fechareprogfinal= '" . $fecharepf6 . "',
    s6_estadoregistro= '" . $estadoreg6 . "',
    s7_fecharegistro= '" . $s7fecharegistro . "',
	s7_horaregistro= '" . $s7horaregistro . "', 
    s7_tipoactividad= '" . $tipoactividad7 . "',
    s7_descripcion= '" . $DescripcionActSem7 . "',
    s7_justifica_nov= '" . $justificasem7 . "',
    s7_fechanovedad= '" . $fechanov7 . "',
    s7_tiponovedad= '" . $tiponov7 . "', 
    s7_fechareproginicial= '" . $fecharepi7 . "',
    s7_fechareprogfinal= '" . $fecharepf7 . "',
    s7_estadoregistro= '" . $estadoreg7 . "',
    s8_fecharegistro= '" . $s8fecharegistro . "',
	s8_horaregistro= '" . $s8horaregistro . "', 
    s8_tipoactividad= '" . $tipoactividad8 . "',
    s8_descripcion= '" . $DescripcionActSem8 . "',
    s8_justifica_nov= '" . $justificasem8 . "',
    s8_fechanovedad= '" . $fechanov8 . "',
    s8_tiponovedad= '" . $tiponov8 . "', 
    s8_fechareproginicial= '" . $fecharepi8 . "',
    s8_fechareprogfinal= '" . $fecharepf8 . "',
    s8_estadoregistro= '" . $estadoreg8 . "',
    s9_fecharegistro= '" . $s9fecharegistro . "',
	s9_horaregistro= '" . $s9horaregistro . "', 
    s9_tipoactividad= '" . $tipoactividad9 . "',
    s9_descripcion= '" . $DescripcionActSem9 . "',
    s9_justifica_nov= '" . $justificasem9 . "',
    s9_fechanovedad= '" . $fechanov9 . "',
    s9_tiponovedad= '" . $tiponov9 . "', 
    s9_fechareproginicial= '" . $fecharepi9 . "',
    s9_fechareprogfinal= '" . $fecharepf9 . "',
    s9_estadoregistro= '" . $estadoreg9 . "',
    s10_fecharegistro= '" . $s10fecharegistro . "',
	s10_horaregistro= '" . $s10horaregistro . "', 
    s10_tipoactividad= '" . $tipoactividad10 . "',
    s10_descripcion= '" . $DescripcionActSem10 . "',
    s10_justifica_nov= '" . $justificasem10 . "',
    s10_fechanovedad= '" . $fechanov10 . "',
    s10_tiponovedad= '" . $tiponov10 . "', 
    s10_fechareproginicial= '" . $fecharepi10 . "',
    s10_fechareprogfinal= '" . $fecharepf10 . "',
    s10_estadoregistro= '" . $estadoreg10 . "',
    s11_fecharegistro= '" . $s11fecharegistro . "',
	s11_horaregistro= '" . $s11horaregistro . "', 
    s11_tipoactividad= '" . $tipoactividad11 . "',
    s11_descripcion= '" . $DescripcionActSem11 . "',
    s11_justifica_nov= '" . $justificasem11 . "',
    s11_fechanovedad= '" . $fechanov11 . "',
    s11_tiponovedad= '" . $tiponov11 . "', 
    s11_fechareproginicial= '" . $fecharepi11 . "',
    s11_fechareprogfinal= '" . $fecharepf11 . "',
    s11_estadoregistro= '" . $estadoreg11 . "',
    s12_fecharegistro= '" . $s12fecharegistro . "',
	s12_horaregistro= '" . $s12horaregistro . "', 
    s12_tipoactividad= '" . $tipoactividad12 . "',
    s12_descripcion= '" . $DescripcionActSem12 . "',
    s12_justifica_nov= '" . $justificasem12 . "',
    s12_fechanovedad= '" . $fechanov12 . "',
    s12_tiponovedad= '" . $tiponov12 . "', 
    s12_fechareproginicial= '" . $fecharepi12 . "',
    s12_fechareprogfinal= '" . $fecharepf12 . "',
    s12_estadoregistro= '" . $estadoreg12 . "',
    s13_fecharegistro= '" . $s13fecharegistro . "',
	s13_horaregistro= '" . $s13horaregistro . "', 
    s13_tipoactividad= '" . $tipoactividad13 . "',
    s13_descripcion= '" . $DescripcionActSem13 . "',
    s13_justifica_nov= '" . $justificasem13 . "',
    s13_fechanovedad= '" . $fechanov13 . "',
    s13_tiponovedad= '" . $tiponov13 . "', 
    s13_fechareproginicial= '" . $fecharepi13 . "',
    s13_fechareprogfinal= '" . $fecharepf13 . "',
    s13_estadoregistro= '" . $estadoreg13 . "',
    s14_fecharegistro= '" . $s14fecharegistro . "',
	s14_horaregistro= '" . $s14horaregistro . "', 
    s14_tipoactividad= '" . $tipoactividad14 . "',
    s14_descripcion= '" . $DescripcionActSem14 . "',
    s14_justifica_nov= '" . $justificasem14 . "',
    s14_fechanovedad= '" . $fechanov14 . "',
    s14_tiponovedad= '" . $tiponov14 . "', 
    s14_fechareproginicial= '" . $fecharepi14 . "',
    s14_fechareprogfinal= '" . $fecharepf14 . "',
    s14_estadoregistro= '" . $estadoreg14 . "',
    s15_fecharegistro= '" . $s15fecharegistro . "',
	s15_horaregistro= '" . $s15horaregistro . "', 
    s15_tipoactividad= '" . $tipoactividad15 . "',
    s15_descripcion= '" . $DescripcionActSem15 . "',
    s15_justifica_nov= '" . $justificasem15 . "',
    s15_fechanovedad= '" . $fechanov15 . "',
    s15_tiponovedad= '" . $tiponov15 . "', 
    s15_fechareproginicial= '" . $fecharepi15 . "',
    s15_fechareprogfinal= '" . $fecharepf15 . "',
    s15_estadoregistro= '" . $estadoreg15 . "',
    s16_fecharegistro= '" . $s16fecharegistro . "',
	s16_horaregistro= '" . $s16horaregistro . "', 
    s16_tipoactividad= '" . $tipoactividad16 . "',
    s16_descripcion= '" . $DescripcionActSem16 . "',
    s16_justifica_nov= '" . $justificasem16 . "',
    s16_fechanovedad= '" . $fechanov16 . "',
    s16_tiponovedad= '" . $tiponov16 . "', 
    s16_fechareproginicial= '" . $fecharepi16 . "',
    s16_fechareprogfinal= '" . $fecharepf16 . "',
    s16_estadoregistro= '" . $estadoreg16 . "',
    s1_fecharegistro_p= '" . $s1pfecharegistro . "',
	s1_horaregistro_p= '" . $s1phoraregistro . "', 
    s1_tipoactividad_p= '" . $tipoactividad1p . "',
    s1_descripcion_p= '" . $DescripcionActSem1p . "',
    s1_justifica_nov_p= '" . $justificasem1p . "',
    s1_fechanovedad_p= '" . $fechanov1p . "',
    s1_tiponovedad_p= '" . $tiponov1p . "', 
    s1_fechareproginicial_p= '" . $fecharepi1p . "',
    s1_fechareprogfinal_p= '" . $fecharepf1p . "',
    s1_estadoregistro_p= '" . $estadoreg1p . "',
    s2_fecharegistro_p= '" . $s2pfecharegistro . "',
	s2_horaregistro_p= '" . $s2phoraregistro . "', 
    s2_tipoactividad_p= '" . $tipoactividad2p . "',
    s2_descripcion_p= '" . $DescripcionActSem2p . "',
    s2_justifica_nov_p= '" . $justificasem2p . "',
    s2_fechanovedad_p= '" . $fechanov2p . "',
    s2_tiponovedad_p= '" . $tiponov2p . "', 
    s2_fechareproginicial_p= '" . $fecharepi2p . "',
    s2_fechareprogfinal_p= '" . $fecharepf2p . "',
    s2_estadoregistro_p= '" . $estadoreg2p . "',
    s3_fecharegistro_p= '" . $s3pfecharegistro . "',
	s3_horaregistro_p= '" . $s3phoraregistro . "', 
    s3_tipoactividad_p= '" . $tipoactividad3p . "',
    s3_descripcion_p= '" . $DescripcionActSem3p . "',
    s3_justifica_nov_p= '" . $justificasem3p . "',
    s3_fechanovedad_p= '" . $fechanov3p . "',
    s3_tiponovedad_p= '" . $tiponov3p . "', 
    s3_fechareproginicial_p= '" . $fecharepi3p . "',
    s3_fechareprogfinal_p= '" . $fecharepf3p . "',
    s3_estadoregistro_p= '" . $estadoreg3p . "',    
    s5_fecharegistro_p= '" . $s5pfecharegistro . "',
	s5_horaregistro_p= '" . $s5phoraregistro . "', 
    s5_tipoactividad_p= '" . $tipoactividad5p . "',
    s5_descripcion_p= '" . $DescripcionActSem5p . "',
    s5_justifica_nov_p= '" . $justificasem5p . "',
    s5_fechanovedad_p= '" . $fechanov5p . "',
    s5_tiponovedad_p= '" . $tiponov5p . "', 
    s5_fechareproginicial_p= '" . $fecharepi5p . "',
    s5_fechareprogfinal_p= '" . $fecharepf5p . "',
    s5_estadoregistro_p= '" . $estadoreg5p . "'
WHERE id='" .$codregistro. "' 
");

$updateRegistro = pg_query($conexion, $QueryUpdate);
 */
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

?>