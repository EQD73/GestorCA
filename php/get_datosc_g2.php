<?php
header('Content-Type: application/json');
include('conexion2.php');

$docente = $_POST['docente'] ?? '';
$periodo = $_POST['periodo'] ?? '';

$params = [$periodo, $docente, $periodo];

$query = "SELECT 
  p.codigo_asignatura,
  p.nom_asignatura,
  COALESCE(CAST(m2.grupo AS TEXT), 'Sin datos') AS grupo,
  COALESCE(m2.codigo_programa, p.codigo_programa) AS codigo_programa,
  COALESCE(m2.semestre, p.semestre) AS semestre,
  COALESCE(m2.codigo_docente, 'Sin datos') AS codigo_docente,
  COALESCE(m2.nombre_docente, 'Sin datos') AS nombre_docente,
  COALESCE(TO_CHAR(m2.fecha_consigna, 'YYYY-MM-DD'), 'Sin datos') AS fecha_consigna,
  pr.nombre_programa,
  ROUND(
    (
      SELECT COUNT(*) 
      FROM (
        SELECT unnest(
          CASE 
            WHEN LEFT(p.codigo_asignatura, 2) IN ('26', '30', '31', '32') THEN
              array[
                m2.s1_contenidos_p, m2.s2_contenidos_p, m2.s3_contenidos_p,
                m2.s4_contenidos_p, m2.s5_contenidos_p
              ]
            ELSE
              array[
                m2.s1_contenidos, m2.s2_contenidos, m2.s3_contenidos,
                m2.s4_contenidos, m2.s5_contenidos, m2.s6_contenidos,
                m2.s7_contenidos, m2.s8_contenidos, m2.s9_contenidos,
                m2.s10_contenidos, m2.s11_contenidos, m2.s12_contenidos,
                m2.s13_contenidos, m2.s14_contenidos, m2.s15_contenidos,
                m2.s16_contenidos, m2.s17_contenidos, m2.s18_contenidos
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
              m2.s1_contenidos_p, m2.s2_contenidos_p, m2.s3_contenidos_p,
              m2.s4_contenidos_p, m2.s5_contenidos_p
            ]
          ELSE
            array[
              m2.s1_contenidos, m2.s2_contenidos, m2.s3_contenidos,
              m2.s4_contenidos, m2.s5_contenidos, m2.s6_contenidos,
              m2.s7_contenidos, m2.s8_contenidos, m2.s9_contenidos,
              m2.s10_contenidos, m2.s11_contenidos, m2.s12_contenidos,
              m2.s13_contenidos, m2.s14_contenidos, m2.s15_contenidos,
              m2.s16_contenidos, m2.s17_contenidos, m2.s18_contenidos
            ]
        END
      ) AS contenido
    ) AS unn
    WHERE LENGTH(TRIM(contenido)) > 1
  ) AS total_semanas

FROM sistema.pensum p
LEFT JOIN sistema.m2 m2 
  ON m2.codigo_asignatura = p.codigo_asignatura AND m2.codigo_periodo = ?
LEFT JOIN sistema.programas pr 
  ON pr.codigo_programa = COALESCE(m2.codigo_programa, p.codigo_programa)
WHERE m2.codigo_docente = ? AND m2.codigo_periodo = ?";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($datos);
