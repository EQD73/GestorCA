<?php
require 'conexion2.php';
header('Content-Type: application/json');

$tipo = $_GET['tipo'] ?? '';
$valoresValidos = ['prerequisitos', 'asignaturas', 'programas'];

if (!in_array($tipo, $valoresValidos)) {
    echo json_encode([]);
    exit;
}

switch ($tipo) {
    case 'prerequisitos':
    case 'asignaturas':
        $sql = "SELECT codigo_asignatura AS id, nom_asignatura AS text FROM sistema.asignaturas ORDER BY codigo_asignatura";
        break;
    case 'programas':
        $sql = "SELECT codigo_programa AS id, nombre_programa AS text FROM sistema.programas";
        break;
}

try {
    $stmt = $pdo->query($sql);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
