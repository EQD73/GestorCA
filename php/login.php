<?php
session_start();
include("conexion2.php");

// Función para eliminar cookies
function eliminarCookies()
{
    foreach ($_COOKIE as $key => $value) {
        setcookie($key, '', time() - 3600, '/'); // Expira todas las cookies
    }
}

// Destruir la sesión anterior y eliminar cookies
if (isset($_SESSION['codigo_usuario'])) {
    session_unset();
    session_destroy();
    eliminarCookies();
}

$codigo_usuario = isset($_POST['codigo_usuario']) ? $_POST['codigo_usuario'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$pass = md5($password);

$consulta = "SELECT * FROM sistema.usuarios WHERE codigo_usuario = :codigo_usuario AND password = :password";
$resultado = $pdo->prepare($consulta);
$resultado->bindParam(':codigo_usuario', $codigo_usuario);
$resultado->bindParam(':password', $pass);
$resultado->execute();

if ($resultado->rowCount() >= 1) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['codigo_usuario'] = $codigo_usuario;
    foreach ($data as $valor) {
        $_SESSION['nombres'] = $valor['nombres'];
        $_SESSION['codigo_rol'] = $valor['codigo_rol'];
    }
} else {
    $_SESSION['codigo_usuario'] = null;
    $_SESSION['nombres'] = null;
    $_SESSION['codigo_rol'] = null;
    $data = null;
}

// CORRECCIÓN aquí
header('Content-Type: application/json');
echo json_encode($data);
