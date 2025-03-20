<?php
include 'conexion3.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];

    $stmt = $conn->prepare("INSERT INTO usuarios (nombres, apellidos) VALUES (:nombre, :apellidos)");
    $stmt->bindParam(':nombres', $nombres);
    $stmt->bindParam(':apellidos', $apellidos);
    $stmt->execute();

    echo json_encode(['status' => 'success']);
}
?>
