<?php
include "conexion2.php";
$accion = $_POST['accion'];

switch ($accion) {
    case 'crear':

        $codigo_docente    = $_POST['codigo_docente'] ?? null;
        $codigo_asignatura = $_POST['codigo_asignatura'] ?? null;
        $semestre          = $_POST['semestre'] !== '' ? (int)$_POST['semestre'] : null;
        $grupo             = $_POST['grupo'] !== '' ? (int)$_POST['grupo'] : null;
        $codigo_programa   = $_POST['codigo_programa'] ?? null;
        $codigo_periodo    = $_POST['codigo_periodo'] ?? null;
        try {
            // Conexión PDO (suponiendo que ya la tienes en $pdo)
            $stmt = $pdo->prepare("
                    SELECT 1 FROM sistema.docente_asignaturas_periodo
                    WHERE codigo_docente = :codigo_docente
                      AND codigo_asignatura = :codigo_asignatura
                      AND codigo_programa = :codigo_programa
                      AND codigo_periodo = :codigo_periodo
                      AND semestre = :semestre
                      AND grupo = :grupo
                ");

            $stmt->execute([
                ':codigo_docente' => $codigo_docente,
                ':codigo_asignatura' => $codigo_asignatura,
                ':codigo_programa' => $codigo_programa,
                ':codigo_periodo' => $codigo_periodo,
                ':semestre' => $semestre,
                ':grupo' => $grupo
            ]);

            if ($stmt->fetch()) {
                echo json_encode([
                    'estado' => 'Error',
                    'mensaje' => 'Ya existe un registro con esta combinación de datos. Por favor verifica'
                ]);
                exit;
            }

            $sql = "INSERT INTO sistema.docente_asignaturas_periodo 
                (codigo_docente, codigo_asignatura, semestre, grupo, codigo_programa, codigo_periodo)
                VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $codigo_docente,
                $codigo_asignatura,
                $semestre,
                $grupo,
                $codigo_programa,
                $codigo_periodo
            ]);

            echo json_encode([
                'estado' => 'Éxito',
                'mensaje' => 'Registro guardado correctamente.'
            ]);
        } catch (PDOException $e) {
            echo json_encode([
                'estado' => 'Error',
                'mensaje' => 'Error al guardar en la base de datos: ' . $e->getMessage()
            ]);
        }
        break;


    case 'leer':
        try {
            $sql = "
            SELECT 
                dap.*,
                u.nomcompleto AS nombre_docente,
                a.nom_asignatura,
                p.nombre_programa,
                pe.nombre_periodo
            FROM sistema.docente_asignaturas_periodo dap
            LEFT JOIN sistema.usuarios u ON dap.codigo_docente = CAST(u.codigo_usuario AS VARCHAR)
            LEFT JOIN sistema.asignaturas a ON dap.codigo_asignatura = a.codigo_asignatura
            LEFT JOIN sistema.programas p ON dap.codigo_programa = p.codigo_programa
            LEFT JOIN sistema.periodos pe ON dap.codigo_periodo = pe.codigo_periodo
            ORDER BY dap.id ASC";
            $stmt = $pdo->query($sql);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            echo json_encode([]);
        }
        break;


    case 'editar':
        $id = $_POST['id'];
        $nuevo_codigo_docente = $_POST['codigo_docente'] ?? null;
        $codigo_asignatura = $_POST['codigo_asignatura'] ?? null;
        $codigo_periodo = $_POST['codigo_periodo'] ?? null;
        $semestre = $_POST['semestre'] !== '' ? (int)$_POST['semestre'] : null;
        $grupo = $_POST['grupo'] !== '' ? (int)$_POST['grupo'] : null;
        $codigo_programa = $_POST['codigo_programa'] ?? null;

        try {
            // Obtener registro actual
            $stmt = $pdo->prepare("SELECT * FROM sistema.docente_asignaturas_periodo WHERE id = ?");
            $stmt->execute([$id]);
            $registro_actual = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$registro_actual) {
                echo json_encode([
                    'estado' => 'Error',
                    'mensaje' => 'Registro no encontrado'
                ]);
                exit;
            }

            $docente_cambiado = ($registro_actual['codigo_docente'] != $nuevo_codigo_docente);

            // Verificar duplicados
            $stmt = $pdo->prepare("
            SELECT 1 FROM sistema.docente_asignaturas_periodo
            WHERE codigo_docente = :codigo_docente
              AND codigo_asignatura = :codigo_asignatura
              AND codigo_programa = :codigo_programa
              AND codigo_periodo = :codigo_periodo
              AND semestre = :semestre
              AND grupo = :grupo
              AND id != :id
        ");
            $stmt->execute([
                ':codigo_docente' => $nuevo_codigo_docente,
                ':codigo_asignatura' => $codigo_asignatura,
                ':codigo_programa' => $codigo_programa,
                ':codigo_periodo' => $codigo_periodo,
                ':semestre' => $semestre,
                ':grupo' => $grupo,
                ':id' => $id
            ]);

            if ($stmt->fetch()) {
                echo json_encode([
                    'estado' => 'Error',
                    'mensaje' => 'Ya existe un registro con esta combinación de datos.'
                ]);
                exit;
            }

            $pdo->beginTransaction();

            // 1. Actualizar tabla principal
            $sql = "UPDATE sistema.docente_asignaturas_periodo SET
            codigo_docente = ?, codigo_asignatura = ?, semestre = ?, 
            grupo = ?, codigo_programa = ?, codigo_periodo = ?
            WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $nuevo_codigo_docente,
                $codigo_asignatura,
                $semestre,
                $grupo,
                $codigo_programa,
                $codigo_periodo,
                $id
            ]);

            $actualizaciones = 0;
            $filas_afectadas = ['m1' => 0, 'm2' => 0, 'm3' => 0];

            // 2. Si el docente cambió, actualizar tablas relacionadas
            if ($docente_cambiado) {
                $codigo_docente_anterior = $registro_actual['codigo_docente'];

                // Función para actualizar con retardo
                function actualizarConRetardo($pdo, $sql, $params, $tabla)
                {
                    // Pequeño retardo artificial para visualizar progreso
                    usleep(800000); // 0.5 segundos
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($params);
                    return $stmt->rowCount();
                }

                // Actualizar tabla m1
                $filas_afectadas['m1'] = actualizarConRetardo($pdo, "
                    UPDATE sistema.m1
                    SET 
                    codigo_docente = :nuevo_docente_str,
                    nombre_docente = (
                        SELECT nomcompleto
                        FROM sistema.usuarios
                        WHERE codigo_usuario = :nuevo_docente_int
                    )
                    WHERE 
                    codigo_docente = :docente_anterior 
                    AND codigo_asignaturacurso = :asignatura
                    AND ano_micro = (
                        SELECT CAST(EXTRACT(YEAR FROM fecha_inicio) AS character varying)
                        FROM sistema.periodos 
                        WHERE codigo_periodo = :periodo
                    )
                    ", [
                    ':nuevo_docente_int' => (int) $nuevo_codigo_docente,
                    ':nuevo_docente_str' => (string) $nuevo_codigo_docente,
                    ':docente_anterior' => $codigo_docente_anterior,
                    ':asignatura' => $codigo_asignatura,
                    ':periodo' => $codigo_periodo
                ], 'm1');

                // Actualizar tabla m2
                $filas_afectadas['m2'] = actualizarConRetardo($pdo, "
                    UPDATE sistema.m2 
                    SET
                    codigo_docente = :nuevo_docente_str,
                    nombre_docente = (
                                SELECT nomcompleto
                                FROM sistema.usuarios
                                WHERE codigo_usuario = :nuevo_docente_int
                            )
                    WHERE codigo_docente = :docente_anterior 
                    AND codigo_asignatura = :asignatura
                    AND codigo_periodo = :periodo
                ", [
                    ':nuevo_docente_int' => (int) $nuevo_codigo_docente,
                    ':nuevo_docente_str' => (string) $nuevo_codigo_docente,
                    ':docente_anterior' => $codigo_docente_anterior,
                    ':asignatura' => $codigo_asignatura,
                    ':periodo' => $codigo_periodo
                ], 'm2');

                // Actualizar tabla m3
                $filas_afectadas['m3'] = actualizarConRetardo($pdo, "
                    UPDATE sistema.m3 
                    SET
                    codigo_docente = CAST(:nuevo_docente AS character varying),
                    nombre_docente = (
                                SELECT nomcompleto
                                FROM sistema.usuarios
                                WHERE codigo_usuario = CAST(:nuevo_docente AS integer)
                            )
                    WHERE codigo_docente = :docente_anterior 
                    AND codigo_asignatura = :asignatura
                    AND codigo_periodo = :periodo
                ", [
                    ':nuevo_docente' => $nuevo_codigo_docente,
                    ':docente_anterior' => $codigo_docente_anterior,
                    ':asignatura' => $codigo_asignatura,
                    ':periodo' => $codigo_periodo
                ], 'm3');

                $actualizaciones = array_sum($filas_afectadas);
            }

            $pdo->commit();
            echo json_encode([
                'estado' => 'Éxito',
                'mensaje' => 'Actualización completada con éxito',
                'docente_cambiado' => $docente_cambiado,
                'actualizaciones_relacionadas' => $actualizaciones,
                'filas_afectadas' => $filas_afectadas,
                'detalle' => 'Proceso completado en ' . round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 2) . ' segundos'
            ]);
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo json_encode([
                'estado' => 'Error',
                'mensaje' => 'Error en el proceso: ' . $e->getMessage(),
                'error_sql' => $e->errorInfo ?? null,
                'query' => $e->getTrace()[0]['args'][0] ?? null
            ]);
        }
        break;

    case 'eliminar':
        try {
            $stmt = $pdo->prepare("DELETE FROM sistema.docente_asignaturas_periodo WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            echo json_encode(['estado' => 'Éxito', 'mensaje' => 'Registro eliminado correctamente.']);
        } catch (PDOException $e) {
            echo json_encode(['estado' => 'Error', 'mensaje' => 'Error al eliminar: ' . $e->getMessage()]);
        }
        break;
    default:
        echo json_encode(['estado' => 'Error', 'mensaje' => 'Acción no válida.']);
        break;
}
