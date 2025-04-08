<?php
include 'conexion.php'; // tu conexión a PostgreSQL

$codigo = $_POST['codigo_docente'] ?? '';

if ($codigo != '') {
    $sql = "SELECT nomcompleto FROM sistema.usuarios WHERE codigo_usuario = $1 LIMIT 1";
    $result = pg_query_params($conexion, $sql, array($codigo));

    if ($row = pg_fetch_assoc($result)) {
        echo json_encode(['nombre' => $row['nomcompleto']]);
    } else {
        echo json_encode(['nombre' => null]);
    }
} else {
    echo json_encode(['nombre' => null]);
}
