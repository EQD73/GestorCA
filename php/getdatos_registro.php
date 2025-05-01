<?php
header('Content-Type: application/json'); // Respuesta en JSON

include('conexion.php');

// Obtener los filtros desde la URL
$periodo = isset($_GET['periodo']) ? pg_escape_string($conexion, $_GET['periodo']) : '';
$codigo_programa = isset($_GET['codigo_programa']) ? pg_escape_string($conexion, $_GET['codigo_programa']) : '';
$codigo_asignatura = isset($_GET['codigo_asignatura']) ? pg_escape_string($conexion, $_GET['codigo_asignatura']) : '';
$semestre = isset($_GET['semestre']) ? pg_escape_string($conexion, $_GET['semestre']) : '';
$grupo = isset($_GET['grupo']) ? pg_escape_string($conexion, $_GET['grupo']) : '';

if (!in_array($codigo_programa, [26, 31, 32, 30])) {
    // Código a ejecutar si codigo_programa es diferente de 26, 31, 32 y 30
    // Construir la consulta base
    $query = "SELECT codigo_docente, nombre_docente, nombre_asignatura, COUNT(*) as total_semanas, 
    SUM(
        (CASE WHEN TRIM(s1_descripcion) != ''  THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s2_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s3_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s4_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s5_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s6_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s7_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s8_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s9_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s10_descripcion) != ''  THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s11_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s12_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s13_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s14_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s15_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s16_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s17_descripcion) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s18_descripcion) != '' THEN 1 ELSE 0 END)
    ) as semanas_diligenciadas
    FROM sistema.m3 WHERE 1=1";
} else {
    $query = "SELECT codigo_docente, nombre_docente, nombre_asignatura, COUNT(*) as total_semanas, 
    SUM(
        (CASE WHEN TRIM(s1_descripcion_p) != ''  THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s2_descripcion_p) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s3_descripcion_p) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s4_descripcion_p) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(s5_descripcion_p) != '' THEN 1 ELSE 0 END)
    ) as semanas_diligenciadas
    FROM sistema.m3 WHERE 1=1";
}

// Agregar filtros dinámicamente
if (!empty($periodo)) {
    $query .= " AND codigo_periodo = '$periodo'";
}
if (!empty($codigo_programa)) {
    $query .= " AND codigo_programa = '$codigo_programa'";
}
if (!empty($codigo_asignatura)) {
    $query .= " AND codigo_asignaturacurso = '$codigo_asignatura'";
}
if (!empty($semestre)) {
    $query .= " AND semestre = '$semestre'";
}
if (!empty($grupo)) {
    $query .= " AND grupo = '$grupo'";
}

$query .= " GROUP BY codigo_docente, nombre_docente, nombre_asignatura ORDER BY semanas_diligenciadas DESC";

$result = pg_query($conexion, $query);

$data = [];
while ($row = pg_fetch_assoc($result)) {
    $data[] = $row;
}

pg_close($conexion);

// Devolver los datos en formato JSON
echo json_encode($data);
