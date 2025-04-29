<?php
header('Content-Type: application/json');
require_once 'conexion2.php';

$periodo_origen = $_POST['periodo_origen'];
$periodo_destino = $_POST['periodo_destino'];
$codigo_asignatura = $_POST['codigo_asignatura'];
$codigo_usuario = $_POST['codigo_usuario'] ?? null;
$nombre_docente = $_POST['nombre_docente'] ?? null;

if (empty($codigo_usuario) || empty($nombre_docente)) {
    echo json_encode([
        'status' => 'error',
        'title' => 'Faltan datos del docente',
        'message' => 'Debe ingresar el código y nombre del docente antes de realizar el traslado.'
    ]);
    exit;
}

try {
    if ($periodo_origen === $periodo_destino) {
        echo json_encode([
            'status' => 'error',
            'title' => 'Periodo no permitido',
            'message' => 'El traslado no se puede realizar porque los periodos son iguales.'
        ]);
        exit;
    }

    // Obtener datos del periodo destino
    $sql_periodos = "SELECT nombre_periodo, fecha_inicio, total_semanas 
                     FROM sistema.periodos WHERE codigo_periodo = :destino";
    $stmt_periodos = $pdo->prepare($sql_periodos);
    $stmt_periodos->execute([':destino' => $periodo_destino]);
    $periodo_data = $stmt_periodos->fetch(PDO::FETCH_ASSOC);

    if (!$periodo_data) {
        echo json_encode([
            'status' => 'error',
            'title' => 'Periodo inválido',
            'message' => 'No se encontró el periodo destino.'
        ]);
        exit;
    }

    $periodo_descripcion = $periodo_data['nombre_periodo'];
    /* $fecha_inicio = $periodo_data['fecha_inicio']; */
    $fecha_inicio = new DateTime($periodo_data['fecha_inicio']);
    $total_semanas = (int)$periodo_data['total_semanas'];


    // Campos a trasladar
    $fields = [
        'codigo_asignatura',
        'nombre_asignatura',
        'codigo_periodo',
        'nombre_periodo',
        'codigo_programa',
        'nombre_programa',
        // 'num_consignacion',
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

    $primeros_dos = substr($codigo_asignatura, 0, 2);
    if (in_array($primeros_dos, ['26', '30', '31', '32'])) { //Codigos Especializacion(postgrados)
        // Agregar campos para rangos semanales
        for ($i = 1; $i <= 5; $i++) {
            $fields[] = "s{$i}_rangoi_p";
            $fields[] = "s{$i}_rangof_p";
            $fields[] = "s{$i}_titulo_p";
            $fields[] = "s{$i}_contenidos_p";
            $fields[] = "s{$i}_estrategia_p";
            $fields[] = "s{$i}_metodologia_p";
        }
        // Obtener registros del origen
        $sql_select = "SELECT " . implode(', ', $fields) . " 
                   FROM sistema.m2 
                   WHERE codigo_periodo = :origen AND codigo_asignatura = :asignatura";
        $stmt_select = $pdo->prepare($sql_select);
        $stmt_select->execute([
            ':origen' => $periodo_origen,
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
        // Preparar SQL de inserción
        $placeholders = implode(",", array_map(function ($f) {
            return ":$f";
        }, $fields));
        $sql_insert = "INSERT INTO sistema.m2 (" . implode(', ', $fields) . ") VALUES ($placeholders)";
        $stmt_insert = $pdo->prepare($sql_insert);

        foreach ($rows as $row) {
            // Sobrescribir valores
            $row['codigo_periodo'] = $periodo_destino;
            $row['nombre_periodo'] = $periodo_descripcion;
            $row['codigo_docente'] = $codigo_usuario;
            $row['nombre_docente'] = $nombre_docente;
            $row['fecha_consigna'] = $fecha_inicio->format('d-m-Y');

            /*  // Agregar rangos semanales y títulos
            foreach ($rangos_semanales as $campo => $valor) {
                $row[$campo] = $valor;
            } */
            for ($i = 1; $i <= 5; $i++) {
                $row["s{$i}_titulo_p"] = "Semana {$i}";
                // Si los campos no existen en el row original (porque no se copiaron), los dejamos vacíos
                $row["s{$i}_contenidos_p"] = $row["s{$i}_contenidos_p"] ?? null;
                $row["s{$i}_estrategia_p"] = $row["s{$i}_estrategia_p"] ?? null;
                $row["s{$i}_metodologia_p"] = $row["s{$i}_metodologia_p"] ?? null;
            }
            // Asegurar que todos los campos estén definidos
            foreach ($fields as $f) {
                if (!array_key_exists($f, $row)) {
                    $row[$f] = null;
                }
            }
        }

        $stmt_insert->execute($row);
    } else {
        // Agregar campos para rangos semanales
        for ($i = 1; $i <= $total_semanas; $i++) {
            $fields[] = "s{$i}_rangoi";
            $fields[] = "s{$i}_rangof";
            $fields[] = "s{$i}_titulo";
            $fields[] = "s{$i}_contenidos";
            $fields[] = "s{$i}_estrategia";
            $fields[] = "s{$i}_metodologia";
        }

        // Obtener registros del origen
        $sql_select = "SELECT " . implode(', ', $fields) . " 
                   FROM sistema.m2 
                   WHERE codigo_periodo = :origen AND codigo_asignatura = :asignatura";
        $stmt_select = $pdo->prepare($sql_select);
        $stmt_select->execute([
            ':origen' => $periodo_origen,
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



        // Generar rangos semanales
        $rangos_semanales = [];
        for ($i = 1; $i <= $total_semanas; $i++) {
            $inicio = clone $fecha_inicio;
            $inicio->modify('+' . (($i - 1) * 7) . ' days');
            $fin = clone $inicio;
            $fin->modify('+5 days');
            $rangos_semanales["s{$i}_rangoi"] = $inicio->format('d-m-Y');
            $rangos_semanales["s{$i}_rangof"] = $fin->format('d-m-Y');
        }

        // Preparar SQL de inserción
        $placeholders = implode(",", array_map(function ($f) {
            return ":$f";
        }, $fields));
        $sql_insert = "INSERT INTO sistema.m2 (" . implode(', ', $fields) . ") VALUES ($placeholders)";
        $stmt_insert = $pdo->prepare($sql_insert);

        foreach ($rows as $row) {
            // Sobrescribir valores
            $row['codigo_periodo'] = $periodo_destino;
            $row['nombre_periodo'] = $periodo_descripcion;
            $row['codigo_docente'] = $codigo_usuario;
            $row['nombre_docente'] = $nombre_docente;
            $row['fecha_consigna'] = $fecha_inicio->format('d-m-Y');

            // Agregar rangos semanales y títulos
            foreach ($rangos_semanales as $campo => $valor) {
                $row[$campo] = $valor;
            }
            for ($i = 1; $i <= $total_semanas; $i++) {
                $row["s{$i}_titulo"] = "Semana {$i}";
                // Si los campos no existen en el row original (porque no se copiaron), los dejamos vacíos
                $row["s{$i}_contenidos"] = $row["s{$i}_contenidos"] ?? null;
                $row["s{$i}_estrategia"] = $row["s{$i}_estrategia"] ?? null;
                $row["s{$i}_metodologia"] = $row["s{$i}_metodologia"] ?? null;
            }
            // Asegurar que todos los campos estén definidos
            foreach ($fields as $f) {
                if (!array_key_exists($f, $row)) {
                    $row[$f] = null;
                }
            }

            $stmt_insert->execute($row);
        }
    }

    echo json_encode([
        'status' => 'success',
        'title' => 'Traslado exitoso',
        'message' => count($rows) . ' registros trasladados correctamente con rangos semanales.'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'title' => 'Error en la base de datos',
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
