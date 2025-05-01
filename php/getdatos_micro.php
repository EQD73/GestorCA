<?php
header('Content-Type: application/json'); // Respuesta en JSON

include('conexion.php');

// Obtener los filtros desde la URL
$ano_micro = isset($_GET['ano_micro']) ? pg_escape_string($conexion, $_GET['ano_micro']) : '';
$codigo_programa = isset($_GET['codigo_programa']) ? pg_escape_string($conexion, $_GET['codigo_programa']) : '';
$codigo_asignaturacurso = isset($_GET['codigo_asignaturacurso']) ? pg_escape_string($conexion, $_GET['codigo_asignaturacurso']) : '';
$semestre = isset($_GET['semestre']) ? pg_escape_string($conexion, $_GET['semestre']) : '';

// Construir la consulta base
$query = "SELECT codigo_docente, nombre_docente, nombre_asignatura, COUNT(*) as total_unidades, 
    SUM(
        (CASE WHEN TRIM(u1_resultados) != ''  THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(u2_resultados) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(u3_resultados) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(u4_resultados) != '' THEN 1 ELSE 0 END) +
        (CASE WHEN TRIM(u5_resultados) != '' THEN 1 ELSE 0 END)
    ) as unidades_diligenciadas
    FROM sistema.m1 WHERE 1=1";

// Agregar filtros dinámicamente
if (!empty($ano_micro)) {
    $query .= " AND ano_micro = '$ano_micro'";
}
if (!empty($codigo_programa)) {
    $query .= " AND codigo_programa = '$codigo_programa'";
}
if (!empty($codigo_asignaturacurso)) {
    $query .= " AND codigo_asignaturacurso = '$codigo_asignaturacurso'";
}
if (!empty($semestre)) {
    $query .= " AND semestre = '$semestre'";
}

$query .= " GROUP BY codigo_docente, nombre_docente, nombre_asignatura ORDER BY unidades_diligenciadas DESC";

$result = pg_query($conexion, $query);

$data = [];
while ($row = pg_fetch_assoc($result)) {
    $data[] = $row;
}

pg_close($conexion);

// Devolver los datos en formato JSON
echo json_encode($data);
