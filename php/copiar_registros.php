<?php
// // Conexión a la base de datos
// $host = 'localhost';
// $dbname = 'mi_db';
// $user = 'mi_usuario';
// $password = 'mi_contraseña';
include('conexion5.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tabla = $_POST['tabla'];
    $periodo_anterior = $_POST['periodo_anterior'];
    $periodo_nuevo = $_POST['periodo_nuevo'];
    $nomp = $_POST['nomp'];

    echo $nomp;


    try {
        // $dsn = "pgsql:host=$host;dbname=$dbname";
        // $pdo = new PDO($dsn, $user, $password, [
        //     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        //     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // ]);

        // Verificar si la tabla está permitida (seguridad)
        $tablas_permitidas = ['m2_pruebas', 'm3_pruebas'];  // Cambiar por tus tablas
        if (!in_array($tabla, $tablas_permitidas)) {
            throw new Exception('Tabla no permitida.');
        }

         // Paso 1: Iniciar una transacción
        $pdo->beginTransaction();

        // Paso 2: Crear tabla temporal y seleccionar datos
        $sqlCreateTempTable = "
        CREATE TEMP TABLE temp_tabla AS
        SELECT * FROM $tabla WHERE codigo_periodo = :periodo_anterior;
        ";
        $stmt = $pdo->prepare($sqlCreateTempTable);
        $stmt->execute(['periodo_anterior' => $periodo_anterior]);

        $sqlUpdate = "
        UPDATE temp_tabla
        SET codigo_periodo = :periodo_nuevo, nombre_periodo = :nomp
        WHERE codigo_periodo = :periodo_anterior;
        ";
        $stmt = $pdo->prepare($sqlUpdate);
        $stmt->execute([':periodo_nuevo' => $periodo_nuevo, ':periodo_anterior' => $periodo_anterior, ':nomp' => $nomp]);

        $sqlInsert = "
        INSERT INTO $tabla SELECT * FROM temp_tabla;
        ";
        $stmt = $pdo->prepare($sqlInsert);
        $stmt->execute();

        // Paso 5: Confirmar transacción
        $pdo->commit();

        echo json_encode(['status' => 'success', 'message' => 'Registros copiados exitosamente.']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}




