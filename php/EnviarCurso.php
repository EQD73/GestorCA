<?php
header('Content-Type: application/json');
require('conexion2.php');

$codcurso = $_GET['codigocurso'];
/* $grupo = $_POST['grupo'];
$per = $_POST['per']; */

//* /AND periodo='$per'
/* $sql = "SELECT * FROM sistema.asignaturas WHERE codigo_asignatura='$codcurso'";
$result = pg_query($conexion, $sql);
$objConsulta = pg_fetch_object($result);
//$array=array();

$array = $objConsulta->prerequisito;
//var_dump($array);
print_r($array);
 */

try { // Obtener prerrequisitos desde la tabla prerequisitos
    $stmtPrereq = $pdo->prepare("
                SELECT codigo_prerequisito, nombre_prerequisito 
                FROM sistema.prerequisitos 
                WHERE codigo_asignatura = ?
            ");
    $stmtPrereq->execute([$codcurso]);
    $prerequisitos = $stmtPrereq->fetchAll();

    $asignatura['prerequisitos'] = $prerequisitos;
    echo json_encode(['success' => true, 'data' => $asignatura]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al obtener prerequisitos: ' . $e->getMessage()]);
}
