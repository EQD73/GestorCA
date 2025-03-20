<?php
// Ruta del archivo CSV en tu servidor
$file = 'plantilla asignaturas_periodo.csv';

// Verificar que el archivo exista
if (file_exists($file)) {
    // Definir los encabezados para forzar la descarga del archivo
    header('Content-Description: File Transfer');
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    
    // Limpiar el búfer de salida
    flush();

    // Leer el archivo y enviarlo al cliente
    readfile($file);

    exit;
} else {
    // En caso de que el archivo no exista
    echo "El archivo no existe.";
}
?>
