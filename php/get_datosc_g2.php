<?php
include 'conexion6.php';

$docente = $_POST['docente'];
$periodo = $_POST['periodo'];

$query = "SELECT 
  m2.codigo_asignatura, 
  m2.nombre_asignatura, 
  m2.grupo, 
  m2.nombre_programa, 
  m2.semestre,

  ROUND(
    (
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
    ) / 18.0 * 100
  , 2) AS avance,

  (
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
  ) AS total_semanas,

  m2.fecha_consigna

FROM sistema.m2 m2
WHERE m2.codigo_docente = ?
  AND m2.codigo_periodo = ?";


$stmt = $conn->prepare($query);
$stmt->execute([$docente, $periodo]);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($datos);
