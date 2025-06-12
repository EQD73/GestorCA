<?php
require_once 'conexion2.php';
header('Content-Type: application/json');

/* $q = $_GET['q'] ?? '';
$q = strtolower($q); */

// Concatenamos código + nombre para mostrar en el select
$sql = "SELECT DISTINCT 
            a.codigo_asignatura AS id, 
            a.nom_asignatura AS text
        FROM sistema.asignaturas a
        INNER JOIN sistema.m2 m2 ON m2.codigo_asignatura = a.codigo_asignatura       
        ORDER BY a.codigo_asignatura";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);

// Formato requerido por Select2
/* echo json_encode(['results' => $data]); */
exit;
