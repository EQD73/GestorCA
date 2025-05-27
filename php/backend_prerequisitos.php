<?php
require('conexion2.php');

header('Content-Type: application/json');

// Si es una solicitud GET, devolver los datos
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = "SELECT preq.*, asig.nom_asignatura AS nombre_asignatura, prog.nombre_programa AS nombre_programa
              FROM sistema.prerequisitos preq
              LEFT JOIN sistema.asignaturas asig ON preq.codigo_asignatura = asig.codigo_asignatura
              LEFT JOIN sistema.programas prog ON preq.codigo_programa = prog.codigo_programa
              ORDER BY preq.codigo_prerequisito ASC";
    $stmt = $pdo->query($query);
    $prerequisitos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($prerequisitos);
    exit;
}

// Procesar acciones CRUD (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'crear':
            crearPrerequisito($pdo);
            break;
        case 'editar':
            editarPrerequisito($pdo);
            break;
        case 'eliminar':
            eliminarPrerequisito($pdo);
            break;
    }
}


function crearPrerequisito($pdo)
{
    $data = [
        'codigo_prerequisito' => $_POST['codigo_prerequisito'],
        'nombre_prerequisito' => $_POST['nombre_prerequisito'],
        'codigo_asignatura' => $_POST['codigo_asignatura'],
        'codigo_programa' => $_POST['codigo_programa']
    ];

    try {
        $query = "INSERT INTO sistema.prerequisitos (codigo_prerequisito, nombre_prerequisito, codigo_asignatura, codigo_programa) 
                  VALUES (:codigo_prerequisito, :nombre_prerequisito, :codigo_asignatura, :codigo_programa)";

        $stmt = $pdo->prepare($query);
        $stmt->execute($data);

        echo json_encode(['success' => true, 'message' => 'Prerequisito creado correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

function editarPrerequisito($pdo)
{
    $data = [
        'id' => $_POST['id'],
        'codigo_prerequisito' => $_POST['codigo_prerequisito_editar'],
        'nombre_prerequisito' => $_POST['nombre_prerequisito_editar'],
        'codigo_asignatura' => $_POST['codigo_asignatura_editar'],
        'codigo_programa' => $_POST['codigo_programa_editar']
    ];

    try {
        $query = "UPDATE sistema.prerequisitos SET 
                  codigo_prerequisito = :codigo_prerequisito, 
                  nombre_prerequisito = :nombre_prerequisito, 
                  codigo_asignatura = :codigo_asignatura, 
                  codigo_programa = :codigo_programa 
                  WHERE id = :id";

        $stmt = $pdo->prepare($query);
        $stmt->execute($data);

        echo json_encode(['success' => true, 'message' => 'Prerequisito actualizado correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

function eliminarPrerequisito($pdo)
{
    $id = $_POST['id'];

    try {
        $query = "DELETE FROM sistema.prerequisitos WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Prerequisito eliminado correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}
