<?php
date_default_timezone_set('America/Bogota');
// Configuración de la base de datos
$PGUSER = "postgres";
$PGPASSWORD = "Killa2022";
$PGHOST = "localhost";
$PGPORT = "5434";
$PGDATABASE = "postgres";
$PGSCHEMA = "sistema";
$RESTORE_DIR = "../backups/";
$LOG_DIR = "../logs/";
$LOG_FILE = $LOG_DIR . 'restore_log_' . date('Ymd_His') . '.txt';

// Verificar si el directorio de logs existe, si no, crearlo
if (!file_exists($LOG_DIR)) {
    mkdir($LOG_DIR, 0777, true);
}

// Verificar si el archivo fue subido correctamente
if (isset($_FILES['backupFile']) && $_FILES['backupFile']['error'] === UPLOAD_ERR_OK) {
    $uploadedFile = $_FILES['backupFile']['tmp_name'];
    $filename = basename($_FILES['backupFile']['name']);
    $destination = $RESTORE_DIR . $filename;

    // Mover el archivo subido al directorio de restauración
    if (move_uploaded_file($uploadedFile, $destination)) {
        // Ruta a pg_restore (ajusta según la instalación)
        $PGRESTORE_PATH = '"C:\\Program Files\\PostgreSQL\\9.1\\bin\\pg_restore.exe"';

        // Comando para restaurar la base de datos
        $command = "$PGRESTORE_PATH -U $PGUSER -h $PGHOST -p $PGPORT -d $PGDATABASE --schema $PGSCHEMA -v $destination > $LOG_FILE 2>&1";

        // Necesario para que `pg_restore` funcione correctamente
        putenv("PGPASSWORD=$PGPASSWORD");

        // Ejecutar el comando
        shell_exec($command);

        // Verificar si hubo algún error
        if (strpos(file_get_contents($LOG_FILE), 'error') === false) {
            echo '<div class="alert alert-success">Restauración completada con éxito. Revisa los <a href="' . $LOG_FILE . '" target="_blank">logs</a> para más detalles.</div>';
        } else {
            echo '<div class="alert alert-danger">Error durante la restauración. Revisa los <a href="' . $LOG_FILE . '" target="_blank">logs</a> para más detalles.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Error al subir el archivo de backup.</div>';
    }
} else {
    echo '<div class="alert alert-danger">Error al procesar el archivo de backup. Intenta nuevamente.</div>';
}
?>
