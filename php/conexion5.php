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
    // // Conexión a la base de datos PostgreSQL usando PDO
    $c1 = "pgsql:host=$host;port=$port;dbname=$dbname";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($c1, $user, $password, $options);
    //$conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
     // Configurar los atributos de PDO (manejo de errores)
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Establecer el esquema por defecto
    $pdo->exec("SET search_path TO $schema");
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

