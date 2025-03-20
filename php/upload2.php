<?php
// Función para registrar logs
function write_log($message) {
    date_default_timezone_set('America/Bogota');
    $logFile = '../logs/log_Cargue2.txt';  // Archivo de log
    $time = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$time] $message\n", FILE_APPEND);
}
include("conexion5.php");

// Ruta del archivo de log
$logFile = '../logs/cargue2_duplicados_log.txt';  // Ruta del archivo de log

// Función para registrar errores en el archivo de log
function logError($message) {
    global $logFile;
    $timestamp = date("Y-m-d H:i:s");
    $logMessage = "[$timestamp] $message" . PHP_EOL;
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

try {
    if (!$pdo) {
        write_log("Error al conectar a la base de datos.");
        // Redirigir a index.php con un mensaje de error
        header("Location: cargue2.php?status=error_db");
        exit();
    }
write_log("Conexión a la base de datos exitosa.");
if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['csvFile']['tmp_name'];
    $handle = fopen($file, "r");
    // Contar el total de líneas del archivo CSV (para calcular el progreso)
    $totalLines = count(file($file));
    // Saltar la primera línea del archivo CSV (encabezado)
    fgetcsv($handle, 1000, ",");

    // Inicializar la variable de progreso y la lista de duplicados
    $currentLine = 0;
    $duplicados = [];  // Lista para almacenar los códigos duplicados

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $currentLine++;  // Incrementa la línea actual
        $codigo_asignatura = $data[0]; // Suponiendo que $data[0] es el campo `codigo_asignatura`
        $nomasig= $data[1];
        $codprog = $data[2];
        $sem = $data[3];
        $grup= $data[4];
        $ihs = $data[5];
        $creditos = $data[6];
        $coddoc = $data[7];
        $nomdoc= $data[8];
        $periodo = $data[9];

         // Verificar si el codigo_usuario ya existe en la tabla usando consultas preparadas
         $stmt = $pdo->prepare("SELECT COUNT(*) FROM asignaturas WHERE codigo_asignatura = :codigo_asignatura");
         $stmt->execute(['codigo_asignatura' => $codigo_asignatura]);
         $count = $stmt->fetchColumn();

         if ($count > 0) {
            // Si el código de asignatura ya existe, agregarlo a la lista de duplicados
            $duplicados[] = $codigo_asignatura;
            $errorMessage = "Error al insertar el código $codigo_asignatura: Codigo Asignatura Duplicado";
            logError($errorMessage);
        } else {
            try {
                // Insertar si no existe
                $insertStmt = $pdo->prepare("INSERT INTO asignaturas (codigo_asignatura, nom_asignatura, codigo_programa, semestre, grupo, ihs, creditos, codigo_docente, nombre_docente, periodo) VALUES (:codigo_asignatura, :nomasig, :codprog, :sem, :grup, :ihs, :creditos, :coddoc, :nomdoc, :periodo)");
                $insertStmt->execute([
                    'codigo_asignatura' => $codigo_asignatura,
                    'nomasig' => $nomasig,
                    'codprog' => $codprog,
                    'sem' => $sem,
                    'grup' => $grup,
                    'ihs' => $ihs,
                    'creditos' => $creditos,
                    'coddoc' =>$coddoc,
                    'nomdoc' => $nomdoc, 
                    'periodo' => $periodo,                    
                ]);
                write_log("Datos insertados: $codigo_asignatura, $nomasig, $codprog, $sem, $grup, $ihs, $creditos, $coddoc, $nomdoc, $periodo");
                
            } catch (PDOException $e) {
                // En caso de error de inserción, registrar el error en el archivo de log
                $errorMessage = "Error al insertar el código $codigo_asignatura: " . $e->getMessage();
                logError($errorMessage);
            }
        }

        // Calcular el porcentaje de progreso
        $progress = ($currentLine / $totalLines) * 100;
            
        // Enviar el progreso al frontend
        // echo "<script>
        //     document.getElementById('progressBar').style.width = '$progress%';
        //     document.getElementById('progressBar').innerHTML = '$progress%';
        // </script>";
        // flush();  // Enviar el contenido al navegador inmediatamente
    }

    fclose($handle);
    
        // Generar la lista de duplicados en un array
        if (count($duplicados) > 0) {
            $duplicadosList = implode(', ', $duplicados);
            write_log("Error al subir el archivo CSV.");
            
            header('Content-Type: application/json');  // Asegura que el servidor indique que está enviando JSON
            // Enviar la respuesta en formato JSON
            echo json_encode([
                'status' => 'duplicados',
                'message' => 'Códigos de asignaturas duplicados: ' . $duplicadosList
            ]);
             
        } else {
             // Respuesta sin duplicados
            write_log("Archivo CSV procesado correctamente.");
            header('Content-Type: application/json');  // Asegura que el servidor indique que está enviando JSON
            echo json_encode([
                'status' => 'success',
                'message' => 'Todos los registros fueron insertados correctamente.'
            ]);
                       
        }
        
    }


} catch (PDOException $e) {
    // Manejo de errores en la conexión
    $errorMessage = "Error de conexión: " . $e->getMessage();
    logError($errorMessage);
    echo "Error de conexión: " . $e->getMessage();
}
?>
