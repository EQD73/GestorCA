<?php
header('Content-Type: application/json');
include 'conexion2.php';

$periodo    = $_POST['periodo'] ?? '';
$programa   = $_POST['programa'] ?? '';
$semestre   = $_POST['semestre'] ?? '';
$asignatura = $_POST['asignatura'] ?? '';
$grupo      = $_POST['grupo'] ?? '';

if (!$periodo || !$programa) {
    echo json_encode(['error' => 'Faltan filtros obligatorios.']);
    exit;
}

// 1. Obtener las asignaturas del pensum con filtros dinámicos
$sqlPensum = "SELECT codigo_asignatura FROM sistema.pensum WHERE codigo_programa = :programa";
$params = [':programa' => $programa];

if (!empty($semestre)) {
    $sqlPensum .= " AND semestre = :semestre";
    $params[':semestre'] = $semestre;
}
if (!empty($asignatura)) {
    $sqlPensum .= " AND codigo_asignatura = :asignatura";
    $params[':asignatura'] = $asignatura;
}

$stmt = $pdo->prepare($sqlPensum);
$stmt->execute($params);
$asignaturas = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (empty($asignaturas)) {
    echo json_encode(['error' => 'No hay asignaturas válidas para esos filtros.']);
    exit;
}

// 2. Buscar registros en m2 de esas asignaturas para el periodo y programa
$inQuery = implode(',', array_fill(0, count($asignaturas), '?'));

$sqlM2 = "SELECT codigo_asignatura, grupo, nombre_asignatura, nombre_docente,
          s1_contenidos, s2_contenidos, s3_contenidos, s4_contenidos, s5_contenidos,
          s6_contenidos, s7_contenidos, s8_contenidos, s9_contenidos, s10_contenidos,
          s11_contenidos, s12_contenidos, s13_contenidos, s14_contenidos, s15_contenidos,
          s16_contenidos, s17_contenidos, s18_contenidos
          FROM sistema.m2 
          WHERE codigo_periodo = ? AND codigo_programa = ? 
          AND codigo_asignatura IN ($inQuery)";

$paramsM2 = array_merge([$periodo, $programa], $asignaturas);

if (!empty($grupo)) {
    $sqlM2 .= " AND grupo = ?";
    $paramsM2[] = $grupo;
}

$stmtM2 = $pdo->prepare($sqlM2);
$stmtM2->execute($paramsM2);

$data = [];

while ($row = $stmtM2->fetch(PDO::FETCH_ASSOC)) {
    $conteo = 0;
    for ($i = 1; $i <= 18; $i++) {
        $campo = "s{$i}_contenidos";
        if (!empty($row[$campo])) {
            $conteo++;
        }
    }

    $data[] = [
        'docente'    => $row['nombre_docente'],
        'asignatura' => $row['nombre_asignatura'],
        'semanas'    => $conteo
    ];
}

echo json_encode($data);
