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
            ORDER BY dap.id DESC";
            $stmt = $pdo->query($sql);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            echo json_encode([]);
        }
        break;


    case 'editar':
        $codigo_docente    = $_POST['codigo_docente'] ?? null;
        $codigo_asignatura = $_POST['codigo_asignatura'] ?? null;
        $semestre          = $_POST['semestre'] !== '' ? (int)$_POST['semestre'] : null;
        $grupo             = $_POST['grupo'] !== '' ? (int)$_POST['grupo'] : null;
        $codigo_programa   = $_POST['codigo_programa'] ?? null;
        $codigo_periodo    = $_POST['codigo_periodo'] ?? null;
        try {
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
            $sql = "UPDATE sistema.docente_asignaturas_periodo SET
            codigo_docente = ?, codigo_asignatura = ?, semestre = ?, grupo = ?, codigo_programa = ?, codigo_periodo = ?
            WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $_POST['codigo_docente'],
                $_POST['codigo_asignatura'],
                $_POST['semestre'],
                $_POST['grupo'],
                $_POST['codigo_programa'],
                $_POST['codigo_periodo'],
                $_POST['id']
            ]);
            echo json_encode(['estado' => 'Éxito', 'mensaje' => 'Registro actualizado correctamente.']);
        } catch (PDOException $e) {
            echo json_encode(['estado' => 'Error', 'mensaje' => 'Error al actualizar la base de datos: ' . $e->getMessage()]);
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
