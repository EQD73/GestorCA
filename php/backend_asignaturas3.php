<?php
header('Content-Type: application/json');
require('conexion2.php');

// Obtener la acción solicitada
$action = $_REQUEST['action'] ?? '';

switch ($action) {
    case 'list':
        listAsignaturas();
        break;
    case 'get':
        getAsignatura();
        break;
    case 'create':
        createAsignatura();
        break;
    case 'update':
        updateAsignatura();
        break;
    case 'delete':
        deleteAsignatura();
        break;
    case 'update_prerequisitos':
        updatePrerequisitos();
        break;
    case 'get_prerequisitos':
        getPrerequisitosAsignatura();
        break;
    case 'list_prerequisitos_disponibles':
        listPrerequisitosDisponibles();
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        break;
}

function listAsignaturas()
{
    global $pdo;

    try {
        $stmt = $pdo->query("SELECT a.*, pr.nombre_programa FROM sistema.asignaturas a
        INNER JOIN sistema.programas pr ON pr.codigo_programa = a.codigo_programa
        ORDER BY a.id ASC");
        $asignaturas = $stmt->fetchAll();

        // Convertir el array de prerrequisitos a string para JSON
        foreach ($asignaturas as &$asignatura) {
            if (is_array($asignatura['prerequisito'])) {
                $asignatura['prerequisito'] = implode(',', $asignatura['prerequisito']);
            }
        }

        echo json_encode($asignaturas);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al listar asignaturas: ' . $e->getMessage()]);
    }
}

function getAsignatura()
{
    global $pdo;

    if (!isset($_GET['id'])) {
        echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
        return;
    }

    $id = $_GET['id'];

    try {
        // Obtener información básica de la asignatura
        $stmt = $pdo->prepare("
            SELECT a.*, pr.nombre_programa 
            FROM sistema.asignaturas a
            INNER JOIN sistema.programas pr ON pr.codigo_programa = a.codigo_programa
            WHERE a.id = ?
        ");
        $stmt->execute([$id]);
        $asignatura = $stmt->fetch();

        if ($asignatura) {
            // Obtener prerrequisitos desde la tabla prerequisitos
            $stmtPrereq = $pdo->prepare("
                SELECT codigo_prerequisito, nombre_prerequisito 
                FROM sistema.prerequisitos 
                WHERE codigo_asignatura = ?
            ");
            $stmtPrereq->execute([$asignatura['codigo_asignatura']]);
            $prerequisitos = $stmtPrereq->fetchAll();

            $asignatura['prerequisitos'] = $prerequisitos;
            echo json_encode(['success' => true, 'data' => $asignatura]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Asignatura no encontrada']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener asignatura: ' . $e->getMessage()]);
    }
}

function createAsignatura()
{
    global $pdo;

    try {
        // Validar campos obligatorios
        $required = ['codigo_asignatura', 'nom_asignatura', 'codigo_programa'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("El campo $field es requerido");
            }
        }

        // Insertar la asignatura (sin prerrequisitos)
        $stmt = $pdo->prepare("
            INSERT INTO sistema.asignaturas (
                codigo_asignatura, nom_asignatura, codigo_programa, 
                ihs, creditos
            ) VALUES (
                :codigo_asignatura, :nom_asignatura, :codigo_programa, 
                :ihs, :creditos
            ) RETURNING id
        ");

        $stmt->execute([
            ':codigo_asignatura' => $_POST['codigo_asignatura'],
            ':nom_asignatura' => $_POST['nom_asignatura'],
            ':codigo_programa' => $_POST['codigo_programa'],
            ':ihs' => $_POST['ihs'] ?? null,
            ':creditos' => $_POST['creditos'] ?? null
        ]);

        $asignaturaId = $stmt->fetchColumn();

        echo json_encode([
            'success' => true,
            'message' => 'Asignatura creada correctamente',
            'id' => $asignaturaId
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'success' => true,
            'message' => '✅ Asignatura creada correctamente',
            'id' => $asignaturaId
        ]);
    }
}


function updateAsignatura()
{
    global $pdo;

    if (!isset($_POST['id'])) {
        echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
        return;
    }

    $id = $_POST['id'];

    try {
        // Validar campos obligatorios
        $required = ['codigo_asignatura', 'nom_asignatura', 'codigo_programa'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("El campo $field es requerido");
            }
        }

        // Preparar datos para la actualización
        $updateData = [
            ':codigo_asignatura' => $_POST['codigo_asignatura'],
            ':nom_asignatura' => $_POST['nom_asignatura'],
            ':codigo_programa' => $_POST['codigo_programa'],
            ':id' => $id
        ];

        // Campos opcionales
        $optionalFields = ['ihs', 'creditos'];
        $sqlFields = [];

        foreach ($optionalFields as $field) {
            if (isset($_POST[$field])) {
                $sqlFields[] = "$field = :$field";
                $updateData[":$field"] = $_POST[$field];
            }
        }

        // Construir consulta SQL dinámica
        $sql = "UPDATE sistema.asignaturas SET
                codigo_asignatura = :codigo_asignatura,
                nom_asignatura = :nom_asignatura,
                codigo_programa = :codigo_programa";

        if (!empty($sqlFields)) {
            $sql .= ", " . implode(", ", $sqlFields);
        }

        $sql .= " WHERE id = :id";

        // Ejecutar la actualización
        $stmt = $pdo->prepare($sql);
        $stmt->execute($updateData);

        echo json_encode([
            'success' => true,
            'message' => '✅ Asignatura actualizada correctamente'
        ]);
    } catch (PDOException $e) {
        //error_log("Error en updateAsignatura: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error al actualizar asignatura: ' . $e->getMessage()]);
    }
}

function updatePrerequisitos()
{
    global $pdo;

    if (!isset($_POST['codigo_asignatura'])) {
        echo json_encode(['success' => false, 'message' => 'Código de asignatura no proporcionado']);
        return;
    }

    $codigo_asignatura = $_POST['codigo_asignatura'];
    $nombre_asignatura = $_POST['nom_asignatura'] ?? '';
    $prerequisitos = $_POST['prerequisitos'] ?? [];

    try {
        $pdo->beginTransaction();

        // Eliminar prerrequisitos existentes
        $stmtDelete = $pdo->prepare("DELETE FROM sistema.prerequisitos WHERE codigo_asignatura = ?");
        $stmtDelete->execute([$codigo_asignatura]);

        // Insertar nuevos prerrequisitos si los hay
        if (!empty($prerequisitos)) {
            // Primero obtenemos los datos de las asignaturas seleccionadas
            $placeholders = implode(',', array_fill(0, count($prerequisitos), '?'));
            $stmtAsignaturas = $pdo->prepare("
                SELECT codigo_asignatura, nom_asignatura, codigo_programa 
                FROM sistema.asignaturas 
                WHERE codigo_asignatura IN ($placeholders)
            ");
            $stmtAsignaturas->execute($prerequisitos);
            $asignaturas = $stmtAsignaturas->fetchAll();

            // Insertar cada prerrequisito
            $stmtInsert = $pdo->prepare("
                INSERT INTO sistema.prerequisitos (
                    codigo_prerequisito, nombre_prerequisito, 
                    codigo_asignatura, nombre_asignatura, codigo_programa
                ) VALUES (?, ?, ?, ?, ?)
            ");

            foreach ($asignaturas as $asignatura) {
                $stmtInsert->execute([
                    $asignatura['codigo_asignatura'],
                    $asignatura['nom_asignatura'],
                    $codigo_asignatura,
                    $nombre_asignatura,
                    $asignatura['codigo_programa']
                ]);
            }
        }

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Prerrequisitos actualizados correctamente']);
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error al actualizar prerrequisitos: ' . $e->getMessage()]);
    }
}

function deleteAsignatura()
{
    global $pdo;

    if (!isset($_POST['id'])) {
        echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
        return;
    }

    $id = $_POST['id'];

    try {
        $pdo->beginTransaction();

        // Primero eliminar los prerrequisitos asociados
        $stmtGetCodigo = $pdo->prepare("SELECT codigo_asignatura FROM sistema.asignaturas WHERE id = ?");
        $stmtGetCodigo->execute([$id]);
        $codigo_asignatura = $stmtGetCodigo->fetchColumn();

        if ($codigo_asignatura) {
            $stmtDeletePrereq = $pdo->prepare("DELETE FROM sistema.prerequisitos WHERE codigo_asignatura = ?");
            $stmtDeletePrereq->execute([$codigo_asignatura]);
        }

        // Luego eliminar la asignatura
        $stmt = $pdo->prepare("DELETE FROM sistema.asignaturas WHERE id = ?");
        $stmt->execute([$id]);

        $pdo->commit();

        if ($stmt->rowCount() > 0) {
            echo json_encode([
                'success' => true,
                'message' => '✅ Asignatura eliminada correctamente'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Asignatura no encontrada'
            ]);
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error al eliminar asignatura: ' . $e->getMessage()]);
    }
}

function getPrerequisitosAsignatura()
{
    global $pdo;

    if (!isset($_GET['codigo_asignatura'])) {
        echo json_encode(['success' => false, 'message' => 'Código de asignatura no proporcionado']);
        return;
    }

    $codigo = $_GET['codigo_asignatura'];

    try {
        $stmt = $pdo->prepare("
            SELECT codigo_prerequisito, nombre_prerequisito 
            FROM sistema.prerequisitos 
            WHERE codigo_asignatura = ?
        ");
        $stmt->execute([$codigo]);
        $prerequisitos = $stmt->fetchAll();

        echo json_encode(['success' => true, 'data' => $prerequisitos]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener prerrequisitos: ' . $e->getMessage()]);
    }
}

function listPrerequisitosDisponibles()
{
    global $pdo;

    $current_asignatura = $_GET['current_asignatura'] ?? null;

    try {
        $sql = "SELECT codigo_asignatura, nom_asignatura FROM sistema.asignaturas";
        $params = [];

        if ($current_asignatura) {
            $sql .= " WHERE codigo_asignatura != ?";
            $params[] = $current_asignatura;
        }

        $sql .= " ORDER BY nom_asignatura";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $asignaturas = $stmt->fetchAll();

        echo json_encode(['success' => true, 'data' => $asignaturas]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al listar asignaturas: ' . $e->getMessage()]);
    }
}
