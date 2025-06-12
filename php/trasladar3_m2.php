<?php
header('Content-Type: application/json');
require_once 'conexion2.php';

function trasladarRegistro(
    PDO $pdo,
    array $fields,
    array $rows,
    string $periodo,
    string $periodo_desc,
    DateTime $fecha_inicio,
    int $total_semanas,
    bool $isPosgrado,
    string $asignatura_destino,
    string $nombre_asignatura_destino,
    string $codigo_programa_destino,
    string $nombre_programa_destino
) {
    $placeholders = implode(",", array_map(function ($f) {
        return ":$f";
    }, $fields));
    $sql_insert = "INSERT INTO sistema.m2 (" . implode(', ', $fields) . ") VALUES ($placeholders)";
    $stmt_insert = $pdo->prepare($sql_insert);

    foreach ($rows as $row) {
        $row['codigo_periodo']     = $periodo;
        $row['nombre_periodo']     = $periodo_desc;
        $row['fecha_consigna']     = $fecha_inicio->format('d-m-Y');
        $row['codigo_asignatura']  = $asignatura_destino;
        $row['nombre_asignatura']  = $nombre_asignatura_destino;
        $row['codigo_programa']    = $codigo_programa_destino;
        $row['nombre_programa']    = $nombre_programa_destino;

        if ($isPosgrado) {
            for ($i = 1; $i <= 5; $i++) {
                $row["s{$i}_titulo_p"]      = "Semana {$i}";
                $row["s{$i}_contenidos_p"]  = $row["s{$i}_contenidos_p"] ?? null;
                $row["s{$i}_estrategia_p"]  = $row["s{$i}_estrategia_p"] ?? null;
                $row["s{$i}_metodologia_p"] = $row["s{$i}_metodologia_p"] ?? null;
            }
        } else {
            for ($i = 1; $i <= $total_semanas; $i++) {
                $ini = clone $fecha_inicio;
                $ini->modify('+' . (($i - 1) * 7) . ' days');
                $fin = clone $ini;
                $fin->modify('+5 days');
                $row["s{$i}_rangoi"] = $ini->format('d-m-Y');
                $row["s{$i}_rangof"] = $fin->format('d-m-Y');
                $row["s{$i}_titulo"] = "Semana {$i}";
                $row["s{$i}_contenidos"]  = $row["s{$i}_contenidos"] ?? null;
                $row["s{$i}_estrategia"]  = $row["s{$i}_estrategia"] ?? null;
                $row["s{$i}_metodologia"] = $row["s{$i}_metodologia"] ?? null;
            }
        }

        // Completar campos faltantes
        foreach ($fields as $f) {
            if (!array_key_exists($f, $row)) {
                $row[$f] = null;
            }
        }

        $stmt_insert->execute($row);
    }

    return count($rows);
}

try {
    $periodo = $_POST['periodo'];
    $origin  = $_POST['codigo_asignatura_origen'];
    $dest    = $_POST['codigo_asignatura_destino'];

    if ($origin === $dest) {
        echo json_encode(['status' => 'error', 'title' => 'Error', 'message' => 'Asignaturas idénticas']);
        exit;
    }

    // Obtener datos del periodo
    $stmt = $pdo->prepare("SELECT nombre_periodo, fecha_inicio, total_semanas FROM sistema.periodos WHERE codigo_periodo = :periodo AND estado='ACTIVO'");
    $stmt->execute([':periodo' => $periodo]);
    $info = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$info) throw new Exception("Periodo inválido o Bloqueado no se permiten traslados");

    $fecha_inicio   = new DateTime($info['fecha_inicio']);
    $total_semanas  = (int)$info['total_semanas'];
    $periodo_desc   = $info['nombre_periodo'];

    // Determinar si es posgrado
    $isPosgrado = in_array(substr($origin, 0, 2), ['26', '30', '31', '32']);
    $semanas = $isPosgrado ? 5 : $total_semanas;

    // Campos comunes
    $fields = [
        'codigo_asignatura',
        'nombre_asignatura',
        'codigo_periodo',
        'nombre_periodo',
        'codigo_programa',
        'nombre_programa',
        'fecha_consigna',
        'semestre',
        'grupo',
        'codigo_docente',
        'nombre_docente',
        'resultados_aprendizaje',
        'htts',
        'htps',
        'htis'
    ];

    // Agregar campos semanales
    for ($i = 1; $i <= $semanas; $i++) {
        if ($isPosgrado) {
            foreach (['rangoi_p', 'rangof_p', 'titulo_p', 'contenidos_p', 'estrategia_p', 'metodologia_p'] as $sufix) {
                $fields[] = "s{$i}_{$sufix}";
            }
        } else {
            foreach (['rangoi', 'rangof', 'titulo', 'contenidos', 'estrategia', 'metodologia'] as $sufix) {
                $fields[] = "s{$i}_{$sufix}";
            }
        }
    }

    // Obtener nombre de la asignatura destino
    $stmt = $pdo->prepare("SELECT nom_asignatura FROM sistema.asignaturas WHERE codigo_asignatura = :cod");
    $stmt->execute([':cod' => $dest]);
    $asig = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$asig) throw new Exception("Asignatura destino no encontrada");
    $nombre_asignatura_destino = $asig['nom_asignatura'];

    // Obtener programa destino desde los 2 primeros dígitos del código de asignatura destino
    $cod_prog = substr($dest, 0, 2);
    $stmt = $pdo->prepare("SELECT codigo_programa, nombre_programa FROM sistema.programas WHERE codigo_programa = :cod");
    $stmt->execute([':cod' => $cod_prog]);
    $prog_info = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$prog_info) throw new Exception("Programa no encontrado para asignatura destino");

    // Obtener los datos de la asignatura origen desde m2
    $stmt = $pdo->prepare("SELECT " . implode(', ', $fields) . " FROM sistema.m2 WHERE codigo_periodo = :periodo AND codigo_asignatura = :asignatura");
    $stmt->execute([':periodo' => $periodo, ':asignatura' => $origin]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$rows) throw new Exception("No hay registros para la asignatura origen");

    // Ejecutar traslado
    $count = trasladarRegistro(
        $pdo,
        $fields,
        $rows,
        $periodo,
        $periodo_desc,
        $fecha_inicio,
        $total_semanas,
        $isPosgrado,
        $dest,
        $nombre_asignatura_destino,
        $prog_info['codigo_programa'],
        $prog_info['nombre_programa']
    );

    echo json_encode(['status' => 'success', 'title' => 'Traslado OK', 'message' => "$count registros trasladados"]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'title' => 'BD', 'message' => $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'title' => 'Error', 'message' => $e->getMessage()]);
}
