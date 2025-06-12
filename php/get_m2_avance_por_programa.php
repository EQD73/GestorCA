<?php
require_once 'conexion2.php';

$sql = "
SELECT 
  p.nombre_programa,
  ROUND(AVG(avance), 2) AS avance
FROM (
  SELECT 
    m2.codigo_programa,
    CASE 
      WHEN LEFT(m2.codigo_asignatura, 2) IN ('26', '30', '31', '32') THEN
        ROUND((
          SELECT COUNT(*) 
          FROM (
            SELECT unnest(array[
              m2.s1_contenidos_p, m2.s2_contenidos_p, m2.s3_contenidos_p,
              m2.s4_contenidos_p, m2.s5_contenidos_p
            ]) AS contenido
          ) AS unn
          WHERE LENGTH(TRIM(contenido)) > 1
        ) / 18.0 * 100, 2)
      ELSE
        ROUND((
          SELECT COUNT(*) 
          FROM (
            SELECT unnest(array[
              m2.s1_contenidos, m2.s2_contenidos, m2.s3_contenidos,
              m2.s4_contenidos, m2.s5_contenidos, m2.s6_contenidos,
              m2.s7_contenidos, m2.s8_contenidos, m2.s9_contenidos,
              m2.s10_contenidos, m2.s11_contenidos, m2.s12_contenidos,
              m2.s13_contenidos, m2.s14_contenidos, m2.s15_contenidos,
              m2.s16_contenidos, m2.s17_contenidos, m2.s18_contenidos
            ]) AS contenido
          ) AS unn
          WHERE LENGTH(TRIM(contenido)) > 1
        ) / 18.0 * 100, 2)
    END AS avance
  FROM sistema.m2
  WHERE codigo_periodo = '20251'
) sub
JOIN sistema.programas p ON sub.codigo_programa = p.codigo_programa
GROUP BY p.nombre_programa
ORDER BY p.nombre_programa;
";

$stmt = $pdo->query($sql);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
