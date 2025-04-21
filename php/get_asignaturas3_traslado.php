<?php
require_once 'conexion2.php';

$periodo = $_GET['periodo'] ?? '';
$stmt = $pdo->prepare("SELECT DISTINCT codigo_asignatura, nom_asignatura, grupo 
                        FROM sistema.asignaturas 
                        WHERE periodo = :periodo 
                        ORDER BY nom_asignatura");
$stmt->execute(['periodo' => $periodo]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
