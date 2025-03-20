<?php
// conexion3.php
$host = "localhost";
$dbname = "postgres";
$user = "postgres";
$password = "postgres";
$port = "5432";
$schema = "sistema";

try {
     // Establecer conexión PDO con PostgreSQL
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
     // Configurar los atributos de PDO (manejo de errores)
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Establecer el esquema por defecto
    $conn->exec("SET search_path TO $schema");
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>




