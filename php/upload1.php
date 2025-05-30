<?php
header('Content-Type: application/json');
date_default_timezone_set('America/Bogota');

include("conexion5.php");

// === Configuración de logs ===
$fechaLog = date('Ymd');
$logFileGeneral = "../logs/log_Cargue1_$fechaLog.txt";
$logFileErrores = "../logs/errores_Cargue1_$fechaLog.txt";

function write_log($message)
{
    global $logFileGeneral;
    $time = date('Y-m-d H:i:s');
    file_put_contents($logFileGeneral, "[$time] $message\n", FILE_APPEND);
}

function logError($message)
{
    global $logFileErrores;
    $time = date('Y-m-d H:i:s');
    file_put_contents($logFileErrores, "[$time] $message\n", FILE_APPEND);
}

// === Inicializar respuesta JSON por defecto ===
$response = [
    'status' => 'error',
    'message' => 'Ha ocurrido un error inesperado.',
    'insertados' => 0,
    'duplicados' => []
];

try {
    if (!$pdo) {
        write_log("Error al conectar a la base de datos.");
        throw new Exception("Error de conexión a la base de datos.");
    }

    write_log("Conexión a la base de datos exitosa.");

    if (!isset($_FILES['csvFile']) || $_FILES['csvFile']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Archivo CSV no recibido o con errores.");
    }

    $file = $_FILES['csvFile']['tmp_name'];
    $ext = pathinfo($_FILES['csvFile']['name'], PATHINFO_EXTENSION);

    if (strtolower($ext) !== 'csv') {
        logError("Archivo no tiene extensión CSV.");
        throw new Exception("El archivo debe tener extensión .csv.");
    }

    $handle = fopen($file, "r");
    if (!$handle) {
        logError("No se pudo abrir el archivo CSV.");
        throw new Exception("No se pudo abrir el archivo CSV.");
    }

    fgetcsv($handle, 1000, ","); // Saltar encabezado

    $duplicados = [];
    $insertados = 0;
    $lineaActual = 1;

    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        $lineaActual++;

        if (empty(array_filter($data))) {
            logError("Línea $lineaActual vacía. Saltada.");
            continue;
        }

        if (count($data) < 6) {
            logError("Línea $lineaActual incompleta. Saltada.");
            continue;
        }

        $codigo_usuario = mb_convert_encoding(trim($data[0]), 'UTF-8', 'auto');
        $password = MD5(substr($codigo_usuario, -4));
        $nombres = mb_convert_encoding(trim($data[1]), 'UTF-8', 'auto');
        $apellidos = mb_convert_encoding(trim($data[2]), 'UTF-8', 'auto');
        $nomcompleto = mb_convert_encoding(trim($data[2]) . ' ' . trim($data[1]), 'UTF-8', 'auto');
        $email = mb_convert_encoding(trim($data[3]), 'UTF-8', 'auto');
        $codigo_rol = mb_convert_encoding(trim($data[4]), 'UTF-8', 'auto');
        $estado = mb_convert_encoding(trim($data[5]), 'UTF-8', 'auto');

        if (empty($codigo_usuario)) {
            logError("Línea $lineaActual sin código de usuario. Saltada.");
            continue;
        }

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM sistema.usuarios WHERE codigo_usuario = ?");
        $stmt->execute([$codigo_usuario]);
        if ($stmt->fetchColumn() > 0) {
            $duplicados[] = $codigo_usuario;
            logError("Código duplicado: $codigo_usuario");
            continue;
        }

        try {
            $insert = $pdo->prepare("INSERT INTO usuarios (codigo_usuario, password, nombres, apellidos, nomcompleto, email_institucional, codigo_rol, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $insert->execute([$codigo_usuario, $password, $nombres, $apellidos, $nomcompleto, $email, $codigo_rol, $estado]);
            $insertados++;
            write_log("Insertado: $codigo_usuario - $nomcompleto");
        } catch (PDOException $e) {
            logError("Error insertando $codigo_usuario: " . $e->getMessage());
        }
    }

    fclose($handle);

    if ($insertados > 0 && count($duplicados) === 0) {
        $response['status'] = 'success';
        $response['message'] = "Se insertaron $insertados registros correctamente.";
    } elseif ($insertados > 0 && count($duplicados) > 0) {
        $response['status'] = 'parcial';
        $response['message'] = "Se insertaron $insertados registros. Algunos ya existían y fueron omitidos.";
    } elseif ($insertados === 0 && count($duplicados) > 0) {
        $response['status'] = 'noparcial';
        $response['message'] = "Todos los registros ya existían. No se insertó ninguno.";
    } else {
        $response['status'] = 'error';
        $response['message'] = "No se insertaron registros válidos.";
    }

    $response['insertados'] = $insertados;
    $response['duplicados'] = $duplicados;
} catch (Exception $e) {
    logError("Excepción general: " . $e->getMessage());
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
