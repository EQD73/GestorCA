<?php

session_start();

if (!isset($_SESSION['codigo_usuario'])) {
    header("Location: ../index.php");
}

$nombre = $_SESSION['nombres'];
$codigo_rol = $_SESSION['codigo_rol'];
$tablam1 = $_SESSION['tablam1'];
$codigo_usuario = $_SESSION['codigo_usuario'];
$anio = $_SESSION['anio'];

//conexiones

include('conexion.php');
include('scriptsweet.php');

$codigocurso     = $_REQUEST['CodigoCur'];
//echo $codigocurso;
$nombrecurso      = $_REQUEST['NombreCurso'];
$codigogrupo        = $_REQUEST['grupo'];
$codigodocente   = $codigo_usuario;
$nombredocente   = strval($_REQUEST['NomDocente']);
$fechaupdate        = $_REQUEST['fechaupdate'];
$anomicro        = $anio;
$codigofacultad     = $_REQUEST['CodFacul'];
$nombrefacultad     = strval($_REQUEST['NombreFacul']);
$semestre        = intval($_REQUEST['semestre']);
$codigoprograma     = $_REQUEST['CodProg'];
$nombreprograma     = $_REQUEST['NombreProg'];
$creditos           = intval($_REQUEST['creditos']);

if (empty($_REQUEST['requisitos'])) {
    $requisitos = '{}';
} else {
    $requisitos      = $_REQUEST['requisitos'];
    var_dump($_REQUEST['requisitos']);
    //print_r($_REQUEST['requisitos']);
    foreach ($requisitos as $t) {
        $t = str_replace('"', '\\"', $t); // escape double quote
        if (!is_numeric($t)) // quote only non-numeric values
            $t = '"' . $t . '"';
        $result[] = $t;
    }

    $valor = '{' . implode(",", $result) . '}'; // format
    $requisitos = $valor;
}
$nivel           = $_REQUEST['NivelRadioOptions'];
$area            = $_REQUEST['AreaRadioOptions'];
$tipo            = $_REQUEST['TipoRadioOptions'];
$modalidad          = $_REQUEST['ModalRadioOptions'];
$tht             = intval($_REQUEST['tht']);
$thti             = intval($_REQUEST['thti']);
$thtp             = intval($_REQUEST['thtp']);
$descripcion        = strval($_REQUEST['DescripcionTextarea1']);
$resul              = strval($_REQUEST['ResultadosTextarea1']);
$estrategia      = strval($_REQUEST['EstrategiaTextarea1']);
$recursos           = strval($_REQUEST['RecursosTextarea1']);
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
    $validador1 = "";
}
if (isset($_POST['validador2'])) {
    $validador2      = strval($REQUEST['validador2']);
} else {
    $validador2 = "";
}

//$validador1      = strval($_REQUEST['validador1']);
//$validador2      = strval($_REQUEST['validador2']);   

//consulta si el curso ya existe en microcurriculo

$sqlSelect = "SELECT * FROM $tablam1 WHERE codigo_asignaturacurso='$codigocurso' AND  grupo='$codigogrupo' AND ano_micro='$anio'";
$resultSelect = pg_query($conexion, $sqlSelect);
$numrow = pg_num_rows($resultSelect);

if ($numrow == 0) {


    $QueryInsert = ("INSERT INTO $tablam1 (
    codigo_asignaturacurso,
    nombre_asignatura,
    grupo,
    ano_micro,
    codigo_docente,
    nombre_docente,
    fecha_actualizacion,
    codigo_facultad,
    nombre_facultad, 
    semestre, 
    codigo_programa,
    nombre_programa, 
    creditos, 
    requisitos,
    nivel_formacion,
    area_formacion, 
    tipo_curso, 
    modalidad, 
    tht,
    thti,
    thtp,
    descripcion_intension, 
    resultados_aprendizaje,
    estrategia_pyd, 
    recursos, 
    u1_hp, 
    u1_hi, 
    u1_cortesemanas,
    u1_resultados, 
    u1_contenidos, 
    u1_actividades, 
    u1_evaluacion,
    u2_hp, 
    u2_hi, 
    u2_cortesemanas, 
    u2_resultados, 
    u2_contenidos, 
    u2_actividades, 
    u2_evaluacion,
    u3_hp, 
    u3_hi, 
    u3_cortesemanas, 
    u3_resultados, 
    u3_contenidos, 
    u3_actividades, 
    u3_evaluacion,
    u4_hp, 
    u4_hi, 
    u4_cortesemanas, 
    u4_resultados, 
    u4_contenidos, 
    u4_actividades, 
    u4_evaluacion,
    u5_hp, 
    u5_hi, 
    u5_cortesemanas, 
    u5_resultados, 
    u5_contenidos, 
    u5_actividades, 
    u5_evaluacion,
    nombre_proyecto,
    proy_asignaturas, 
    proy_tematicas, 
    proy_acciones, 
    ref_biblio, 
    ref_otra, 
    ref_ingles, 
    ref_webgrafia,
    validador1,
    validador2 
)   
VALUES (
    '" . $codigocurso . "',
    '" . $nombrecurso . "',
    '" . $codigogrupo . "',
    '" . $anomicro . "',
    '" . $codigodocente . "',
    '" . $nombredocente . "',
    '" . $fechaupdate . "',
    '" . $codigofacultad . "',
    '" . $nombrefacultad . "',
    '" . $semestre . "',        
    '" . $codigoprograma . "',  
    '" . $nombreprograma . "',
    '" . $creditos . "',        
    '" . $requisitos . "',
    '" . $nivel . "',
    '" . $area . "',            
    '" . $tipo . "',            
    '" . $modalidad . "',    
    '" . $tht . "',
    '" . $thti . "',  
    '" . $thtp . "',          
    '" . $descripcion . "',     
    '" . $resul . "',
    '" . $estrategia . "',      
    '" . $recursos . "',
    '" . $horaspres1 . "',      
    '" . $horasindep1 . "',     
    '" . $cortesem1 . "',
    '" . $u1resultados . "',    
    '" . $u1contenidos . "',    
    '" . $u1actividades . "',   
    '" . $u1sistema . "',
    '" . $horaspres2 . "',      
    '" . $horasindep2 . "',     
    '" . $cortesem2 . "',       
    '" . $u2resultados . "',    
    '" . $u2contenidos . "',    
    '" . $u2actividades . "',   
    '" . $u2sistema . "',
    '" . $horaspres3 . "',            
    '" . $horasindep3 . "',     
    '" . $cortesem3 . "',       
    '" . $u3resultados . "',    
    '" . $u3contenidos . "',    
    '" . $u3actividades . "',   
    '" . $u3sistema . "',
    '" . $horaspres4 . "',            
    '" . $horasindep4 . "',     
    '" . $cortesem4 . "',       
    '" . $u4resultados . "',    
    '" . $u4contenidos . "',    
    '" . $u4actividades . "',   
    '" . $u4sistema . "',
    '" . $horaspres5 . "',            
    '" . $horasindep5 . "',     
    '" . $cortesem5 . "',       
    '" . $u5resultados . "',    
    '" . $u5contenidos . "',    
    '" . $u5actividades . "',   
    '" . $u5sistema . "',
    '" . $nombreproy . "',
    '" . $asignaproy . "',      
    '" . $tematicasproy . "',   
    '" . $accionesproy . "',    
    '" . $referbiblio . "',     
    '" . $referotra . "',       
    '" . $referingles . "',     
    '" . $referweb . "',
    '" . $validador1 . "',
    '" . $validador2 . "'  
    
)");
    $insertMicro = pg_query($conexion, $QueryInsert);

    if ($insertMicro) {
        //echo "registro insertado";
        echo '<script>
    Swal.fire({
     icon: "success",
     title: "Exito...",
     text: "¡Registro Guardado con Exito!",
     showConfirmButton: true,
     confirmButtonText: "Cerrar"
     }).then(function(result){
        if(result.value){                   
         window.location = "Microcurriculo.php";
        }
     });
    </script>';
    } else {

        echo '<script>
    Swal.fire({
     icon: "error",
     title: "Oops...",
     text: "¡Ocurrio un error, el registro no se guardó!",
     showConfirmButton: true,
     confirmButtonText: "Cerrar"
     }).then(function(result){
        if(result.value){                   
         window.location = "Microcurriculo.php";
        }
     });
    </script>';
    }
} else {
    echo '<script>
    Swal.fire({
     icon: "error",
     title: "Oops...",
     text: "¡El microcurriculo  de esta asignatura YA Existe, por favor verifique e ingrese los microcurriculos faltantes",
     showConfirmButton: true,
     confirmButtonText: "Cerrar"
     }).then(function(result){
        if(result.value){                   
         window.location = "Microcurriculo.php";
        }
     });
    </script>';
}


//header("location: agregar_micro.php");
