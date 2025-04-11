<?php
date_default_timezone_set('America/Bogota');

// Configuración de la base de datos
$PGUSER = "postgres";
$PGPASSWORD = "postgres";
$PGHOST = "localhost";
$PGPORT = "5432";
$PGDATABASE = "postgres";
$PGSCHEMA = "sistema";
$RESTORE_DIR = "../backups/";
$LOG_DIR = "../logs/";
$LOG_FILE = $LOG_DIR . 'restore_log_' . date('Ymd_His') . '.txt';

// Rutas completas a herramientas
$PSQL_PATH = '"C:\\Program Files\\PostgreSQL\\9.1\\bin\\psql.exe"';
$PGRESTORE_PATH = '"C:\\Program Files\\PostgreSQL\\9.1\\bin\\pg_restore.exe"';

// Verificar si el directorio de logs existe
if (!file_exists($LOG_DIR)) {
    mkdir($LOG_DIR, 0777, true);
}

if (isset($_FILES['backupFile']) && $_FILES['backupFile']['error'] === UPLOAD_ERR_OK) {
    $uploadedFile = $_FILES['backupFile']['tmp_name'];
    $filename = basename($_FILES['backupFile']['name']);
    $destination = $RESTORE_DIR . $filename;

    if (move_uploaded_file($uploadedFile, $destination)) {
        // Establecer variable de entorno para la contraseña
        putenv("PGPASSWORD=$PGPASSWORD");

        // Borrar y recrear el esquema
        $dropSchemaCmd = "$PSQL_PATH -U $PGUSER -h $PGHOST -p $PGPORT -d $PGDATABASE -c \"DROP SCHEMA IF EXISTS $PGSCHEMA CASCADE; CREATE SCHEMA $PGSCHEMA;\"";
        $outputDrop = shell_exec($dropSchemaCmd);

        file_put_contents($LOG_FILE, "Resultado DROP SCHEMA:\n" . $outputDrop . "\n", FILE_APPEND);

        // Restaurar el esquema
        $restoreCmd = "$PGRESTORE_PATH -U $PGUSER -h $PGHOST -p $PGPORT -d $PGDATABASE --schema=$PGSCHEMA -v \"$destination\"";
        $outputRestore = shell_exec("$restoreCmd >> \"$LOG_FILE\" 2>&1");

        // Verificar el log para errores
        if (strpos(file_get_contents($LOG_FILE), 'error') === false) {
            echo '<div class="alert alert-danger text-white text-center mt-3">Restauración completada con éxito. Revisa los <a href="' . $LOG_FILE . '" target="_blank">logs</a> para más detalles.</div>';
        } else {
            echo '<div class="alert alert-danger text-white text-center mt-3">Error durante la restauración. Revisa los <a href="' . $LOG_FILE . '" target="_blank">logs</a> para más detalles.</div>';
        }
    } else {
        echo '<div class="alert alert-danger text-white text-center mt-3">Error al subir el archivo de backup.</div>';
    }
} else {
    echo '<div class="alert alert-danger text-white text-center mt-3">Error al procesar el archivo de backup. Intenta nuevamente.</div>';
}
