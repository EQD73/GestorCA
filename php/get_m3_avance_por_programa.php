<?php
session_start();
require_once 'conexion2.php';

//$periodo = '20251';
$periodo = $_SESSION['codigo_periodo'];

$sql = "
SELECT p.nombre_programa,
ROUND(AVG((
  SELECT COUNT(*) 
  FROM (
    SELECT unnest(
      CASE 
        WHEN LEFT(m3.codigo_asignatura, 2) IN ('26', '30', '31', '32') THEN
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
) / 18.0 * 100), 2) AS avance
FROM sistema.m3 m3
JOIN sistema.programas p ON m3.codigo_programa = p.codigo_programa 
WHERE m3.codigo_periodo = :periodo
GROUP BY p.nombre_programa
ORDER BY p.nombre_programa
";

$stmt = $pdo->prepare($sql);
$stmt->execute(['periodo' => $periodo]);

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
