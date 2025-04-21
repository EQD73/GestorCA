<?php
include("conexion.php");

$programa = $_POST['programa'] ?? '';
$periodo = $_POST['periodo'] ?? '';

if (!empty($programa)) {
    $query = "SELECT codigo_asignatura, nombre_asignatura FROM sistema.m3 WHERE codigo_programa = '$programa' AND codigo_periodo = '$periodo' ORDER BY codigo_asignatura";
    $result = pg_query($conexion, $query);

    echo '<option value="">Todas</option>';
    while ($row = pg_fetch_assoc($result)) {
        echo '<option value="' . $row['codigo_asignatura'] . '">' . $row['codigo_asignatura'] . ' - ' . $row['nombre_asignatura'] . '</option>';
    }
}
