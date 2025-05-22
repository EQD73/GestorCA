<?php
include 'conexion2.php';

$periodo         = $_POST['periodo'] ?? '';
$programa        = $_POST['programa'] ?? '';
$asignatura      = $_POST['asignatura'] ?? '';
$semestre        = $_POST['semestre'] ?? '';
$grupo           = $_POST['grupo'] ?? '';


$params = [$periodo]; // periodo

$filters = "";
$join_extra = "";

if (!empty($programa)) {
    $join_extra .= " AND m2.codigo_programa = ?";
    $params[] = $programa;

    $filters .= " AND p.codigo_programa = ?";
    $params[] = $programa;
}

if (!empty($asignatura)) {
    $filters .= " AND p.codigo_asignatura = ?";
    $params[] = $asignatura;
}

if (!empty($semestre)) {
    $filters .= " AND p.semestre = ?";
    $params[] = $semestre;
}

if (!empty($grupo)) {
    $filters .= " AND m2.grupo = ?";
    $params[] = $grupo;
}

if (!in_array($programa, [26, 31, 32, 30])) {
    $query = "
SELECT 
    p.codigo_asignatura,
    p.nom_asignatura,
    COALESCE(CAST(m2.grupo AS TEXT), 'Sin datos') AS grupo,
    COALESCE(m2.codigo_programa, p.codigo_programa) AS codigo_programa,
    COALESCE(m2.semestre, p.semestre) AS semestre,
    COALESCE(m2.codigo_docente, 'Sin datos') AS codigo_docente,
    COALESCE(m2.nombre_docente, 'Sin datos') AS nombre_docente,
    COALESCE(TO_CHAR(m2.fecha_consigna, 'YYYY-MM-DD'), 'Sin datos') AS fecha_consigna,
    pr.nombre_programa, 
   
    SUM(
        (CASE WHEN TRIM(s1_contenidos) != ''  THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s2_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s3_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s4_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s5_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s6_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s7_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s8_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s9_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s10_contenidos) != ''  THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s11_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s12_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s13_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s14_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s15_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s16_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s17_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s18_contenidos) != '' THEN 1 ELSE 0 END)
    ) as semanas_diligenciadas

FROM sistema.pensum p
LEFT JOIN sistema.m2 m2 ON m2.codigo_asignatura = p.codigo_asignatura AND m2.codigo_periodo = ?
$join_extra
LEFT JOIN sistema.programas pr ON pr.codigo_programa = COALESCE(m2.codigo_programa, p.codigo_programa)
WHERE 1=1
$filters
GROUP BY 
    p.codigo_asignatura,
    p.nom_asignatura,
    m2.grupo,
    m2.codigo_programa,
    p.codigo_programa,
    m2.semestre,
    p.semestre,
    m2.codigo_docente,
    m2.nombre_docente,
    m2.fecha_consigna,
    pr.nombre_programa
ORDER BY p.codigo_programa, p.codigo_asignatura, p.semestre
";
} else {
    $query = "
SELECT 
    p.codigo_asignatura,
    p.nom_asignatura,
    COALESCE(CAST(m2.grupo AS TEXT), 'Sin datos') AS grupo,
    COALESCE(m2.codigo_programa, p.codigo_programa) AS codigo_programa,
    COALESCE(m2.semestre, p.semestre) AS semestre,
    COALESCE(m2.codigo_docente, 'Sin datos') AS codigo_docente,
    COALESCE(m2.nombre_docente, 'Sin datos') AS nombre_docente,
    COALESCE(TO_CHAR(m2.fecha_consigna, 'YYYY-MM-DD'), 'Sin datos') AS fecha_consigna,
    pr.nombre_programa, 
   
    SUM(
        (CASE WHEN TRIM(s1_contenidos_p) != ''  THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s2_contenidos_p) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s3_contenidos_p) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s4_contenidos_p) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s5_contenidos_p) != '' THEN 1 ELSE 0 END)
    ) as semanas_diligenciadas

FROM sistema.pensum p
LEFT JOIN sistema.m2 m2 ON m2.codigo_asignatura = p.codigo_asignatura AND m2.codigo_periodo = ?
$join_extra
LEFT JOIN sistema.programas pr ON pr.codigo_programa = COALESCE(m2.codigo_programa, p.codigo_programa)
WHERE 1=1
$filters
GROUP BY 
    p.codigo_asignatura,
    p.nom_asignatura,
    m2.grupo,
    m2.codigo_programa,
    p.codigo_programa,
    m2.semestre,
    p.semestre,
    m2.codigo_docente,
    m2.nombre_docente,
    m2.fecha_consigna,
    pr.nombre_programa
ORDER BY p.codigo_programa, p.codigo_asignatura, p.semestre
";
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($datos);
