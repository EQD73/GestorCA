<?php
require 'conexion2.php';
$stmt = $pdo->query("SELECT codigo_periodo AS codigo, nombre_periodo AS nombre FROM sistema.periodos WHERE estado='ACTIVO' OR estado='BLOQUEADO' ORDER BY anio DESC, nombre_periodo DESC");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
