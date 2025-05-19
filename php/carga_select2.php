<?php
require 'conexion2.php';
header('Content-Type: application/json');
$tipo = $_GET['tipo'] ?? '';
switch ($tipo) {
    case 'docentes':
        $sql = "SELECT codigo_usuario AS id, nomcompleto AS text FROM sistema.usuarios WHERE codigo_rol=2";
        break;
    case 'asignaturas':
        $sql = "SELECT codigo_asignatura AS id, nom_asignatura AS text, semestre FROM sistema.asignaturas";
        break;
    case 'programas':
        $sql = "SELECT codigo_programa AS id, nombre_programa AS text FROM sistema.programas";
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
