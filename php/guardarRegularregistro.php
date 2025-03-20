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
    $s1fecharegistro = date("d-m-Y");
    $s1horaregistro  = date('H:i:s');
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
    if ($tipoactividad1 == "Regular") {
        $estadoreg1 = "REGISTRO VALIDO";
    } else if ($tipoactividad1 == "Novedad") {
        $estadoreg1 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad1 == "") {
        $estadoreg1 = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s1_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);


    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET    
    s1_fecharegistro= '" . $s1fecharegistro . "',
	s1_horaregistro= '" . $s1horaregistro . "', 
    s1_tipoactividad= '" . $tipoactividad1 . "',
    s1_descripcion= '" . $DescripcionActSem1 . "',
    s1_estadoregistro= '" . $estadoreg1 . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        //echo $numrow;
        $updateRegistro = false;
    }
}
if (isset($_POST['titulosem2'])) {
    //semana 2
    $s2fecharegistro = date("d-m-Y");
    $s2horaregistro  = date('H:i:s');
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
    if ($tipoactividad2 == "Regular") {
        $estadoreg2 = "REGISTRO VALIDO";
    } else if ($tipoactividad2 == "Novedad") {
        $estadoreg2 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad2 == "") {
        $estadoreg2 = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s2_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET    
    s2_fecharegistro= '" . $s2fecharegistro . "',
	s2_horaregistro= '" . $s2horaregistro . "', 
    s2_tipoactividad= '" . $tipoactividad2 . "',
    s2_descripcion= '" . $DescripcionActSem2 . "',
    s2_estadoregistro= '" . $estadoreg2 . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        //echo $numrow;
        $updateRegistro = false;
    }
}
//
if (isset($_POST['titulosem3'])) {
    //semana 3
    $s3fecharegistro = date("d-m-Y");
    $s3horaregistro  = date('H:i:s');
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
    if ($tipoactividad3 == "Regular") {
        $estadoreg3 = "REGISTRO VALIDO";
    } else if ($tipoactividad3 == "Novedad") {
        $estadoreg3 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad3 == "") {
        $estadoreg3 = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s3_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET    
    s3_fecharegistro= '" . $s3fecharegistro . "',
	s3_horaregistro= '" . $s3horaregistro . "', 
    s3_tipoactividad= '" . $tipoactividad3 . "',
    s3_descripcion= '" . $DescripcionActSem3 . "',
    s3_estadoregistro= '" . $estadoreg3 . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        //echo $numrow;
        $updateRegistro = false;
    }
}
if (isset($_POST['titulosem4'])) {
    //semana 4
    $s4fecharegistro = date("d-m-Y");
    $s4horaregistro  = date('H:i:s');
    //Otros campos
    //echo $codregistro;
    if (isset($_POST['TipoActividad4'])) {
        $tipoactividad4    = strval($_REQUEST['TipoActividad4']);
        //echo $tipoactividad4;
    } else {
        $tipoactividad4 = "";
    }
    if (isset($_POST['DescripcionActSem4'])) {
        $DescripcionActSem4         = strval($_REQUEST['DescripcionActSem4']);
    } else {
        $DescripcionActSem4     = "";
    }
    if ($tipoactividad4 == "Regular") {
        $estadoreg4 = "REGISTRO VALIDO";
    } else if ($tipoactividad4 == "Novedad") {
        $estadoreg4 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad4 == "") {
        $estadoreg4 = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s4_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    echo $numrow;

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET    
    s4_fecharegistro= '" . $s4fecharegistro . "',
	s4_horaregistro= '" . $s4horaregistro . "', 
    s4_tipoactividad= '" . $tipoactividad4 . "',
    s4_descripcion= '" . $DescripcionActSem4 . "',
    s4_estadoregistro= '" . $estadoreg4 . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
//
if (isset($_POST['titulosem5'])) {
    //semana 5
    $s5fecharegistro = date("d-m-Y");
    $s5horaregistro  = date('H:i:s');
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
    if ($tipoactividad5 == "Regular") {
        $estadoreg5 = "REGISTRO VALIDO";
    } else if ($tipoactividad5 == "Novedad") {
        $estadoreg5 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad5 == "") {
        $estadoreg5 = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s5_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET    
    s5_fecharegistro= '" . $s5fecharegistro . "',
	s5_horaregistro= '" . $s5horaregistro . "', 
    s5_tipoactividad= '" . $tipoactividad5 . "',
    s5_descripcion= '" . $DescripcionActSem5 . "',
    s5_estadoregistro= '" . $estadoreg5 . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
//
if (isset($_POST['titulosem6'])) {
    //semana 6
    $s6fecharegistro = date("d-m-Y");
    $s6horaregistro  = date('H:i:s');
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
    if ($tipoactividad6 == "Regular") {
        $estadoreg6 = "REGISTRO VALIDO";
    } else if ($tipoactividad6 == "Novedad") {
        $estadoreg6 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad6 == "") {
        $estadoreg6 = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s6_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET    
    s6_fecharegistro= '" . $s6fecharegistro . "',
	s6_horaregistro= '" . $s6horaregistro . "', 
    s6_tipoactividad= '" . $tipoactividad6 . "',
    s6_descripcion= '" . $DescripcionActSem6 . "',
    s6_estadoregistro= '" . $estadoreg6 . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
//
if (isset($_POST['titulosem7'])) {
    //semana 7
    $s7fecharegistro = date("d-m-Y");
    $s7horaregistro  = date('H:i:s');
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
    if ($tipoactividad7 == "Regular") {
        $estadoreg7 = "REGISTRO VALIDO";
    } else if ($tipoactividad7 == "Novedad") {
        $estadoreg7 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad7 == "") {
        $estadoreg7 = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s7_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET    
    s7_fecharegistro= '" . $s7fecharegistro . "',
	s7_horaregistro= '" . $s7horaregistro . "', 
    s7_tipoactividad= '" . $tipoactividad7 . "',
    s7_descripcion= '" . $DescripcionActSem7 . "',
    s7_estadoregistro= '" . $estadoreg7 . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
if (isset($_POST['titulosem8'])) {
    //semana 8

    $s8fecharegistro = date("d-m-Y");
    $s8horaregistro  = date('H:i:s');
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
    if ($tipoactividad8 == "Regular") {
        $estadoreg8 = "REGISTRO VALIDO";
    } else if ($tipoactividad8 == "Novedad") {
        $estadoreg8 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad8 == "") {
        $estadoreg8 = "CONSIGNADOR SIN DEFINIR";
    }

    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s8_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET    
    s8_fecharegistro= '" . $s8fecharegistro . "',
	s8_horaregistro= '" . $s8horaregistro . "', 
    s8_tipoactividad= '" . $tipoactividad8 . "',
    s8_descripcion= '" . $DescripcionActSem8 . "',
    s8_estadoregistro= '" . $estadoreg8 . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
if (isset($_POST['titulosem9'])) {
    //semana 9
    $s9fecharegistro = date("d-m-Y");
    $s9horaregistro  = date('H:i:s');
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
    if ($tipoactividad9 == "Regular") {
        $estadoreg9 = "REGISTRO VALIDO";
    } else if ($tipoactividad9 == "Novedad") {
        $estadoreg9 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad9 == "") {
        $estadoreg9 = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s9_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET    
    s9_fecharegistro= '" . $s9fecharegistro . "',
	s9_horaregistro= '" . $s9horaregistro . "', 
    s9_tipoactividad= '" . $tipoactividad9 . "',
    s9_descripcion= '" . $DescripcionActSem9 . "',
    s9_estadoregistro= '" . $estadoreg9 . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
if (isset($_POST['titulosem10'])) {
    //semana 10
    $s10fecharegistro = date("d-m-Y");
    $s10horaregistro  = date('H:i:s');
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
    if ($tipoactividad10 == "Regular") {
        $estadoreg10 = "REGISTRO VALIDO";
    } else if ($tipoactividad10 == "Novedad") {
        $estadoreg10 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad10 == "") {
        $estadoreg10 = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s10_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET    
    s10_fecharegistro= '" . $s10fecharegistro . "',
	s10_horaregistro= '" . $s10horaregistro . "', 
    s10_tipoactividad= '" . $tipoactividad10 . "',
    s10_descripcion= '" . $DescripcionActSem10 . "',
    s10_estadoregistro= '" . $estadoreg10 . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
if (isset($_POST['titulosem11'])) {
    //semana 11
    $s11fecharegistro = date("d-m-Y");
    $s11horaregistro  = date('H:i:s');
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
    if ($tipoactividad11 == "Regular") {
        $estadoreg11 = "REGISTRO VALIDO";
    } else if ($tipoactividad11 == "Novedad") {
        $estadoreg11 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad11 == "") {
        $estadoreg11 = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s11_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET    
    s11_fecharegistro= '" . $s11fecharegistro . "',
	s11_horaregistro= '" . $s11horaregistro . "', 
    s11_tipoactividad= '" . $tipoactividad11 . "',
    s11_descripcion= '" . $DescripcionActSem11 . "',
    s11_estadoregistro= '" . $estadoreg11 . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
if (isset($_POST['titulosem12'])) {
    //semana 12
    $s12fecharegistro = date("d-m-Y");
    $s12horaregistro  = date('H:i:s');
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
    if ($tipoactividad12 == "Regular") {
        $estadoreg12 = "REGISTRO VALIDO";
    } else if ($tipoactividad12 == "Novedad") {
        $estadoreg12 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad12 == "") {
        $estadoreg12 = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s12_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET    
    s12_fecharegistro= '" . $s12fecharegistro . "',
	s12_horaregistro= '" . $s12horaregistro . "', 
    s12_tipoactividad= '" . $tipoactividad12 . "',
    s12_descripcion= '" . $DescripcionActSem12 . "',
    s12_estadoregistro= '" . $estadoreg12 . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
//
if (isset($_POST['titulosem13'])) {
    //semana 13
    $s13fecharegistro = date("d-m-Y");
    $s13horaregistro  = date('H:i:s');
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
    if ($tipoactividad13 == "Regular") {
        $estadoreg13 = "REGISTRO VALIDO";
    } else if ($tipoactividad13 == "Novedad") {
        $estadoreg13 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad13 == "") {
        $estadoreg13 = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s13_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET    
    s13_fecharegistro= '" . $s13fecharegistro . "',
	s13_horaregistro= '" . $s13horaregistro . "', 
    s13_tipoactividad= '" . $tipoactividad13 . "',
    s13_descripcion= '" . $DescripcionActSem13 . "',
    s13_estadoregistro= '" . $estadoreg13 . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
if (isset($_POST['titulosem14'])) {
    //semana 14
    $s14fecharegistro = date("d-m-Y");
    $s14horaregistro  = date('H:i:s');
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
    if ($tipoactividad14 == "Regular") {
        $estadoreg14 = "REGISTRO VALIDO";
    } else if ($tipoactividad14 == "Novedad") {
        $estadoreg14 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad14 == "") {
        $estadoreg14 = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s14_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET    
    s14_fecharegistro= '" . $s14fecharegistro . "',
	s14_horaregistro= '" . $s14horaregistro . "', 
    s14_tipoactividad= '" . $tipoactividad14 . "',
    s14_descripcion= '" . $DescripcionActSem14 . "',
    s14_estadoregistro= '" . $estadoreg14 . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
if (isset($_POST['titulosem15'])) {
    //semana 15
    $s15fecharegistro = date("d-m-Y");
    $s15horaregistro  = date('H:i:s');
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
    if ($tipoactividad15 == "Regular") {
        $estadoreg15 = "REGISTRO VALIDO";
    } else if ($tipoactividad15 == "Novedad") {
        $estadoreg15 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad15 == "") {
        $estadoreg15 = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s15_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET    
    s15_fecharegistro= '" . $s15fecharegistro . "',
    s15_horaregistro= '" . $s15horaregistro . "',
	s15_tipoactividad= '" . $tipoactividad15 . "',
    s15_descripcion= '" . $DescripcionActSem15 . "',
    s15_estadoregistro= '" . $estadoreg15 . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
////
if (isset($_POST['titulosem16'])) {
    //semana 16

    $s16fecharegistro = date("d-m-Y");
    $s16horaregistro  = date('H:i:s');
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

    if ($tipoactividad16 == "Regular") {
        $estadoreg16 = "REGISTRO VALIDO";
    } else if ($tipoactividad16 == "Novedad") {
        $estadoreg16 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad16 == "") {
        $estadoreg16 = "CONSIGNADOR SIN DEFINIR";
    }

    //comprobar si campo descripcion es vacia//
    //$sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND s16_descripcion='' OR s16_descripcion=NULL";
    $sql = "SELECT * FROM $tablam3 WHERE id = '$codregistro' AND TRIM(s16_descripcion)=''";

    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);


    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET    
    s16_fecharegistro= '" . $s16fecharegistro . "',
    s16_horaregistro= '" . $s16horaregistro . "',
	s16_tipoactividad= '" . $tipoactividad16 . "',
    s16_descripcion= '" . $DescripcionActSem16 . "',
    s16_estadoregistro= '" . $estadoreg16 . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
//
if (isset($_POST['titulosem17'])) {
    //semana 17
    $s17fecharegistro = date("d-m-Y");
    $s17horaregistro  = date('H:i:s');
    //Otros campos
    if (isset($_POST['TipoActividad17'])) {
        $tipoactividad17    = strval($_REQUEST['TipoActividad17']);
    } else {
        $tipoactividad17 = "";
    }
    if (isset($_POST['DescripcionActSem17'])) {
        $DescripcionActSem17         = strval($_REQUEST['DescripcionActSem17']);
    } else {
        $DescripcionActSem17     = "";
    }
    if ($tipoactividad17 == "Regular") {
        $estadoreg17 = "REGISTRO VALIDO";
    } else if ($tipoactividad17 == "Novedad") {
        $estadoreg17 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad17 == "") {
        $estadoreg17 = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s17_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
     SET    
        s17_fecharegistro= '" . $s17fecharegistro . "',
        s17_horaregistro= '" . $s17horaregistro . "',
        s17_tipoactividad= '" . $tipoactividad17 . "',
        s17_descripcion= '" . $DescripcionActSem17 . "',
        s17_estadoregistro= '" . $estadoreg17 . "'
    WHERE id='" . $codregistro . "' 
    ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}

//
if (isset($_POST['titulosem18'])) {
    //semana 18
    $s18fecharegistro = date("d-m-Y");
    $s18horaregistro  = date('H:i:s');
    //Otros campos
    if (isset($_POST['TipoActividad18'])) {
        $tipoactividad18    = strval($_REQUEST['TipoActividad18']);
    } else {
        $tipoactividad18 = "";
    }
    if (isset($_POST['DescripcionActSem18'])) {
        $DescripcionActSem18         = strval($_REQUEST['DescripcionActSem18']);
    } else {
        $DescripcionActSem18     = "";
    }
    if ($tipoactividad18 == "Regular") {
        $estadoreg18 = "REGISTRO VALIDO";
    } else if ($tipoactividad18 == "Novedad") {
        $estadoreg18 = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad18 == "") {
        $estadoreg18 = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s18_descripcion)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
     SET    
        s18_fecharegistro= '" . $s18fecharegistro . "',
        s18_horaregistro= '" . $s18horaregistro . "',
        s18_tipoactividad= '" . $tipoactividad18 . "',
        s18_descripcion= '" . $DescripcionActSem18 . "',
        s18_estadoregistro= '" . $estadoreg18 . "'
    WHERE id='" . $codregistro . "' 
    ");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}

///POSTGRADOS


////****/*/
if (isset($_POST['titulosem1p'])) {
    //semana1 postgrado
    $s1pfecharegistro = date("d-m-Y");
    $s1phoraregistro  = date('H:i:s');
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
    if ($tipoactividad1p == "Regular") {
        $estadoreg1p = "REGISTRO VALIDO";
    } else if ($tipoactividad1p == "Novedad") {
        $estadoreg1p = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad1p == "") {
        $estadoreg1p = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s1_descripcion_p)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET
    s1_fecharegistro_p= '" . $s1pfecharegistro . "',
	s1_horaregistro_p= '" . $s1phoraregistro . "', 
    s1_tipoactividad_p= '" . $tipoactividad1p . "',
    s1_descripcion_p= '" . $DescripcionActSem1p . "',
    s1_estadoregistro_p= '" . $estadoreg1p . "'  
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
//
if (isset($_POST['titulosem2p'])) {
    //semana2 postgrado
    $s2pfecharegistro = date("d-m-Y");
    $s2phoraregistro  = date('H:i:s');
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
    if ($tipoactividad2p == "Regular") {
        $estadoreg2p = "REGISTRO VALIDO";
    } else if ($tipoactividad2p == "Novedad") {
        $estadoreg2p = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad2p == "") {
        $estadoreg2p = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s2_descripcion_p)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET
    s2_fecharegistro_p= '" . $s2pfecharegistro . "',
	s2_horaregistro_p= '" . $s2phoraregistro . "', 
    s2_tipoactividad_p= '" . $tipoactividad2p . "',
    s2_descripcion_p= '" . $DescripcionActSem2p . "',
    s2_estadoregistro_p= '" . $estadoreg2p . "'  
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
if (isset($_POST['titulosem3p'])) {
    //semana3 postgrado
    $s3pfecharegistro = date("d-m-Y");
    $s3phoraregistro  = date('H:i:s');
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
    if ($tipoactividad3p == "Regular") {
        $estadoreg3p = "REGISTRO VALIDO";
    } else if ($tipoactividad3p == "Novedad") {
        $estadoreg3p = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad3p == "") {
        $estadoreg3p = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s3_descripcion_p)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET
    s3_fecharegistro_p= '" . $s3pfecharegistro . "',
	s3_horaregistro_p= '" . $s3phoraregistro . "', 
    s3_tipoactividad_p= '" . $tipoactividad3p . "',
    s3_descripcion_p= '" . $DescripcionActSem3p . "',
    s3_estadoregistro_p= '" . $estadoreg3p . "'  
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
//semana4 postgrado
if (isset($_POST['titulosem4p'])) {

    $s4pfecharegistro = date("d-m-Y");
    $s4phoraregistro  = date('H:i:s');
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
    if ($tipoactividad4p == "Regular") {
        $estadoreg4p = "REGISTRO VALIDO";
    } else if ($tipoactividad4p == "Novedad") {
        $estadoreg4p = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad4p == "") {
        $estadoreg4p = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s4_descripcion_p)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET
    s4_fecharegistro_p= '" . $s4pfecharegistro . "',
	s4_horaregistro_p= '" . $s4phoraregistro . "', 
    s4_tipoactividad_p= '" . $tipoactividad4p . "',
    s4_descripcion_p= '" . $DescripcionActSem4p . "',
    s4_estadoregistro_p= '" . $estadoreg4p . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}
//
if (isset($_POST['titulosem5p'])) {
    //semana5 postgrado
    $s5pfecharegistro = date("d-m-Y");
    $s5phoraregistro  = date('H:i:s');
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
    if ($tipoactividad5p == "Regular") {
        $estadoreg5p = "REGISTRO VALIDO";
    } else if ($tipoactividad5p == "Novedad") {
        $estadoreg5p = "REGISTRO CON NOVEDAD";
    } else if ($tipoactividad5p == "") {
        $estadoreg5p = "CONSIGNADOR SIN DEFINIR";
    }
    //comprobar si campo descripcion es vacia//
    $sql = "SELECT * FROM $tablam3 WHERE id='$codregistro' AND TRIM(s5_descripcion_p)=''";
    $Queryprueba = pg_query($conexion, $sql);
    $numrow = pg_num_rows($Queryprueba);

    if ($numrow == 1) {
        $QueryUpdate = ("UPDATE $tablam3
 SET
    s5_fecharegistro_p= '" . $s5pfecharegistro . "',
	s5_horaregistro_p= '" . $s5phoraregistro . "', 
    s5_tipoactividad_p= '" . $tipoactividad5p . "',
    s5_descripcion_p= '" . $DescripcionActSem5p . "',
    s5_estadoregistro_p= '" . $estadoreg5p . "'
WHERE id='" . $codregistro . "' 
");
        $updateRegistro = pg_query($conexion, $QueryUpdate);
    } else if ($numrow == 0) {
        $updateRegistro = false;
    }
}


if ($updateRegistro && $numrow == 1) {
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
     text: "¡El registro regular YA existe, o no se pudo actualizar!",
     showConfirmButton: true,
     confirmButtonText: "Cerrar"
     }).then(function(result){
        if(result.value){                   
         window.location = "Registro.php";
        }
     });
    </script>';
}
