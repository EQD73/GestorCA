<?php

header('Content-Type: application/json');

include 'conexion2.php';


$accion = $_POST['accion'] ?? '';

switch ($accion) {
    case 'listar':
        try {
            $stmt = $pdo->query("SELECT p.*, f.nombre_facultad AS nombre_facultad, pr.nombre_programa AS nombre_programa
                                 FROM sistema.pensum p
                                 INNER JOIN sistema.facultades f ON p.codigo_facultad = CAST(f.codigo_facultad AS character varying)
                                 INNER JOIN sistema.programas pr ON p.codigo_programa = pr.codigo_programa
                                 ORDER BY p.id ASC");
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($datos);
        } catch (PDOException $e) {
            echo json_encode([]);
        }
        break;

    case 'insertar':
        try {
            $stmt = $pdo->prepare("INSERT INTO sistema.pensum (codigo_programa, codigo_facultad, codigo_asignatura, nom_asignatura, semestre, comentarios, estado) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['codigo_programa'],
                $_POST['codigo_facultad'],
                $_POST['codigo_asignatura'],
                $_POST['nom_asignatura'],
                $_POST['semestre'],
                $_POST['comentarios'],
                $_POST['estado']
            ]);
            echo json_encode(['estado' => 'Éxito', 'mensaje' => 'Registro insertado correctamente.']);
        } catch (PDOException $e) {

            //error_log("Error: " . $e->getMessage());
            echo json_encode(['estado' => 'Error', 'mensaje' => 'Error al insertar: ' . $e->getMessage()]);
        }
        break;

    case 'editar':


        try {
            $stmt = $pdo->prepare("UPDATE sistema.pensum 
                                   SET codigo_programa=?, codigo_facultad=?, codigo_asignatura=?, nom_asignatura=?, semestre=?, comentarios=?, estado=? 
                                   WHERE id=?");
            $stmt->execute([
                $_POST['codigo_programa'],
                $_POST['codigo_facultad'],
                $_POST['codigo_asignatura'],
                $_POST['nom_asignatura'],
                $_POST['semestre'],
                $_POST['comentarios'],
                $_POST['estado'],
                $_POST['id']
            ]);
            echo json_encode(['estado' => 'Éxito', 'mensaje' => 'Registro actualizado correctamente.']);
        } catch (PDOException $e) {
            echo json_encode(['estado' => 'Error', 'mensaje' => 'Error al actualizar: ' . $e->getMessage()]);
        }
        break;

    case 'eliminar':
        try {
            $stmt = $pdo->prepare("DELETE FROM sistema.pensum WHERE id = ?");
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
