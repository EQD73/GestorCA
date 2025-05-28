<?php
header('Content-Type: application/json');
include('conexion2.php');

$docente = $_POST['docente'] ?? '';
$periodo = $_POST['periodo'] ?? '';

$query = "SELECT 
    p.codigo_asignatura,
    p.nom_asignatura,
    COALESCE(CAST(m3.grupo AS TEXT), 'Sin datos') AS grupo,
    COALESCE(m3.codigo_programa, p.codigo_programa) AS codigo_programa,
    COALESCE(m3.semestre, p.semestre) AS semestre,
    COALESCE(m3.codigo_docente, 'Sin datos') AS codigo_docente,
    COALESCE(m3.nombre_docente, 'Sin datos') AS nombre_docente,
    COALESCE(TO_CHAR(m3.fecha_registro, 'YYYY-MM-DD'), 'Sin datos') AS fecha_registro,
    pr.nombre_programa, 
    ROUND(
        (
            SELECT COUNT(*) 
            FROM (
                SELECT unnest(
                    CASE 
                        WHEN LEFT(p.codigo_asignatura, 2) IN ('26', '30', '31', '32') THEN
                            array[
                                m3.s1_descripcion_p, m3.s2_descripcion_p, m3.s3_descripcion_p,
                                m3.s4_descripcion_p, m3.s5_descripcion_p
                            ]
                        ELSE
                            array[
                                m3.s1_descripcion, m3.s2_descripcion, m3.s3_descripcion,
                                m3.s4_descripcion, m3.s5_descripcion, m3.s6_descripcion,
                                m3.s7_descripcion, m3.s8_descripcion, m3.s9_descripcion,
                                m3.s10_descripcion, m3.s11_descripcion, m3.s12_descripcion,
                                m3.s13_descripcion, m3.s14_descripcion, m3.s15_descripcion,
                                m3.s16_descripcion, m3.s17_descripcion, m3.s18_descripcion
                            ]
                    END
                ) AS contenido
            ) AS unn
            WHERE LENGTH(TRIM(contenido)) > 1
        ) / 18.0 * 100
    , 2) AS avance,

    (
        SELECT COUNT(*) 
        FROM (
            SELECT unnest(
                CASE 
                    WHEN LEFT(p.codigo_asignatura, 2) IN ('26', '30', '31', '32') THEN
                        array[
                            m3.s1_descripcion_p, m3.s2_descripcion_p, m3.s3_descripcion_p,
                            m3.s4_descripcion_p, m3.s5_descripcion_p
                        ]
                    ELSE
                        array[
                            m3.s1_descripcion, m3.s2_descripcion, m3.s3_descripcion,
                            m3.s4_descripcion, m3.s5_descripcion, m3.s6_descripcion,
                            m3.s7_descripcion, m3.s8_descripcion, m3.s9_descripcion,
                            m3.s10_descripcion, m3.s11_descripcion, m3.s12_descripcion,
                            m3.s13_descripcion, m3.s14_descripcion, m3.s15_descripcion,
                            m3.s16_descripcion, m3.s17_descripcion, m3.s18_descripcion
                        ]
                END
            ) AS contenido
        ) AS unn
        WHERE LENGTH(TRIM(contenido)) > 1
    ) AS total_semanas
 

FROM sistema.pensum p
JOIN sistema.m3 m3 ON m3.codigo_asignatura = p.codigo_asignatura
LEFT JOIN sistema.programas pr ON pr.codigo_programa = COALESCE(m3.codigo_programa, p.codigo_programa)
WHERE m3.codigo_docente = ?
  AND m3.codigo_periodo = ?";

$stmt = $pdo->prepare($query);
$stmt->execute([$docente, $periodo]);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($datos);
