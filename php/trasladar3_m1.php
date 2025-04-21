<?php
header('Content-Type: application/json');
require_once 'conexion2.php';

$periodo_origen = $_POST['periodo_origen'];
$periodo_destino = $_POST['periodo_destino'];
$codigo_asignatura = $_POST['codigo_asignatura'];
$codigo_usuario = $_POST['codigo_usuario'] ?? null;
$nombre_docente = $_POST['nombre_docente'] ?? null;

// Validar datos del docente
if (empty($codigo_usuario) || empty($nombre_docente)) {
    echo json_encode([
        'status' => 'error',
        'title' => 'Faltan datos del docente',
        'message' => 'Debe ingresar el código y nombre del docente antes de realizar el traslado.'
    ]);
    exit;
}

try {
    // Obtener años
    $sql_anios = "SELECT codigo_periodo, anio FROM sistema.periodos WHERE codigo_periodo IN (:origen, :destino)";
    $stmt_anios = $pdo->prepare($sql_anios);
    $stmt_anios->execute([':origen' => $periodo_origen, ':destino' => $periodo_destino]);
    $anios = $stmt_anios->fetchAll(PDO::FETCH_KEY_PAIR);

    if ($anios[$periodo_origen] == $anios[$periodo_destino]) {
        echo json_encode([
            'status' => 'error',
            'title' => 'Año no permitido',
            'message' => 'El traslado no se puede realizar porque ambos periodos son del mismo año. El microcurrículo es anual.'
        ]);
        exit;
    }

    // Obtener campos sin incluir el campo ID
    $columnsQuery = $pdo->query("
        SELECT column_name 
        FROM information_schema.columns 
        WHERE table_schema = 'sistema' AND table_name = 'm1' 
        AND column_name <> 'id'
    ");
    $fields = array_column($columnsQuery->fetchAll(), 'column_name');

    // Asegurar que campos para docente estén presentes
    if (!in_array('codigo_docente', $fields)) $fields[] = 'codigo_docente';
    if (!in_array('nombre_docente', $fields)) $fields[] = 'nombre_docente';

    // Cargar registros del periodo origen y asignatura
    $sql_select = "SELECT " . implode(', ', $fields) . " 
        FROM sistema.m1 
        WHERE ano_micro = :origen AND codigo_asignaturacurso = :asignatura";
    $stmt_select = $pdo->prepare($sql_select);
    $stmt_select->execute([
        ':origen' => substr($periodo_origen, 0, 4),
        ':asignatura' => $codigo_asignatura
    ]);
    $rows = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        echo json_encode([
            'status' => 'warning',
            'title' => 'Sin registros',
            'message' => 'No se encontraron registros para la asignatura y periodo origen seleccionados.'
        ]);
        exit;
    }

    // Preparar inserción
    $placeholders = implode(",", array_map(function ($f) {
        return ":$f";
    }, $fields));
    $sql_insert = "
        INSERT INTO sistema.m1 (" . implode(', ', $fields) . ") 
        VALUES (" . $placeholders . ")
    ";
    $stmt_insert = $pdo->prepare($sql_insert);

    foreach ($rows as $row) {
        $row['ano_micro'] = substr($periodo_destino, 0, 4);
        $row['codigo_docente'] = $codigo_usuario;
        $row['nombre_docente'] = $nombre_docente;

        // Asegurar que todos los campos estén presentes en el array
        foreach ($fields as $field) {
            if (!array_key_exists($field, $row)) {
                $row[$field] = null;
            }
        }

        $stmt_insert->execute($row);
    }

    echo json_encode([
        'status' => 'success',
        'title' => 'Traslado exitoso',
        'message' => count($rows) . ' registros fueron trasladados correctamente al nuevo periodo.'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'title' => 'Error en la base de datos',
        'message' => $e->getMessage() . ' Microcurrículo ya existe para el año ' . substr($periodo_destino, 0, 4)
    ]);
}
