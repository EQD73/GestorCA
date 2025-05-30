<?php
header('Content-Type: application/json');
date_default_timezone_set('America/Bogota');

include("conexion5.php");

// === Configuración de logs ===
$fechaLog = date('Ymd');
$logFileGeneral = "../logs/log_Cargue5_$fechaLog.txt";
$logFileErrores = "../logs/errores_Cargue5_$fechaLog.txt";

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

        $codigo_docente = mb_convert_encoding(trim($data[0]), 'UTF-8', 'auto');
        $codigo_asignatura = mb_convert_encoding(trim($data[1]), 'UTF-8', 'auto');
        $semestre = trim($data[2]);
        $grupo = trim($data[3]);
        $codigo_programa = mb_convert_encoding(trim($data[4]), 'UTF-8', 'auto');
        $codigo_periodo = mb_convert_encoding(trim($data[5]), 'UTF-8', 'auto');

        if (empty($codigo_docente) || empty($codigo_asignatura)) {
            logError("Línea $lineaActual sin código de docente y asignatura. Saltada.");
            continue;
        }

        if (!is_numeric($semestre) || !is_numeric($grupo)) {
            logError("Línea $lineaActual con Semestre o Grupo no numéricos. Saltada.");
            continue;
        }

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM sistema.docente_asignaturas_periodo WHERE codigo_docente = ? AND codigo_asignatura = ?");
        $stmt->execute([$codigo_docente, $codigo_asignatura]);
        if ($stmt->fetchColumn() > 0) {
            $duplicados[] = $codigo_docente . "-" . $codigo_asignatura;
            logError("Código duplicado: $codigo_docente" . "-" . "$codigo_asignatura");
            continue;
        }

        try {
            $insert = $pdo->prepare("INSERT INTO sistema.docente_asignaturas_periodo (codigo_docente, codigo_asignatura, semestre, grupo, codigo_programa, codigo_periodo) VALUES (?, ?, ?, ?, ?, ?)");
            $insert->execute([$codigo_docente, $codigo_asignatura, $semestre, $grupo, $codigo_programa, $codigo_periodo]);
            $insertados++;
            write_log("Insertado: $codigo_docente - $codigo_asignatura");
        } catch (PDOException $e) {
            logError("Error insertando $codigo_docente - $codigo_asignatura: " . $e->getMessage());
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
