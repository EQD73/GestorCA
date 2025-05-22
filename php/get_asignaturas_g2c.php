<?php
require 'conexion2.php'; // tu archivo PDO

$codigo_programa = $_POST['codigo_programa'] ?? '';

if (empty($codigo_programa)) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("SELECT DISTINCT codigo_asignatura, nom_asignatura 
                       FROM sistema.pensum 
                       WHERE codigo_programa = :codigo_programa 
                       ORDER BY codigo_asignatura");
$stmt->execute(['codigo_programa' => $codigo_programa]);
$asignaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($asignaturas);
