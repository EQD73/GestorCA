<?php
include("conexion.php");

$programa = $_POST['programa'] ?? '';
$periodo = $_POST['periodo'] ?? '';

if (!empty($programa)) {
    $query = "SELECT codigo_asignaturacurso, nombre_asignatura FROM sistema.m1 WHERE codigo_programa = '$programa' AND ano_micro = '$periodo' ORDER BY codigo_asignaturacurso";
    //query = "SELECT codigo_asignaturacurso, nombre_asignatura FROM sistema.m1 WHERE codigo_programa = '$programa'  AND ano_micro = '$periodo' ORDER BY codigo_asignaturacurso";
    $result = pg_query($conexion, $query);

    echo '<option value="">Todas</option>';
    while ($row = pg_fetch_assoc($result)) {
        echo '<option value="' . $row['codigo_asignaturacurso'] . '">' . $row['codigo_asignaturacurso'] . ' - ' . $row['nombre_asignatura'] . '</option>';
    }
}
