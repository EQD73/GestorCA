<?php
// // Conexión a la base de datos
// $host = 'localhost';
// $dbname = 'mi_db';
// $user = 'mi_usuario';
// $password = 'mi_contraseña';
include('conexion5.php');

try {
    // $dsn = "pgsql:host=$host;dbname=$dbname";
    // $pdo = new PDO($dsn, $user, $password, [
    //     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    //     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // ]);

    // Obtener los periodos de la tabla de periodos
    $stmt = $pdo->query("SELECT codigo_periodo, nombre_periodo FROM periodos");
    $periodos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Mapeo de tablas con nombres amigables o descripciones
    $tablas_permitidas = [
        ['nombre_tabla' => 'm2_pruebas', 'descripcion' => 'Consignador Acádemico'],
        ['nombre_tabla' => 'm3_pruebas', 'descripcion' => 'Registro de Actividades']        
    ];

// Devolver los periodos y tablas como JSON
echo json_encode(['periodos' => $periodos, 'tablas' => $tablas_permitidas]);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
