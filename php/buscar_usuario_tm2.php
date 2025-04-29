<?php
require_once 'conexion2.php';

$codigo = $_GET['codigo'] ?? '';

if ($codigo === '') {
    echo json_encode(['status' => 'error', 'message' => 'Código vacío']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT nomcompleto FROM sistema.usuarios WHERE codigo_usuario = :codigo AND codigo_rol=2");
    $stmt->execute([':codigo' => $codigo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        echo json_encode(['status' => 'success', 'nombre' => $usuario['nomcompleto']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
