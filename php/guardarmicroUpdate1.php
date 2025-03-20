<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];
$tablam1=$_SESSION['tablam1'];
$codigo_usuario=$_SESSION['codigo_usuario'];


include('conexion.php');
include('scriptsweet.php');


//$codigocur       = $_REQUEST['CodigoCur'];
//$nombrecurso 	 = $_REQUEST['NombreCurso'];
//$codigogrupo   	 = $_REQUEST['grupo'];
//$codigodocente   = $codigo_usuario;
//$nombredocente   = strval($_REQUEST['NomDocente']);
$codmicro= $_REQUEST['id_micro'];
$fechaupdate   	 = $_REQUEST['fechaupdate'];
//$anomicro        = date("Y",strtotime($_REQUEST['fechaupdate']));
//$codigofacultad	 = $_REQUEST['CodigoFacultad'];
//$nombrefacultad	 = $_REQUEST['NombreFacul'];
//$semestre        = $_REQUEST['semestre'];
//$codigoprograma	 = $_REQUEST['CodigoPrograma'];
//$nombreprograma	 = $_REQUEST['NombreProg'];
//$creditos      	 = intval($_REQUEST['creditos']);
/* if (empty($_REQUEST['requisitos2'])){ 
    $requisitos='null';
}else{
$requisitos      = json_encode($_REQUEST['requisitos2']);} */
if (isset($_POST['NivelRadioOptions'])) {
    $nivel      = $_REQUEST['NivelRadioOptions'];
} else {
    $nivel= "";
}

//$nivel      	 = $_REQUEST['NivelRadioOptions'];
if (isset($_POST['AreaRadioOptions'])) {
    $area     = $_REQUEST['AreaRadioOptions'];
} else {
    $area  = "";
}
//$area       	 = $_REQUEST['AreaRadioOptions'];
if (isset($_POST['TipoRadioOptions'])) {
    $tipo      = $_REQUEST['TipoRadioOptions'];
} else {
    $tipo  = "";
}
//$tipo       	 = $_REQUEST['TipoRadioOptions'];
if (isset($_POST['ModalRadioOptions'])) {
    $modalidad      = $_REQUEST['ModalRadioOptions'];
} else {
    $modalidad  = "";
}
//$modalidad     	 = $_REQUEST['ModalRadioOptions'];
$tht             = intval($_REQUEST['tht']);
$thti             = intval($_REQUEST['thti']);
$thtp             = intval($_REQUEST['thtp']);
$descripcion   	 = strval($_REQUEST['DescripcionTextarea1']);
$resul         	 = strval($_REQUEST['ResultadosTextarea1']); 
$estrategia      = strval($_REQUEST['EstrategiaTextarea1']);
$recursos      	 = strval($_REQUEST['RecursosTextarea1']); 
$horaspres1      = intval($_REQUEST['Unidad1HP']);
$horasindep1     = intval($_REQUEST['Unidad1HI']);
$cortesem1       = intval($_REQUEST['Unidad1CS']);
$u1resultados    = strval($_REQUEST['U1ResultadosTextarea1']);
$u1contenidos    = strval($_REQUEST['U1ContenidosTextarea1']);
$u1actividades   = strval($_REQUEST['U1ActividadesTextarea1']);
$u1sistema       = strval($_REQUEST['U1SistemaTextarea1']);
$horaspres2      = intval($_REQUEST['Unidad2HP']);
$horasindep2     = intval($_REQUEST['Unidad2HI']);
$cortesem2       = intval($_REQUEST['Unidad2CS']);
$u2resultados    = strval($_REQUEST['U2ResultadosTextarea1']);
$u2contenidos    = strval($_REQUEST['U2ContenidosTextarea1']);
$u2actividades   = strval($_REQUEST['U2ActividadesTextarea1']);
$u2sistema       = strval($_REQUEST['U2SistemaTextarea1']);
$horaspres3      = intval($_REQUEST['Unidad3HP']);
$horasindep3     = intval($_REQUEST['Unidad3HI']);
$cortesem3       = intval($_REQUEST['Unidad3CS']);
$u3resultados    = strval($_REQUEST['U3ResultadosTextarea1']);
$u3contenidos    = strval($_REQUEST['U3ContenidosTextarea1']);
$u3actividades   = strval($_REQUEST['U3ActividadesTextarea1']);
$u3sistema       = strval($_REQUEST['U3SistemaTextarea1']);
$horaspres4      = intval($_REQUEST['Unidad4HP']);
$horasindep4    = intval($_REQUEST['Unidad4HI']);
$cortesem4       = intval($_REQUEST['Unidad4CS']);
$u4resultados    = strval($_REQUEST['U4ResultadosTextarea1']);
$u4contenidos    = strval($_REQUEST['U4ContenidosTextarea1']);
$u4actividades   = strval($_REQUEST['U4ActividadesTextarea1']);
$u4sistema       = strval($_REQUEST['U4SistemaTextarea1']);
$horaspres5      = intval($_REQUEST['Unidad5HP']);
$horasindep5    = intval($_REQUEST['Unidad5HI']);
$cortesem5      = intval($_REQUEST['Unidad5CS']);
$u5resultados    = strval($_REQUEST['U5ResultadosTextarea1']);
$u5contenidos    = strval($_REQUEST['U5ContenidosTextarea1']);
$u5actividades   = strval($_REQUEST['U5ActividadesTextarea1']);
$u5sistema       = strval($_REQUEST['U5SistemaTextarea1']);
$nombreproy      = strval($_REQUEST['NombreProy']);
$asignaproy      = strval($_REQUEST['AsignaturaProy']);
$tematicasproy   = strval($_REQUEST['TematicasProy']);
$accionesproy    = strval($_REQUEST['AccionesProy']);
$referbiblio     = strval($_REQUEST['ReferBiblio']);
$referotra       = strval($_REQUEST['ReferOtra']);
$referingles     = strval($_REQUEST['ReferIngles']);
$referweb        = strval($_REQUEST['ReferWebgrafia']); 
if (isset($_POST['validador1'])) {
    $validador1      = strval($REQUEST['validador1']);
} else {
    $validador1= "";
}
if (isset($_POST['validador2'])) {
    $validador2      = strval($REQUEST['validador2']);
} else {
    $validador2= "";
}
//$validador1      = strval($REQUEST['validador1']);
//$validador2      = strval($REQUEST['validador2']);  

$QueryUpdate = ("UPDATE $tablam1
 SET
    fecha_actualizacion ='".$fechaupdate."',
    nivel_formacion     ='" .$nivel. "',
    area_formacion      ='" .$area. "', 
    tipo_curso          ='" .$tipo. "',   
    modalidad           ='" .$modalidad. "',
    tht                 ='" .$tht. "',
    thti                 ='" .$thti. "',
    thtp                 ='" .$thtp. "',
    
    descripcion_intension   ='" .$descripcion. "', 
    resultados_aprendizaje  ='" .$resul. "', 
    estrategia_pyd          ='" .$estrategia. "',
    recursos                ='" .$recursos. "', 
    u1_hp                   ='" .$horaspres1. "',
    u1_hi                   ='" .$horasindep1. "',
    u1_cortesemanas         ='" .$cortesem1. "', 
    u1_resultados           ='" .$u1resultados. "',
    u1_contenidos           ='" .$u1contenidos. "',
    u1_actividades          ='" .$u1actividades. "',
    u1_evaluacion           ='" .$u1sistema. "',
    u2_hp                   ='" .$horaspres2. "', 
    u2_hi                   ='" .$horasindep2. "', 
    u2_cortesemanas         ='" .$cortesem2. "',  
    u2_resultados           ='" .$u2resultados. "', 
    u2_contenidos           ='" .$u2contenidos. "',
    u2_actividades          ='" .$u2actividades. "',  
    u2_evaluacion           ='" .$u2sistema. "', 
    u3_hp                   ='" .$horaspres3. "',
    u3_hi                   ='" .$horasindep3. "',
    u3_cortesemanas         ='" .$cortesem3. "', 
    u3_resultados           ='" .$u3resultados. "',
    u3_contenidos           ='" .$u3contenidos. "', 
    u3_actividades          ='" .$u3actividades. "',
    u3_evaluacion           ='" .$u3sistema. "', 
    u4_hp                   ='" .$horaspres4. "',
    u4_hi                   ='" .$horasindep4. "',
    u4_cortesemanas         ='" .$cortesem4. "', 
    u4_resultados           ='" .$u4resultados. "',
    u4_contenidos           ='" .$u4contenidos. "', 
    u4_actividades          ='" .$u4actividades. "',
    u4_evaluacion           ='" .$u4sistema. "', 
    u5_hp                   ='" .$horaspres5. "',
    u5_hi                   ='" .$horasindep5. "',
    u5_cortesemanas         ='" .$cortesem5. "', 
    u5_resultados           ='" .$u5resultados. "',
    u5_contenidos           ='" .$u5contenidos. "', 
    u5_actividades          ='" .$u5actividades. "',
    u5_evaluacion           ='" .$u5sistema. "',
    nombre_proyecto         ='" .$nombreproy. "', 
    proy_asignaturas        ='" .$asignaproy. "',
    proy_tematicas          ='" .$tematicasproy. "', 
    proy_acciones           ='" .$accionesproy. "',
    ref_biblio              ='" .$referbiblio. "', 
    ref_otra                ='" .$referotra. "', 
    ref_ingles              ='" .$referingles. "', 
    ref_webgrafia           ='" .$referweb. "', 
    validador1              ='" .$validador1. "',
    validador2              ='" .$validador2. "'  
WHERE id='" .$codmicro. "' 
");

$updateMicro = pg_query($conexion, $QueryUpdate);


if ($updateMicro){
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
         window.location = "Microcurriculo.php";
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
         window.location = "Microcurriculo.php";
        }
     });
    </script>';
    
}

//header("location: consultar_micro.php"); 
?>
