<?php
require 'conexion2.php';
header('Content-Type: application/json');
$tipo = $_GET['tipo'] ?? '';
switch ($tipo) {
    case 'facultads':
        $sql = "SELECT codigo_facultad AS id, nombre_facultad AS text FROM sistema.facultades ORDER BY codigo_facultad ASC";
        break;
    case 'asignaturas':
        $sql = "SELECT codigo_asignatura AS id, nom_asignatura AS text, semestre FROM sistema.asignaturas ORDER BY codigo_asignatura ASC";
        break;
    case 'programas':
        $sql = "SELECT codigo_programa AS id, nombre_programa AS text FROM sistema.programas ORDER BY codigo_programa ASC";
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
