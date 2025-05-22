<?php
include 'conexion.php';

$codigo_programa = $_GET['codigo_programa'] ?? '';

if (!empty($codigo_programa)) {
    $query = "SELECT codigo_asignatura, nom_asignatura FROM asignaturas WHERE codigo_programa = $1 ORDER BY codigo_asignatura";
    $result = pg_query_params($conexion, $query, [$codigo_programa]);

    $asignaturas = [];
    while ($row = pg_fetch_assoc($result)) {
        $asignaturas[] = $row;
    }

    echo json_encode($asignaturas);
}
