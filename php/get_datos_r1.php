<?php
include 'conexion2.php';

$ano             = $_POST['ano'] ?? '';
$programa        = $_POST['programa'] ?? '';
$nombre_programa = $_POST['nombrePrograma'] ?? 'Sin datos';
$asignatura      = $_POST['asignatura'] ?? '';
$semestre        = $_POST['semestre'] ?? '';

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
   
    CASE 
        WHEN (
            (CASE WHEN LENGTH(TRIM(m1.u1_resultados)) > 1 THEN 1 ELSE 0 END) +
            (CASE WHEN LENGTH(TRIM(m1.u2_resultados)) > 1 THEN 1 ELSE 0 END) +
            (CASE WHEN LENGTH(TRIM(m1.u3_resultados)) > 1 THEN 1 ELSE 0 END) +
            (CASE WHEN LENGTH(TRIM(m1.u4_resultados)) > 1 THEN 1 ELSE 0 END) +
            (CASE WHEN LENGTH(TRIM(m1.u5_resultados)) > 1 THEN 1 ELSE 0 END)
        ) >= 3 
        THEN 100.0
        ELSE ROUND(
            (
                (CASE WHEN LENGTH(TRIM(m1.u1_resultados)) > 1 THEN 1 ELSE 0 END) +
                (CASE WHEN LENGTH(TRIM(m1.u2_resultados)) > 1 THEN 1 ELSE 0 END) +
                (CASE WHEN LENGTH(TRIM(m1.u3_resultados)) > 1 THEN 1 ELSE 0 END) +
                (CASE WHEN LENGTH(TRIM(m1.u4_resultados)) > 1 THEN 1 ELSE 0 END) +
                (CASE WHEN LENGTH(TRIM(m1.u5_resultados)) > 1 THEN 1 ELSE 0 END)
            ) / 3.0 * 100, 2
        )
    END AS avance

FROM sistema.pensum p
LEFT JOIN sistema.m1 m1 ON m1.codigo_asignaturacurso = p.codigo_asignatura AND m1.ano_micro = ?
$join_extra
LEFT JOIN sistema.programas pr ON pr.codigo_programa = COALESCE(m1.codigo_programa, p.codigo_programa)
WHERE 1=1
$filters
ORDER BY p.codigo_programa, p.codigo_asignatura, p.semestre
";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($datos);
