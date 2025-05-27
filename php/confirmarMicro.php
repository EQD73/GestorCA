<!-- 
session_start();

include ('conexion.php');
$tablam1=$_SESSION['tablam1'];
$anio=strval($_SESSION['anio']);
$codcurso=$_REQUEST['codasig'];
$codgrupo=$_REQUEST['codgrup'];


$sql="SELECT * FROM $tablam1 WHERE codigo_asignaturacurso='$codcurso' AND grupo='$codgrupo' AND ano_micro='$anio'";
$query=pg_query($conexion,$sql);
$numrow=pg_num_rows($query);



if($numrow>0){
    
    $data=null;
    
}
print json_encode($data);
?> -->

<?php
session_start();
include('conexion.php');

$tablam1 = $_SESSION['tablam1'] ?? '';
$anio = $_SESSION['anio'] ?? '';
$codcurso = $_REQUEST['codasig'] ?? '';
$codgrupo = $_REQUEST['codgrup'] ?? '';

$response = [
    'success' => false,
    'exists' => false,
    'error' => null
];

// Validar datos antes de ejecutar la consulta
if ($tablam1 && $anio && $codcurso && $codgrupo) {
    // Evitar inyección SQL usando pg_escape_string
    $tabla = preg_replace('/[^a-zA-Z0-9_]/', '', $tablam1); // limpiar nombre de tabla
    $anio = pg_escape_string($conexion, $anio);
    $codcurso = pg_escape_string($conexion, $codcurso);
    $codgrupo = pg_escape_string($conexion, $codgrupo);

    $sql = "SELECT 1 FROM $tabla WHERE codigo_asignaturacurso='$codcurso' AND grupo='$codgrupo' AND ano_micro='$anio' LIMIT 1";
    $query = pg_query($conexion, $sql);

    if ($query) {
        $response['success'] = true;
        $response['exists'] = pg_num_rows($query) > 0;
    } else {
        $response['error'] = pg_last_error($conexion);
    }
} else {
    $response['error'] = 'Parámetros incompletos';
}

header('Content-Type: application/json');
echo json_encode($response);
?>