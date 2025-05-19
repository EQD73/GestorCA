<?php
require 'conexion2.php';
$stmt = $pdo->query("SELECT codigo_programa AS codigo, nombre_programa AS nombre FROM sistema.programas ORDER BY codigo_programa");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
