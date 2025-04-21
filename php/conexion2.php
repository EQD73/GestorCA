<?php
/*


================================
Este archivo se encarga de conectar a la base de datos
y traer un objeto PDO

================================
 */
$contraseña = "postgres";
$usuario = "postgres";
$nombreBaseDeDatos = "postgres";
# Puede ser 127.0.0.1 o el nombre de tu equipo; o la IP de un servidor remoto
$rutaServidor = "localhost";
$puerto = "5432";
// $pdo = new PDO("pgsql:host=$rutaServidor;port=$puerto;dbname=$nombreBaseDeDatos", $usuario, $contraseña);
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Crear la conexión PDO
    $pdo = new PDO("pgsql:host=$rutaServidor;port=$puerto;dbname=$nombreBaseDeDatos", $usuario, $contraseña);

    // Establecer el modo de error a excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Puedes agregar una salida opcional para saber que la conexión fue exitosa
    // echo "Conexión exitosa"; 

} catch (PDOException $e) {
    // En caso de error, muestra el mensaje de error
    echo "Error de conexión: " . $e->getMessage();
    exit; // Termina el script en caso de error
}
