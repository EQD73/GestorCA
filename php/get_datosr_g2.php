<?php
include 'conexion6.php';

$docente = $_POST['docente'];
$periodo = $_POST['periodo'];

$query = "SELECT 
  m3.codigo_asignatura, 
  m3.nombre_asignatura, 
  m3.grupo, 
  m3.nombre_programa, 
  m3.semestre,

  ROUND(
    (
      SELECT COUNT(*) 
      FROM (
        SELECT unnest(array[
          m3.s1_descripcion, m3.s2_descripcion, m3.s3_descripcion,
          m3.s4_descripcion, m3.s5_descripcion, m3.s6_descripcion,
          m3.s7_descripcion, m3.s8_descripcion, m3.s9_descripcion,
          m3.s10_descripcion, m3.s11_descripcion, m3.s12_descripcion,
          m3.s13_descripcion, m3.s14_descripcion, m3.s15_descripcion,
          m3.s16_descripcion, m3.s17_descripcion, m3.s18_descripcion
        ]) AS contenido
      ) AS unn
      WHERE LENGTH(TRIM(contenido)) > 1
    ) / 18.0 * 100
  , 2) AS avance,

  (
    SELECT COUNT(*) 
    FROM (
      SELECT unnest(array[
        m3.s1_descripcion, m3.s2_descripcion, m3.s3_descripcion,
        m3.s4_descripcion, m3.s5_descripcion, m3.s6_descripcion,
        m3.s7_descripcion, m3.s8_descripcion, m3.s9_descripcion,
        m3.s10_descripcion, m3.s11_descripcion, m3.s12_descripcion,
        m3.s13_descripcion, m3.s14_descripcion, m3.s15_descripcion,
        m3.s16_descripcion, m3.s17_descripcion, m3.s18_descripcion
      ]) AS contenido
    ) AS unn
    WHERE LENGTH(TRIM(contenido)) > 1
  ) AS total_semanas,

  m3.fecha_registro

FROM sistema.m3 m3
WHERE m3.codigo_docente = ?
  AND m3.codigo_periodo = ?";


$stmt = $conn->prepare($query);
$stmt->execute([$docente, $periodo]);
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($datos);
