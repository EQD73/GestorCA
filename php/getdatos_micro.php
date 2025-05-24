<?php
header('Content-Type: application/json'); // Respuesta en JSON

include('conexion2.php');

// Obtener los filtros desde la URL
$ano             = $_GET['ano_micro'] ?? '';
$programa        = $_GET['codigo_programa'] ?? '';
//$nombre_programa = $_GET['nombrePrograma'] ?? 'Sin datos';
$asignatura      = $_GET['codigo_asignaturacurso'] ?? '';
$semestre        = $_GET['semestre'] ?? '';


$params = [$ano]; // ano_micro van primero

$filters = "";
$join_extra = "";

if (!empty($programa)) {
    $join_extra .= " AND m1.codigo_programa = ?";
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

$query = "
SELECT 
    p.codigo_asignatura AS codigo_asignaturacurso,
    p.nom_asignatura,
    COALESCE(CAST(m1.grupo AS TEXT), 'Sin datos') AS grupo,
    COALESCE(m1.codigo_programa, p.codigo_programa) AS codigo_programa,
    COALESCE(m1.semestre, p.semestre) AS semestre,
    COALESCE(m1.codigo_docente, 'Sin datos') AS codigo_docente,
    COALESCE(m1.nombre_docente, 'Sin datos') AS nombre_docente,
    COALESCE(TO_CHAR(m1.fecha_actualizacion, 'YYYY-MM-DD'), 'Sin datos') AS fecha_actualizacion,
    pr.nombre_programa, 
   
    SUM(
        (CASE WHEN TRIM(u1_resultados) != ''  THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(u2_resultados) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(u3_resultados) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(u4_resultados) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(u5_resultados) != '' THEN 1 ELSE 0 END)
    ) as unidades_diligenciadas

FROM sistema.pensum p
LEFT JOIN sistema.m1 m1 ON m1.codigo_asignaturacurso = p.codigo_asignatura AND m1.ano_micro = ?
$join_extra
LEFT JOIN sistema.programas pr ON pr.codigo_programa = COALESCE(m1.codigo_programa, p.codigo_programa)
WHERE 1=1
$filters
GROUP BY 
    p.codigo_asignatura, 
    p.nom_asignatura, 
    m1.grupo, 
    m1.codigo_programa, 
    p.codigo_programa, 
    m1.semestre, 
    p.semestre, 
    m1.codigo_docente, 
    m1.nombre_docente, 
    m1.fecha_actualizacion, 
    pr.nombre_programa

ORDER BY p.codigo_programa, p.codigo_asignatura, p.semestre
";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($datos);
