<?php
date_default_timezone_set('America/Bogota');
// Configuración de las variables para el backup
$PGUSER = "postgres";
$PGPASSWORD = "Killa2022";
$PGHOST = "localhost";
$PGPORT = "5434";
$PGDATABASE = "postgres";
$PGSCHEMA = "sistema";
$BACKUP_DIR = "../backups/";
$LOG_DIR = "../logs/";
$BACKUP_FILE = $BACKUP_DIR . $PGDATABASE . '_backup_' . date('Ymd_His') . '.sql';
$LOG_FILE = $LOG_DIR . 'backup_log_' . date('Ymd_His') . '.txt';

// Verificar si los directorios de backup y logs existen, si no, crearlos
if (!file_exists($BACKUP_DIR)) {
    mkdir($BACKUP_DIR, 0777, true);
}

if (!file_exists($LOG_DIR)) {
    mkdir($LOG_DIR, 0777, true);
}

// Ruta a pg_dump (ajusta la ruta según tu instalación)
$PGDUMP_PATH = '"C:\\Program Files\\PostgreSQL\\9.1\\bin\\pg_dump.exe"';

// Ejecutar el comando pg_dump y redirigir la salida y los errores al archivo de log
$command = "$PGDUMP_PATH -U $PGUSER -h $PGHOST -p $PGPORT -F c -b -v -f $BACKUP_FILE --schema $PGSCHEMA $PGDATABASE > $LOG_FILE 2>&1";

// Necesario para que `pg_dump` funcione correctamente
putenv("PGPASSWORD=$PGPASSWORD");

// Ejecutar el comando y registrar el resultado en el archivo de log
$output = shell_exec($command);

// Verificar si el archivo de backup fue generado
if (file_exists($BACKUP_FILE)) {
    // Si el backup se genera correctamente, ofrecer el enlace de descarga
    echo '<div class="alert alert-success">Backup generado con éxito. <a href="' . $BACKUP_FILE . '" download>Descargar backup</a></div>';
} else {
    // Si falla el backup, mostrar un mensaje de error y enlace al log
    echo '<div class="alert alert-danger">Error al generar el backup. Revisa los <a href="' . $LOG_FILE . '" target="_blank">logs</a> para más detalles.</div>';
}
?>
