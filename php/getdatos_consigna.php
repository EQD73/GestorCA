<?php
header('Content-Type: application/json'); // Respuesta en JSON

include('conexion2.php');

// Obtener los filtros desde la URL
$periodo = $_GET['periodo'] ?? '';
$codigo_programa = $_GET['codigo_programa'] ?? '';
$codigo_asignatura = $_GET['codigo_asignatura'] ?? '';
$semestre = $_GET['semestre'] ?? '';
$grupo = $_GET['grupo'] ?? '';

$params = [$periodo]; // periodo como primer parámetro
$filters = "";
$join_conditions = "m2.codigo_asignatura = p.codigo_asignatura AND m2.codigo_periodo = ?";

// Aplicar filtros
if (!empty($codigo_programa)) {
    $join_conditions .= " AND m2.codigo_programa = ?";
    $params[] = $codigo_programa;

    $filters .= " AND p.codigo_programa = ?";
    $params[] = $codigo_programa;
}

if (!empty($codigo_asignatura)) {
    $filters .= " AND p.codigo_asignatura = ?";
    $params[] = $codigo_asignatura;
}

if (!empty($semestre)) {
    $filters .= " AND p.semestre = ?";
    $params[] = $semestre;
}

if (!empty($grupo)) {
    $filters .= " AND m2.grupo = ?";
    $params[] = $grupo;
}

if (!in_array($codigo_programa, [26, 31, 32, 30])) {
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
        (CASE WHEN TRIM(s1_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s2_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s3_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s4_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s5_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s6_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s7_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s8_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s9_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s10_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s11_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s12_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s13_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s14_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s15_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s16_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s17_contenidos) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s18_contenidos) != '' THEN 1 ELSE 0 END)
    ) AS semanas_diligenciadas
FROM sistema.pensum p
LEFT JOIN sistema.m2 m2 ON $join_conditions
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
        (CASE WHEN TRIM(s1_contenidos_p) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s2_contenidos_p) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s3_contenidos_p) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s4_contenidos_p) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s5_contenidos_p) != '' THEN 1 ELSE 0 END)
    ) AS semanas_diligenciadas
FROM sistema.pensum p
LEFT JOIN sistema.m2 m2 ON $join_conditions
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

// Ejecutar y retornar datos
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($datos);
