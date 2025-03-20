<?php
include 'conexion3.php';

$query = $conn->query("SELECT * FROM usuarios");
$users = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['data' => $users]);
?>
