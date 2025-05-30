<?php
require 'conexion2.php';
header('Content-Type: application/json');
$tipo = $_GET['tipo'] ?? '';
switch ($tipo) {
    case 'docentes':
        $sql = "SELECT codigo_usuario AS id, nomcompleto AS text FROM sistema.usuarios WHERE codigo_rol=2 ORDER BY nomcompleto";
        break;
    case 'asignaturas':
        $sql = "SELECT a.codigo_asignatura AS id, a.nom_asignatura AS text, p.semestre FROM sistema.asignaturas a
        INNER JOIN sistema.pensum p ON p.codigo_asignatura = a.codigo_asignatura ORDER BY a.codigo_asignatura";
        break;
    case 'programas':
        $sql = "SELECT codigo_programa AS id, nombre_programa AS text FROM sistema.programas ORDER BY codigo_programa";
        break;
    case 'periodos':
        $sql = "SELECT codigo_periodo AS id, nombre_periodo AS text FROM sistema.periodos ORDER BY codigo_periodo DESC";
        break;
    default:
        echo json_encode([]);
        exit;
}
try {
    $stmt = $pdo->query($sql);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
